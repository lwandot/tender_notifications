<?php

namespace App\Models;

use CodeIgniter\Model;

class UserSubscriptionModel extends Model
{
    protected $table = 'user_subscriptions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'user_id', 'notification_type', 'filter_type', 
        'filter_value', 'is_active', 'push_token'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'user_id' => 'required|integer',
        'notification_type' => 'required|in_list[email,push,sms]',
        'filter_type' => 'in_list[category,province,organ_of_state]',
        'filter_value' => 'string|max_length[100]',
        'is_active' => 'in_list[0,1]',
        'push_token' => 'string|max_length[255]',
    ];

    public function getUserSubscriptions($userId, $type = null)
    {
        $builder = $this->where('user_id', $userId)
            ->where('is_active', true);

        if ($type) {
            $builder->where('notification_type', $type);
        }

        return $builder->findAll();
    }

    public function getSubscribersForTender($tenderId)
    {
        // Get all users subscribed to this tender's category, province, or organ of state
        $tender = (new TenderModel())->find($tenderId);
        if (!$tender) {
            return [];
        }

        // Get categories for this tender
        $categoryIds = (new TenderModel())->db->table('tender_categories')
            ->where('tender_id', $tenderId)
            ->select('category_id')
            ->get()
            ->getResultArray();

        $categoryIds = array_column($categoryIds, 'category_id');

        $subscribers = $this->db->table('user_subscriptions')
            ->join('users', 'user_subscriptions.user_id = users.id')
            ->where('user_subscriptions.is_active', true)
            ->groupStart()
                ->groupStart()
                    ->where('user_subscriptions.filter_type', 'category')
                    ->whereIn('user_subscriptions.filter_value', $categoryIds)
                ->groupEnd()
                ->orGroupStart()
                    ->where('user_subscriptions.filter_type', 'province')
                    ->where('user_subscriptions.filter_value', $tender['province_id'])
                ->groupEnd()
                ->orGroupStart()
                    ->where('user_subscriptions.filter_type', 'organ_of_state')
                    ->where('user_subscriptions.filter_value', $tender['organ_of_state_id'])
                ->groupEnd()
            ->groupEnd()
            ->select('users.*', 'user_subscriptions.notification_type', 'user_subscriptions.push_token')
            ->distinct()
            ->get()
            ->getResultArray();

        return $subscribers;
    }
}
