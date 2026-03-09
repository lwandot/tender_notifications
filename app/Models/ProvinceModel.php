<?php

namespace App\Models;

use CodeIgniter\Model;

class ProvinceModel extends Model
{
    protected $table = 'provinces';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'code'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'name' => 'required|string|max_length[100]',
        'code' => 'required|string|max_length[10]|is_unique[provinces.code]',
    ];

    public function getTenderCount($provinceId)
    {
        return $this->db->table('tenders')
            ->where('province_id', $provinceId)
            ->where('status', 'active')
            ->countAllResults();
    }
}
