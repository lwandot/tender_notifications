<?php

namespace App\Models;

use CodeIgniter\Model;

class TenderDocumentModel extends Model
{
    protected $table = 'tender_documents';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['tender_id', 'document_name', 'file_path', 'file_type', 'file_size'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'tender_id' => 'required|integer',
        'document_name' => 'required|string|max_length[150]',
        'file_path' => 'required|string|max_length[255]',
        'file_type' => 'required|string|max_length[50]',
        'file_size' => 'required|integer',
    ];

    public function incrementDownloadCount($documentId)
    {
        $document = $this->find($documentId);
        if ($document) {
            $this->update($documentId, [
                'download_count' => $document['download_count'] + 1
            ]);
        }
    }
}
