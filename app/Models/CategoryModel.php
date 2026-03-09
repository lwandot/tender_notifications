<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'slug', 'description'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'name' => 'required|string|max_length[100]',
        'slug' => 'required|string|max_length[100]|is_unique[categories.slug]',
        'description' => 'string',
    ];

    public function getTenderCount($categoryId)
    {
        return $this->db->table('tender_categories')
            ->where('category_id', $categoryId)
            ->countAllResults();
    }
}
