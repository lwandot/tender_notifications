<?php

namespace App\Models;

use CodeIgniter\Model;

class OrganModel extends Model
{
    protected $table            = 'organs_of_state';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['name'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}
?>
