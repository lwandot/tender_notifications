<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #003d6b; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { background-color: #f8f9fa; padding: 20px; border: 1px solid #dee2e6; }
        .tender-info { background-color: white; padding: 15px; border-left: 4px solid #0066b2; margin: 15px 0; }
        .footer { background-color: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #6c757d; border-top: 1px solid #dee2e6; }
        .btn { display: inline-block; background-color: #0066b2; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
        h2 { color: #003d6b; margin-top: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Government Tender Notification</h1>
        </div>
        <div class="content">
            <h2><?= $title ?></h2>
            
            <p><?= $body ?></p>
            
            <div class="tender-info">
                <h3>View Tender Details</h3>
                <p>Click the button below to view the full tender details:</p>
                <a href="<?= $viewUrl ?>" class="btn">View Tender</a>
            </div>

            <p>
                You are receiving this email because you have subscribed to government tender notifications. 
                To manage your subscriptions, <a href="<?= base_url('/subscription') ?>">click here</a>.
            </p>
        </div>
        <div class="footer">
            <p>&copy; <?= date('Y') ?> Government Tenders Portal. All rights reserved.</p>
            <p>This is an automated message, please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
