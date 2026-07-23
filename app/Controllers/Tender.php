<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProvinceModel;
use App\Models\OrganModel;

class Tenders extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $provinceModel = new ProvinceModel();
        $organModel = new OrganModel();

        // Retrieve filters dynamically from DB
        $data = [
            'title'      => 'Active Government Tenders Portal',
            'categories' => $categoryModel->findAll(),
            'provinces'  => $provinceModel->findAll(),
            'organs'     => $organModel->findAll(),
            // Pass hardcoded mock active items for dynamic listing
            'tenders'    => [
                [
                    'refNumber'     => 'RT29-2024',
                    'title'         => 'Supply and Delivery of Medical Equipment to the State',
                    'department'    => 'National Treasury',
                    'location'      => 'Gauteng',
                    'closingDate'   => '15 Aug 2024',
                    'publishedDate' => '2 days ago',
                    'iconType'      => 'medical'
                ],
                [
                    'refNumber'     => 'W11432',
                    'title'         => 'Maintenance of Water Treatment Plants - Region 4',
                    'department'    => 'Department of Water and Sanitation',
                    'location'      => 'Western Cape',
                    'closingDate'   => '22 Aug 2024',
                    'publishedDate' => '3 days ago',
                    'iconType'      => 'engineering'
                ],
                [
                    'refNumber'     => 'SITA/2024/005',
                    'title'         => 'Supply of Laptops and Peripherals for Schools',
                    'department'    => 'SITA',
                    'location'      => 'Limpopo',
                    'closingDate'   => '30 Aug 2024',
                    'publishedDate' => 'Today',
                    'iconType'      => 'computer'
                ],
                [
                    'refNumber'     => 'EDU-08-2024',
                    'title'         => 'Provision of School Nutrition Program Services',
                    'department'    => 'Department of Education',
                    'location'      => 'KwaZulu-Natal',
                    'closingDate'   => '10 Sep 2024',
                    'publishedDate' => '1 day ago',
                    'iconType'      => 'general'
                ],
            ]
        ];

        // Load Views
        return view('layout/header', $data)
             . view('tenders/index', $data)
             . view('layout/footer');
    }
}
