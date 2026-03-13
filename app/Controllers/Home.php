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

        // Set default date range: today to 7 days from now
        $today = date('Y-m-d');
        $sevenDaysFromNow = date('Y-m-d', strtotime('+7 days'));
        $sevenDaysBack = date('Y-m-d', strtotime('-7 days'));

        // Get filters from request (only include values explicitly provided by the user)
        $filters = [
            'province_id' => $this->request->getVar('province_id'),
            'organ_of_state_id' => $this->request->getVar('organ_of_state_id'),
            'category_id' => $this->request->getVar('category_id'),
            'tender_type' => $this->request->getVar('tender_type'),
            'search' => $this->request->getVar('search'),
            'dateFrom' => $this->request->getVar('dateFrom'),
            'dateTo' => $this->request->getVar('dateTo'),
        ];

        // Remove empty filters so we only apply filtering when user has selected something
        $filters = array_filter($filters, fn($v) => $v !== null && $v !== '');

        if (!empty($filters)) {
            // User has applied filters: use the filtered search
            $result = $tenderModel->filterTenders($filters, $perPage, $offset);
            $tenders = $result['tenders'];
            $totalTenders = $tenderModel->countFilteredTenders($filters);
            $rawApiResponse = $result['raw_response'];
            $requestUrl = $result['request_url'];
        } else {
            // Initial page load: show active tenders (no filters)
            $result = $tenderModel->getActiveTenders($perPage, $offset, $sevenDaysBack, $sevenDaysFromNow);
            $tenders = $result['tenders'];
            $totalTenders = $tenderModel->countFilteredTenders([]);
            $rawApiResponse = $result['raw_response'];
            $requestUrl = $result['request_url'];
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
            'rawApiResponse' => $rawApiResponse,
            'requestUrl' => $requestUrl,
        ];

        return view('home', $data);
    }

    public function getTenderTypes()
    {
        $types = ['goods', 'services', 'works'];
        return $this->response->setJSON(['types' => $types]);
    }
}
