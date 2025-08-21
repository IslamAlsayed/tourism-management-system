<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - World's Largest Geographic Database</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #667eea;
            --primary-dark: #764ba2;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        
        body {
            font-family: 'Figtree', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M1200 120L0 16.48V0h1200v120z" fill="rgba(255,255,255,0.03)"/></svg>');
            background-repeat: no-repeat;
            background-position: bottom;
            background-size: cover;
        }
        
        .auth-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 3rem 2.5rem;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            max-width: 450px;
            width: 100%;
            position: relative;
            z-index: 1;
        }
        
        .auth-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark), var(--success));
            border-radius: 22px;
            z-index: -1;
            opacity: 0.1;
        }
        
        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: white;
        }
        
        .input-group-text {
            background: rgba(102, 126, 234, 0.1);
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: var(--primary);
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }
        
        .btn {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            text-transform: none;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .text-primary {
            color: var(--primary) !important;
        }
        
        .text-success {
            color: var(--success) !important;
        }
        
        a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        a:hover {
            color: var(--primary-dark);
        }
        
        .is-invalid {
            border-color: var(--danger) !important;
        }
        
        .invalid-feedback {
            color: var(--danger);
        }
        
        @media (max-width: 768px) {
            .auth-card {
                margin: 1rem;
                padding: 2rem 1.5rem;
            }
        }
        
        /* Loading Animation */
        .btn:active {
            transform: scale(0.98);
        }
        
        /* Floating Icons Animation */
        .floating-icon {
            position: absolute;
            font-size: 2rem;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .floating-icon:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
        .floating-icon:nth-child(2) { top: 20%; right: 10%; animation-delay: 2s; }
        .floating-icon:nth-child(3) { bottom: 20%; left: 15%; animation-delay: 4s; }
        .floating-icon:nth-child(4) { bottom: 10%; right: 15%; animation-delay: 1s; }
    </style>
</head>
<body>
    <!-- Floating Background Icons -->
    <i class="floating-icon fas fa-globe"></i>
    <i class="floating-icon fas fa-map"></i>
    <i class="floating-icon fas fa-plane"></i>
    <i class="floating-icon fas fa-compass"></i>
    
    <div class="auth-card">
        {{ $slot }}
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Form Validation -->
    <script>
        // Bootstrap form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>
</html>
