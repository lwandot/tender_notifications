<?php

namespace App\Models;

use CodeIgniter\Model;

class OrganOfStateModel extends Model
{
    protected $table = 'organs_of_state';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'slug', 'description', 'contact_email'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'name' => 'required|string|max_length[150]',
        'slug' => 'required|string|max_length[150]|is_unique[organs_of_state.slug]',
        'description' => 'string',
        'contact_email' => 'valid_email',
    ];

    public function getTenderCount($organId)
    {
        return $this->db->table('tenders')
            ->where('organ_of_state_id', $organId)
            ->where('status', 'active')
            ->countAllResults();
    }
}
