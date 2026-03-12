<?php

namespace App\Controllers;

use App\Models\TenderModel;
use App\Models\CategoryModel;
use App\Models\OrganOfStateModel;
use App\Models\ProvinceModel;

class Home extends BaseController
{
    public function index()
    {
        $tenderModel = new TenderModel();
        $categoryModel = new CategoryModel();
        $organModel = new OrganOfStateModel();
        $provinceModel = new ProvinceModel();

        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        // Get filters from request
        $filters = [
            'province_id' => $this->request->getVar('province_id'),
            'organ_of_state_id' => $this->request->getVar('organ_of_state_id'),
            'category_id' => $this->request->getVar('category_id'),
            'tender_type' => $this->request->getVar('tender_type'),
            'search' => $this->request->getVar('search'),
            'dateFrom' => $this->request->getVar('dateFrom'),
            'dateTo'   => $this->request->getVar('dateTo'),
        ];

        // Remove null filters
        $filters = array_filter($filters, fn($v) => $v !== null && $v !== '');

        // Choose retrieval method depending on presence of filters
        if (empty($filters)) {
            // page load, no user filters: use getActiveTenders so defaults are applied
            $tenders = $tenderModel->getActiveTenders($perPage, $offset);
            $totalTenders = $tenderModel->countFilteredTenders([]);
        } else {
            $tenders = $tenderModel->filterTenders($filters, $perPage, $offset);
            $totalTenders = $tenderModel->countFilteredTenders($filters);
        }

        // Get filter options
        $categories = $categoryModel->findAll();
        $organs = $organModel->findAll();
        $provinces = $provinceModel->findAll();

        $data = [
            'title' => 'Government Tenders',
            'tenders' => $tenders,
            'total' => $totalTenders,
            'perPage' => $perPage,
            'page' => $page,
            'categories' => $categories,
            'organs' => $organs,
            'provinces' => $provinces,
            'filters' => $filters,
        ];

        return view('home', $data);
    }

    public function getTenderTypes()
    {
        $types = ['goods', 'services', 'works'];
        return $this->response->setJSON(['types' => $types]);
    }
}
