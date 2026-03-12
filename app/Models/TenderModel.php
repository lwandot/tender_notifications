<?php

namespace App\Models;

use App\Services\TreasuryAPIService;

class TenderModel
{
    protected TreasuryAPIService $apiService;
    protected $table = 'tenders';
    protected $primaryKey = 'id';

    public function __construct()
    {
        $this->apiService = new TreasuryAPIService();
    }

    /**
     * Get a single tender by API ID
     */
    public function find($id)
    {
        $tender = $this->apiService->getTenderDetails($id);
        return $tender ? $this->apiService->mapTenderData($tender) : null;
    }

    /**
     * Get active tenders with pagination
     */
    public function getActiveTenders($limit = 20, $offset = 0)
    {
        $result = $this->apiService->searchTenders([
            'status' => 'active',
            'limit' => $limit,
            'page' => floor($offset / $limit) + 1,
        ]);
        
        $tenders = [];
        if (!empty($result['data'])) {
            foreach ($result['data'] as $item) {
                $tenders[] = $this->apiService->mapTenderData($item);
            }
        }

        return $tenders;
    }

    /**
     * Get tender with all related details
     */
    public function getTenderWithDetails($tenderId)
    {
        $tender = $this->find($tenderId);
        if (!$tender) {
            return null;
        }

        // Enrich tender data from API
        $apiData = $this->apiService->getTenderDetails($tenderId);
        
        if ($apiData) {
            // Add nested details from API response
            $tender['enquiries'] = $apiData['enquiries'] ?? [];
            $tender['briefing_sessions'] = $apiData['briefingSessions'] ?? [];
            $tender['documents'] = $apiData['documents'] ?? [];
            $tender['categories'] = $apiData['categories'] ?? [];
            
            // Add organ of state and province info from API
            $tender['organ_of_state'] = $apiData['organisingEntity'] ?? null;
            $tender['province'] = $apiData['province'] ?? null;
        }

        return $tender;
    }

    /**
     * Get categories for a tender from API
     */
    public function getCategories($tenderId)
    {
        $tender = $this->apiService->getTenderDetails($tenderId);
        return $tender['categories'] ?? [];
    }

    /**
     * Filter tenders by various criteria
     */
    public function filterTenders($filters, $limit = 20, $offset = 0)
    {
        $searchFilters = [
            'limit' => $limit,
            'page' => floor($offset / $limit) + 1,
            'status' => 'active',
        ];

        // Map filter parameters to API parameters
        if (!empty($filters['search'])) {
            $searchFilters['search'] = $filters['search'];
        }

        if (!empty($filters['tender_type'])) {
            $searchFilters['tender_type'] = $filters['tender_type'];
        }

        if (!empty($filters['province_id'])) {
            $searchFilters['province'] = $filters['province_id'];
        }

        if (!empty($filters['organ_of_state_id'])) {
            $searchFilters['organisation'] = $filters['organ_of_state_id'];
        }

        $result = $this->apiService->searchTenders($searchFilters);
        $tenders = [];

        if (!empty($result['data'])) {
            foreach ($result['data'] as $item) {
                $tenders[] = $this->apiService->mapTenderData($item);
            }
        }

        return $tenders;
    }

    /**
     * Count filtered tenders
     */
    public function countFilteredTenders($filters)
    {
        $searchFilters = [
            'status' => 'active',
        ];

        if (!empty($filters['search'])) {
            $searchFilters['search'] = $filters['search'];
        }

        if (!empty($filters['tender_type'])) {
            $searchFilters['tender_type'] = $filters['tender_type'];
        }

        if (!empty($filters['province_id'])) {
            $searchFilters['province'] = $filters['province_id'];
        }

        if (!empty($filters['organ_of_state_id'])) {
            $searchFilters['organisation'] = $filters['organ_of_state_id'];
        }

        $result = $this->apiService->searchTenders($searchFilters);
        
        return $result['total'] ?? count($result['data'] ?? []);
    }
}
