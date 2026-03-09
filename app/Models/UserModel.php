<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'email', 'password_hash', 'first_name', 'last_name', 
        'phone', 'organization', 'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[users.email]',
        'password_hash' => 'required|string|min_length[60]|max_length[255]',
        'first_name' => 'string|max_length[100]',
        'last_name' => 'string|max_length[100]',
        'phone' => 'string|max_length[20]',
        'organization' => 'string|max_length[150]',
    ];

    public function findByEmail($email)
    {
        return $this->where('email', $email)
            ->where('is_active', true)
            ->first();
    }
}
