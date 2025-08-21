<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>{{ $pageTitle ?? 'MixJo Tourism' }} - World's Largest Geographic Database</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="{{ $pageDescription ?? 'Tourism Dashboard with 88,092 cities & 245 countries' }}" />
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <!-- Custom Metronic-inspired Styles -->
    <style>
        :root {
            --bs-primary: #009ef7;
            --bs-success: #50cd89;
            --bs-danger: #f1416c;
            --bs-warning: #ffc700;
            --bs-info: #7239ea;
            --sidebar-bg: #1e2129;
            --header-bg: #ffffff;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f8fa;
            font-weight: 400;
        }
        
        .app-sidebar {
            background: var(--sidebar-bg);
            color: white;
            min-height: 100vh;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .app-header {
            background: var(--header-bg);
            box-shadow: 0 1px 10px rgba(0,0,0,0.05);
            border-bottom: 1px solid #e4e6ef;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            padding: 0.75rem 1rem;
            border-radius: 0.475rem;
            margin-bottom: 0.25rem;
            transition: all 0.3s;
        }
        
        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white !important;
        }
        
        .nav-link.active {
            background: var(--bs-primary);
            color: white !important;
        }
        
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.08);
            transition: all 0.3s;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 1rem 3rem rgba(0,0,0,0.12);
        }
        
        .progress {
            height: 8px;
            border-radius: 1rem;
            overflow: hidden;
        }
        
        .avatar-lg {
            width: 4rem;
            height: 4rem;
        }
        
        .fs-1 {
            font-size: 2.5rem !important;
            font-weight: 700;
        }
        
        .badge {
            font-weight: 500;
            padding: 0.5rem 0.75rem;
        }
        
        .btn {
            border-radius: 0.475rem;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
        }
        
        /* Loading Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .card {
            animation: fadeInUp 0.6s ease-out;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .app-sidebar {
                min-height: auto;
            }
        }
    </style>
    
    @stack('custom_css')
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="app-sidebar" style="width: 280px;">
            <div class="p-4">
                <!-- Logo -->
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary rounded-3 p-2 me-3">
                        <i class="fas fa-globe text-white fs-4"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-0">MixJo Tourism</h5>
                        <small class="text-white-50">Dashboard</small>
                    </div>
                </div>
                
                <!-- Navigation Menu -->
                <nav class="nav flex-column">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-home me-3"></i>Dashboard
                    </a>
                    <div class="nav-header text-white-50 text-uppercase fs-7 fw-bold mt-4 mb-2">Geographic Database</div>
                    <a href="#" class="nav-link">
                        <i class="fas fa-flag me-3"></i>Countries <span class="badge bg-danger ms-auto">245</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-city me-3"></i>Cities <span class="badge bg-success ms-auto">88K+</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-coins me-3"></i>Currencies <span class="badge bg-warning ms-auto">49</span>
                    </a>
                    <div class="nav-header text-white-50 text-uppercase fs-7 fw-bold mt-4 mb-2">User Management</div>
                    <a href="#" class="nav-link">
                        <i class="fas fa-users me-3"></i>Users <span class="badge bg-info ms-auto">10</span>
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-fill">
            <!-- Header -->
            <div class="app-header p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0 fw-bold">{{ $pageTitle ?? 'Dashboard' }}</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#" class="text-muted">Home</a></li>
                                <li class="breadcrumb-item active">{{ $pageTitle ?? 'Dashboard' }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="d-flex align-items-center">
                        <!-- Search -->
                        <div class="me-3">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-0 bg-light" placeholder="Search...">
                            </div>
                        </div>
                        <!-- User Menu -->
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown">
                                <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div class="d-none d-md-block">
                                    <div class="fw-semibold">Tourism Admin Pro</div>
                                    <small class="text-muted">admin@mixjo.com</small>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>My Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Sign Out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Page Content -->
            <div class="p-4">
                @yield('content')
            </div>
            
            <!-- Footer -->
            <footer class="text-center py-3 border-top bg-white mt-5">
                <div class="container-fluid">
                    <div class="text-muted">
                        <span>2025 © </span>
                        <a href="https://mixjo.com" target="_blank" class="text-primary fw-semibold">MixJo Tourism</a>
                        <span class="ms-3">
                            <a href="#" class="text-muted me-3">About</a>
                            <a href="#" class="text-muted me-3">Support</a>
                            <a href="#" class="text-muted">Contact</a>
                        </span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('custom_js')
    
    <script>
    // إعداد عام
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🌍 MixJo Tourism System Initialized');
        
        // تأثيرات تفاعلية للبطاقات
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
    </script>
</body>
</html>
