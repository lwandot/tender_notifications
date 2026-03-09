<?php

namespace App\Controllers;

use App\Models\TenderModel;

class Tender extends BaseController
{
    public function view($id = null)
    {
        if ($id === null) {
            return redirect()->to('/');
        }

        $tenderModel = new TenderModel();
        $tender = $tenderModel->getTenderWithDetails($id);

        if (!$tender) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tender not found');
        }

        $data = [
            'title' => $tender['title'],
            'tender' => $tender,
        ];

        return view('tender/view', $data);
    }

    public function search()
    {
        $tenderModel = new TenderModel();
        $query = $this->request->getVar('q');
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $filters = ['search' => $query];
        $tenders = $tenderModel->filterTenders($filters, $perPage, $offset);
        $total = $tenderModel->countFilteredTenders($filters);

        $data = [
            'title' => 'Search Results: ' . $query,
            'tenders' => $tenders,
            'total' => $total,
            'perPage' => $perPage,
            'page' => $page,
            'query' => $query,
        ];

        return view('tender/search', $data);
    }
}
