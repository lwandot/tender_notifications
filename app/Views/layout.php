<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>Government Tenders</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #0f766e;
            --accent-color: #dc2626;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
        }

        nav {
            background-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        nav .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        footer {
            background-color: var(--primary-color);
            color: white;
            margin-top: 3rem;
            padding: 2rem 0;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }

        .tender-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .tender-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        }

        .tender-header {
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-active {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-closed {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .filter-section {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #1e40af;
            border-color: #1e40af;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border-color: #86efac;
        }

        .pagination {
            margin-top: 2rem;
        }

        .tender-details {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .detail-section {
            margin-bottom: 2rem;
        }

        .detail-section h5 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 0.5rem;
        }

        .enquiry-item {
            background: #f1f5f9;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 0.5rem;
        }

        .document-item {
            border-left: 4px solid var(--secondary-color);
            padding-left: 1rem;
            margin-bottom: 1rem;
        }

        .btn-download {
            background-color: var(--secondary-color);
        }

        .btn-download:hover {
            background-color: #0d6a5a;
        }

        .no-results {
            text-align: center;
            padding: 3rem;
            color: #64748b;
        }

        .search-input {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            border: 2px solid #e2e8f0;
            transition: border-color 0.3s ease;
        }

        .search-input:focus {
            border-color: var(--secondary-color);
            outline: none;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 2rem 0;
            }

            .tender-card {
                margin-bottom: 1rem;
            }

            .filter-section {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-file-contract me-2"></i>GovTenders
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <?php if (session()->has('user_id')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/subscription">My Subscriptions</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i><?= session()->get('name') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/subscription">Subscriptions</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/auth/logout">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/auth/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/auth/register">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    <?php if (session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="container" style="min-height: 70vh;">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5><i class="fas fa-file-contract me-2"></i>GovTenders</h5>
                    <p class="text-white-50">A comprehensive platform for government tender information</p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled text-white-50">
                        <li><a href="/" class="text-white-50 text-decoration-none">Home</a></li>
                        <li><a href="/auth/login" class="text-white-50 text-decoration-none">Login</a></li>
                        <li><a href="/auth/register" class="text-white-50 text-decoration-none">Register</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6>Contact</h6>
                    <p class="text-white-50 mb-0">Email: info@govtenders.gov.za</p>
                    <p class="text-white-50">Phone: +27 (0)12 345 6789</p>
                </div>
            </div>
            <hr class="my-3 bg-white-50">
            <div class="text-center text-white-50">
                <p>&copy; 2026 Government Tenders. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
