<?php

namespace App\Controllers;

use App\Models\UserSubscriptionModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class Subscription extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        if (!session()->has('user_id')) {
            throw new \CodeIgniter\Exceptions\RedirectException(redirect()->to('/auth/login'));
        }
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $subscriptionModel = new UserSubscriptionModel();
        $subscriptions = $subscriptionModel->getUserSubscriptions($userId);

        $data = [
            'title' => 'My Subscriptions',
            'subscriptions' => $subscriptions,
        ];

        return view('subscription/index', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() !== 'post') {
            return view('subscription/create');
        }

        $userId = session()->get('user_id');
        $subscriptionModel = new UserSubscriptionModel();

        $data = [
            'user_id' => $userId,
            'notification_type' => $this->request->getPost('notification_type'),
            'filter_type' => $this->request->getPost('filter_type'),
            'filter_value' => $this->request->getPost('filter_value'),
            'is_active' => true,
        ];

        if (!$subscriptionModel->insert($data)) {
            return $this->fail('Failed to create subscription', 400);
        }

        session()->setFlashdata('success', 'Subscription created successfully!');
        return redirect()->to('/subscription');
    }

    public function delete($id = null)
    {
        if ($id === null) {
            return $this->fail('Invalid subscription ID', 400);
        }

        $userId = session()->get('user_id');
        $subscriptionModel = new UserSubscriptionModel();
        $subscription = $subscriptionModel->find($id);

        if (!$subscription || $subscription['user_id'] != $userId) {
            return $this->fail('Unauthorized', 403);
        }

        $subscriptionModel->delete($id);
        session()->setFlashdata('success', 'Subscription deleted successfully!');

        return redirect()->to('/subscription');
    }

    public function registerPushToken()
    {
        $userId = session()->get('user_id');
        $token = $this->request->getPost('push_token');

        if (!$token) {
            return $this->fail('Push token required', 400);
        }

        $subscriptionModel = new UserSubscriptionModel();
        $subscriptionModel->where('user_id', $userId)
            ->where('notification_type', 'push')
            ->set(['push_token' => $token])
            ->update();

        return $this->respond(['success' => true], 200);
    }
}
