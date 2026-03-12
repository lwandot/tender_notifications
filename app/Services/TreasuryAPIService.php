<?php

namespace App\Services;

/**
 * TreasuryAPIService
 * Handles integration with the government treasury API
 */
class TreasuryAPIService
{
    protected $apiBaseUrl;
    protected $apiKey;
    protected $client;

    public function __construct()
    {
        $this->apiBaseUrl = getenv('TREASURY_API_URL') ?? 'https://ocds-api.etenders.gov.za/api/OCDSReleases?PageSize=200&dateFrom=2024-01-01&dateTo=2024-03-31';
        $this->apiKey = getenv('TREASURY_API_KEY');
        
        // Initialize HTTP client
        $this->client = \Config\Services::curlRequest();
    }

    /**
     * Fetch tenders from the treasury API
     */
    public function fetchTenders($since = null)
    {
        try {
            $url = $this->apiBaseUrl . '/list';
            $headers = [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json'
            ];

            $params = [];
            if ($since) {
                $params['since'] = $since->format('Y-m-d');
            }

            $response = $this->client->request('GET', $url, [
                'headers' => $headers,
                'query' => $params,
                'http_errors' => false
            ]);

            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                log_message('error', "Treasury API error: " . $response->getBody());
                return [];
            }

            $body = $response->getBody();
            return json_decode($body, true);
        } catch (\Exception $e) {
            log_message('error', "Treasury API exception: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch tender details from the API
     */
    public function getTenderDetails($apiId)
    {
        try {
            $url = $this->apiBaseUrl . '/' . $apiId;
            $headers = [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json'
            ];

            $response = $this->client->request('GET', $url, [
                'headers' => $headers,
                'http_errors' => false
            ]);

            if ($response->getStatusCode() !== 200) {
                return null;
            }

            $body = $response->getBody();
            return json_decode($body, true);
        } catch (\Exception $e) {
            log_message('error', "Treasury API exception: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Parse API response and map to tender model
     */
    public function mapTenderData($apiData)
    {
        return [
            'tender_number' => $apiData['tenderNumber'] ?? null,
            'title' => $apiData['title'] ?? null,
            'description' => $apiData['description'] ?? null,
            'tender_type' => $apiData['type'] ?? 'goods',
            'closing_date' => $apiData['closingDate'] ?? null,
            'opening_date' => $apiData['openingDate'] ?? null,
            'published_date' => $apiData['publishedDate'] ?? null,
            'budget_estimate' => $apiData['budget'] ?? null,
            'status' => $apiData['status'] ?? 'active',
            'api_id' => $apiData['id'] ?? null,
        ];
    }

    /**
     * Search tenders with filters
     */
    public function searchTenders(array $filters = [])
    {
        try {
            $url = $this->apiBaseUrl . '/search';
            $headers = [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json'
            ];

            $query = [];

            // Map filter parameters to API query parameters
            if (!empty($filters['search'])) {
                $query['q'] = $filters['search'];
            }

            if (!empty($filters['status'])) {
                $query['status'] = $filters['status'];
            }

            if (!empty($filters['tender_type'])) {
                $query['type'] = $filters['tender_type'];
            }

            if (!empty($filters['province'])) {
                $query['province'] = $filters['province'];
            }

            if (!empty($filters['organisation'])) {
                $query['organisation'] = $filters['organisation'];
            }

            if (!empty($filters['page'])) {
                $query['page'] = $filters['page'];
            }

            if (!empty($filters['limit'])) {
                $query['limit'] = $filters['limit'];
            }

            $response = $this->client->request('GET', $url, [
                'headers' => $headers,
                'query' => $query,
                'http_errors' => false
            ]);

            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                log_message('error', "Treasury API search error: " . $response->getBody());
                return ['data' => [], 'total' => 0];
            }

            $body = $response->getBody();
            $result = json_decode($body, true);

            return [
                'data' => $result['data'] ?? [],
                'total' => $result['total'] ?? count($result['data'] ?? []),
                'page' => $result['page'] ?? 1,
                'limit' => $result['limit'] ?? 20,
            ];
        } catch (\Exception $e) {
            log_message('error', "Treasury API search exception: " . $e->getMessage());
            return ['data' => [], 'total' => 0];
        }
    }

    /**
     * Sync tenders from API to database
     */
    public function syncTenders()
    {
        $tenderModel = new \App\Models\TenderModel();
        
        // Get last sync time
        $lastSync = cache()->get('last_tender_sync');
        $since = $lastSync ? new \DateTime($lastSync) : null;

        // Fetch from API
        $apiTenders = $this->fetchTenders($since);

        if (empty($apiTenders)) {
            return ['synced' => 0, 'error' => 'No data from API'];
        }

        $synced = 0;
        foreach ($apiTenders['data'] ?? [] as $apiTender) {
            try {
                $mappedData = $this->mapTenderData($apiTender);
                
                // Check if tender exists
                $existing = $tenderModel->where('api_id', $mappedData['api_id'])->first();

                if ($existing) {
                    // Update existing
                    $tenderModel->update($existing['id'], $mappedData);
                } else {
                    // Create new
                    $tenderModel->insert($mappedData);
                }

                $synced++;
            } catch (\Exception $e) {
                log_message('error', "Error syncing tender: " . $e->getMessage());
                continue;
            }
        }

        // Update last sync time
        cache()->save('last_tender_sync', date('Y-m-d H:i:s'), 3600);

        return ['synced' => $synced];
    }
}
