<?php

namespace App\Models;

use CodeIgniter\Model;

class TenderEnquiryModel extends Model
{
    protected $table = 'tender_enquiries';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['tender_id', 'contact_person', 'email', 'phone', 'fax'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'tender_id' => 'required|integer',
        'contact_person' => 'required|string|max_length[150]',
        'email' => 'required|valid_email|max_length[100]',
        'phone' => 'string|max_length[20]',
        'fax' => 'string|max_length[20]',
    ];
}
