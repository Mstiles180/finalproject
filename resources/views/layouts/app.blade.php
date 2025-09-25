<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Work Connect') }} - @yield('title', 'Welcome')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Enhanced Design System */
        :root {
            --primary-50: #f0f9ff;
            --primary-100: #e0f2fe;
            --primary-200: #bae6fd;
            --primary-300: #7dd3fc;
            --primary-400: #38bdf8;
            --primary-500: #0ea5e9;
            --primary-600: #0284c7;
            --primary-700: #0369a1;
            --primary-800: #075985;
            --primary-900: #0c4a6e;
            
            --secondary-50: #fdf4ff;
            --secondary-100: #fae8ff;
            --secondary-200: #f5d0fe;
            --secondary-300: #f0abfc;
            --secondary-400: #e879f9;
            --secondary-500: #d946ef;
            --secondary-600: #c026d3;
            --secondary-700: #a21caf;
            --secondary-800: #86198f;
            --secondary-900: #701a75;
            
            --success-50: #f0fdf4;
            --success-100: #dcfce7;
            --success-200: #bbf7d0;
            --success-300: #86efac;
            --success-400: #4ade80;
            --success-500: #22c55e;
            --success-600: #16a34a;
            --success-700: #15803d;
            --success-800: #166534;
            --success-900: #14532d;
            
            --warning-50: #fffbeb;
            --warning-100: #fef3c7;
            --warning-200: #fde68a;
            --warning-300: #fcd34d;
            --warning-400: #fbbf24;
            --warning-500: #f59e0b;
            --warning-600: #d97706;
            --warning-700: #b45309;
            --warning-800: #92400e;
            --warning-900: #78350f;
            
            --danger-50: #fef2f2;
            --danger-100: #fee2e2;
            --danger-200: #fecaca;
            --danger-300: #fca5a5;
            --danger-400: #f87171;
            --danger-500: #ef4444;
            --danger-600: #dc2626;
            --danger-700: #b91c1c;
            --danger-800: #991b1b;
            --danger-900: #7f1d1d;
            
            --neutral-50: #fafafa;
            --neutral-100: #f5f5f5;
            --neutral-200: #e5e5e5;
            --neutral-300: #d4d4d4;
            --neutral-400: #a3a3a3;
            --neutral-500: #737373;
            --neutral-600: #525252;
            --neutral-700: #404040;
            --neutral-800: #262626;
            --neutral-900: #171717;
            
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --shadow-2xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);
            
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            
            --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-normal: 250ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 350ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Enhanced Global Styles */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--neutral-800);
            background-color: var(--neutral-50);
        }

        /* Enhanced Typography */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        h1 { font-size: 2.5rem; }
        h2 { font-size: 2rem; }
        h3 { font-size: 1.75rem; }
        h4 { font-size: 1.5rem; }
        h5 { font-size: 1.25rem; }
        h6 { font-size: 1.125rem; }

        .display-1 { font-size: 3.5rem; font-weight: 800; }
        .display-2 { font-size: 3rem; font-weight: 800; }
        .display-3 { font-size: 2.5rem; font-weight: 800; }
        .display-4 { font-size: 2.25rem; font-weight: 800; }

        /* Enhanced Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            line-height: 1.25rem;
            border-radius: var(--radius-lg);
            border: 1px solid transparent;
            text-decoration: none;
            cursor: pointer;
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left var(--transition-slow);
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
            color: white;
            border-color: var(--primary-600);
            box-shadow: var(--shadow-md);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-700), var(--primary-800));
            border-color: var(--primary-700);
            box-shadow: var(--shadow-lg);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--secondary-600), var(--secondary-700));
            color: white;
            border-color: var(--secondary-600);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, var(--secondary-700), var(--secondary-800));
            border-color: var(--secondary-700);
            box-shadow: var(--shadow-lg);
            transform: translateY(-1px);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-600), var(--success-700));
            color: white;
            border-color: var(--success-600);
            box-shadow: var(--shadow-md);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, var(--success-700), var(--success-800));
            border-color: var(--success-700);
            box-shadow: var(--shadow-lg);
            transform: translateY(-1px);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-600), var(--warning-700));
            color: white;
            border-color: var(--warning-600);
            box-shadow: var(--shadow-md);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, var(--warning-700), var(--warning-800));
            border-color: var(--warning-700);
            box-shadow: var(--shadow-lg);
            transform: translateY(-1px);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-600), var(--danger-700));
            color: white;
            border-color: var(--danger-600);
            box-shadow: var(--shadow-md);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, var(--danger-700), var(--danger-800));
            border-color: var(--danger-700);
            box-shadow: var(--shadow-lg);
            transform: translateY(-1px);
        }

        .btn-outline-primary {
            background: transparent;
            color: var(--primary-600);
            border-color: var(--primary-600);
        }

        .btn-outline-primary:hover {
            background: var(--primary-600);
            color: white;
            transform: translateY(-1px);
        }

        .btn-outline-secondary {
            background: transparent;
            color: var(--secondary-600);
            border-color: var(--secondary-600);
        }

        .btn-outline-secondary:hover {
            background: var(--secondary-600);
            color: white;
            transform: translateY(-1px);
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1rem;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
        }

        /* Enhanced Cards */
        .card {
            background: white;
            border: none;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
            overflow: hidden;
            position: relative;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-500), var(--secondary-500));
            opacity: 0;
            transition: opacity var(--transition-normal);
        }

        .card:hover::before {
            opacity: 1;
        }

        .card:hover {
            box-shadow: var(--shadow-xl);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--neutral-50), var(--neutral-100));
            border-bottom: 1px solid var(--neutral-200);
            padding: 1.5rem;
            font-weight: 600;
            color: var(--neutral-800);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-footer {
            background: var(--neutral-50);
            border-top: 1px solid var(--neutral-200);
            padding: 1rem 1.5rem;
        }

        /* Enhanced Forms */
        .form-control, .form-select {
            border: 2px solid var(--neutral-200);
            border-radius: var(--radius-lg);
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            transition: all var(--transition-normal);
            background-color: white;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-500);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
            outline: none;
        }

        .form-label {
            font-weight: 600;
            color: var(--neutral-700);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .form-text {
            color: var(--neutral-500);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        /* Enhanced Alerts */
        .alert {
            border: none;
            border-radius: var(--radius-lg);
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
        }

        .alert::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: currentColor;
            opacity: 0.3;
        }

        .alert-success {
            background: linear-gradient(135deg, var(--success-50), var(--success-100));
            color: var(--success-800);
            border-left: 4px solid var(--success-500);
        }

        .alert-warning {
            background: linear-gradient(135deg, var(--warning-50), var(--warning-100));
            color: var(--warning-800);
            border-left: 4px solid var(--warning-500);
        }

        .alert-danger {
            background: linear-gradient(135deg, var(--danger-50), var(--danger-100));
            color: var(--danger-800);
            border-left: 4px solid var(--danger-500);
        }

        .alert-info {
            background: linear-gradient(135deg, var(--primary-50), var(--primary-100));
            color: var(--primary-800);
            border-left: 4px solid var(--primary-500);
        }

        /* Enhanced Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--neutral-900), var(--neutral-800)) !important;
            box-shadow: var(--shadow-lg);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--primary-400), var(--secondary-400));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: var(--neutral-300) !important;
            transition: all var(--transition-normal);
            position: relative;
        }

        .navbar-nav .nav-link:hover {
            color: white !important;
            transform: translateY(-1px);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-400), var(--secondary-400));
            transition: all var(--transition-normal);
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link:hover::after {
            width: 100%;
        }

        /* Enhanced Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-600) 0%, var(--secondary-600) 100%);
            color: white;
            padding: 120px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .hero-section .container {
            position: relative;
            z-index: 1;
        }

        /* Enhanced Feature Cards */
        .feature-card {
            transition: all var(--transition-normal);
            border: none;
            background: white;
            border-radius: var(--radius-2xl);
            overflow: hidden;
            position: relative;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-50), var(--secondary-50));
            opacity: 0;
            transition: opacity var(--transition-normal);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-2xl);
        }

        .feature-card .card-body {
            position: relative;
            z-index: 1;
        }

        .feature-card i {
            background: linear-gradient(135deg, var(--primary-500), var(--secondary-500));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transition: transform var(--transition-normal);
        }

        .feature-card:hover i {
            transform: scale(1.1);
        }

        /* Enhanced Stats Cards */
        .stats-card {
            background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
            color: white;
            border-radius: var(--radius-xl);
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: all var(--transition-normal);
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            transition: all var(--transition-normal);
        }

        .stats-card:hover::before {
            transform: scale(1.2);
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-2xl);
        }

        .stats-card.bg-success {
            background: linear-gradient(135deg, var(--success-600), var(--success-700));
        }

        .stats-card.bg-warning {
            background: linear-gradient(135deg, var(--warning-600), var(--warning-700));
        }

        .stats-card.bg-info {
            background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
        }

        .stats-card.bg-secondary {
            background: linear-gradient(135deg, var(--secondary-600), var(--secondary-700));
        }

        /* Enhanced Dropdowns */
        .dropdown-menu {
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            padding: 0.5rem 0;
            margin-top: 0.5rem;
            background: white;
            border: 1px solid var(--neutral-200);
        }

        .dropdown-item {
            padding: 0.75rem 1.5rem;
            color: var(--neutral-700);
            transition: all var(--transition-fast);
            border-radius: var(--radius-sm);
            margin: 0 0.5rem;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, var(--primary-50), var(--secondary-50));
            color: var(--primary-700);
            transform: translateX(4px);
        }

        /* Enhanced Tables */
        .table {
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .table thead th {
            background: linear-gradient(135deg, var(--neutral-100), var(--neutral-200));
            border: none;
            font-weight: 600;
            color: var(--neutral-700);
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            border-bottom: 1px solid var(--neutral-200);
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: linear-gradient(135deg, var(--primary-50), var(--secondary-50));
        }

        /* Enhanced Badges */
        .badge {
            padding: 0.5rem 0.75rem;
            font-weight: 600;
            border-radius: var(--radius-lg);
            font-size: 0.75rem;
        }

        .badge.bg-success {
            background: linear-gradient(135deg, var(--success-500), var(--success-600)) !important;
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, var(--warning-500), var(--warning-600)) !important;
        }

        .badge.bg-danger {
            background: linear-gradient(135deg, var(--danger-500), var(--danger-600)) !important;
        }

        .badge.bg-primary {
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600)) !important;
        }

        .badge.bg-secondary {
            background: linear-gradient(135deg, var(--secondary-500), var(--secondary-600)) !important;
        }

        /* Enhanced Footer */
        footer {
            background: linear-gradient(135deg, var(--neutral-900), var(--neutral-800));
            color: var(--neutral-300);
            padding: 3rem 0 2rem;
            margin-top: 4rem;
        }

        /* Enhanced Animations */
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

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slide-in-left {
            animation: slideInLeft 0.6s ease-out;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.6s ease-out;
        }

        .animate-pulse {
            animation: pulse 2s infinite;
        }

        /* Enhanced Responsive Design */
        @media (max-width: 768px) {
            .hero-section {
                padding: 80px 0;
            }
            
            .display-1 { font-size: 2.5rem; }
            .display-2 { font-size: 2rem; }
            .display-3 { font-size: 1.75rem; }
            .display-4 { font-size: 1.5rem; }
            
            .card-body {
                padding: 1rem;
            }
            
            .stats-card {
                padding: 1.5rem;
            }
        }

        /* Enhanced Loading States */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Enhanced Focus States */
        .btn:focus,
        .form-control:focus,
        .form-select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
        }

        /* Enhanced Hover Effects */
        .hover-lift {
            transition: transform var(--transition-normal);
        }

        .hover-lift:hover {
            transform: translateY(-4px);
        }

        .hover-scale {
            transition: transform var(--transition-normal);
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        /* Enhanced Grid Layouts */
        .grid-auto-fit {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .grid-auto-fill {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        /* Enhanced Spacing Utilities */
        .gap-6 { gap: 1.5rem; }
        .gap-8 { gap: 2rem; }
        .gap-10 { gap: 2.5rem; }
        .gap-12 { gap: 3rem; }

        .p-6 { padding: 1.5rem; }
        .p-8 { padding: 2rem; }
        .p-10 { padding: 2.5rem; }
        .p-12 { padding: 3rem; }

        .m-6 { margin: 1.5rem; }
        .m-8 { margin: 2rem; }
        .m-10 { margin: 2.5rem; }
        .m-12 { margin: 3rem; }

        /* Enhanced Text Utilities */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-600), var(--secondary-600));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .text-shadow {
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Enhanced Border Utilities */
        .border-gradient {
            border: 2px solid;
            border-image: linear-gradient(135deg, var(--primary-500), var(--secondary-500)) 1;
        }

        /* Enhanced Background Utilities */
        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-50), var(--primary-100));
        }

        .bg-gradient-secondary {
            background: linear-gradient(135deg, var(--secondary-50), var(--secondary-100));
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, var(--success-50), var(--success-100));
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, var(--warning-50), var(--warning-100));
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, var(--danger-50), var(--danger-100));
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-handshake me-2"></i>{{ config('app.name', 'Work Connect') }}
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        @if(auth()->user()->isBoss())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('jobs.create') }}">Post Job</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('jobs.my-jobs') }}">My Jobs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('jobs.active-workers') }}">Active Workers</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('job-offers.index') }}">My Job Offers</a>
                            </li>
                        @endif
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a>
                            </li>
                        @endif
                    @endauth
                </ul>
                
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('settings.profile') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                <li><a class="dropdown-item" href="{{ route('history.index') }}"><i class="fas fa-history me-2"></i>History</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-5 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="text-gradient mb-3">
                        <i class="fas fa-handshake me-2"></i>Work Connect
                    </h5>
                    <p class="mb-3 opacity-75">Connecting talented workers with great opportunities through intelligent job matching and comprehensive project management.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light opacity-75 hover-lift">
                            <i class="fab fa-facebook fa-lg"></i>
                        </a>
                        <a href="#" class="text-light opacity-75 hover-lift">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        <a href="#" class="text-light opacity-75 hover-lift">
                            <i class="fab fa-linkedin fa-lg"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h6 class="text-gradient mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('jobs.index') }}" class="text-light opacity-75 text-decoration-none hover-lift">
                                <i class="fas fa-arrow-right me-2"></i>Browse Jobs
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('register') }}" class="text-light opacity-75 text-decoration-none hover-lift">
                                <i class="fas fa-arrow-right me-2"></i>Get Started
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-light opacity-75 text-decoration-none hover-lift">
                                <i class="fas fa-arrow-right me-2"></i>Support
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="text-gradient mb-3">Contact Info</h6>
                    <div class="mb-3">
                        <i class="fas fa-envelope me-2 text-primary"></i>
                        <span class="opacity-75">support@workconnect.rw</span>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-phone me-2 text-primary"></i>
                        <span class="opacity-75">+250 123 456 789</span>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                        <span class="opacity-75">Kigali, Rwanda</span>
                    </div>
                </div>
            </div>
            <hr class="my-4 opacity-25">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 opacity-75">&copy; {{ date('Y') }} Work Connect. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 opacity-75">Made with <i class="fas fa-heart text-danger"></i> in Rwanda</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html> 