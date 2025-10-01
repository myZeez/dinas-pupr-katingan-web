<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $profil = \App\Models\Profil::first();
    @endphp

    <title>@yield('title', 'Admin') - {{ $profil->nama_instansi ?? config('app.name', 'Laravel') }}</title>

    <!-- Favicon (cached) -->
    @include('components.favicon', ['profil' => $profil])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Admin Action Buttons CSS -->
    <link href="{{ asset('css/admin-action-buttons.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            /* Clean Professional Color Palette - Based on Reference */
            --primary-color: #5b72ee;
            --primary-light: #7c93ff;
            --primary-dark: #4461d9;
            --secondary-color: #00d4aa;
            --accent-green: #00d4aa;
            --accent-yellow: #ffb020;
            --accent-orange: #ff8f44;
            --accent-red: #ff5757;
            --accent-purple: #8b5cf6;
            --sidebar-width: 250px;

            /* Clean Neutral Colors */
            --bg-primary: #f7f8fc;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --bg-light: #fafbff;
            --text-primary: #1a1d29;
            --text-secondary: #8b92a5;
            --text-muted: #a5b0c1;
            --border-color: #e6ebf4;
            --border-light: #f0f3f9;
            --shadow-clean: 0 2px 8px rgba(31, 41, 55, 0.04);
            --shadow-card: 0 4px 16px rgba(31, 41, 55, 0.08);
            --shadow-hover: 0 8px 24px rgba(31, 41, 55, 0.12);
        }

        /* Modern Toast Notifications */
        .toast-container {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
        }

        .custom-toast {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border: none;
            margin-bottom: 10px;
            overflow: hidden;
            animation: slideInRight 0.3s ease-out;
        }

        .custom-toast.toast-success {
            border-left: 4px solid #00d4aa;
        }

        .custom-toast.toast-error {
            border-left: 4px solid #ff5757;
        }

        .custom-toast.toast-warning {
            border-left: 4px solid #ffb020;
        }

        .custom-toast.toast-info {
            border-left: 4px solid #5b72ee;
        }

        .toast-header-custom {
            background: transparent;
            border-bottom: none;
            padding: 15px 20px 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .toast-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: white;
            font-weight: bold;
        }

        .toast-icon.success {
            background: #00d4aa;
        }

        .toast-icon.error {
            background: #ff5757;
        }

        .toast-icon.warning {
            background: #ffb020;
        }

        .toast-icon.info {
            background: #5b72ee;
        }

        .toast-title {
            font-weight: 600;
            font-size: 14px;
            color: #1a1d29;
            margin: 0;
        }

        .toast-body-custom {
            padding: 0 20px 15px;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.5;
        }

        .toast-close {
            background: transparent;
            border: none;
            color: #9ca3af;
            font-size: 18px;
            cursor: pointer;
            padding: 0;
            margin-left: auto;
        }

        .toast-close:hover {
            color: #6b7280;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .toast-hide {
            animation: slideOutRight 0.3s ease-in forwards;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-weight: 400;
            line-height: 1.6;
        }

        /* Top Header */
        .top-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: #FFFFFF;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid #E6E6E6;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
        }

        .top-header .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .top-header .logo img {
            width: 45px;
            height: 45px;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .top-header .logo h4 {
            color: #1A1A1A;
            margin: 0;
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: -0.025em;
        }

        .top-header .logo small {
            color: #6B7280;
            font-size: 0.75rem;
            font-weight: 500;
            display: block;
            margin-top: -2px;
        }

        /* Bottom Navigation */
        .bottom-nav {
            border-radius: 20px;
            margin: 0 auto 25px auto;
            width: 1000px;
            max-width: calc(94vw - 20px);
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            height: 85px;
            background: #FFFFFF;
            box-shadow: 0 5px 50px rgba(0, 0, 0, 0.30);
            border-top: 1px solid #E6E6E6;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }


        .bottom-nav-wrapper {
            width: 100%;
            max-width: none;
            overflow: hidden;
            padding: 0 0.5rem;
        }

        .bottom-nav-list {
            display: flex;
            margin: 0;
            padding: 0;
            list-style: none;
            gap: 2px;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .bottom-nav-item {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .bottom-nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            padding: 6px 4px;
            color: #808080;
            text-decoration: none;
            transition: all 0.2s ease;
            font-weight: 500;
            font-size: 0.65rem;
            border-radius: 10px;
            width: 100%;
            max-width: 70px;
            text-align: center;
            border: none;
            background: transparent;
        }

        .bottom-nav-link:hover {
            background-color: rgba(0, 0, 140, 0.05);
            color: #00008C;
            transform: translateY(-2px);
        }

        .bottom-nav-link.active {
            background-color: rgba(0, 0, 140, 0.1);
            color: #00008C;
            transform: translateY(-2px);
        }

        .bottom-nav-link .nav-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            fill: currentColor;
            transition: all 0.2s ease;
        }

        .bottom-nav-link.active .nav-icon {
            fill: #00008C;
            transform: scale(1.1);
        }

        .bottom-nav-link:hover .nav-icon {
            transform: scale(1.1);
        }

        /* Dropdown styling for bottom nav */
        .bottom-nav-item.dropdown {
            position: relative;
        }

        .bottom-nav-item .dropdown-menu {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            margin-bottom: 10px;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 8px 0;
            min-width: 160px;
            z-index: 1001;
            display: none;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .bottom-nav-item .dropdown-menu.show {
            display: block;
            opacity: 1;
        }

        .bottom-nav-item .dropdown-item {
            display: block;
            padding: 8px 16px;
            color: #333;
            text-decoration: none;
            font-size: 0.875rem;
            transition: background-color 0.2s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .bottom-nav-item .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #00008C;
        }

        .bottom-nav-item .dropdown-toggle::after {
            display: none;
            /* Hide Bootstrap arrow */
        }

        .bottom-nav-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            line-height: 1.2;
        }

        /* Custom Scrollbar untuk Bottom Nav - Removed as we're using full width without scroll */

        .main-content {
            margin-top: 80px;
            margin-bottom: 85px;
            min-height: calc(100vh - 165px);
            background-color: var(--bg-primary);
        }

        .topbar {
            background: var(--bg-secondary);
            padding: 1.5rem 2rem;
            box-shadow: var(--shadow-clean);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-light);
        }

        .content-wrapper {
            padding: 2rem;
        }

        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 1.25rem;
            box-shadow: var(--shadow-clean);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--shadow-card);
            transform: translateY(-2px);
        }

        .card-header {
            background: var(--bg-light);
            color: var(--text-primary);
            border-radius: 1.25rem 1.25rem 0 0 !important;
            font-weight: 600;
            border-bottom: 1px solid var(--border-light);
            padding: 1.5rem 1.75rem;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            padding: 0.625rem 1.25rem;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-light);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            transform: translateY(-1px);
            box-shadow: var(--shadow-medium);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--accent-green) 0%, #059669 100%);
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--accent-yellow) 0%, #d97706 100%);
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .btn-info {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #0891b2 100%);
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--accent-red) 0%, #dc2626 100%);
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .stats-card {
            background: var(--bg-card);
            border-radius: 1.25rem;
            padding: 2rem 1.75rem;
            box-shadow: var(--shadow-clean);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
            min-height: 140px;
            display: flex;
            align-items: center;
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
        }

        .stats-card.primary {
            background: linear-gradient(135deg, rgba(91, 114, 238, 0.05) 0%, rgba(91, 114, 238, 0.02) 100%);
            border-color: rgba(91, 114, 238, 0.1);
        }

        .stats-card.success {
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.05) 0%, rgba(0, 212, 170, 0.02) 100%);
            border-color: rgba(0, 212, 170, 0.1);
        }

        .stats-card.warning {
            background: linear-gradient(135deg, rgba(255, 176, 32, 0.05) 0%, rgba(255, 176, 32, 0.02) 100%);
            border-color: rgba(255, 176, 32, 0.1);
        }

        .stats-card.danger {
            background: linear-gradient(135deg, rgba(255, 87, 87, 0.05) 0%, rgba(255, 87, 87, 0.02) 100%);
            border-color: rgba(255, 87, 87, 0.1);
        }

        .stats-card.info {
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.05) 0%, rgba(0, 212, 170, 0.02) 100%);
            border-color: rgba(0, 212, 170, 0.1);
        }

        /* Tables */
        .table {
            background-color: var(--bg-card);
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: var(--shadow-clean);
            border: 1px solid var(--border-color);
        }

        .table th {
            background: var(--bg-light);
            color: var(--text-primary);
            font-weight: 600;
            border-bottom: 1px solid var(--border-light);
            padding: 1.25rem 1.5rem;
            font-size: 0.9rem;
        }

        .table td {
            padding: 1.25rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-light);
            font-size: 0.95rem;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: var(--bg-light);
        }

        /* Forms */
        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            transition: all 0.2s ease;
            background-color: var(--bg-card);
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(91, 114, 238, 0.1);
            background-color: white;
        }

        .form-label {
            color: var(--text-primary);
            font-weight: 500;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        /* Page Headers */
        .page-header {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(6, 182, 212, 0.05) 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
        }

        .page-title {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1.875rem;
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        .page-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            margin: 0;
        }

        /* Icons */
        .text-primary {
            color: var(--primary-color) !important;
        }

        .text-success {
            color: var(--accent-green) !important;
        }

        .text-warning {
            color: var(--accent-yellow) !important;
        }

        .text-danger {
            color: var(--accent-red) !important;
        }

        .text-info {
            color: var(--secondary-color) !important;
        }

        /* Breadcrumb */
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 1rem;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: var(--text-muted);
        }

        /* Custom animations */
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

        .fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* Button enhancements */
        .btn {
            font-weight: 500;
            border-radius: 0.5rem;
            padding: 0.625rem 1.25rem;
            transition: all 0.2s ease;
            border: none;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-medium);
        }

        /* Responsive */

        @media (max-width: 768px) {
            .top-header {
                padding: 0 1rem;
            }

            .top-header .logo h4 {
                font-size: 1.1rem;
            }

            .bottom-nav {
                width: 700px;
                margin: 0 auto 10px auto;
            }

            .bottom-nav-wrapper {
                padding: 0 0.25rem;
            }

            .bottom-nav-link {
                padding: 5px 2px;
                font-size: 0.6rem;
            }

            .bottom-nav-link .nav-icon {
                width: 18px;
                height: 18px;
            }

            .content-wrapper {
                padding: 1rem;
            }
        }

        @media (max-width: 480px) {
            .bottom-nav {
                height: 75px;
                width: auto;
            }

            .main-content {
                margin-bottom: 75px;
            }

            .bottom-nav-link {
                padding: 4px 1px;
                font-size: 0.55rem;
                gap: 1px;
            }

            .bottom-nav-link .nav-icon {
                width: 16px;
                height: 16px;
            }
        }

        @media (max-width: 380px) {
            .bottom-nav-text {
                font-size: 0.5rem;
            }
        }
    </style>

    <!-- SweetAlert2 - Available but not used for primary notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Admin Notifications Component -->
    @include('admin.components.notifications')

    @stack('styles')
</head>

<body style="background-color: #f8f9fa;">
    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer">
        <!-- Toasts will be dynamically added here -->
    </div>

    <!-- Top Header -->
    <div class="top-header">
        <div class="logo">
            @include('components.logo')
            <div>
                <h4>{{ $profil->nama_instansi ?? 'ADMIN PANEL' }}</h4>
                <small>{{ $profil->alamat ?? 'Sistem Administrasi' }}</small>
            </div>
        </div>
        <div>
            <div class="d-flex align-items-center text-muted">
                <i class="bi bi-calendar3 me-2"></i>
                <span
                    class="d-none d-md-inline">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}</span>
                <span class="d-md-none">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j M Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div>
                <h5 class="mb-0">
                    Selamat Datang {{ auth()->user()->isSuperAdmin() ? 'Super Admin' : 'Admin' }}
                </h5>
                <small class="text-muted d-none d-md-block">Kelola konten website PUPR dengan mudah melalui dashboard
                    admin yang intuitif.</small>
                <small class="text-muted d-md-none">Dashboard Admin PUPR</small>
            </div>
            <div class="d-none d-lg-block">
                <div class="d-flex align-items-center text-muted">
                    <i class="bi bi-person-circle me-2"></i>
                    <div class="d-flex flex-column">
                        <span>{{ auth()->user()->name }}</span>
                        <small class="text-muted">
                            @if (auth()->user()->isSuperAdmin())
                                <span class="badge bg-danger">Super Admin</span>
                            @else
                                <span class="badge bg-primary">Admin Biasa</span>
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <div class="bottom-nav-wrapper">
            <ul class="bottom-nav-list">
                <!-- Dashboard -->
                <li class="bottom-nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="bottom-nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="21"
                            viewBox="0 0 20 21" fill="none">
                            <path
                                d="M0.833403 8.83236C0.612371 8.83236 0.400392 8.74456 0.244098 8.58826C0.0878049 8.43197 0 8.21999 0 7.99896V1.3334C0 1.11237 0.0878049 0.900392 0.244098 0.744098C0.400392 0.587805 0.612371 0.5 0.833403 0.5H7.50063C7.72166 0.5 7.93364 0.587805 8.08993 0.744098C8.24622 0.900392 8.33403 1.11237 8.33403 1.3334V7.99896C8.33403 8.21999 8.24622 8.43197 8.08993 8.58826C7.93364 8.74456 7.72166 8.83236 7.50063 8.83236H0.833403ZM12.501 8.83236C12.28 8.83236 12.068 8.74456 11.9117 8.58826C11.7554 8.43197 11.6676 8.21999 11.6676 7.99896V1.3334C11.6676 1.11237 11.7554 0.900392 11.9117 0.744098C12.068 0.587805 12.28 0.5 12.501 0.5H19.1666C19.3876 0.5 19.5996 0.587805 19.7559 0.744098C19.9122 0.900392 20 1.11237 20 1.3334V7.99896C20 8.21999 19.9122 8.43197 19.7559 8.58826C19.5996 8.74456 19.3876 8.83236 19.1666 8.83236H12.501ZM0.833403 20.5C0.612371 20.5 0.400392 20.4122 0.244098 20.2559C0.0878049 20.0996 0 19.8876 0 19.6666V12.9994C0 12.7783 0.0878049 12.5664 0.244098 12.4101C0.400392 12.2538 0.612371 12.166 0.833403 12.166H7.50063C7.72166 12.166 7.93364 12.2538 8.08993 12.4101C8.24622 12.5664 8.33403 12.7783 8.33403 12.9994V19.6666C8.33403 19.8876 8.24622 20.0996 8.08993 20.2559C7.93364 20.4122 7.72166 20.5 7.50063 20.5H0.833403ZM12.501 20.5C12.28 20.5 12.068 20.4122 11.9117 20.2559C11.7554 20.0996 11.6676 19.8876 11.6676 19.6666V12.9994C11.6676 12.7783 11.7554 12.5664 11.9117 12.4101C12.068 12.2538 12.28 12.166 12.501 12.166H19.1666C19.3876 12.166 19.5996 12.2538 19.7559 12.4101C19.9122 12.5664 20 12.7783 20 12.9994V19.6666C20 19.8876 19.9122 20.0996 19.7559 20.2559C19.5996 20.4122 19.3876 20.5 19.1666 20.5H12.501Z" />
                        </svg>
                        <span class="bottom-nav-text">Beranda</span>
                    </a>
                </li>

                <!-- Pengaduan -->
                <li class="bottom-nav-item">
                    <a href="{{ route('admin.pengaduan.index') }}"
                        class="bottom-nav-link {{ Request::routeIs('admin.pengaduan.*') ? 'active' : '' }}">
                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="23"
                            viewBox="0 0 24 24" fill="none">
                            <path
                                d="M20 2H4C2.9 2 2 2.9 2 4V22L6 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2ZM20 16H5.17L4 17.17V4H20V16ZM11 5H13V11H11V5ZM11 13H13V15H11V13Z"
                                fill="currentColor" />
                        </svg>
                        <span class="bottom-nav-text">Pengaduan</span>
                    </a>
                </li>

                <!-- Ulasan -->
                <li class="bottom-nav-item">
                    <a href="{{ route('admin.ulasan.index') }}"
                        class="bottom-nav-link {{ Request::routeIs('admin.ulasan.*') ? 'active' : '' }}">
                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="23"
                            viewBox="0 0 24 24" fill="none">
                            <path
                                d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"
                                fill="currentColor" />
                        </svg>
                        <span class="bottom-nav-text">Ulasan</span>
                    </a>
                </li>

                <!-- Program Kerja -->
                <li class="bottom-nav-item">
                    <a href="{{ route('admin.konten.program.index') }}"
                        class="bottom-nav-link {{ Request::routeIs('admin.konten.program.*') || Request::routeIs('admin.program.*') ? 'active' : '' }}">
                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="23"
                            viewBox="0 0 24 24" fill="none">
                            <path
                                d="M16 6L18.29 8.29L13.41 13.17L9.41 9.17L2 16.59L3.41 18L9.41 12L13.41 16L19.71 9.7L22 12V6H16Z"
                                fill="currentColor" />
                        </svg>
                        <span class="bottom-nav-text">Program</span>
                    </a>
                </li>

                <!-- Konten (Berita, Galeri & Download) -->
                <li class="bottom-nav-item">
                    <a href="{{ route('admin.konten.index') }}"
                        class="bottom-nav-link {{ Request::routeIs('admin.konten.*') && !Request::routeIs('admin.konten.program.*') ? 'active' : '' }}">
                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="23"
                            viewBox="0 0 24 24" fill="none">
                            <path
                                d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM19 19H5V5H19V19ZM13.96 12.29L11.21 15.83L9.25 13.47L6.5 17H17.5L13.96 12.29Z"
                                fill="currentColor" />
                        </svg>
                        <span class="bottom-nav-text">Konten</span>
                    </a>
                </li>

                <!-- Konten Public (Karosel, Video, Mitra) -->
                <li class="bottom-nav-item">
                    <a href="{{ route('admin.public-content.index') }}"
                        class="bottom-nav-link {{ Request::routeIs('admin.public-content.*') ? 'active' : '' }}">
                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="23"
                            viewBox="0 0 24 24" fill="none">
                            <path
                                d="M21 3H3C1.9 3 1 3.9 1 5V19C1 20.1 1.9 21 3 21H21C22.1 21 23 20.1 23 19V5C23 3.9 22.1 3 21 3ZM21 19H3V5H21V19ZM10 12L15.5 9L10 6V12ZM18.5 8.5C18.78 8.5 19 8.72 19 9C19 9.28 18.78 9.5 18.5 9.5S18 9.28 18 9C18 8.72 18.22 8.5 18.5 8.5Z"
                                fill="currentColor" />
                        </svg>
                        <span class="bottom-nav-text">Beranda</span>
                    </a>
                </li>

                <!-- Struktur Organisasi -->
                <li class="bottom-nav-item">
                    <a href="{{ route('admin.struktur.index') }}"
                        class="bottom-nav-link {{ Request::routeIs('admin.struktur.*') ? 'active' : '' }}">
                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="23"
                            viewBox="0 0 24 24" fill="none">
                            <path
                                d="M12 9c2.21 0 4-1.79 4-4s-1.79-4-4-4s-4 1.79-4 4s1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2s-2-.9-2-2s.9-2 2-2zm0 8c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4zm-6 5v-1c0-.99 3.39-2 6-2s6 1.01 6 2v1H6zm8-9h5v3h-5zM7 17h5v3H7zm5-12h5v3h-5zM7 8h5v3H7z"
                                fill="currentColor" />
                        </svg>
                        <span class="bottom-nav-text">Struktur</span>
                    </a>
                </li>


                <!-- Activity Log & System (Super Admin Only) -->
                @if (auth()->user()->isSuperAdmin())
                    <li class="bottom-nav-item">
                        <a href="{{ route('admin.activity-log.index') }}"
                            class="bottom-nav-link {{ Request::routeIs('admin.activity-log.*') || Request::routeIs('admin.users.*') ? 'active' : '' }}">
                            <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="21"
                                viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M13,9H18.5L13,3.5V9M6,2H14L20,8V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V4C4,2.89 4.89,2 6,2M15,18V16H6V18H15M18,14V12H6V14H18Z"
                                    fill="currentColor" />
                            </svg>
                            <span class="bottom-nav-text">Log</span>
                        </a>
                    </li>
                @endif

                <!-- Admin Management (Super Admin Only) -->
                @if (auth()->user()->isSuperAdmin())
                    <li class="bottom-nav-item">
                        <a href="{{ route('admin.admin-management.index') }}"
                            class="bottom-nav-link {{ Request::routeIs('admin.admin-management.*') ? 'active' : '' }}">
                            <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="21"
                                viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z"
                                    fill="currentColor" />
                                <path
                                    d="M21 11.5C21 11.78 20.78 12 20.5 12H19.5C19.22 12 19 11.78 19 11.5C19 11.22 19.22 11 19.5 11H20.5C20.78 11 21 11.22 21 11.5ZM18.36 16.95C18.51 17.1 18.51 17.35 18.36 17.5L17.66 18.2C17.51 18.35 17.26 18.35 17.11 18.2C16.96 18.05 16.96 17.8 17.11 17.65L17.81 16.95C17.96 16.8 18.21 16.8 18.36 16.95Z"
                                    fill="currentColor" />
                            </svg>
                            <span class="bottom-nav-text">Admin</span>
                        </a>
                    </li>
                @endif

                <!-- Soft Deleted Data (Super Admin Only) -->
                @if (auth()->user()->isSuperAdmin())
                    <li class="bottom-nav-item">
                        <a href="{{ route('admin.soft-deleted.index') }}"
                            class="bottom-nav-link {{ Request::routeIs('admin.soft-deleted.*') ? 'active' : '' }}">
                            <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="21"
                                viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M9,3V4H4V6H5V19A2,2 0 0,0 7,21H17A2,2 0 0,0 19,19V6H20V4H15V3H9M7,6H17V19H7V6M9,8V17H11V8H9M13,8V17H15V8H13Z"
                                    fill="currentColor" />
                            </svg>
                            <span class="bottom-nav-text">Recycle</span>
                        </a>
                    </li>
                @endif

                <!-- Settings (Super Admin Only) -->
                @if (auth()->user()->isSuperAdmin())
                    <li class="bottom-nav-item">
                        <a href="{{ route('admin.settings.index') }}"
                            class="bottom-nav-link {{ Request::routeIs('admin.settings.*') ? 'active' : '' }}">
                            <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="21"
                                viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M12,8A4,4 0 0,1 16,12A4,4 0 0,1 12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8M12,10A2,2 0 0,0 10,12A2,2 0 0,0 12,14A2,2 0 0,0 14,12A2,2 0 0,0 12,10M10,22C9.75,22 9.54,21.82 9.5,21.58L9.13,18.93C8.5,18.68 7.96,18.34 7.44,17.94L4.95,18.95C4.73,19.03 4.46,18.95 4.34,18.73L2.34,15.27C2.21,15.05 2.27,14.78 2.46,14.63L4.57,12.97L4.5,12L4.57,11L2.46,9.37C2.27,9.22 2.21,8.95 2.34,8.73L4.34,5.27C4.46,5.05 4.73,4.96 4.95,5.05L7.44,6.05C7.96,5.66 8.5,5.32 9.13,5.07L9.5,2.42C9.54,2.18 9.75,2 10,2H14C14.25,2 14.46,2.18 14.5,2.42L14.87,5.07C15.5,5.32 16.04,5.66 16.56,6.05L19.05,5.05C19.27,4.96 19.54,5.05 19.66,5.27L21.66,8.73C21.79,8.95 21.73,9.22 21.54,9.37L19.43,11L19.5,12L19.43,13L21.54,14.63C21.73,14.78 21.79,15.05 21.66,15.27L19.66,18.73C19.54,18.95 19.27,19.04 19.05,18.95L16.56,17.95C16.04,18.34 15.5,18.68 14.87,18.93L14.5,21.58C14.46,21.82 14.25,22 14,22H10M11.25,4L10.88,6.61C9.68,6.86 8.62,7.5 7.85,8.39L5.44,7.35L4.69,8.65L6.8,10.2C6.4,11.37 6.4,12.64 6.8,13.8L4.68,15.36L5.43,16.66L7.86,15.62C8.63,16.5 9.68,17.14 10.87,17.38L11.24,20H12.76L13.13,17.39C14.32,17.14 15.37,16.5 16.14,15.62L18.57,16.66L19.32,15.36L17.2,13.81C17.6,12.64 17.6,11.37 17.2,10.2L19.31,8.65L18.56,7.35L16.15,8.39C15.38,7.5 14.32,6.86 13.12,6.61L12.75,4H11.25Z"
                                    fill="currentColor" />
                            </svg>
                            <span class="bottom-nav-text">Setting</span>
                        </a>
                    </li>
                @endif

                <!-- Profil -->
                <li class="bottom-nav-item">
                    <a href="{{ route('admin.profil.index') }}"
                        class="bottom-nav-link {{ Request::routeIs('admin.profil.*') ? 'active' : '' }}">
                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="21"
                            viewBox="0 0 24 24" fill="none">
                            <path
                                d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,6A2,2 0 0,0 10,8A2,2 0 0,0 12,10A2,2 0 0,0 14,8A2,2 0 0,0 12,6M12,13C14.67,13 20,14.33 20,17V20H4V17C4,14.33 9.33,13 12,13M12,14.9C9.03,14.9 5.9,16.36 5.9,17V18.1H18.1V17C18.1,16.36 14.97,14.9 12,14.9Z"
                                fill="currentColor" />
                        </svg>
                        <span class="bottom-nav-text">Profil</span>
                    </a>
                </li>

                <!-- Logout -->
                <li class="bottom-nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="bottom-nav-link">
                            <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="31" height="31"
                                viewBox="0 0 31 31" fill="none">
                                <path opacity="0.6"
                                    d="M19.375 2.58331H18.0833C14.4305 2.58331 12.6028 2.58331 11.4687 3.71869C10.3333 4.85277 10.3333 6.68048 10.3333 10.3333V20.6666C10.3333 24.3195 10.3333 26.1472 11.4687 27.2813C12.6028 28.4166 14.4305 28.4166 18.0833 28.4166H19.375C23.0278 28.4166 24.8555 28.4166 25.9896 27.2813C27.125 26.1472 27.125 24.3195 27.125 20.6666V10.3333C27.125 6.68048 27.125 4.85277 25.9896 3.71869C24.8555 2.58331 23.0278 2.58331 19.375 2.58331Z" />
                                <path opacity="0.4"
                                    d="M10.3333 10.3333C10.3333 8.34675 10.3333 6.90137 10.5155 5.8125H10.3333C7.28887 5.8125 5.766 5.8125 4.8205 6.758C3.875 7.7035 3.875 9.22637 3.875 12.2708V18.7292C3.875 21.7736 3.875 23.2952 4.8205 24.242C5.766 25.1888 7.28887 25.1875 10.3333 25.1875H10.5155C10.3333 24.0986 10.3333 22.6532 10.3333 20.6667V10.3333Z" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.77375 14.8154C5.59233 14.9971 5.49043 15.2433 5.49043 15.5C5.49043 15.7567 5.59233 16.003 5.77375 16.1846L8.35708 18.7679C8.54072 18.9391 8.78362 19.0322 9.03459 19.0278C9.28556 19.0234 9.52502 18.9217 9.70251 18.7442C9.88 18.5667 9.98167 18.3272 9.9861 18.0763C9.99053 17.8253 9.89737 17.5824 9.72625 17.3988L8.79625 16.4688H18.0833C18.3403 16.4688 18.5867 16.3667 18.7683 16.185C18.95 16.0033 19.0521 15.7569 19.0521 15.5C19.0521 15.2431 18.95 14.9967 18.7683 14.815C18.5867 14.6333 18.3403 14.5313 18.0833 14.5313H8.79625L9.72625 13.6013C9.82143 13.5126 9.89777 13.4056 9.95071 13.2868C10.0037 13.168 10.0321 13.0397 10.0344 12.9096C10.0367 12.7795 10.0128 12.6503 9.96407 12.5297C9.91535 12.4091 9.84283 12.2995 9.75084 12.2075C9.65885 12.1155 9.54927 12.043 9.42864 11.9943C9.30802 11.9456 9.17881 11.9216 9.04874 11.9239C8.91866 11.9262 8.79038 11.9547 8.67155 12.0076C8.55272 12.0606 8.44577 12.1369 8.35708 12.2321L5.77375 14.8154Z" />
                            </svg>
                            <span class="bottom-nav-text">Logout</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (Required for AJAX operations) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Chart.js for Dashboard -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Bottom Navigation Enhancement -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth animation untuk bottom nav
            const bottomNavLinks = document.querySelectorAll('.bottom-nav-link');

            bottomNavLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (!this.closest('form')) {
                        // Tambahkan animasi loading sederhana
                        this.style.transform = 'translateY(-4px) scale(0.95)';
                        setTimeout(() => {
                            this.style.transform = '';
                        }, 150);
                    }
                });
            });

            // Touch feedback untuk mobile
            if ('ontouchstart' in window) {
                bottomNavLinks.forEach(link => {
                    link.addEventListener('touchstart', function() {
                        this.style.backgroundColor = 'rgba(0, 0, 140, 0.15)';
                    });

                    link.addEventListener('touchend', function() {
                        setTimeout(() => {
                            this.style.backgroundColor = '';
                        }, 100);
                    });
                });
            }
        });

        // Custom dropdown functionality for bottom navigation
        function toggleDropdown(element) {
            // Get the dropdown menu
            const dropdownMenu = element.nextElementSibling;
            const isCurrentlyOpen = dropdownMenu.classList.contains('show');

            // Close all other dropdowns first
            document.querySelectorAll('.bottom-nav .dropdown-menu.show').forEach(menu => {
                menu.classList.remove('show');
                menu.parentElement.querySelector('.dropdown-toggle').classList.remove('show');
            });

            // Toggle the current dropdown
            if (!isCurrentlyOpen) {
                dropdownMenu.classList.add('show');
                element.classList.add('show');
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.bottom-nav .dropdown')) {
                document.querySelectorAll('.bottom-nav .dropdown-menu.show').forEach(menu => {
                    menu.classList.remove('show');
                    menu.parentElement.querySelector('.dropdown-toggle').classList.remove('show');
                });
            }
        });

        // Make toggleDropdown available globally
        window.toggleDropdown = toggleDropdown;

        // Modern Toast Notification System
        window.showToast = function(type, title, message, duration = 4000) {
            const toastContainer = document.getElementById('toastContainer');
            const toastId = 'toast-' + Date.now();

            const icons = {
                success: '✓',
                error: '✕',
                warning: '⚠',
                info: 'i'
            };

            const titles = {
                success: title || 'Berhasil!',
                error: title || 'Terjadi Kesalahan!',
                warning: title || 'Perhatian!',
                info: title || 'Informasi'
            };

            const toastHTML = `
                <div class="custom-toast toast-${type}" id="${toastId}">
                    <div class="toast-header-custom">
                        <div class="toast-icon ${type}">${icons[type]}</div>
                        <h6 class="toast-title">${titles[type]}</h6>
                        <button type="button" class="toast-close" onclick="hideToast('${toastId}')">×</button>
                    </div>
                    <div class="toast-body-custom">
                        ${message}
                    </div>
                </div>
            `;

            toastContainer.insertAdjacentHTML('afterbegin', toastHTML);

            // Auto hide after duration
            setTimeout(() => {
                hideToast(toastId);
            }, duration);

            return toastId;
        };

        window.hideToast = function(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.add('toast-hide');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }
        };

        // Shorthand functions
        window.showSuccess = function(message, title) {
            return showToast('success', title, message);
        };

        window.showError = function(message, title) {
            return showToast('error', title, message);
        };

        window.showWarning = function(message, title) {
            return showToast('warning', title, message);
        };

        window.showInfo = function(message, title) {
            return showToast('info', title, message);
        };

        // Replace all alert() calls with toast notifications
        window.originalAlert = window.alert;
        window.alert = function(message) {
            if (message.toLowerCase().includes('berhasil') || message.toLowerCase().includes('sukses')) {
                showSuccess(message);
            } else if (message.toLowerCase().includes('gagal') || message.toLowerCase().includes('error')) {
                showError(message);
            } else if (message.toLowerCase().includes('peringatan') || message.toLowerCase().includes('perhatian')) {
                showWarning(message);
            } else {
                showInfo(message);
            }
        };
    </script>

    {{-- Include GIF Notifications Component --}}
    @include('components.gif-notifications')

    {{-- Include Delete Confirmation Component --}}
    @include('components.delete-confirmation')

    {{-- Include Global Loading Component --}}
    @include('components.global-loading')

    {{-- Enhanced Loading Utilities --}}
    <script src="{{ asset('js/admin-loading-enhancements.js') }}"></script>

    @stack('scripts')
</body>

</html>
