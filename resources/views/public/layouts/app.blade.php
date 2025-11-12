<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $profil = \App\Models\Profil::first();
    @endphp

    <meta name="description"
        content="Website Resmi {{ $profil->nama_instansi ?? 'Dinas PUPR Kabupaten Katingan' }} - Melayani Masyarakat dengan Profesional dan Transparan">
    <meta name="keywords" content="dinas pupr, katingan, pembangunan, infrastruktur, jalan, jembatan">
    <meta name="author" content="{{ $profil->nama_instansi ?? 'Dinas PUPR Kabupaten Katingan' }}">

    <title>
        @hasSection('title')
            {!! trim(strip_tags($__env->yieldContent('title'))) !!} - {{ $profil->nama_instansi ?? 'Dinas PUPR Kabupaten Katingan' }}
        @else
            Beranda - {{ $profil->nama_instansi ?? 'Dinas PUPR Kabupaten Katingan' }}
        @endif
    </title>

    <!-- Langsung tampilkan logo instansi sebagai favicon -->
    @if ($profil && $profil->logo)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $profil->logo) }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('storage/' . $profil->logo) }}">
    @endif

    <!-- Additional head content dari halaman individual -->
    @stack('head')

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #f4b400;
            --secondary-color: #0033a0;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
            --bg-light: #f8f9fa;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Reset font sizes to ensure consistency */
        html {
            font-size: 16px !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            font-size: 1rem !important;
            padding-top: 0;
        }

        /* Main content padding for non-hero pages */
        main > section:first-child:not(.hero-section),
        main > .container:first-child {
            padding-top: 100px;
        }

        @media (max-width: 991px) {
            main > section:first-child:not(.hero-section),
            main > .container:first-child {
                padding-top: 80px;
            }

            /* Mobile Floating Header - Global Style */
            section[class*="hero"],
            section.py-5.text-white {
                position: relative;
                border-radius: 0 0 30px 30px !important;
                margin: 0 !important;
                padding: 90px 20px 25px 20px !important;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
                animation: floatHeaderSlide 0.5s ease-out;
            }

            section[class*="hero"] h1,
            section.py-5.text-white h1 {
                font-size: 1.75rem !important;
                margin-bottom: 0.75rem !important;
            }

            section[class*="hero"] .lead,
            section.py-5.text-white .lead {
                font-size: 0.9rem !important;
                margin-bottom: 1rem !important;
            }

            section[class*="hero"] .badge,
            section.py-5.text-white .badge {
                font-size: 0.75rem !important;
                padding: 0.35rem 0.7rem !important;
            }

            @keyframes floatHeaderSlide {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        }

        @media (max-width: 768px) {
            section[class*="hero"],
            section.py-5.text-white {
                margin: 0 !important;
                padding: 85px 15px 22px 15px !important;
                border-radius: 0 0 25px 25px !important;
            }

            section[class*="hero"] h1,
            section.py-5.text-white h1 {
                font-size: 1.5rem !important;
            }

            section[class*="hero"] .lead,
            section.py-5.text-white .lead {
                font-size: 0.85rem !important;
            }
        }

        @media (max-width: 576px) {
            section[class*="hero"],
            section.py-5.text-white {
                margin: 0 !important;
                padding: 80px 12px 18px 12px !important;
                border-radius: 0 0 20px 20px !important;
            }

            section[class*="hero"] h1,
            section.py-5.text-white h1 {
                font-size: 1.35rem !important;
            }

            section[class*="hero"] .lead,
            section.py-5.text-white .lead {
                font-size: 0.8rem !important;
            }
        }

        /* =================================================================== */
        /* FLOATING NAVIGATION - MODERN GLASSMORPHISM DESIGN                  */
        /* =================================================================== */

        .floating-navbar {
            position: fixed;
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 40px);
            max-width: 1320px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), 0 2px 8px rgba(0, 0, 0, 0.05);
            z-index: 1030;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 0;
        }

        .floating-navbar.scrolled {
            top: 10px;
            width: calc(100% - 30px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15), 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .nav-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 30px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            gap: 12px;
            transition: transform 0.3s ease;
            z-index: 1031;
        }

        .nav-brand:hover {
            transform: scale(1.02);
        }

        .brand-text {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--secondary-color);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 280px;
        }

        .nav-toggler {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 8px;
            z-index: 1031;
            transition: all 0.3s ease;
        }

        .toggler-icon {
            width: 28px;
            height: 3px;
            background: var(--secondary-color);
            border-radius: 3px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-toggler.active .toggler-icon:nth-child(1) {
            transform: rotate(45deg) translateY(11px);
            background: var(--primary-color);
        }

        .nav-toggler.active .toggler-icon:nth-child(2) {
            opacity: 0;
            transform: translateX(-20px);
        }

        .nav-toggler.active .toggler-icon:nth-child(3) {
            transform: rotate(-45deg) translateY(-11px);
            background: var(--primary-color);
        }

        .nav-menu {
            display: flex;
        }

        .nav-list {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-link i {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-color), #FFB300);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
            border-radius: 12px;
        }

        .nav-link:hover {
            color: white;
            transform: translateY(-2px);
        }

        .nav-link:hover::before {
            opacity: 1;
        }

        .nav-link:hover i {
            transform: scale(1.15);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), #FFB300);
            color: white;
            box-shadow: 0 4px 15px rgba(244, 180, 0, 0.3);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 40%;
            height: 3px;
            background: white;
            border-radius: 3px;
        }

        /* =================================================================== */
        /* RESPONSIVE NAVIGATION STYLES                                       */
        /* =================================================================== */

        @media (max-width: 1200px) {
            .floating-navbar {
                width: calc(100% - 30px);
            }

            .nav-link {
                padding: 8px 14px;
                font-size: 0.9rem;
            }

            .brand-text {
                font-size: 1rem;
                max-width: 200px;
            }
        }

        @media (max-width: 991px) {
            body {
                padding-top: 0;
                padding-bottom: 0 !important;
            }

            .floating-navbar {
                display: none;
            }

            .nav-toggler {
                display: flex;
            }

            .nav-menu {
                position: fixed;
                top: 0;
                right: -100%;
                width: 300px;
                height: 100vh;
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(20px);
                padding: 100px 30px 30px;
                transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: -10px 0 30px rgba(0, 0, 0, 0.1);
                overflow-y: auto;
            }

            .nav-menu.active {
                right: 0;
            }

            .nav-list {
                flex-direction: column;
                gap: 8px;
                width: 100%;
            }

            .nav-item {
                width: 100%;
            }

            .nav-link {
                width: 100%;
                justify-content: flex-start;
                padding: 14px 20px;
                font-size: 1rem;
            }

            .nav-link i {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 768px) {
            .floating-navbar {
                top: 10px;
                width: calc(100% - 20px);
            }

            .nav-wrapper {
                padding: 10px 20px;
            }

            .brand-text {
                font-size: 0.9rem;
                max-width: 150px;
            }

            .nav-menu {
                width: 280px;
                padding: 90px 25px 25px;
            }
        }

        @media (max-width: 576px) {
            .nav-menu {
                width: 260px;
                padding: 80px 20px 20px;
            }

            .brand-text {
                font-size: 0.85rem;
                max-width: 130px;
            }
        }

        @media (max-width: 400px) {
            .nav-menu {
                width: 240px;
            }

            .brand-text {
                font-size: 0.8rem;
                max-width: 110px;
            }
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #e6a200;
            border-color: #e6a200;
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 3rem;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .footer {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #001f5c 100%);
            color: white;
            padding: 50px 0 20px;
        }

        /* Fix for pagination and navigation sizing */
        .pagination {
            font-size: 1rem !important;
            margin-bottom: 0 !important;
        }

        .pagination .page-link {
            padding: 0.5rem 0.75rem !important;
            font-size: 1rem !important;
            line-height: 1.25 !important;
            color: var(--secondary-color) !important;
            border: 1px solid #dee2e6 !important;
            text-decoration: none !important;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }

        .pagination .page-link:hover {
            color: var(--primary-color) !important;
            background-color: #f8f9fa !important;
            border-color: #dee2e6 !important;
        }

        /* Fix any oversized elements */
        .btn {
            font-size: 1rem !important;
        }

        .btn-sm {
            font-size: 0.875rem !important;
            padding: 0.25rem 0.5rem !important;
        }

        .btn-lg {
            font-size: 1.125rem !important;
            padding: 0.75rem 1.5rem !important;
        }

        /* Responsive design fixes */
        @media (max-width: 1200px) {
            .container {
                max-width: 95% !important;
                padding: 0 15px !important;
            }
        }

        @media (max-width: 991px) {
            body {
                padding-bottom: 0 !important;
            }

            .hero-section {
                min-height: 100vh !important;
            }

            .display-4 {
                font-size: 2.25rem !important;
                line-height: 1.2 !important;
            }

            .lead {
                font-size: 1.05rem !important;
                line-height: 1.5 !important;
            }

            .btn-lg {
                font-size: 1rem !important;
                padding: 0.75rem 1.5rem !important;
            }

            .hero-buttons {
                flex-direction: column !important;
                align-items: center !important;
                gap: 1rem !important;
            }

            .hero-buttons .btn {
                width: 250px !important;
                max-width: 90% !important;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 12px !important;
            }

            .display-4 {
                font-size: 2rem !important;
            }

            .lead {
                font-size: 1rem !important;
                margin-bottom: 2rem !important;
            }

            .hero-text h1 {
                margin-bottom: 1.5rem !important;
            }

            .hero-text p {
                max-width: 90% !important;
            }

            .section-title {
                font-size: 1.75rem !important;
            }

            .section-subtitle {
                font-size: 0.95rem !important;
            }

            .card-body {
                padding: 1.25rem !important;
            }

            .modal-dialog {
                margin: 0.5rem !important;
                max-width: calc(100% - 1rem) !important;
            }

            .modal-body {
                padding: 1rem !important;
            }

            /* Stats cards responsive */
            .stats-section .row>div {
                margin-bottom: 1rem;
            }

            .stats-card .card-body {
                padding: 1rem !important;
                text-align: center;
            }

            .stats-card h3 {
                font-size: 1.75rem !important;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding: 0 8px !important;
            }

            body {
                padding-bottom: 20px !important;
            }

            .display-4 {
                font-size: 1.75rem !important;
                margin-bottom: 1rem !important;
            }

            .lead {
                font-size: 0.95rem !important;
                margin-bottom: 1.5rem !important;
            }

            .btn-lg {
                font-size: 0.9rem !important;
                padding: 0.6rem 1.25rem !important;
            }

            .hero-buttons .btn {
                width: 200px !important;
            }

            .section-title {
                font-size: 1.5rem !important;
                margin-bottom: 1rem !important;
            }

            .section-subtitle {
                font-size: 0.9rem !important;
            }

            .card {
                margin-bottom: 1rem !important;
            }

            .card-body {
                padding: 1rem !important;
            }

            .modal-body {
                padding: 0.75rem !important;
            }

            .modal-header {
                padding: 1rem 0.75rem 0.5rem !important;
            }

            .modal-footer {
                padding: 0.5rem 0.75rem 1rem !important;
            }

            .hero-content {
                padding: 2rem 0 !important;
            }

            .stats-card h3 {
                font-size: 1.5rem !important;
            }

            .stats-card p {
                font-size: 0.85rem !important;
            }
        }

        @media (max-width: 480px) {
            .display-4 {
                font-size: 1.5rem !important;
            }

            .lead {
                font-size: 0.9rem !important;
            }

            .btn-lg {
                font-size: 0.85rem !important;
                padding: 0.5rem 1rem !important;
            }

            .hero-buttons .btn {
                width: 180px !important;
            }

            .section-title {
                font-size: 1.3rem !important;
            }
        }

        @media (max-width: 400px) {
            .display-4 {
                font-size: 1.35rem !important;
            }

            .hero-buttons .btn {
                width: 160px !important;
            }

            .section-title {
                font-size: 1.2rem !important;
            }
        }

        /* Enhanced mobile styles for cards and content */
        @media (max-width: 991px) {
            .row.g-4 {
                --bs-gutter-x: 1rem !important;
                --bs-gutter-y: 1rem !important;
            }

            .program-card,
            .berita-card {
                margin-bottom: 1rem !important;
            }

            .program-card .card-body,
            .berita-card .card-body {
                padding: 1.25rem !important;
            }

            .badge {
                font-size: 0.75rem !important;
                padding: 0.35rem 0.65rem !important;
            }

            /* Better spacing for content sections */
            .py-5 {
                padding-top: 2.5rem !important;
                padding-bottom: 2.5rem !important;
            }

            .mb-4 {
                margin-bottom: 1.5rem !important;
            }

            .mb-5 {
                margin-bottom: 2rem !important;
            }
        }

        .footer a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: var(--primary-color);
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
        }

        /* Bottom Navigation for Mobile/Tablet */
        .public-bottom-nav {
            position: fixed;
            bottom: 12px;
            left: 12px;
            right: 12px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            z-index: 1000;
            display: none;
            padding: 8px;
            max-width: 500px;
            margin: 0 auto;
        }

        .public-bottom-nav-list {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0;
            padding: 0;
            list-style: none;
            gap: 2px;
        }

        .public-bottom-nav-item {
            flex: 1;
            text-align: center;
        }

        .public-bottom-nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            padding: 8px 4px;
            color: #666;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
            font-size: 0.65rem;
            font-weight: 600;
            border-radius: 16px;
            position: relative;
            min-height: 56px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .public-bottom-nav-link:hover,
        .public-bottom-nav-link.active {
            color: var(--primary-color);
            text-decoration: none;
            background: linear-gradient(135deg, rgba(244, 180, 0, 0.1), rgba(244, 180, 0, 0.05));
            transform: translateY(-2px);
        }

        .public-bottom-nav-icon {
            font-size: 1.1rem;
            transition: all 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
            margin-bottom: 2px;
        }

        .public-bottom-nav-link:hover .public-bottom-nav-icon,
        .public-bottom-nav-link.active .public-bottom-nav-icon {
            transform: scale(1.2);
            filter: drop-shadow(0 2px 8px rgba(244, 180, 0, 0.4));
        }

        .public-bottom-nav-link.active::before {
            content: '';
            position: absolute;
            top: 4px;
            left: 50%;
            transform: translateX(-50%);
            width: 24px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), #FFB300);
            border-radius: 2px;
            box-shadow: 0 1px 3px rgba(244, 180, 0, 0.3);
        }

        /* =================================================================== */
        /* RESPONSIVE BREAKPOINTS - MOBILE FIRST APPROACH                     */
        /* =================================================================== */

        /* ===== TABLET & MOBILE: Show bottom nav, hide desktop nav ===== */
        @media (max-width: 991px) {
            .public-bottom-nav {
                display: block;
            }

            body {
                padding-bottom: 0px !important;
                overflow-x: hidden;
            }

            html {
                overflow-x: hidden;
            }

            .navbar {
                display: none !important;
            }
        }

        /* ===== MEDIUM TABLETS: 768px and below ===== */
        @media (max-width: 768px) {
            .public-bottom-nav {
                bottom: 10px;
                width: calc(100% - 16px);
                max-width: 480px;
                padding: 6px;
            }

            .public-bottom-nav-link {
                font-size: 0.6rem;
                padding: 6px 3px;
                gap: 2px;
                min-height: 50px;
            }

            .public-bottom-nav-icon {
                font-size: 1rem;
            }

            body {
                padding-bottom: 20px !important;
            }

            .section-title {
                font-size: 2rem;
            }

            .section-subtitle {
                font-size: 1rem;
            }
        }

        /* ===== SMALL TABLETS: 576px and below ===== */
        @media (max-width: 576px) {
            .public-bottom-nav {
                bottom: 8px;
                width: calc(100% - 12px);
                max-width: 420px;
                padding: 4px;
                border-radius: 20px;
            }

            .public-bottom-nav-link {
                font-size: 0.55rem;
                padding: 5px 2px;
                gap: 1px;
                min-height: 46px;
                border-radius: 12px;
            }

            .public-bottom-nav-icon {
                font-size: 0.95rem;
            }

            body {
                padding-bottom: 20px !important;
            }

            .display-4 {
                font-size: 1.75rem !important;
            }

            .lead {
                font-size: 1rem !important;
            }

            .btn-lg {
                font-size: 0.9rem !important;
                padding: 0.6rem 1rem !important;
            }
        }

        /* ===== LARGE PHONES: 480px and below ===== */
        @media (max-width: 480px) {
            .public-bottom-nav {
                width: calc(100% - 10px);
                max-width: 380px;
                padding: 3px;
            }

            .public-bottom-nav-link {
                font-size: 0.5rem;
                padding: 4px 1px;
                min-height: 42px;
            }

            .public-bottom-nav-icon {
                font-size: 0.9rem;
            }

            body {
                padding-bottom: 20px !important;
            }
        }

        /* ===== STANDARD PHONES: 400px and below ===== */
        @media (max-width: 400px) {
            .public-bottom-nav {
                bottom: 6px;
                width: calc(100% - 8px);
                max-width: 340px;
            }

            .public-bottom-nav-link {
                font-size: 0.45rem;
                padding: 3px 1px;
                min-height: 38px;
            }

            .public-bottom-nav-icon {
                font-size: 0.85rem;
            }

            body {
                padding-bottom: 20px !important;
            }
        }

        /* ===== SMALL PHONES: 350px and below ===== */
        @media (max-width: 350px) {
            .public-bottom-nav {
                bottom: 4px;
                width: calc(100% - 6px);
                max-width: 320px;
                padding: 2px;
                border-radius: 18px;
            }

            .public-bottom-nav-link {
                font-size: 0.4rem;
                padding: 2px 1px;
                min-height: 34px;
                border-radius: 10px;
                gap: 0px;
            }

            .public-bottom-nav-icon {
                font-size: 0.8rem;
                margin-bottom: 1px;
            }

            body {
                padding-bottom: 20px !important;
            }

            .display-4 {
                font-size: 1.5rem !important;
            }

            .lead {
                font-size: 0.95rem !important;
            }

            .btn-lg {
                font-size: 0.8rem !important;
                padding: 0.5rem 0.8rem !important;
            }

            .container {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
        }

        /* ===== LANDSCAPE ORIENTATION: Mobile/Tablet ===== */
        @media (max-width: 991px) and (orientation: landscape) {
            body {
                padding-bottom: 20px !important;
            }

            .public-bottom-nav {
                bottom: 8px;
                width: calc(100% - 12px);
                max-width: 640px;
                padding: 4px;
            }

            .public-bottom-nav-link {
                min-height: 38px;
                padding: 4px 2px;
                font-size: 0.5rem;
            }

            .public-bottom-nav-icon {
                font-size: 0.9rem;
            }
        }

        /* =================================================================== */
        /* HERO SECTION RESPONSIVE STYLES                                     */
        /* =================================================================== */

        /* Video Background Styles */
        .video-background {
            overflow: hidden;
        }

        .video-background iframe {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        /* Bounce Animation */
        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-bounce {
            animation: bounce 2s ease-in-out infinite;
        }

        /* Hero Section Enhancements */
        .hero-section {
            position: relative;
            overflow: hidden;
        }

        /* ===== HERO RESPONSIVE: 768px and below ===== */
        @media (max-width: 768px) {
            .video-background iframe {
                min-width: 120%;
                min-height: 120%;
            }

            .hero-section {
                min-height: 100vh;
            }

            .display-4 {
                font-size: 2rem !important;
            }

            .lead {
                font-size: 1.1rem !important;
            }

            .btn-lg {
                font-size: 1rem !important;
                padding: 0.75rem 1.25rem !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Floating Navigation -->
    <nav class="floating-navbar" id="floatingNav">
        <div class="container">
            <div class="nav-wrapper">
                <a class="nav-brand" href="{{ route('public.home') }}">
                    @include('components.logo', ['style' => 'height: 45px; width: auto; margin-right: 12px;'])
                    <span class="brand-text">{{ $profil->nama_instansi ?? 'Dinas PUPR' }}</span>
                </a>

                <button class="nav-toggler" type="button" id="navToggler">
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                </button>

                <div class="nav-menu" id="navMenu">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('public.home') ? 'active' : '' }}"
                                href="{{ route('public.home') }}">
                                <i class="bi bi-house-door-fill"></i>
                                <span>Beranda</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('public.struktur') ? 'active' : '' }}"
                                href="{{ route('public.struktur') }}">
                                <i class="bi bi-diagram-3-fill"></i>
                                <span>Struktur</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('public.program*') ? 'active' : '' }}"
                                href="{{ route('public.program') }}">
                                <i class="bi bi-briefcase-fill"></i>
                                <span>Program</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('public.berita*') ? 'active' : '' }}"
                                href="{{ route('public.berita') }}">
                                <i class="bi bi-newspaper"></i>
                                <span>Berita</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('public.galeri*') ? 'active' : '' }}"
                                href="{{ route('public.galeri') }}">
                                <i class="bi bi-images"></i>
                                <span>Galeri</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('public.unduhan*') ? 'active' : '' }}"
                                href="{{ route('public.unduhan') }}">
                                <i class="bi bi-download"></i>
                                <span>Unduhan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('public.kontak') ? 'active' : '' }}"
                                href="{{ route('public.kontak') }}">
                                <i class="bi bi-telephone-fill"></i>
                                <span>Kontak</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="d-flex align-items-center mb-3">
                        @include('components.logo', [
                            'style' => 'height: 50px; width: auto; margin-right: 15px;',
                        ])
                        <h5 class="fw-bold mb-0">{{ $profil->nama_instansi ?? 'Dinas PUPR Kabupaten Katingan' }}</h5>
                    </div>
                    <p class="mb-3">
                        @php
                            $misi =
                                $profil->misi ??
                                'Melayani masyarakat dengan profesional dan transparan dalam pembangunan infrastruktur yang berkelanjutan.';
                            $shortMisi = Str::limit($misi, 80);
                        @endphp
                        {{ $shortMisi }}
                        @if (strlen($misi) > 80)
                            <br>
                            <a href="#" class="btn btn-sm btn-outline-light mt-2" data-bs-toggle="modal"
                                data-bs-target="#aboutModal">
                                <i class="bi bi-info-circle me-1"></i>Selengkapnya
                            </a>
                        @endif
                    </p>
                    <div class="social-links">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Menu</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('public.home') }}">Beranda</a></li>
                        <li><a href="{{ route('public.struktur') }}">Struktur</a></li>
                        <li><a href="{{ route('public.program') }}">Program</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Informasi</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('public.berita') }}">Berita</a></li>
                        <li><a href="{{ route('public.kontak') }}">Kontak</a></li>
                        <li><a href="#">Pengaduan</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 mb-4">
                    <h6 class="fw-bold mb-3">Kontak Kami</h6>
                    <div class="d-flex mb-2">
                        <i class="bi bi-geo-alt-fill me-2 mt-1"></i>
                        <span>{{ $profil->alamat ?? 'Jl. Raya Kasongan No. 123, Katingan, Kalimantan Tengah' }}</span>
                    </div>
                    @if (isset($profil) && $profil->telepon)
                        <div class="d-flex mb-2">
                            <i class="bi bi-telephone-fill me-2 mt-1"></i>
                            <span>{{ $profil->telepon }}</span>
                        </div>
                    @endif
                    @if (isset($profil) && $profil->email)
                        <div class="d-flex mb-2">
                            <i class="bi bi-envelope-fill me-2 mt-1"></i>
                            <span>{{ $profil->email }}</span>
                        </div>
                    @endif
                    @if (isset($profil) && $profil->jam_operasional)
                        <div class="d-flex mb-2">
                            <i class="bi bi-clock-fill me-2 mt-1"></i>
                            <span>{{ $profil->jam_operasional }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <hr class="my-4">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }}
                        {{ $profil->nama_instansi ?? 'Dinas PUPR Kabupaten Katingan' }}. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small>Developed with ❤️ for better public service</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bottom Navigation for Mobile/Tablet -->
    <nav class="public-bottom-nav">
        <ul class="public-bottom-nav-list">
            <li class="public-bottom-nav-item">
                <a href="{{ route('public.home') }}"
                    class="public-bottom-nav-link {{ Request::routeIs('public.home') ? 'active' : '' }}">
                    <i class="bi bi-house-fill public-bottom-nav-icon"></i>
                    <span>Beranda</span>
                </a>
            </li>
            <li class="public-bottom-nav-item">
                <a href="{{ route('public.struktur') }}"
                    class="public-bottom-nav-link {{ Request::routeIs('public.struktur') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3-fill public-bottom-nav-icon"></i>
                    <span>Struktur</span>
                </a>
            </li>
            <li class="public-bottom-nav-item">
                <a href="{{ route('public.program') }}"
                    class="public-bottom-nav-link {{ Request::routeIs('public.program*') ? 'active' : '' }}">
                    <i class="bi bi-briefcase-fill public-bottom-nav-icon"></i>
                    <span>Program</span>
                </a>
            </li>
            <li class="public-bottom-nav-item">
                <a href="{{ route('public.berita') }}"
                    class="public-bottom-nav-link {{ Request::routeIs('public.berita*') ? 'active' : '' }}">
                    <i class="bi bi-newspaper public-bottom-nav-icon"></i>
                    <span>Berita</span>
                </a>
            </li>
            <li class="public-bottom-nav-item">
                <a href="{{ route('public.galeri') }}"
                    class="public-bottom-nav-link {{ Request::routeIs('public.galeri*') ? 'active' : '' }}">
                    <i class="bi bi-images public-bottom-nav-icon"></i>
                    <span>Galeri</span>
                </a>
            </li>
            <li class="public-bottom-nav-item">
                <a href="{{ route('public.unduhan') }}"
                    class="public-bottom-nav-link {{ Request::routeIs('public.unduhan*') ? 'active' : '' }}">
                    <i class="bi bi-download public-bottom-nav-icon"></i>
                    <span>Unduhan</span>
                </a>
            </li>
            <li class="public-bottom-nav-item">
                <a href="{{ route('public.kontak') }}"
                    class="public-bottom-nav-link {{ Request::routeIs('public.kontak') ? 'active' : '' }}">
                    <i class="bi bi-telephone-fill public-bottom-nav-icon"></i>
                    <span>Kontak</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- About Modal -->
    <div class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aboutModalLabel">Tentang Kami</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center mb-4">
                        @include('components.logo', [
                            'style' => 'height: 60px; width: auto; margin-right: 15px;',
                        ])
                        <h6 class="fw-bold mb-0">{{ $profil->nama_instansi ?? 'Dinas PUPR Kabupaten Katingan' }}</h6>
                    </div>

                    @if ($profil && $profil->visi)
                        <h6 class="mt-4 fw-bold">Visi:</h6>
                        <p>{{ $profil->visi }}</p>
                    @endif

                    @if ($profil && $profil->misi)
                        <h6 class="mt-3 fw-bold">Misi:</h6>
                        <p>{{ $profil->misi }}</p>
                    @endif

                    @if ($profil && $profil->sejarah)
                        <h6 class="mt-3 fw-bold">Sejarah:</h6>
                        <p>{{ $profil->sejarah }}</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });

        // =================================================================
        // FLOATING NAVIGATION CONTROLS
        // =================================================================

        document.addEventListener('DOMContentLoaded', function() {
            const floatingNav = document.getElementById('floatingNav');
            const navToggler = document.getElementById('navToggler');
            const navMenu = document.getElementById('navMenu');
            const navLinks = document.querySelectorAll('.nav-link');

            // Scroll effect for navbar
            let lastScroll = 0;
            window.addEventListener('scroll', function() {
                const currentScroll = window.pageYOffset;

                if (currentScroll > 100) {
                    floatingNav.classList.add('scrolled');
                } else {
                    floatingNav.classList.remove('scrolled');
                }

                // Hide navbar on scroll down, show on scroll up
                if (currentScroll > lastScroll && currentScroll > 300) {
                    floatingNav.style.transform = 'translateX(-50%) translateY(-120%)';
                } else {
                    floatingNav.style.transform = 'translateX(-50%) translateY(0)';
                }

                lastScroll = currentScroll;
            });

            // Mobile menu toggle
            if (navToggler && navMenu) {
                navToggler.addEventListener('click', function() {
                    this.classList.toggle('active');
                    navMenu.classList.toggle('active');
                    document.body.style.overflow = navMenu.classList.contains('active') ? 'hidden' : '';
                });

                // Close menu when clicking nav links
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        navToggler.classList.remove('active');
                        navMenu.classList.remove('active');
                        document.body.style.overflow = '';
                    });
                });

                // Close menu when clicking outside
                document.addEventListener('click', function(event) {
                    const isClickInsideNav = floatingNav.contains(event.target);
                    if (!isClickInsideNav && navMenu.classList.contains('active')) {
                        navToggler.classList.remove('active');
                        navMenu.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });
            }

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href !== '#' && href.length > 1) {
                        e.preventDefault();
                        const target = document.querySelector(href);
                        if (target) {
                            const offsetTop = target.offsetTop - 100;
                            window.scrollTo({
                                top: offsetTop,
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            });
        });

        // Video background controls
        function toggleVideoSound() {
            const iframe = document.querySelector('.video-background iframe');
            const toggleBtn = document.getElementById('videoToggle');

            if (iframe && toggleBtn) {
                const currentSrc = iframe.src;

                if (currentSrc.includes('mute=1')) {
                    // Unmute video
                    iframe.src = currentSrc.replace('mute=1', 'mute=0');
                    toggleBtn.innerHTML = '<i class="bi bi-volume-up me-2"></i>Matikan Suara';
                } else if (currentSrc.includes('mute=0')) {
                    // Mute video
                    iframe.src = currentSrc.replace('mute=0', 'mute=1');
                    toggleBtn.innerHTML = '<i class="bi bi-volume-mute me-2"></i>Aktifkan Suara';
                }
            }
        }

        // Smooth scrolling for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Auto-hide video controls on mobile for better UX
        if (window.innerWidth <= 768) {
            const videoToggle = document.getElementById('videoToggle');
            if (videoToggle) {
                videoToggle.style.display = 'none';
            }
        }

        // Lazy loading optimization for video background
        function optimizeVideoBackground() {
            const videoContainer = document.querySelector('.video-background');
            if (videoContainer && window.innerWidth <= 768) {
                // On mobile, replace video with static background for better performance
                videoContainer.style.display = 'none';
                const heroSection = document.querySelector('.hero-section');
                if (heroSection) {
                    heroSection.style.background = 'linear-gradient(135deg, var(--secondary-color) 0%, #001f5c 100%)';
                }
            }
        }

        // Run optimization on load and resize
        window.addEventListener('load', optimizeVideoBackground);
        window.addEventListener('resize', optimizeVideoBackground);

        // Enhanced YouTube Autoplay Handler
        document.addEventListener('DOMContentLoaded', function() {
            const youtubeIframes = document.querySelectorAll('iframe[src*="youtube.com/embed"]');

            // Force autoplay for all YouTube videos
            youtubeIframes.forEach(function(iframe) {
                const src = iframe.src;

                // Ensure autoplay parameters are set
                if (!src.includes('autoplay=1')) {
                    const separator = src.includes('?') ? '&' : '?';
                    iframe.src = src + separator + 'autoplay=1&mute=1&playsinline=1';
                }

                // Add intersection observer for lazy loading
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Trigger autoplay when video is in viewport
                            const currentSrc = iframe.src;
                            if (!currentSrc.includes('autoplay=1')) {
                                const separator = currentSrc.includes('?') ? '&' : '?';
                                iframe.src = currentSrc + separator + 'autoplay=1&mute=1';
                            }
                        }
                    });
                }, {
                    threshold: 0.3
                });

                observer.observe(iframe);
            });

            // Handle mobile autoplay restrictions
            if (/Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                // Add click handler for mobile devices
                document.addEventListener('touchstart', function() {
                    youtubeIframes.forEach(function(iframe) {
                        const src = iframe.src;
                        if (!src.includes('autoplay=1')) {
                            const separator = src.includes('?') ? '&' : '?';
                            iframe.src = src + separator + 'autoplay=1&mute=1';
                        }
                    });
                }, {
                    once: true
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
