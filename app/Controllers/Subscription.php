<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SubscriptionModel;
use App\Models\CategoryModel;
use App\Models\ProvinceModel;
use App\Models\OrganModel;

class Subscription extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $provinceModel = new ProvinceModel();
        $organModel = new OrganModel();

        // Feed database values to setup multiselection lists on client side
        $data = [
            'title'      => 'Subscribe for Tenders Notifications - South Africa',
            'categories' => $categoryModel->findAll(),
            'provinces'  => $provinceModel->findAll(),
            'organs'     => $organModel->findAll(),
            'csrf_token' => csrf_token(),
            'csrf_hash'  => csrf_hash()
        ];

        return view('layout/header', $data)
             . view('subscription/index', $data)
             . view('layout/footer');
    }

    public function process()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/subscription');
        }

        $userModel = new UserModel();
        $subscriptionModel = new SubscriptionModel();

        // Package and validation variables matching requirements:
        // Basic R29 limit rules (<=5 categories, <=2 provinces, whatsapp/email only)
        // Premium R49 limit rules (<=10 categories, multiple provinces, push/sms/whatsapp/email)
        $packageId = $this->request->getPost('package_id');
        $selectedCategories = $this->request->getPost('categories') ?? [];
        $selectedProvinces  = $this->request->getPost('provinces') ?? [];
        $selectedOrgans     = $this->request->getPost('organs') ?? [];
        $selectedChannels   = $this->request->getPost('channels') ?? [];

        // Determine price and limits validation on backend
        $price = 0.00;
        $packageName = 'Free Trial';
        $limitCategories = 1;
        $limitProvinces = 1;

        if ($packageId === 'basic') {
            $price = 29.00;
            $packageName = 'Basic Alert';
            $limitCategories = 5;
            $limitProvinces = 2;

            // Enforce Whatsapp/Email only
            if (in_array('sms', $selectedChannels) || in_array('push', $selectedChannels)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'The R29.00 Basic alert package is restricted to Email and WhatsApp notifications only. Upgrade to R49.00 Premium Max to unlock SMS and Push Notifications.'
                ]);
            }
        } elseif ($packageId === 'premium') {
            $price = 49.00;
            $packageName = 'Premium Max';
            $limitCategories = 10;
            $limitProvinces = 9;
        } elseif ($packageId === 'free') {
            $price = 0.00;
            $packageName = 'Free Trial';
            $limitCategories = 1;
            $limitProvinces = 1;

            if (count($selectedChannels) > 1 || !in_array('email', $selectedChannels)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'The Free Trial is limited to Email notifications only.'
                ]);
            }
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid package plan selected.'
            ]);
        }

        // Validate multiple-selection limits against package boundaries
        if (count($selectedCategories) > $limitCategories) {
            return $this->response->setJSON([
                'success' => false,
                'message' => "The selected package ($packageName at R$price) only supports up to $limitCategories categories. You selected " . count($selectedCategories) . "."
            ]);
        }

        if (count($selectedProvinces) > $limitProvinces) {
            return $this->response->setJSON([
                'success' => false,
                'message' => "The selected package ($packageName at R$price) only supports up to $limitProvinces provinces. You selected " . count($selectedProvinces) . "."
            ]);
        }

        if (empty($selectedChannels)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please select at least one notification delivery channel.'
            ]);
        }

        // User Input validations
        $email = $this->request->getPost('email');
        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');
        $whatsapp = $this->request->getPost('whatsapp');

        if (in_array('email', $selectedChannels) && empty($email)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Please provide a valid email address.']);
        }
        if (in_array('whatsapp', $selectedChannels) && empty($whatsapp)) {
            return $this->response->setJSON(['success' => false, 'message' => 'WhatsApp number is required for R29 / R49 alerts.']);
        }
        if (in_array('sms', $selectedChannels) && empty($phone)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Mobile number is required for SMS broadcasts.']);
        }

        // Register user or retrieve if already registered
        $existingUser = $userModel->where('email', $email)->first();
        if ($existingUser) {
            $userId = $existingUser['id'];
            // Update details
            $userModel->update($userId, [
                'name'     => $name,
                'phone'    => $phone,
                'whatsapp' => $whatsapp
            ]);
        } else {
            $userId = $userModel->insert([
                'name'     => $name,
                'email'    => $email,
                'phone'    => $phone,
                'whatsapp' => $whatsapp
            ]);

            if ($userModel->errors()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => implode(' ', $userModel->errors())
                ]);
            }
        }

        // Insert new Subscription matching the customized packages specifications
        $subscriptionData = [
            'user_id'             => $userId,
            'package_id'          => $packageId,
            'package_name'        => $packageName,
            'price'               => $price,
            'channels'            => json_encode($selectedChannels),
            'selected_categories' => json_encode($selectedCategories),
            'selected_provinces'  => json_encode($selectedProvinces),
            'selected_organs'     => json_encode($selectedOrgans),
            'status'              => ($price > 0.00) ? 'pending_payment' : 'active'
        ];

        $subId = $subscriptionModel->insert($subscriptionData);

        if (!$subId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while setting up your subscription alerts.'
            ]);
        }

        return $this->response->setJSON([
            'success'          => true,
            'message'          => 'Tenders notify subscription successfully active!',
            'subscription_id'  => 'GT-' . str_pad($subId, 6, "0", STR_PAD_LEFT),
            'requires_payment' => ($price > 0.00),
            'price'            => $price,
            'package_name'     => $packageName
        ]);
    }
}
