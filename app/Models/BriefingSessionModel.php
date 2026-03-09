<?php

namespace App\Models;

use CodeIgniter\Model;

class BriefingSessionModel extends Model
{
    protected $table = 'briefing_sessions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['tender_id', 'date', 'time', 'venue', 'is_virtual', 'virtual_link'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'tender_id' => 'required|integer',
        'date' => 'required|valid_date[Y-m-d]',
        'time' => 'required|valid_date[H:i:s]',
        'venue' => 'required|string',
        'is_virtual' => 'in_list[0,1]',
        'virtual_link' => 'valid_url',
    ];
}
