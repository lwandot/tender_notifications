<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div class="container">
        <h1 class="mb-0">
            <i class="fas fa-bell me-2"></i>My Subscriptions
        </h1>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <a href="/subscription/create" class="btn btn-primary mb-4">
                <i class="fas fa-plus me-2"></i>Create New Subscription
            </a>

            <?php if (empty($subscriptions)): ?>
                <div class="alert alert-info alert-custom" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    You don't have any active subscriptions yet.
                    <a href="/subscription/create" class="alert-link">Create one now</a>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($subscriptions as $sub): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="card-title">
                                                <?php
                                                if ($sub['filter_type'] == 'category') {
                                                    echo 'Category: ' . 'Category Name';
                                                } elseif ($sub['filter_type'] == 'province') {
                                                    echo 'Province Filter';
                                                } elseif ($sub['filter_type'] == 'organ_of_state') {
                                                    echo 'Organ of State Filter';
                                                } else {
                                                    echo 'Tender Subscription';
                                                }
                                                ?>
                                            </h5>
                                        </div>
                                        <span class="badge bg-<?= $sub['is_active'] ? 'success' : 'secondary' ?>">
                                            <?= $sub['is_active'] ? 'Active' : 'Inactive' ?>
                                        </span>
                                    </div>

                                    <p class="card-text mb-2">
                                        <strong>Type:</strong> 
                                        <span class="badge bg-info">
                                            <?= ucfirst($sub['notification_type']) ?>
                                        </span>
                                    </p>

                                    <p class="card-text small text-muted mb-3">
                                        <strong>Created:</strong> 
                                        <?= date('M d, Y', strtotime($sub['created_at'])) ?>
                                    </p>

                                    <div class="d-grid gap-2">
                                        <form method="post" action="/subscription/delete/<?= $sub['id'] ?>" 
                                              onsubmit="return confirm('Are you sure?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash me-1"></i>Cancel Subscription
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
