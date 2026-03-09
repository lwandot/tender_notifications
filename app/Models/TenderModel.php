<?php

namespace App\Models;

use CodeIgniter\Model;

class TenderModel extends Model
{
    protected $table = 'tenders';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'tender_number', 'title', 'description', 'organ_of_state_id', 
        'province_id', 'tender_type', 'status', 'opening_date', 'closing_date', 
        'published_date', 'budget_estimate', 'api_id'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'tender_number' => 'required|string|max_length[100]|is_unique[tenders.tender_number]',
        'title' => 'required|string|max_length[255]',
        'description' => 'required|string',
        'organ_of_state_id' => 'required|integer',
        'province_id' => 'required|integer',
        'tender_type' => 'required|string|max_length[50]',
        'status' => 'in_list[active,closed,awarded]',
        'closing_date' => 'valid_date[Y-m-d H:i:s]',
    ];

    public function getActiveTenders($limit = 20, $offset = 0)
    {
        return $this->where('status', 'active')
            ->orderBy('closing_date', 'ASC')
            ->limit($limit, $offset)
            ->findAll();
    }

    public function getTenderWithDetails($tenderId)
    {
        $tender = $this->find($tenderId);
        if (!$tender) {
            return null;
        }

        // Load related data
        $tender['organ_of_state'] = (new OrganOfStateModel())->find($tender['organ_of_state_id']);
        $tender['province'] = (new ProvinceModel())->find($tender['province_id']);
        $tender['enquiries'] = (new TenderEnquiryModel())->where('tender_id', $tenderId)->findAll();
        $tender['briefing_sessions'] = (new BriefingSessionModel())->where('tender_id', $tenderId)->findAll();
        $tender['documents'] = (new TenderDocumentModel())->where('tender_id', $tenderId)->findAll();
        $tender['categories'] = $this->getCategories($tenderId);

        return $tender;
    }

    public function getCategories($tenderId)
    {
        return $this->db->table('tender_categories')
            ->join('categories', 'tender_categories.category_id = categories.id')
            ->where('tender_categories.tender_id', $tenderId)
            ->select('categories.*')
            ->get()
            ->getResultArray();
    }

    public function filterTenders($filters, $limit = 20, $offset = 0)
    {
        $builder = $this->where('status', 'active');

        if (!empty($filters['province_id'])) {
            $builder->where('province_id', $filters['province_id']);
        }

        if (!empty($filters['organ_of_state_id'])) {
            $builder->where('organ_of_state_id', $filters['organ_of_state_id']);
        }

        if (!empty($filters['category_id'])) {
            $builder->join('tender_categories', 'tender_categories.tender_id = tenders.id')
                ->where('tender_categories.category_id', $filters['category_id']);
        }

        if (!empty($filters['tender_type'])) {
            $builder->where('tender_type', $filters['tender_type']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $builder->groupStart()
                ->like('title', $search)
                ->orLike('description', $search)
                ->orLike('tender_number', $search)
                ->groupEnd();
        }

        $builder->orderBy('closing_date', 'ASC')
            ->limit($limit, $offset);

        return $builder->findAll();
    }

    public function countFilteredTenders($filters)
    {
        $builder = $this->where('status', 'active');

        if (!empty($filters['province_id'])) {
            $builder->where('province_id', $filters['province_id']);
        }

        if (!empty($filters['organ_of_state_id'])) {
            $builder->where('organ_of_state_id', $filters['organ_of_state_id']);
        }

        if (!empty($filters['category_id'])) {
            $builder->join('tender_categories', 'tender_categories.tender_id = tenders.id')
                ->where('tender_categories.category_id', $filters['category_id']);
        }

        if (!empty($filters['tender_type'])) {
            $builder->where('tender_type', $filters['tender_type']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $builder->groupStart()
                ->like('title', $search)
                ->orLike('description', $search)
                ->orLike('tender_number', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }
}
