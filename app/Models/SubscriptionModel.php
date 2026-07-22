<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriptionModel extends Model
{
    protected $table            = 'subscriptions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id', 
        'package_id', 
        'package_name', 
        'price', 
        'channels', 
        'selected_categories', 
        'selected_provinces', 
        'selected_organs', 
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id'             => 'required|integer',
        'package_id'          => 'required',
        'package_name'        => 'required',
        'price'               => 'required|decimal',
        'channels'            => 'required',
        'selected_categories' => 'required',
        'selected_provinces'  => 'required',
        'selected_organs'     => 'required',
    ];
}
