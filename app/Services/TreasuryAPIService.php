<?php

namespace App\Services;

/**
 * TreasuryAPIService
 * Handles integration with the government treasury API
 */
class TreasuryAPIService
{
    protected string $apiBaseUrl;
    protected ?string $apiKey;
    protected $client;

    public function __construct()
    {
        // Base URL should point to the releases endpoint without query params
        $this->apiBaseUrl = rtrim(getenv('TREASURY_API_URL') ?: 'https://ocds-api.etenders.gov.za/api/OCDSReleases', '/');
        $this->apiKey = getenv('TREASURY_API_KEY');
        
        // Initialize HTTP client
        $this->client = \Config\Services::curlRequest(['timeout' => 30]);
    }

    /**
     * Perform a GET request to the releases endpoint with given query parameters.
     */
    protected function request(array $query = []): array
    {
        try {
            $headers = [
                'Accept' => 'application/json',
            ];

            if ($this->apiKey) {
                $headers['Authorization'] = 'Bearer ' . $this->apiKey;
            }

            $response = $this->client->request('GET', $this->apiBaseUrl, [
                'headers' => $headers,
                'query'   => $query,
                'http_errors' => false,
            ]);
            if ($response->getStatusCode() !== 200) {
                log_message('error', 'Treasury API request failed: ' . $response->getBody());
                return [];
            }

            return json_decode($response->getBody(), true) ?: [];
        } catch (\Exception $e) {
            log_message('error', 'Treasury API request exception: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch tenders from the treasury API (wrapper for request)
     *
     * Accepts same parameters as searchTenders for convenience.
     */
    public function fetchTenders(array $params = []): array
    {
        return $this->request($params);
    }

    /**
     * Fetch tender details from the API by OCID
     */
    public function getTenderDetails($ocid)
    {
        try {
            $headers = [
                'Accept' => 'application/json',
            ];

            if ($this->apiKey) {
                $headers['Authorization'] = 'Bearer ' . $this->apiKey;
            }

            // Construct URL with OCID in path: /api/OCDSReleases/release/{ocid}
            $url = $this->apiBaseUrl . '/release/' . $ocid;

            $response = $this->client->request('GET', $url, [
                'headers' => $headers,
                'http_errors' => false,
            ]);

            if ($response->getStatusCode() !== 200) {
                log_message('error', 'Treasury API getTenderDetails request failed: ' . $response->getBody());
                return null;
            }

            $result = json_decode($response->getBody(), true) ?: [];

            // API returns a single release object, not an array
            if (!empty($result)) {
                return $result['tender'] ?? $result;
            }

            return null;
        } catch (\Exception $e) {
            log_message('error', 'Treasury API getTenderDetails request exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Parse API release/tender object and map to tender model
     */
    public function mapTenderData($apiData)
    {
        // release may contain 'tender' sub-object
        if (isset($apiData['tender'])) {
            $ocid = $apiData['ocid'] ?? null;
            $apiData = $apiData['tender'];
            $apiData['tender']['ocid'] = $ocid; // Preserve OCID for reference
        }

        return [
            'ocid' => $ocid ?? null,
            'tender_number' => $apiData['id'] ?? $apiData['tenderNumber'] ?? null,
            'title' => $apiData['title'] ?? null,
            'description' => $apiData['description'] ?? null,
            'category' => $apiData['category'] ?? null,
            'province' => $apiData['province'] ?? null,
            'delivery_location' => $apiData['deliveryLocation'] ?? null,
            'special_conditions' => $apiData['specialConditions'] ?? null,
            'main_procurement_category' => $apiData['mainProcurementCategory'] ?? null,
            'additional_procurement_categories' => $apiData['additionalProcurementCategories'] ?? [],
            'tender_type' => $apiData['status'] ?? null,
            'closing_date' => $apiData['tenderPeriod']['endDate'] ?? null,
            'opening_date' => $apiData['tenderPeriod']['startDate'] ?? null,
            'published_date' => $apiData['date'] ?? null,
            'budget_estimate' => $apiData['value']['amount'] ?? null,
            'budget_currency' => $apiData['value']['currency'] ?? null,
            'status' => $apiData['status'] ?? 'active',
            'tender_id' => $apiData['id'] ?? null,
            'documents' => $apiData['documents'] ?? [],
            'briefing_session' => $apiData['briefingSession'] ?? null,
            'contact_person' => $apiData['contactPerson'] ?? null,
            'procuring_entity' => $apiData['procuringEntity'] ?? null,
        ];
    }
    /**
     * Search tenders with filters using the API's query parameters
     */
    public function searchTenders(array $filters = []): array
    {
        $query = [];

        if (!empty($filters['search'])) {
            // API supports free-text q parameter
            $query['q'] = $filters['search'];
        }

        if (!empty($filters['status'])) {
            $query['status'] = $filters['status'];
        }

        if (!empty($filters['tender_type'])) {
            $query['category'] = $filters['tender_type'];
        }

        if (!empty($filters['province'])) {
            $query['province'] = $filters['province'];
        }

        if (!empty($filters['organisation'])) {
            $query['procuringEntity'] = $filters['organisation'];
        }

        if (!empty($filters['dateFrom'])) {
            $query['dateFrom'] = $filters['dateFrom'];
        }

        if (!empty($filters['dateTo'])) {
            $query['dateTo'] = $filters['dateTo'];
        }

        // paging parameters use PageNumber/PageSize
        if (!empty($filters['page'])) {
            $query['PageNumber'] = $filters['page'];
        }

        if (!empty($filters['limit'])) {
            $query['PageSize'] = $filters['limit'];
        }

        $result = $this->request($query);

        // Response has 'releases' as data
        $data = $result['releases'] ?? [];
        $total = $result['total'] ?? count($data);

        return [
            'data' => $data,
            'total' => $total,
            'page' => $query['PageNumber'] ?? 1,
            'limit' => $query['PageSize'] ?? 20,
        ];
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
                $existing = $tenderModel->where('tender_id', $mappedData['tender_id'])->first();

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
