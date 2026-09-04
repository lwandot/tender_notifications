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
        // In development, use central mock data from Config\DevMocks
        if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
            $dev = new \Config\DevMocks();
            $tenders = $dev->tenders;

            $data = [
                'title' => 'Government Tenders (Development)',
                'tenders' => $tenders,
                'total' => count($tenders),
                'perPage' => 10,
                'page' => 1,
                'categories' => [],
                'organs' => [],
                'provinces' => [],
                'filters' => [],
                'rawApiResponse' => [],
                'requestUrl' => null,
            ];

            return view('home', $data);
        }
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
        $monthBack = date('Y-m-d', strtotime('-30 days'));

        // Get filters from request (only include values explicitly provided by the user)
        $filters = [
            'province_id' => $this->request->getVar('province_id'),
            'organ_of_state_id' => $this->request->getVar('organ_of_state_id'),
            'category_id' => $this->request->getVar('category_id'),
            'tender_type' => $this->request->getVar('tender_type'),
            'search' => $this->request->getVar('search'),
            'dateFrom' => $this->request->getVar('dateFrom') ?: $monthBack,
            'dateTo' => $this->request->getVar('dateTo') ?: $today,
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
            $totalTenders = $tenderModel->countFilteredTenders(['dateFrom' => $sevenDaysBack, 'dateTo' => $sevenDaysFromNow]);
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

    public function fetchTendersAjax()
    {
        $tenderModel = new TenderModel();

        $page = (int) ($this->request->getVar('page') ?? 1);
        $perPage = (int) ($this->request->getVar('perPage') ?? 10);
        $offset = ($page - 1) * $perPage;

        // Serve mock paginated data in development
        if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
            $dev = new \Config\DevMocks();
            $all = $dev->tenders;
            $total = count($all);
            $tenders = array_slice($all, $offset, $perPage);
            $requestUrl = null;
            $rawResponse = [];

            $partialData = [
                'tenders' => $tenders,
                'total' => $total,
                'perPage' => $perPage,
                'page' => $page,
            ];

            $html = view('partials/tenders_list', $partialData);

            return $this->response->setJSON([
                'html' => $html,
                'total' => $total,
                'page' => $page,
                'perPage' => $perPage,
                'requestUrl' => $requestUrl,
                'rawResponse' => $rawResponse,
            ]);
        }

        // default date ranges
        $today = date('Y-m-d');
        $sevenDaysFromNow = date('Y-m-d', strtotime('+7 days'));
        $sevenDaysBack = date('Y-m-d', strtotime('-7 days'));

        $filters = [
            'province_id' => $this->request->getVar('province_id'),
            'organ_of_state_id' => $this->request->getVar('organ_of_state_id'),
            'category_id' => $this->request->getVar('category_id'),
            'tender_type' => $this->request->getVar('tender_type'),
            'search' => $this->request->getVar('search'),
            'dateFrom' => $this->request->getVar('dateFrom') ?: $sevenDaysBack,
            'dateTo' => $this->request->getVar('dateTo') ?: $today,
        ];

        $filters = array_filter($filters, fn($v) => $v !== null && $v !== '');

        if (!empty($filters)) {
            $result = $tenderModel->filterTenders($filters, $perPage, $offset);
            $tenders = $result['tenders'];
            $total = $tenderModel->countFilteredTenders($filters);
            $requestUrl = $result['request_url'] ?? null;
            $rawResponse = $result['raw_response'] ?? null;
        } else {
            $result = $tenderModel->getActiveTenders($perPage, $offset, $sevenDaysBack, $sevenDaysFromNow);
            $tenders = $result['tenders'];
            $total = $tenderModel->countFilteredTenders(['dateFrom' => $sevenDaysBack, 'dateTo' => $sevenDaysFromNow]);
            $requestUrl = $result['request_url'] ?? null;
            $rawResponse = $result['raw_response'] ?? null;
        }

        $partialData = [
            'tenders' => $tenders,
            'total' => $total,
            'perPage' => $perPage,
            'page' => $page,
        ];

        $html = view('partials/tenders_list', $partialData);

        return $this->response->setJSON([
            'html' => $html,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'requestUrl' => $requestUrl,
            'rawResponse' => $rawResponse,
        ]);
    }
}
