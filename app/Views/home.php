<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <h1 class="mb-4">
            <i class="fas fa-search me-3"></i>Government Tenders
        </h1>
        <p class="lead mb-0">Search and browse active government tenders across provinces and state organs</p>
    </div>
</div>

<!-- API Response Toggle -->
<div class="container mt-4">
    <div class="d-flex justify-content-end">
        <button class="btn btn-outline-info btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#apiResponse" aria-expanded="false" aria-controls="apiResponse">
            <i class="fas fa-code me-2"></i>Toggle API Response
        </button>
    </div>
    <div class="collapse mt-3" id="apiResponse">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-server me-2"></i>Raw API Response</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Request URL:</strong>
                    <div class="mt-2">
                        <code class="bg-light p-2 rounded d-block text-break"><?= $requestUrl ?></code>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Response Data:</strong>
                </div>
                <pre class="bg-light p-3 rounded"><code><?= json_encode($rawApiResponse, JSON_PRETTY_PRINT) ?></code></pre>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <!-- Filters Sidebar -->
    <div class="col-lg-3 mb-4">
        <div class="filter-section">
            <h5 class="mb-4"><i class="fas fa-filter me-2"></i>Filters</h5>
            
            <form method="get" action="/" class="filter-form">
                <!-- Search -->
                <div class="mb-3">
                    <label for="search" class="form-label">Search Tenders</label>
                    <input type="text" class="form-control search-input" id="search" name="search" 
                           placeholder="Tender number, title..." value="<?= isset($filters['search']) ? $filters['search'] : '' ?>">
                </div>

                <!-- Province -->
                <div class="mb-3">
                    <label for="province" class="form-label">Province</label>
                    <select class="form-select" id="province" name="province_id">
                        <option value="">All Provinces</option>
                        <?php foreach ($provinces as $province): ?>
                            <option value="<?= $province['id'] ?>" 
                                    <?= (isset($filters['province_id']) && $filters['province_id'] == $province['id']) ? 'selected' : '' ?>>
                                <?= $province['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Organ of State -->
                <div class="mb-3">
                    <label for="organ" class="form-label">Organ of State</label>
                    <select class="form-select" id="organ" name="organ_of_state_id">
                        <option value="">All Organs</option>
                        <?php foreach ($organs as $organ): ?>
                            <option value="<?= $organ['id'] ?>"
                                    <?= (isset($filters['organ_of_state_id']) && $filters['organ_of_state_id'] == $organ['id']) ? 'selected' : '' ?>>
                                <?= $organ['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Category -->
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category_id">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"
                                    <?= (isset($filters['category_id']) && $filters['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                <?= $category['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Tender Type -->
                <div class="mb-3">
                    <label for="type" class="form-label">Tender Type</label>
                    <select class="form-select" id="type" name="tender_type">
                        <option value="">All Types</option>
                        <option value="goods" <?= (isset($filters['tender_type']) && $filters['tender_type'] == 'goods') ? 'selected' : '' ?>>Goods</option>
                        <option value="services" <?= (isset($filters['tender_type']) && $filters['tender_type'] == 'services') ? 'selected' : '' ?>>Services</option>
                        <option value="works" <?= (isset($filters['tender_type']) && $filters['tender_type'] == 'works') ? 'selected' : '' ?>>Works</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div class="mb-3">
                    <label for="dateFrom" class="form-label">From Date</label>
                    <input type="date" class="form-control" id="dateFrom" name="dateFrom" 
                           value="<?= isset($filters['dateFrom']) ? $filters['dateFrom'] : '' ?>">
                </div>

                <div class="mb-3">
                    <label for="dateTo" class="form-label">To Date</label>
                    <input type="date" class="form-control" id="dateTo" name="dateTo" 
                           value="<?= isset($filters['dateTo']) ? $filters['dateTo'] : '' ?>">
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-2"></i>Search
                </button>
                <a href="/" class="btn btn-secondary w-100 mt-2">
                    <i class="fas fa-redo me-2"></i>Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Tenders List -->
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>
                <i class="fas fa-list me-2"></i>
                <?= $total ?> Active Tender<?= $total != 1 ? 's' : '' ?>
            </h3>
        </div>

        <?php if (!empty($tenders)): ?>
            <?php foreach ($tenders as $tender): ?>
                <div class="card tender-card">
                    <div class="card-body">
                        <div class="tender-header">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h4 class="card-title mb-0">
                                    <a href="/tender/view/<?= $tender['api_id'] ?>" class="text-decoration-none">
                                        <?= substr($tender['title'], 0, 60) . (strlen($tender['title']) > 60 ? '...' : '') ?>
                                    </a>
                                </h4>
                                <span class="status-badge status-<?= $tender['status'] ?>">
                                    <?= ucfirst($tender['status']) ?>
                                </span>
                            </div>
                            <p class="text-muted mb-0 small">
                                <strong>Tender #:</strong> <?= $tender['tender_number'] ?>
                            </p>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <i class="fas fa-building text-primary me-2"></i>
                                    <strong>Organ:</strong> 
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <strong>Province:</strong>
                                </p>
                            </div>
                        </div>

                        <p class="card-text text-muted">
                            <?= substr($tender['description'], 0, 150) . (strlen($tender['description']) > 150 ? '...' : '') ?>
                        </p>

                        <div class="row text-center border-top border-bottom py-3 mb-3">
                            <div class="col-md-4">
                                <p class="small text-muted mb-0">Type</p>
                                <p class="mb-0"><strong><?= ucfirst($tender['tender_type']) ?></strong></p>
                            </div>
                            <div class="col-md-4">
                                <p class="small text-muted mb-0">Closes</p>
                                <p class="mb-0"><strong><?= date('d M Y', strtotime($tender['closing_date'])) ?></strong></p>
                            </div>
                            <div class="col-md-4">
                                <p class="small text-muted mb-0">Budget</p>
                                <p class="mb-0"><strong><?= $tender['budget_estimate'] ? 'R ' . number_format($tender['budget_estimate'], 2) : 'TBD' ?></strong></p>
                            </div>
                        </div>

                        <a href="/tender/view/<?= $tender['api_id'] ?>" class="btn btn-primary">
                            <i class="fas fa-eye me-2"></i>View Details
                        </a>
                        <?php if (session()->has('user_id')): ?>
                            <button class="btn btn-outline-success" onclick="subscribeTender(<?= $tender['api_id'] ?>)">
                                <i class="fas fa-bell me-2"></i>Subscribe to Updates
                            </button>
                        <?php else: ?>
                            <a href="/auth/login" class="btn btn-outline-success">
                                <i class="fas fa-bell me-2"></i>Subscribe to Updates
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php 
                    $totalPages = ceil($total / $perPage);
                    $startPage = max(1, $page - 2);
                    $endPage = min($totalPages, $page + 2);
                    
                    if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="/?page=1<?= isset($filters['search']) ? '&search=' . $filters['search'] : '' ?>">
                                First
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="/?page=<?= $i ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="/?page=<?= $totalPages ?>">
                                Last
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php else: ?>
            <div class="no-results">
                <i class="fas fa-inbox fa-3x mb-3 text-muted"></i>
                <h4>No tenders found</h4>
                <p>Try adjusting your search filters or browse all available tenders.</p>
                <a href="/" class="btn btn-primary mt-3">View All Tenders</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function subscribeTender(tenderId) {
    // This will be implemented with the subscription functionality
    window.location.href = '/subscription/create?tender_id=' + tenderId;
}
</script>
<?= $this->endSection() ?>
