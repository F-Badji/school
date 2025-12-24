<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Formateur - BJ Academie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        /* Styles pour les badges uniformes */
        .badge-md {
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
            min-width: 1.5rem;
            height: 1.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            line-height: 1;
        }
        .badge-circle {
            border-radius: 50%;
            width: 1.5rem;
            height: 1.5rem;
            padding: 0;
            min-width: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .badge-circle span,
        .badge-circle {
            line-height: 1.5rem;
            vertical-align: middle;
        }
        .badge-floating {
            position: absolute;
            top: -8px;
            right: -8px;
            z-index: 10;
        }
        .badge-danger {
            background-color: #ea4335;
            color: white;
        }
        .badge.border-white {
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f5f7fa;
        }
        .sidebar-bg {
            background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);
        }
        .sidebar-collapsed {
            width: 5rem;
            transition: width 0.3s ease;
        }
        .sidebar-collapsed:hover {
            width: 16rem;
        }
        .sidebar-text {
            opacity: 0;
            max-width: 0;
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.3s ease, max-width 0.3s ease;
        }
        .sidebar-collapsed:hover .sidebar-text {
            opacity: 1;
            max-width: 200px;
        }
        /* Make dropdown menu items always visible when dropdown is open */
        #coursDropdownMenu:not(.hidden) .sidebar-text {
            opacity: 1 !important;
            max-width: 200px !important;
        }
        /* Ensure dropdown menu is visible and properly positioned */
        #coursDropdownMenu:not(.hidden) {
            display: block !important;
        }
        /* Make sure icons in dropdown are visible */
        #coursDropdownMenu:not(.hidden) svg {
            opacity: 1 !important;
            visibility: visible !important;
        }
        nav a {
            transition: none !important;
            -webkit-transition: none !important;
        }
        nav a,
        nav a *,
        aside nav a,
        aside nav a *,
        aside nav a svg,
        aside nav a span {
            transition: none !important;
            -webkit-transition: none !important;
        }
        .hero-background {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            min-width: 400px;
            height: 100%;
            background-image: url('{{ asset("assets/images/photo2.png") }}');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: top right;
            opacity: 0.65;
            pointer-events: none;
            z-index: 1;
        }
        @media (min-width: 1024px) {
            .hero-background {
                width: 45%;
                min-width: 500px;
                opacity: 0.7;
            }
        }
        @media (min-width: 1280px) {
            .hero-background {
                width: 40%;
                min-width: 600px;
                opacity: 0.75;
            }
        }
        .content-wrapper {
            position: relative;
            z-index: 2;
        }
        .hero-banner {
            position: relative;
            width: 100%;
            min-height: 280px;
            border-radius: 24px;
            overflow: hidden;
            background: linear-gradient(135deg, #1a1f3a 0%, #161b33 50%, rgba(255, 255, 255, 0.95) 100%);
            box-shadow: 0 20px 60px rgba(26, 31, 58, 0.3);
            animation: fadeInUp 0.8s ease-out;
        }
        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('{{ asset("assets/images/photo2.png") }}');
            background-size: 25%;
            background-position: center right;
            background-repeat: no-repeat;
            opacity: 0.85;
            z-index: 1;
        }
        .hero-banner::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(26, 31, 58, 0.75) 0%, rgba(22, 27, 51, 0.65) 50%, rgba(255, 255, 255, 0.4) 100%);
            z-index: 2;
        }
        .hero-content {
            position: relative;
            z-index: 3;
            padding: 48px 56px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .hero-title {
            font-size: 2.75rem;
            font-weight: 800;
            background: linear-gradient(135deg, #1a1f3a 0%, #161b33 50%, rgba(255, 255, 255, 1) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 16px;
            line-height: 1.2;
            animation: slideInLeft 0.8s ease-out 0.2s both;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
            filter: drop-shadow(0 2px 6px rgba(255, 255, 255, 0.6)) drop-shadow(0 4px 8px rgba(26, 31, 58, 0.4));
            opacity: 1;
        }
        .hero-subtitle {
            font-size: 1.25rem;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 24px;
            animation: slideInLeft 0.8s ease-out 0.4s both;
            text-shadow: 0 1px 10px rgba(0, 0, 0, 0.15);
        }
        .hero-description {
            font-size: 1rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.9);
            max-width: 600px;
            line-height: 1.6;
            animation: slideInLeft 0.8s ease-out 0.6s both;
        }
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
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        .hero-banner:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 80px rgba(26, 31, 58, 0.4);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hero-banner:hover::before {
            animation: float 3s ease-in-out infinite;
        }
        @media (max-width: 768px) {
            .hero-banner {
                min-height: 220px;
            }
            .hero-content {
                padding: 32px 24px;
            }
            .hero-title {
                font-size: 2rem;
            }
            .hero-subtitle {
                font-size: 1.1rem;
            }
            .hero-description {
                font-size: 0.9rem;
            }
        }
        .stat-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 28px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1a1f3a 0%, #161b33 100%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            transform: translateY(-4px);
        }
        .stat-card:hover::before {
            transform: scaleX(1);
        }
        .stat-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .chart-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 32px;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            width: 100%;
            box-sizing: border-box;
        }
        /* Forcer le grid à utiliser des colonnes flexibles */
        #chartEventsGrid {
            display: grid !important;
            grid-template-columns: 1fr !important;
            gap: 1.5rem !important;
            width: 100% !important;
            max-width: 100% !important;
        }
        @media (min-width: 1024px) {
            #chartEventsGrid {
                grid-template-columns: repeat(3, 1fr) !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            #chartCard1 {
                grid-column: span 2 / span 2 !important;
                width: 100% !important;
            }
            #chartCard2 {
                width: 100% !important;
            }
        }
        .chart-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }
        #performanceChart {
            max-width: 100% !important;
        }
        .event-card {
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #ffffff;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .event-card:hover {
            border-color: #065b32;
            background: #f0fdf4;
            transform: translateX(4px);
        }
        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            color: #64748b;
            cursor: pointer;
            transition: all 0.15s ease;
            position: relative;
        }
        .calendar-day:hover {
            background: #f1f5f9;
        }
        .calendar-day.today {
            background: linear-gradient(135deg, #1a1f3a 0%, #161b33 100%);
            color: white;
            font-weight: 600;
        }
        .calendar-day.has-event::after {
            content: '';
            position: absolute;
            bottom: 6px;
            width: 6px;
            height: 6px;
            background: #1a1f3a;
            border-radius: 50%;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
        }
        .calendar-day.today::after {
            content: '';
            position: absolute;
            bottom: 6px;
            width: 6px;
            height: 6px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.5);
            animation: bouncePoint 2s ease-in-out infinite;
        }
        @keyframes bouncePoint {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-3px);
            }
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .apprenant-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .apprenant-card:hover {
            transform: translateY(-2px);
        }
        .calendar-day.today.has-event::after {
            background: white;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.5);
        }
        .progress-bar {
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 16px;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #065b32 0%, #087a45 100%);
            border-radius: 4px;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .badge-white {
            background: white;
            color: #1a1f3a;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 12px;
            min-width: 20px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }
        /* Support Modal Styles */
        .support-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .support-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .support-modal {
            background: white;
            border-radius: 24px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            transform: scale(0.9) translateY(20px);
            transition: all 0.3s ease;
            position: relative;
        }
        .support-modal-overlay.active .support-modal {
            transform: scale(1) translateY(0);
        }
        .support-modal-header {
            position: relative;
            padding: 0;
            border-radius: 24px 24px 0 0;
            overflow: hidden;
        }
        .support-modal-header img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .support-modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }
        .support-modal-close:hover {
            background: white;
            transform: rotate(90deg);
        }
        .support-modal-content {
            padding: 32px;
        }
        .support-modal-title {
            font-size: 28px;
            font-weight: 700;
            color: #1a1f3a;
            margin-bottom: 12px;
            text-align: center;
        }
        .support-modal-subtitle {
            font-size: 16px;
            color: #6b7280;
            text-align: center;
            margin-bottom: 32px;
        }
        .support-contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        .support-contact-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: block;
        }
        .support-contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s ease;
        }
        .support-contact-card:hover::before {
            left: 100%;
        }
        .support-contact-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            border-color: #3b82f6;
        }
        .support-contact-card.whatsapp:hover {
            background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
            border-color: #25d366;
        }
        .support-contact-card.instagram:hover {
            background: linear-gradient(135deg, #e4405f 0%, #c13584 100%);
            border-color: #e4405f;
        }
        .support-contact-card.gmail:hover {
            background: linear-gradient(135deg, #ea4335 0%, #c5221f 100%);
            border-color: #ea4335;
        }
        .support-contact-card.whatsapp:hover *,
        .support-contact-card.instagram:hover *,
        .support-contact-card.gmail:hover * {
            color: white !important;
        }
        .support-contact-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .support-contact-card:hover .support-contact-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .support-contact-icon img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }
        .support-contact-label {
            font-size: 16px;
            font-weight: 600;
            color: #1a1f3a;
            margin-bottom: 4px;
            transition: color 0.3s ease;
        }
        .support-contact-value {
            font-size: 14px;
            color: #6b7280;
            transition: color 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="flex h-screen overflow-hidden">
        <!-- Left Sidebar -->
        <aside id="sidebar" class="sidebar-collapsed sidebar-bg text-white flex flex-col py-6">
            <!-- Logo -->
            <div class="mb-8 flex items-center justify-center px-4">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 flex flex-col gap-6 w-full px-2">
                @php
                    $currentRoute = request()->route()->getName();
                    $isDashboard = $currentRoute === 'formateur.dashboard';
                    $isCours = $currentRoute === 'formateur.cours' || $currentRoute === 'formateur.cours.create' || $currentRoute === 'formateur.cours.edit';
                    $isNotes = $currentRoute === 'formateur.notes';
                    $isCalendrier = $currentRoute === 'formateur.calendrier';
                    $isMessages = $currentRoute === 'formateur.messages';
                    $isApprenants = $currentRoute === 'formateur.apprenants';
                @endphp
                <a href="{{ route('formateur.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link" style="transition: none !important; -webkit-transition: none !important; {{ $isDashboard ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="sidebar-text font-medium" style="transition: none !important; -webkit-transition: none !important;">Tableau de bord</span>
                </a>
                <div class="w-full">
                    <a href="{{ route('formateur.cours') }}" id="coursDropdownBtn" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link cursor-pointer" style="transition: none !important; -webkit-transition: none !important; {{ $isCours || $isNotes || $isCalendrier ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span class="sidebar-text font-medium flex-1" style="transition: none !important; -webkit-transition: none !important;">Cours</span>
                        <svg class="w-4 h-4 sidebar-text flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <!-- Dropdown Menu -->
                    <div id="coursDropdownMenu" class="w-full mt-2 px-2 hidden">
                        <a href="{{ route('formateur.cours') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg nav-link sidebar-text" style="transition: none !important; -webkit-transition: none !important; {{ $isCours ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="sidebar-text font-medium text-sm" style="transition: none !important; -webkit-transition: none !important;">Mes cours</span>
                        </a>
                        <a href="{{ route('formateur.notes') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg nav-link sidebar-text" style="transition: none !important; -webkit-transition: none !important; {{ $isNotes ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="sidebar-text font-medium text-sm" style="transition: none !important; -webkit-transition: none !important;">Notes</span>
                        </a>
                        <a href="{{ route('formateur.calendrier') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg nav-link sidebar-text" style="transition: none !important; -webkit-transition: none !important; {{ $isCalendrier ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="sidebar-text font-medium text-sm" style="transition: none !important; -webkit-transition: none !important;">Mon calendrier</span>
                        </a>
                    </div>
                </div>
                <a href="{{ route('formateur.devoirs') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link" style="transition: none !important; -webkit-transition: none !important; {{ ($currentRoute ?? '') === 'formateur.devoirs' || ($currentRoute ?? '') === 'formateur.devoirs.create' ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="sidebar-text font-medium" style="transition: none !important; -webkit-transition: none !important;">Devoirs</span>
                </a>
                <a href="{{ route('formateur.examens') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link" style="transition: none !important; -webkit-transition: none !important; {{ ($currentRoute ?? '') === 'formateur.examens' || ($currentRoute ?? '') === 'formateur.examens.create' ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <span class="sidebar-text font-medium" style="transition: none !important; -webkit-transition: none !important;">Examens</span>
                </a>
                <a href="{{ route('formateur.apprenants') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link" style="transition: none !important; -webkit-transition: none !important; {{ $isApprenants ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="sidebar-text font-medium" style="transition: none !important; -webkit-transition: none !important;">Mes apprenants</span>
                </a>
                <a href="{{ route('formateur.messages') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link relative" style="transition: none !important; -webkit-transition: none !important; {{ $isMessages ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span class="sidebar-text font-medium" style="transition: none !important; -webkit-transition: none !important;">Messages</span>
                    @if(isset($sidebarUnreadMessagesCount) && $sidebarUnreadMessagesCount > 0)
                        <span class="badge badge-md badge-circle badge-floating badge-danger border-white" id="sidebarUnreadBadge">{{ $sidebarUnreadMessagesCount }}</span>
                    @endif
                </a>
            </nav>

            <!-- Bottom Section -->
            <div class="w-full px-2 space-y-2 border-t border-gray-700/50 pt-4">
                <a href="{{ route('formateur.parametres') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg " style="transition: none !important; -webkit-transition: none !important; {{ ($currentRoute ?? '') === 'formateur.parametres' ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="sidebar-text font-medium">Paramètres</span>
                </a>
                <a href="#" id="supportBtn" class="flex items-center gap-3 px-4 py-3 rounded-lg ">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="sidebar-text font-medium">Support</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden relative">
            <!-- Hero Background Image -->
            <div class="hero-background" style="background-image: url('{{ asset('assets/images/photo2.png') }}');"></div>
            
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-8 py-6 relative z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-1">Tableau de bord</h1>
                        <p class="text-gray-600">Bonjour, {{ $user->prenom ?? $user->name ?? 'Formateur' }} 👋 Bienvenue sur votre espace d'enseignement</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-lg bg-white hover:border-gray-300 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <select class="text-sm font-medium text-gray-700 border-none outline-none bg-transparent cursor-pointer">
                                <option>{{ \Carbon\Carbon::now()->locale('fr')->isoFormat('MMMM YYYY') }}</option>
                            </select>
                        </div>
                        @include('components.notification-icon-formateur')
                        <div class="relative">
                            <button id="profileBtn" class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 overflow-hidden border-2 border-white shadow-md cursor-pointer hover:ring-2 hover:ring-purple-300 transition-all focus:outline-none">
                                @if($user->photo ?? null)
                                    <img src="{{ asset('storage/' . ($user->photo ?? '')) }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1)) }}
                                    </div>
                                @endif
                            </button>
                            <div id="profileMenu" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-xl border border-gray-200 py-2 z-50">
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 overflow-hidden border-2 border-purple-300 flex-shrink-0">
                                            @if($user->photo ?? null)
                                                <img src="{{ asset('storage/' . ($user->photo ?? '')) }}" alt="Profile" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm">
                                                    {{ strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $user->name ?? ($user->prenom ?? '') . ' ' . ($user->nom ?? '') }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ $user->email ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('formateur.profil') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>Profil</span>
                                    </a>
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>Paramètres</span>
                                    </a>
                                <hr class="my-1 border-gray-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            <span>Déconnexion</span>
                                        </button>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-8 content-wrapper" style="background-color: rgba(249, 250, 251, 0.85);">
                <div class="max-w-7xl mx-auto">
                    <!-- Hero Banner -->
                    <div class="hero-banner mb-8">
                        <div class="hero-content">
                            <h1 class="hero-title">
                                Bienvenue sur votre espace d'enseignement
                            </h1>
                            <p class="hero-subtitle">
                                Gérez vos cours, suivez vos apprenants et restez organisé dans votre enseignement
                            </p>
                            <p class="hero-description">
                                Accédez à tous vos cours, apprenants, devoirs à corriger et examens à noter en un seul endroit. Votre mission est de former les meilleurs.
                            </p>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Apprenants -->
                        <div class="stat-card">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Apprenants</div>
                                    <div class="text-4xl font-bold text-gray-900 mb-2">{{ $totalApprenants ?? 0 }}</div>
                                    <div class="text-xs text-green-600 font-semibold">Total</div>
                        </div>
                                <div class="stat-icon" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #2563eb;">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                        </div>
                        
                        <!-- Cours -->
                        <div class="stat-card">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Cours</div>
                                    <div class="text-4xl font-bold text-gray-900 mb-2">{{ $totalCours ?? 0 }}</div>
                                    <div class="text-xs text-green-600 font-semibold">{{ $totalMatieres ?? 0 }} matières</div>
                                </div>
                                <div class="stat-icon" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #059669;">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Devoirs créés -->
                        <div class="stat-card">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Devoirs</div>
                                    <div class="text-4xl font-bold text-gray-900 mb-2">{{ $totalDevoirs ?? 0 }}</div>
                                    <div class="text-xs text-orange-600 font-semibold">{{ $totalDevoirs ?? 0 }} programmés</div>
                                </div>
                                <div class="stat-icon" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #d97706;">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Examens créés -->
                        <div class="stat-card">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Examens</div>
                                    <div class="text-4xl font-bold text-gray-900 mb-2">{{ $totalExamens ?? 0 }}</div>
                                    <div class="text-xs text-red-600 font-semibold">{{ $totalExamens ?? 0 }} programmés</div>
                                </div>
                                <div class="stat-icon" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #dc2626;">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            </div>
                        </div>
                        
                    <!-- Chart and Events -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8" id="chartEventsGrid">
                        <!-- Performance Chart -->
                        <div class="lg:col-span-2 chart-card h-full w-full flex flex-col" id="chartCard1">
                            <div class="flex items-center justify-between mb-6">
                                <div class="space-y-2">
                                    <h2 class="text-xl font-bold text-gray-900">Activité de correction</h2>
                                    <p class="text-sm text-gray-500">Évolution sur les 10 dernières semaines</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button id="btnVoirTout" class="px-4 py-2 text-sm font-semibold rounded-lg text-white transition-all" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">Voir tout</button>
                                    <button id="btnDevoirs" class="px-4 py-2 text-sm font-semibold rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all">Devoirs</button>
                                    <button id="btnExamens" class="px-4 py-2 text-sm font-semibold rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all">Examens</button>
                                </div>
                            </div>
                            <div class="flex-1" style="min-height: 320px; position: relative; width: 100%;">
                                <canvas id="performanceChart" style="width: 100% !important; height: 100% !important;"></canvas>
                            </div>
                        </div>
                        
                        <!-- Upcoming Events -->
                        <div class="chart-card h-full w-full flex flex-col" id="chartCard2">
                            <div class="flex items-center justify-between mb-6">
                                <div class="space-y-2">
                                    <h2 class="text-xl font-bold text-gray-900">Événements à venir</h2>
                                    <p class="text-sm text-gray-500">{{ $evenementsAvenir->count() ?? 0 }} événements</p>
                                </div>
                            </div>
                            <div class="flex-1 space-y-3 overflow-y-auto">
                                @php
                                  $evenementsAvenirList = $evenementsAvenir ?? collect([]);
                                @endphp
                                @forelse($evenementsAvenirList as $evenement)
                                <div class="event-card">
                                    <div class="flex items-start gap-4">
                                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-[#065b32] to-[#087a45] flex flex-col items-center justify-center text-white flex-shrink-0">
                                            <span class="text-lg font-bold">{{ \Carbon\Carbon::parse($evenement->scheduled_at ?? now())->format('d') }}</span>
                                            <span class="text-xs font-semibold">{{ \Carbon\Carbon::parse($evenement->scheduled_at ?? now())->locale('fr')->isoFormat('MMM') }}</span>
                                                </div>
                                            <div class="flex-1 min-w-0">
                                            <h3 class="font-semibold text-gray-900 mb-1 text-sm">{{ $evenement->titre ?? 'Événement' }}</h3>
                                            <p class="text-xs text-gray-500 mb-2">
                                                {{ $evenement->type ?? 'Général' }}
                                                @if($evenement->matiere)
                                                    - {{ $evenement->matiere->nom_matiere ?? '' }}
                                                @endif
                                            </p>
                                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                <span>{{ \Carbon\Carbon::parse($evenement->scheduled_at ?? now())->locale('fr')->isoFormat('dddd HH:mm') }}</span>
                                            </div>
                                                </div>
                                        </div>
                                    </div>
                                    @empty
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                    <p class="text-sm text-gray-500">Aucun événement à venir</p>
                                    </div>
                                    @endforelse
                                        </div>
                                </div>
                        </div>
                    </div>
                    
                    <!-- Class Apprenants Section -->
                    <div class="chart-card mb-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900">Mes apprenants</h2>
                            <div class="flex items-center gap-2">
                                <button id="prevApprenants" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                <button id="nextApprenants" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div id="apprenantsContainer" class="flex gap-4 overflow-x-auto scrollbar-hide pb-4" style="scroll-behavior: smooth;">
                            @php
                              $apprenantsList = $apprenants ?? collect([]);
                            @endphp
                            @forelse($apprenantsList as $apprenant)
                            <div class="apprenant-card flex-shrink-0 w-64 bg-white border border-gray-200 rounded-xl p-4 hover:shadow-lg transition-shadow">
                                <div class="flex items-start gap-3 mb-4">
                                    <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 border-2 border-gray-200" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                        @if($apprenant->photo ?? null)
                                            <img src="{{ asset('storage/' . $apprenant->photo) }}" alt="{{ $apprenant->prenom ?? '' }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-white font-bold text-lg">
                                                {{ strtoupper(substr($apprenant->prenom ?? '', 0, 1) . substr($apprenant->nom ?? '', 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 text-base mb-1 truncate">{{ $apprenant->prenom ?? 'Apprenant' }}</h3>
                                        <p class="text-sm text-gray-500 truncate">{{ $apprenant->nom ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="mailto:{{ $apprenant->email ?? '#' }}" class="flex-1 flex items-center justify-center gap-2 px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        Email
                                    </a>
                                    <a href="#" class="flex-1 flex items-center justify-center gap-2 px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        Chat
                                    </a>
                                </div>
                            </div>
                            @empty
                            <div class="w-full text-center py-8 text-gray-500">
                                <p>Aucun apprenant trouvé.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                            
                    <!-- Calendar and Metrics -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Calendar -->
                        <div class="chart-card">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 mb-1">Calendrier</h2>
                                    <p class="text-sm text-gray-500">{{ $evenementsAvenir->count() ?? 0 }} événements ce mois</p>
                                </div>
                                            <div class="flex items-center gap-2">
                                    <select class="text-sm font-medium border border-gray-200 rounded-lg px-3 py-1.5 bg-white">
                                        <option>{{ \Carbon\Carbon::now()->locale('fr')->isoFormat('MMMM') }}</option>
                                    </select>
                                    <select class="text-sm font-medium border border-gray-200 rounded-lg px-3 py-1.5 bg-white">
                                        <option>{{ \Carbon\Carbon::now()->year }}</option>
                                    </select>
                            </div>
                            </div>
                            <div class="grid grid-cols-7 gap-2">
                                @foreach(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $jour)
                                <div class="text-center text-xs font-semibold text-gray-500 py-2">{{ $jour }}</div>
                                @endforeach
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $firstDayOfMonth = $now->copy()->startOfMonth();
                                    $lastDayOfMonth = $now->copy()->endOfMonth();
                                    $daysInMonth = $lastDayOfMonth->day;
                                    $startDayOfWeek = $firstDayOfMonth->dayOfWeekIso; // 1 = Monday, 7 = Sunday
                                    
                                    // Get event dates for this month
                                    $eventDates = [];
                                    if(isset($evenementsAvenir)) {
                                        foreach($evenementsAvenir as $event) {
                                            $eventDate = \Carbon\Carbon::parse($event->scheduled_at ?? now());
                                            if($eventDate->month == $now->month && $eventDate->year == $now->year) {
                                                $eventDates[] = $eventDate->day;
                                            }
                                        }
                                    }
                                @endphp
                                
                                {{-- Empty cells for days before the first day of the month --}}
                                @for($i = 1; $i < $startDayOfWeek; $i++)
                                <div class="calendar-day opacity-0"></div>
                                @endfor
                                
                                {{-- Days of the month --}}
                                @for($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $isToday = ($day == $now->day);
                                    $hasEvent = in_array($day, $eventDates);
                                @endphp
                                <div class="calendar-day {{ $isToday ? 'today' : '' }} {{ $hasEvent ? 'has-event' : '' }}">
                                    {{ $day }}
                                            </div>
                                @endfor
                                            </div>
                        </div>

                        <!-- Detailed Metrics -->
                        <div class="chart-card">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Statistiques détaillées</h2>
                            <div class="space-y-4">
                                <div class="p-5 bg-gray-50 rounded-xl border border-gray-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #2563eb;">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">Total devoirs</p>
                                                <p class="text-xs text-gray-500 mt-0.5">{{ $totalDevoirs ?? 0 }} {{ ($totalDevoirs ?? 0) > 1 ? 'devoirs' : 'devoir' }}</p>
                                            </div>
                                    </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-gray-900">{{ $totalDevoirs ?? 0 }}</p>
                                    </div>
                                </div>
                            </div>
                            
                                <div class="p-5 bg-gray-50 rounded-xl border border-gray-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #dc2626;">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                        </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">Total examens</p>
                                                <p class="text-xs text-gray-500 mt-0.5">{{ $totalExamens ?? 0 }} {{ ($totalExamens ?? 0) > 1 ? 'examens' : 'examen' }}</p>
                                    </div>
                                    </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-gray-900">{{ $totalExamens ?? 0 }}</p>
                                            </div>
                                    </div>
                                    </div>

                                <div class="p-5 bg-gray-50 rounded-xl border border-gray-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #059669;">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                        </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">Total matières</p>
                                                <p class="text-xs text-gray-500 mt-0.5">{{ $totalMatieres ?? 0 }} {{ ($totalMatieres ?? 0) > 1 ? 'matières' : 'matière' }}</p>
                                    </div>
                                </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-gray-900">{{ $totalMatieres ?? 0 }}</p>
                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Vérifier que Chart.js est chargé
            if (typeof Chart === 'undefined') {
                return;
            }
            
            const canvas = document.getElementById('performanceChart');
            if (!canvas) {
                return;
            }
            
            const ctx = canvas.getContext('2d');
            if (!ctx) {
                return;
            }
            
            const evolutionData = @json($evolutionData ?? []);
            
            if (!evolutionData || evolutionData.length === 0) {
                return;
            }
            
            // Créer l'instance du graphique
            const performanceChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: evolutionData.map(d => d.week),
                    datasets: [{
                        label: 'Devoirs corrigés',
                        data: evolutionData.map(d => d.devoirs),
                        borderColor: '#065b32',
                        backgroundColor: 'rgba(6, 91, 50, 0.05)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#065b32',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        hidden: false
                    }, {
                        label: 'Examens notés',
                        data: evolutionData.map(d => d.examens),
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.05)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        hidden: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: { size: 13, weight: '500' }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: { size: 13, weight: '600' },
                            bodyFont: { size: 12 },
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { size: 12 }, color: '#64748b' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 12 }, color: '#64748b' }
                        }
                    }
                }
            });

            // Gestion des boutons Voir tout/Devoirs/Examens
            const btnVoirTout = document.getElementById('btnVoirTout');
            const btnDevoirs = document.getElementById('btnDevoirs');
            const btnExamens = document.getElementById('btnExamens');

            function updateButtons(activeBtn) {
                // Réinitialiser tous les boutons
            [btnVoirTout, btnDevoirs, btnExamens].forEach(btn => {
                btn.style.background = '';
                btn.classList.remove('text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });

            // Activer le bouton sélectionné
            if (activeBtn === 'voirTout') {
                btnVoirTout.style.background = 'linear-gradient(180deg, #1a1f3a 0%, #161b33 100%)';
                btnVoirTout.classList.remove('bg-gray-100', 'text-gray-700');
                btnVoirTout.classList.add('text-white');
            } else if (activeBtn === 'devoirs') {
                btnDevoirs.style.background = 'linear-gradient(180deg, #1a1f3a 0%, #161b33 100%)';
                btnDevoirs.classList.remove('bg-gray-100', 'text-gray-700');
                btnDevoirs.classList.add('text-white');
            } else if (activeBtn === 'examens') {
                btnExamens.style.background = 'linear-gradient(180deg, #1a1f3a 0%, #161b33 100%)';
                btnExamens.classList.remove('bg-gray-100', 'text-gray-700');
                btnExamens.classList.add('text-white');
            }
        }

            btnVoirTout?.addEventListener('click', function() {
                // Afficher les deux graphiques
                performanceChart.data.datasets[0].hidden = false;
                performanceChart.data.datasets[1].hidden = false;
                performanceChart.update();
                updateButtons('voirTout');
                
                // Retirer le barré des textes dans la légende
                setTimeout(() => {
                    const legendItems = document.querySelectorAll('#performanceChart').parentElement.querySelectorAll('.chartjs-legend li');
                    legendItems.forEach((item) => {
                        item.style.textDecoration = 'none';
                        item.style.opacity = '1';
                    });
                }, 100);
            });

                    btnDevoirs?.addEventListener('click', function() {
                        // Afficher Devoirs, masquer Examens
                        performanceChart.data.datasets[0].hidden = false;
                        performanceChart.data.datasets[1].hidden = true;
                        performanceChart.update();
                        updateButtons('devoirs');
                
                // Barrer le texte "Examens" dans la légende
                setTimeout(() => {
                    const legendItems = document.querySelectorAll('#performanceChart').parentElement.querySelectorAll('.chartjs-legend li');
                    legendItems.forEach((item, index) => {
                        if (index === 1) { // Index 1 = Examens
                            item.style.textDecoration = 'line-through';
                            item.style.opacity = '0.5';
                    } else {
                            item.style.textDecoration = 'none';
                            item.style.opacity = '1';
                        }
                    });
                }, 100);
            });

                    btnExamens?.addEventListener('click', function() {
                        // Afficher Examens, masquer Devoirs
                        performanceChart.data.datasets[0].hidden = true;
                        performanceChart.data.datasets[1].hidden = false;
                        performanceChart.update();
                        updateButtons('examens');
                
                // Barrer le texte "Devoirs" dans la légende
                setTimeout(() => {
                    const legendItems = document.querySelectorAll('#performanceChart').parentElement.querySelectorAll('.chartjs-legend li');
                    legendItems.forEach((item, index) => {
                        if (index === 0) { // Index 0 = Devoirs
                            item.style.textDecoration = 'line-through';
                            item.style.opacity = '0.5';
                        } else {
                            item.style.textDecoration = 'none';
                            item.style.opacity = '1';
                        }
                    });
                }, 100);
            });
        });

        document.getElementById('profileBtn')?.addEventListener('click', (e) => {
                    e.stopPropagation();
            document.getElementById('profileMenu')?.classList.toggle('hidden');
        });
        document.addEventListener('click', (e) => {
            const btn = document.getElementById('profileBtn');
            const menu = document.getElementById('profileMenu');
            if (btn && menu && !btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });


        // Cours dropdown functionality
        const coursDropdownBtn = document.getElementById('coursDropdownBtn');
        const coursDropdownMenu = document.getElementById('coursDropdownMenu');
        const sidebar = document.getElementById('sidebar');
        let isHovering = false;
        let lastSidebarWidth = sidebar.offsetWidth;

        if (coursDropdownBtn && coursDropdownMenu) {
            coursDropdownBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                coursDropdownMenu.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!coursDropdownBtn.contains(e.target) && !coursDropdownMenu.contains(e.target)) {
                    coursDropdownMenu.classList.add('hidden');
                }
            });

            // Monitor sidebar width changes
            setInterval(function() {
                var currentSidebarWidth = sidebar.offsetWidth;
                if (lastSidebarWidth > 85 && currentSidebarWidth <= 85) {
                    coursDropdownMenu.classList.add('hidden');
                }
                lastSidebarWidth = currentSidebarWidth;
            }, 100);
        }

        // Navigation pour les apprenants
        const apprenantsContainer = document.getElementById('apprenantsContainer');
        const prevApprenantsBtn = document.getElementById('prevApprenants');
        const nextApprenantsBtn = document.getElementById('nextApprenants');

        if (apprenantsContainer && prevApprenantsBtn && nextApprenantsBtn) {
            const scrollAmount = 280; // Largeur d'une carte + gap

            prevApprenantsBtn.addEventListener('click', () => {
                apprenantsContainer.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            });

            nextApprenantsBtn.addEventListener('click', () => {
                apprenantsContainer.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });

            // Désactiver les boutons si on est au début/fin
            const updateNavButtons = () => {
                const { scrollLeft, scrollWidth, clientWidth } = apprenantsContainer;
                prevApprenantsBtn.style.opacity = scrollLeft > 0 ? '1' : '0.5';
                prevApprenantsBtn.style.pointerEvents = scrollLeft > 0 ? 'auto' : 'none';
                nextApprenantsBtn.style.opacity = scrollLeft < scrollWidth - clientWidth - 10 ? '1' : '0.5';
                nextApprenantsBtn.style.pointerEvents = scrollLeft < scrollWidth - clientWidth - 10 ? 'auto' : 'none';
            };

            apprenantsContainer.addEventListener('scroll', updateNavButtons);
            updateNavButtons();
        }


        window.addEventListener('load', () => {
            document.querySelectorAll('.progress-fill').forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => bar.style.width = width, 300);
            });
        });
    </script>

    <!-- Support Modal -->
    <div id="supportModal" class="support-modal-overlay">
        <div class="support-modal">
            <div class="support-modal-header">
                <img src="{{ asset('assets/images/assistance.jpeg') }}" alt="Assistance">
                <button type="button" class="support-modal-close" id="supportModalClose">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="support-modal-content">
                <h2 class="support-modal-title">Besoin d'aide ?</h2>
                <p class="support-modal-subtitle">Contactez notre équipe de support via les canaux ci-dessous</p>
                
                <div class="support-contact-grid">
                    <a href="https://wa.me/221769719383" target="_blank" class="support-contact-card whatsapp">
                        <div class="support-contact-icon">
                            <img src="{{ asset('assets/images/WhatsApp.png') }}" alt="WhatsApp">
                        </div>
                        <div class="support-contact-label">WhatsApp</div>
                        <div class="support-contact-value">Chat direct</div>
                    </a>
                    
                    <a href="mailto:filybadji2020@gmail.com" class="support-contact-card gmail">
                        <div class="support-contact-icon">
                            <img src="{{ asset('assets/images/Gmail.png') }}" alt="Gmail">
                        </div>
                        <div class="support-contact-label">Gmail</div>
                        <div class="support-contact-value">Contactez-nous par email</div>
                    </a>
                    
                    <a href="#" class="support-contact-card instagram">
                        <div class="support-contact-icon">
                            <img src="{{ asset('assets/images/Instagram.png') }}" alt="Instagram">
                        </div>
                        <div class="support-contact-label">Instagram</div>
                        <div class="support-contact-value">Suivez-nous</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Support Modal - Initialisation après chargement du DOM
        document.addEventListener('DOMContentLoaded', function() {
            const supportBtn = document.getElementById('supportBtn');
            const supportModalClose = document.getElementById('supportModalClose');
            const supportModal = document.getElementById('supportModal');

            // Ouvrir le modal
            if (supportBtn) {
                supportBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (supportModal) {
                        supportModal.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    }
                });
            }

            // Fermer le modal avec le bouton X
            if (supportModalClose) {
                supportModalClose.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (supportModal) {
                        supportModal.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                    return false;
                });

                // Double sécurité avec onclick
                supportModalClose.onclick = function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (supportModal) {
                        supportModal.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                    return false;
                };
            }

            // Fermer en cliquant sur l'overlay
            if (supportModal) {
                supportModal.addEventListener('click', function(e) {
                    if (e.target === supportModal) {
                        supportModal.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });

                // Fermer avec Escape
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && supportModal.classList.contains('active')) {
                        supportModal.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });

                // Event delegation pour capturer tous les clics sur le bouton de fermeture
                document.addEventListener('click', function(e) {
                    if (e.target.closest('#supportModalClose') || e.target.closest('.support-modal-close')) {
                        e.preventDefault();
                        e.stopPropagation();
                        if (supportModal) {
                            supportModal.classList.remove('active');
                            document.body.style.overflow = '';
                        }
                    }
                }, true);
            }
        });
    </script>
    @include('components.video-session-notification')
</body>
</html>
