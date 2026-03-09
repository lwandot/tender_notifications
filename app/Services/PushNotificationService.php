<?php

namespace App\Services;

/**
 * PushNotificationService
 * Handles sending push notifications to subscribed users
 */
class PushNotificationService
{
    /**
     * Send push notification via Firebase Cloud Messaging or similar service
     */
    public function sendPushNotification($pushToken, $title, $body, $data = [])
    {
        try {
            // Using Firebase Cloud Messaging as an example
            $serverKey = getenv('FCM_SERVER_KEY');
            
            if (!$serverKey) {
                log_message('warning', 'FCM_SERVER_KEY not configured');
                return false;
            }

            $url = 'https://fcm.googleapis.com/fcm/send';
            
            $notification = [
                'title' => $title,
                'body' => $body,
                'sound' => 'default',
                'icon' => 'notification_icon'
            ];

            $payload = [
                'to' => $pushToken,
                'notification' => $notification,
                'data' => $data
            ];

            $headers = [
                'Authorization' => 'key=' . $serverKey,
                'Content-Type' => 'application/json'
            ];

            $client = \Config\Services::curlRequest();
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'json' => $payload,
                'http_errors' => false
            ]);

            if ($response->getStatusCode() !== 200) {
                log_message('error', 'FCM error: ' . $response->getBody());
                return false;
            }

            return true;
        } catch (\Exception $e) {
            log_message('error', 'Push notification error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send Email notification
     */
    public function sendEmailNotification($email, $title, $body, $tenderId = null)
    {
        try {
            $emailService = \Config\Services::email();
            
            $emailService->setFrom(getenv('email_from') ?? 'noreply@govtenders.local', 'Government Tenders');
            $emailService->setTo($email);
            $emailService->setSubject($title);
            
            // Build email body
            $htmlBody = view('emails/tender_notification', [
                'title' => $title,
                'body' => $body,
                'tenderId' => $tenderId,
                'viewUrl' => base_url('/tender/view/' . $tenderId)
            ]);
            
            $emailService->setMessage($htmlBody);
            
            if (!$emailService->send(false)) {
                log_message('error', 'Email error: ' . $emailService->printDebugger());
                return false;
            }

            return true;
        } catch (\Exception $e) {
            log_message('error', 'Email notification error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send SMS notification
     */
    public function sendSMSNotification($phone, $message)
    {
        try {
            $smsProvider = getenv('SMS_PROVIDER') ?? 'bulk-sms'; // Options: 'bulk-sms', 'twilio', etc.
            
            if ($smsProvider === 'twilio') {
                return $this->sendViaTwilio($phone, $message);
            } else if ($smsProvider === 'bulk-sms') {
                return $this->sendViaBulkSMS($phone, $message);
            }

            return false;
        } catch (\Exception $e) {
            log_message('error', 'SMS notification error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send via Twilio SMS service
     */
    private function sendViaTwilio($phone, $message)
    {
        // Implement Twilio integration
        // Requires: twilio/sdk package
        return true;
    }

    /**
     * Send via Bulk SMS service
     */
    private function sendViaBulkSMS($phone, $message)
    {
        try {
            $url = 'https://api.bulksms.com/v1/messages';
            $username = getenv('BULKSMS_USERNAME');
            $password = getenv('BULKSMS_PASSWORD');

            $client = \Config\Services::curlRequest();
            $response = $client->request('POST', $url, [
                'auth' => [$username, $password],
                'json' => [
                    'to' => $phone,
                    'body' => $message
                ],
                'http_errors' => false
            ]);

            return $response->getStatusCode() === 201;
        } catch (\Exception $e) {
            log_message('error', 'Bulk SMS error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Notify subscribers about a new tender
     */
    public function notifySubscribersAboutTender($tenderId)
    {
        $subscriptionModel = new \App\Models\UserSubscriptionModel();
        $tenderModel = new \App\Models\TenderModel();

        $tender = $tenderModel->find($tenderId);
        if (!$tender) {
            return false;
        }

        $subscribers = $subscriptionModel->getSubscribersForTender($tenderId);

        $title = 'New Tender: ' . $tender['title'];
        $body = 'A new tender matching your interests has been published.';

        foreach ($subscribers as $subscriber) {
            switch ($subscriber['notification_type']) {
                case 'push':
                    if (!empty($subscriber['push_token'])) {
                        $this->sendPushNotification($subscriber['push_token'], $title, $body, [
                            'tenderId' => (string)$tenderId
                        ]);
                    }
                    break;
                case 'email':
                    $this->sendEmailNotification($subscriber['email'], $title, $body, $tenderId);
                    break;
                case 'sms':
                    if (!empty($subscriber['phone'])) {
                        $smsMessage = substr($body, 0, 160);
                        $this->sendSMSNotification($subscriber['phone'], $smsMessage);
                    }
                    break;
            }
        }

        return true;
    }
}
