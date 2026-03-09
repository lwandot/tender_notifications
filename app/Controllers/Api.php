<?php

namespace App\Controllers;

use App\Models\TenderModel;
use App\Models\TenderDocumentModel;
use CodeIgniter\API\ResponseTrait;

class Api extends BaseController
{
    use ResponseTrait;

    public function getTenders()
    {
        $tenderModel = new TenderModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = $this->request->getVar('perPage') ?? 10;
        $offset = ($page - 1) * $perPage;

        $filters = [
            'province_id' => $this->request->getVar('province_id'),
            'organ_of_state_id' => $this->request->getVar('organ_of_state_id'),
            'category_id' => $this->request->getVar('category_id'),
            'tender_type' => $this->request->getVar('tender_type'),
            'search' => $this->request->getVar('search'),
        ];

        $filters = array_filter($filters);
        $tenders = $tenderModel->filterTenders($filters, $perPage, $offset);
        $total = $tenderModel->countFilteredTenders($filters);

        return $this->respond([
            'data' => $tenders,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage),
        ]);
    }

    public function getTender($id)
    {
        $tenderModel = new TenderModel();
        $tender = $tenderModel->getTenderWithDetails($id);

        if (!$tender) {
            return $this->failNotFound('Tender not found');
        }

        return $this->respond($tender);
    }

    public function downloadDocument($documentId)
    {
        $documentModel = new TenderDocumentModel();
        $document = $documentModel->find($documentId);

        if (!$document) {
            return $this->failNotFound('Document not found');
        }

        $documentModel->incrementDownloadCount($documentId);
        $filePath = WRITEPATH . 'uploads/' . $document['file_path'];

        if (!file_exists($filePath)) {
            return $this->failNotFound('File not found');
        }

        return $this->response->download($filePath, null);
    }
}
