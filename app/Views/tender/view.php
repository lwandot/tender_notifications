<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active"><?= substr($tender['title'], 0, 40) ?>...</li>
    </ol>
</nav>

<!-- API Response Toggle -->
<div class="container-fluid mb-4">
    <div class="d-flex justify-content-end">
        <button class="btn btn-outline-info btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#apiResponse" aria-expanded="false" aria-controls="apiResponse">
            <i class="fas fa-code me-2"></i>View API Request
        </button>
    </div>
    <div class="collapse mt-3" id="apiResponse">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-server me-2"></i>API Request Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Request URL:</strong>
                    <div class="mt-2">
                        <code class="bg-light p-2 rounded d-block text-break"><?= $requestUrl ?></code>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>OCID:</strong>
                    <div class="mt-2">
                        <code class="bg-light p-2 rounded d-block text-break"><?= $tender['api_id'] ?? $tender['tender_number'] ?></code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Tender Details -->
        <div class="tender-details">
            <div class="tender-header mb-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h1><?= $tender['title'] ?></h1>
                    <span class="status-badge status-<?= $tender['status'] ?>">
                        <?= ucfirst($tender['status']) ?>
                    </span>
                </div>
                <p class="text-muted">
                    <strong>Tender No:</strong> <?= $tender['tender_number'] ?>
                </p>
            </div>

            <!-- Basic Details -->
            <div class="detail-section">
                <h5><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Organ of State:</strong></p>
                        <p><?= $tender['organ_of_state']['name'] ?? 'N/A' ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Province:</strong></p>
                        <p><?= $tender['province']['name'] ?? 'N/A' ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Type:</strong></p>
                        <p><?= ucfirst($tender['tender_type']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Budget Estimate:</strong></p>
                        <p><?= $tender['budget_estimate'] ? 'R ' . number_format($tender['budget_estimate'], 2) : 'Not Specified' ?></p>
                    </div>
                </div>
            </div>

            <!-- Key Dates -->
            <div class="detail-section">
                <h5><i class="fas fa-calendar-alt me-2"></i>Key Dates</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p class="small text-muted mb-1">Published</p>
                        <p class="mb-0"><?= date('d M Y H:i', strtotime($tender['published_date'])) ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="small text-muted mb-1">Opening Date</p>
                        <p class="mb-0"><?= date('d M Y H:i', strtotime($tender['opening_date'])) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="small text-muted mb-1">Closing Date</p>
                        <p class="mb-0">
                            <strong class="text-danger"><?= date('d M Y H:i', strtotime($tender['closing_date'])) ?></strong>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="detail-section">
                <h5><i class="fas fa-file-alt me-2"></i>Description</h5>
                <div class="bg-light p-3 rounded">
                    <?= nl2br($tender['description']) ?>
                </div>
            </div>

            <!-- Enquiries -->
            <?php if (!empty($tender['enquiries'])): ?>
                <div class="detail-section">
                    <h5><i class="fas fa-question-circle me-2"></i>Tender Enquiries Contact</h5>
                    <?php foreach ($tender['enquiries'] as $enquiry): ?>
                        <div class="enquiry-item">
                            <p class="mb-1">
                                <strong><?= $enquiry['contact_person'] ?></strong>
                            </p>
                            <p class="mb-1 small">
                                <i class="fas fa-envelope me-2"></i>
                                <a href="mailto:<?= $enquiry['email'] ?>"><?= $enquiry['email'] ?></a>
                            </p>
                            <?php if ($enquiry['phone']): ?>
                                <p class="mb-1 small">
                                    <i class="fas fa-phone me-2"></i>
                                    <a href="tel:<?= $enquiry['phone'] ?>"><?= $enquiry['phone'] ?></a>
                                </p>
                            <?php endif; ?>
                            <?php if ($enquiry['fax']): ?>
                                <p class="mb-0 small">
                                    <i class="fas fa-fax me-2"></i>
                                    <?= $enquiry['fax'] ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Briefing Sessions -->
            <?php if (!empty($tender['briefing_sessions'])): ?>
                <div class="detail-section">
                    <h5><i class="fas fa-video me-2"></i>Briefing Sessions</h5>
                    <?php foreach ($tender['briefing_sessions'] as $session): ?>
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="mb-1">
                                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                                            <strong><?= date('d M Y', strtotime($session['date'])) ?> at <?= date('H:i', strtotime($session['time'])) ?></strong>
                                        </p>
                                        <p class="mb-0">
                                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                            <?= $session['is_virtual'] ? 'Virtual Session' : 'Physical Session' ?>
                                        </p>
                                        <p class="small text-muted mb-0 mt-2"><?= $session['venue'] ?></p>
                                        <?php if ($session['is_virtual'] && $session['virtual_link']): ?>
                                            <a href="<?= $session['virtual_link'] ?>" target="_blank" class="btn btn-sm btn-primary mt-2">
                                                <i class="fas fa-link me-1"></i>Join Virtual Session
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Documents -->
            <?php if (!empty($tender['documents'])): ?>
                <div class="detail-section">
                    <h5><i class="fas fa-file-download me-2"></i>Tender Documents</h5>
                    <?php foreach ($tender['documents'] as $doc): ?>
                        <div class="document-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1">
                                        <strong><?= $doc['document_name'] ?></strong>
                                    </p>
                                    <p class="small text-muted mb-0">
                                        <?= strtoupper($doc['file_type']) ?> • 
                                        <?= number_format($doc['file_size'] / 1024 / 1024, 2) ?> MB • 
                                        Downloaded <?= $doc['download_count'] ?> times
                                    </p>
                                </div>
                                <a href="/api/documents/download/<?= $doc['id'] ?>" class="btn btn-sm btn-download text-white">
                                    <i class="fas fa-download me-1"></i>Download
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Subscribe Card -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="fas fa-bell me-2"></i>Stay Updated
                </h5>
                <?php if (session()->has('user_id')): ?>
                    <form action="/subscription/create" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="filter_type" value="tender">
                        <input type="hidden" name="filter_value" value="<?= $tender['id'] ?>">
                        <p class="small text-muted mb-3">Get notified when new tenders matching your interests are published</p>
                        <div class="mb-3">
                            <label for="notifType" class="form-label small">Notification Type</label>
                            <select class="form-select form-select-sm" id="notifType" name="notification_type">
                                <option value="email">Email</option>
                                <option value="push">Push Notification</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check me-2"></i>Subscribe
                        </button>
                    </form>
                <?php else: ?>
                    <p class="small text-muted mb-3">Sign up to receive notifications for new tenders</p>
                    <a href="/auth/register" class="btn btn-primary w-100">
                        <i class="fas fa-user-plus me-2"></i>Create Account
                    </a>
                    <a href="/auth/login" class="btn btn-outline-primary w-100 mt-2">
                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Share Card -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="fas fa-share-alt me-2"></i>Share
                </h5>
                <div class="d-grid gap-2">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" 
                       target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="fab fa-facebook me-2"></i>Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($tender['title']) ?>" 
                       target="_blank" class="btn btn-outline-info btn-sm">
                        <i class="fab fa-twitter me-2"></i>Twitter
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(current_url()) ?>" 
                       target="_blank" class="btn btn-outline-secondary btn-sm">
                        <i class="fab fa-linkedin me-2"></i>LinkedIn
                    </a>
                </div>
            </div>
        </div>

        <!-- Print Card -->
        <div class="card">
            <div class="card-body">
                <button class="btn btn-outline-secondary w-100" onclick="window.print()">
                    <i class="fas fa-print me-2"></i>Print Tender
                </button>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="/" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Tenders
    </a>
</div>

<?= $this->endSection() ?>
