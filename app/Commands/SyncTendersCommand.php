<?php

namespace App\Controllers;

use App\Models\TenderModel;
use App\Services\TreasuryAPIService;
use App\Services\PushNotificationService;

class SyncTendersCommand extends \CodeIgniter\CLI\BaseCommand
{
    protected $group = 'Treasury';
    protected $name = 'sync:tenders';
    protected $description = 'Sync tenders from Treasury API';
    protected $usage = 'sync:tenders [options]';
    protected $arguments = [];
    protected $options = [
        '--force' => 'Force sync regardless of last sync time',
    ];

    public function run(array $params = [])
    {
        $treasuryAPI = new TreasuryAPIService();
        $result = $treasuryAPI->syncTenders();

        if (isset($result['error'])) {
            $this->error("Sync failed: " . $result['error']);
            return;
        }

        $this->write("Successfully synced {$result['synced']} tenders", 'green');

        // Notify subscribers about new tenders
        $tenderModel = new TenderModel();
        $newTenders = $tenderModel->where('updated_at', '>=', date('Y-m-d H:i:s', time() - 3600))
            ->findAll();

        $pushService = new PushNotificationService();
        foreach ($newTenders as $tender) {
            $pushService->notifySubscribersAboutTender($tender['api_id']);
        }

        $this->write("Notified subscribers about {$result['synced']} new tenders", 'green');
    }
}
