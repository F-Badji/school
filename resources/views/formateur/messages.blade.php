<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - BJ Academie</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
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
        input:focus {
            --tw-ring-color: #1a1f3a;
            border-color: #1a1f3a;
        }
        /* Cacher définitivement le badge unread-badge s'il affiche 0 */
        .unread-badge:empty,
        .unread-badge[style*="display: none"],
        .unread-badge:has-text("0") {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
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
        /* Call Interface Styles */
        .call-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #1a1f3a 0%, #161b33 100%);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .call-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .call-interface {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 2rem;
        }
        .call-profile-section {
            text-align: center;
            margin-bottom: 3rem;
        }
        .call-profile-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin: 0 auto 2rem;
            border: 6px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: white;
            font-weight: bold;
            overflow: hidden;
        }
        .call-profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .call-name {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }
        .call-status {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1rem;
        }
        .call-timer {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            font-variant-numeric: tabular-nums;
        }
        .call-controls {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            justify-content: center;
            margin-top: 3rem;
        }
        .call-btn {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .call-btn svg {
            width: 32px;
            height: 32px;
        }
        .call-btn-answer {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        .call-btn-answer:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        .call-btn-reject {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        .call-btn-reject:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
        .call-btn-end {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            width: 80px;
            height: 80px;
        }
        .call-btn-end:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
        .call-btn-mute,
        .call-btn-speaker,
        .call-btn-video {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
        }
        .call-btn-mute:hover,
        .call-btn-speaker:hover,
        .call-btn-video:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }
        .call-btn-mute.active,
        .call-btn-speaker.active,
        .call-btn-video.active {
            background: rgba(255, 255, 255, 0.4);
        }
        .call-ringing-animation {
            animation: pulse-ring 2s infinite;
        }
        @keyframes pulse-ring {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        .call-audio-visualizer {
            display: flex;
            gap: 4px;
            align-items: center;
            justify-content: center;
            margin-top: 1rem;
            height: 40px;
        }
        .audio-bar {
            width: 4px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 2px;
            animation: audio-wave 1s infinite;
        }
        .audio-bar:nth-child(1) { animation-delay: 0s; }
        .audio-bar:nth-child(2) { animation-delay: 0.1s; }
        .audio-bar:nth-child(3) { animation-delay: 0.2s; }
        .audio-bar:nth-child(4) { animation-delay: 0.3s; }
        .audio-bar:nth-child(5) { animation-delay: 0.4s; }
        @keyframes audio-wave {
            0%, 100% { height: 10px; }
            50% { height: 30px; }
        }
        .icon-crossed {
            position: relative;
        }
        .icon-crossed::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(45deg);
            width: 2px;
            height: 100%;
            background: #ef4444;
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
                        <a href="{{ route('formateur.cours') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg nav-link sidebar-text" style="transition: none !important; -webkit-transition: none !important;">
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
                <a href="#" id="parametresBtn" class="flex items-center gap-3 px-4 py-3 rounded-lg ">
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
        <div class="flex-1 flex flex-col overflow-hidden bg-white">
            <!-- Top Header -->
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <!-- Search -->
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <input type="text" placeholder="Rechercher" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Notifications & Profile -->
                    <div class="flex items-center gap-4">
                        @include('components.notification-icon-formateur')
                        <div class="relative">
                            <button id="profileDropdownBtn" class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 overflow-hidden border-2 border-white shadow-md cursor-pointer hover:ring-2 hover:ring-purple-300 transition-all focus:outline-none">
                                @if($user->photo ?? null)
                                    <img src="{{ asset('storage/' . ($user->photo ?? '')) }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1)) }}
                                    </div>
                                @endif
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50 hidden">
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
                                            <p class="text-sm font-semibold text-gray-900 truncate">
                                                {{ $user->name ?? ($user->prenom ?? '') . ' ' . ($user->nom ?? '') }}
                                            </p>
                                            <p class="text-xs text-gray-500 truncate">{{ $user->email ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-1">
                                    <a href="{{ route('formateur.profil') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>Profil</span>
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>Paramètres</span>
                                    </a>
                                    <hr class="my-1 border-gray-200">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            <span>Déconnexion</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-hidden bg-white">
                <div class="flex h-full">
                    <!-- Left Panel - Chat List -->
                    <div class="w-96 border-r border-gray-200 flex flex-col bg-white">
                        @php
                            // Calculer les conversations pour le compteur
                            $conversationsForCount = [];
                            if (isset($messages) && $messages) {
                                foreach($messages as $message) {
                                    $otherUserId = $message->sender_id == $user->id ? $message->receiver_id : $message->sender_id;
                                    if (!isset($conversationsForCount[$otherUserId])) {
                                        $conversationsForCount[$otherUserId] = ['unread_count' => 0];
                                    }
                                    if ($message->receiver_id == $user->id && !$message->read_at) {
                                        $conversationsForCount[$otherUserId]['unread_count']++;
                                    }
                                }
                            }
                            $totalUnread = array_sum(array_column($conversationsForCount, 'unread_count'));
                        @endphp
                        <!-- Chat Title and Messages Section -->
                        <div class="p-6 border-b border-gray-200">
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">Chat</h1>
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-bold text-gray-900">Messages</h2>
                                <div class="flex items-center gap-2">
                                    @if($totalUnread > 0)
                                        <span class="badge badge-md badge-circle badge-floating badge-danger border-white unread-badge">{{ $totalUnread }}</span>
                                    @endif
                                    <span class="text-sm text-gray-500 unread-text">{{ $totalUnread }} nouveaux messages</span>
                                </div>
                                <!-- S'assurer que le badge unread-badge n'apparaît jamais avec 0 -->
                                <style>
                                    .unread-badge:empty,
                                    .unread-badge[textContent="0"],
                                    .unread-badge:has-text("0") {
                                        display: none !important;
                                        visibility: hidden !important;
                                        opacity: 0 !important;
                                        position: absolute !important;
                                        left: -9999px !important;
                                    }
                                </style>
                            </div>
                            <!-- Search Bar -->
                            <div class="relative">
                                <input type="text" id="searchContacts" placeholder="Rechercher" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 text-sm" style="--tw-ring-color: #1a1f3a;">
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Chat List -->
                        <div class="flex-1 overflow-y-auto">
                            <div class="space-y-0" id="chatList">
                                @php
                                    $conversations = [];
                                    if (isset($messages) && $messages) {
                                        foreach($messages as $message) {
                                            $otherUserId = $message->sender_id == $user->id ? $message->receiver_id : $message->sender_id;
                                            if (!isset($conversations[$otherUserId])) {
                                                $otherUser = $message->sender_id == $user->id ? $message->receiver : $message->sender;
                                                $conversations[$otherUserId] = [
                                                    'user' => $otherUser,
                                                    'last_message' => $message,
                                                    'unread_count' => 0
                                                ];
                                            }
                                            if ($message->receiver_id == $user->id && !$message->read_at) {
                                                $conversations[$otherUserId]['unread_count']++;
                                            }
                                            if ($message->created_at > $conversations[$otherUserId]['last_message']->created_at) {
                                                $conversations[$otherUserId]['last_message'] = $message;
                                            }
                                        }
                                    }
                                    $activeChatId = request()->get('chat', null);
                                    $firstApprenant = ($apprenants ?? collect())->first();
                                    if (!$activeChatId && $firstApprenant) {
                                        $activeChatId = $firstApprenant->id;
                                    }
                                @endphp
                                @if(isset($forumGroups) && $forumGroups->count() > 0)
                                    @foreach($forumGroups as $group)
                                        @php
                                            $isActive = $activeChatId == 'group_' . $group->id;
                                            $memberCount = $group->users->count();
                                        @endphp
                                        <div class="p-4 cursor-pointer transition-colors chat-item group-item {{ $isActive ? 'active' : '' }}"
                                            data-group-id="{{ $group->id }}"
                                            data-group-name="{{ $group->name }}"
                                            data-group-description="{{ $group->description ?? '' }}"
                                            data-group-creator="{{ $group->created_by }}"
                                            data-group-restrict="{{ $group->restrict_messages ?? 0 }}"
                                            data-group-avatar="{{ $group->avatar ?? '' }}"
                                            style="{{ $isActive ? 'background-color: rgba(26, 31, 58, 0.1); border-left: 4px solid #1a1f3a;' : '' }} border-bottom: 1px solid #e5e7eb;"
                                            onmouseover="if(!this.classList.contains('active')) this.style.backgroundColor='rgba(0,0,0,0.02)'"
                                            onmouseout="if(!this.classList.contains('active')) this.style.backgroundColor=''"
                                            onclick="window.location.href='{{ route('formateur.messages') }}?chat=group_{{ $group->id }}'">
                                            <div class="flex items-center gap-3">
                                                <div class="relative flex-shrink-0">
                                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm overflow-hidden" style="{{ $group->avatar ? 'background-image: url(/storage/' . $group->avatar . '); background-size: cover; background-position: center;' : 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' }}">
                                                        @if(!$group->avatar)
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                        </svg>
                                                        @endif
                                                    </div>
                                                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-purple-500 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $memberCount }}</span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center justify-between mb-1">
                                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $group->name }}</p>
                                                        <span class="text-xs text-purple-600 font-medium">GROUPE</span>
                                                    </div>
                                                    <p class="text-xs text-gray-600 truncate mb-1">{{ $group->description ?? 'Groupe de discussion' }}</p>
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-xs text-gray-500">{{ $memberCount }} membre{{ $memberCount > 1 ? 's' : '' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                @forelse($apprenants ?? [] as $apprenant)
                                    @php
                                        $conversation = $conversations[$apprenant->id] ?? null;
                                        $lastMessage = $conversation['last_message'] ?? null;
                                        $unreadCount = $conversation['unread_count'] ?? 0;
                                        $isActive = $activeChatId == $apprenant->id;
                                        $initials = strtoupper(substr($apprenant->prenom ?? '', 0, 1) . substr($apprenant->nom ?? '', 0, 1));
                                        $apprenantName = ($apprenant->prenom ?? '') . ' ' . ($apprenant->nom ?? '');
                                        if (empty(trim($apprenantName))) {
                                            $apprenantName = $apprenant->name ?? 'Apprenant';
                                        }
                                        $timeAgo = $lastMessage ? \Carbon\Carbon::parse($lastMessage->created_at)->diffForHumans() : '';
                                        if ($timeAgo === 'il y a 1 seconde' || $timeAgo === '1 second ago') {
                                            $timeAgo = 'À l\'instant';
                                        }
                                    @endphp
                                    <div class="p-4 cursor-pointer transition-colors chat-item" 
                                         data-user-id="{{ $apprenant->id }}"
                                         style="{{ $isActive ? 'background-color: rgba(26, 31, 58, 0.1); border-left: 4px solid #1a1f3a;' : '' }}"
                                         onmouseover="if(!this.classList.contains('active')) this.style.backgroundColor='rgba(0,0,0,0.02)'" 
                                         onmouseout="if(!this.classList.contains('active')) this.style.backgroundColor=''">
                                    <div class="flex items-center gap-3">
                                        <div class="relative flex-shrink-0">
                                                @if($apprenant->photo ?? null)
                                                    <img src="{{ asset('storage/' . $apprenant->photo) }}" alt="{{ $apprenantName }}" class="w-12 h-12 rounded-full object-cover">
                                                @else
                                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                                        {{ $initials }}
                                            </div>
                                                @endif
                                                @php
                                                    $contactIsOnline = false;
                                                    if ($apprenant->last_seen ?? null) {
                                                        $contactLastSeen = \Carbon\Carbon::parse($apprenant->last_seen);
                                                        $contactIsOnline = $contactLastSeen->diffInMinutes(now()) < 5;
                                                    }
                                                @endphp
                                                <span class="absolute bottom-0 right-0 w-3 h-3 border-2 border-white rounded-full {{ $contactIsOnline ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-1">
                                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $apprenantName }}</p>
                                                    @if($timeAgo)
                                                        <span class="text-xs text-gray-500 whitespace-nowrap">{{ $timeAgo }}</span>
                                                    @endif
                                            </div>
                                                @if($lastMessage)
                                                    <p class="text-xs text-gray-600 truncate mb-1">{{ Str::limit($lastMessage->content, 40) }}</p>
                                                @else
                                                    <p class="text-xs text-gray-500 truncate mb-1">Aucun message</p>
                                                @endif
                                            <div class="flex items-center justify-end">
                                                    @if($lastMessage && $lastMessage->sender_id == $user->id)
                                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                    @elseif($unreadCount > 0)
                                                        <span class="badge badge-md badge-circle badge-floating badge-danger border-white">{{ $unreadCount }}</span>
                                                    @endif
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center">
                                        <p class="text-sm text-gray-500">Aucun apprenant disponible</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Right Panel - Active Chat -->
                    <div class="flex-1 flex flex-col bg-white" id="chatPanel">
                        @php
                            $activeGroup = null;
                            if ($activeChatId && strpos($activeChatId, 'group_') === 0) {
                                $groupId = str_replace('group_', '', $activeChatId);
                                $activeGroup = isset($forumGroups) ? $forumGroups->firstWhere('id', $groupId) : null;
                            }
                            $activeApprenant = !$activeGroup ? ($apprenants ?? collect())->firstWhere('id', $activeChatId) : null;
                            $activeMessages = collect();
                            if ($activeApprenant && isset($messages)) {
                                $activeMessages = $messages->filter(function($msg) use ($user, $activeChatId) {
                                    return ($msg->sender_id == $user->id && $msg->receiver_id == $activeChatId) ||
                                           ($msg->sender_id == $activeChatId && $msg->receiver_id == $user->id);
                                })->sortBy('created_at');
                            }
                        @endphp
                        @if($activeChatId && $activeGroup)
                            <!-- Group Chat Header -->
                            <div class="p-6 border-b border-gray-200" id="chatHeader">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="relative">
                                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm overflow-hidden" style="{{ $activeGroup->avatar ? 'background-image: url(/storage/' . $activeGroup->avatar . '); background-size: cover; background-position: center;' : 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' }}">
                                                @if(!$activeGroup->avatar)
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-base font-bold text-gray-900"><a href="#" class="hover:underline" onclick="event.preventDefault(); openGroupModal({{ $activeGroup->id }});">{{ $activeGroup->name }}</a></p>
                                            <p class="text-sm text-gray-500">{{ $activeGroup->users->count() }} membre{{ $activeGroup->users->count() > 1 ? 's' : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Group Messages Area -->
                            <div class="flex-1 overflow-y-auto p-6" id="messagesArea">
                                <div class="text-center py-12">
                                    <p class="text-sm text-gray-500">Les messages de groupe seront disponibles prochainement.</p>
                                </div>
                            </div>
                        @elseif($activeApprenant)
                        <!-- Chat Header -->
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        @if($activeApprenant->photo ?? null)
                                            <img src="{{ asset('storage/' . $activeApprenant->photo) }}" alt="{{ ($activeApprenant->prenom ?? '') . ' ' . ($activeApprenant->nom ?? '') }}" class="w-12 h-12 rounded-full object-cover">
                                        @else
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                                {{ strtoupper(substr($activeApprenant->prenom ?? '', 0, 1) . substr($activeApprenant->nom ?? '', 0, 1)) }}
                                        </div>
                                        @endif
                                        @php
                                            $activeIsOnline = false;
                                            if ($activeApprenant->last_seen ?? null) {
                                                $activeLastSeen = \Carbon\Carbon::parse($activeApprenant->last_seen);
                                                $activeIsOnline = $activeLastSeen->diffInMinutes(now()) < 5;
                                            }
                                        @endphp
                                        <span class="absolute bottom-0 right-0 w-3 h-3 border-2 border-white rounded-full {{ $activeIsOnline ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                    </div>
                                    <div>
                                        <p class="text-base font-bold text-gray-900">{{ ($activeApprenant->prenom ?? '') . ' ' . ($activeApprenant->nom ?? '') }}</p>
                                        @php
                                            $isOnline = false;
                                            $lastSeenText = 'Jamais en ligne';
                                            if ($activeApprenant->last_seen ?? null) {
                                                $lastSeen = \Carbon\Carbon::parse($activeApprenant->last_seen);
                                                $isOnline = $lastSeen->diffInMinutes(now()) < 5;
                                                if (!$isOnline) {
                                                    $lastSeenText = 'En ligne il y a ' . $lastSeen->diffForHumans();
                                                }
                                            }
                                        @endphp
                                        @if($isOnline)
                                        <p class="text-sm text-green-600 font-medium">En ligne</p>
                                        @else
                                            <p class="text-sm text-gray-500 font-medium">{{ $lastSeenText }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2 text-sm font-medium text-gray-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        Appeler
                                    </button>
                                    <button class="px-4 py-2 text-white rounded-lg transition-colors flex items-center gap-2 text-sm font-medium" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        Appel video
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Messages Area -->
                        <div class="flex-1 overflow-y-auto p-6 bg-gray-50" id="messagesArea">
                            <div class="space-y-4">
                                @forelse($activeMessages as $message)
                                    @php
                                        $isSender = $message->sender_id == $user->id;
                                        $otherUser = $isSender ? $message->receiver : $message->sender;
                                        $senderName = ($otherUser->prenom ?? '') . ' ' . ($otherUser->nom ?? '');
                                        if (empty(trim($senderName))) {
                                            $senderName = $otherUser->name ?? 'Contact';
                                        }
                                        $senderInitials = strtoupper(substr($otherUser->prenom ?? '', 0, 1) . substr($otherUser->nom ?? '', 0, 1));
                                        $messageDate = \Carbon\Carbon::parse($message->created_at);
                                        $timeFormat = $messageDate->locale('fr')->isoFormat('dddd HH:mm');
                                    @endphp
                                    @php
                                        $isSystemMessage = $message->label === 'System' || 
                                                         strpos($message->content, '📞❌') !== false || 
                                                         strpos($message->content, '📞✅') !== false ||
                                                         strpos($message->content, 'Appel manqué') !== false ||
                                                         strpos($message->content, 'Appel terminé') !== false;
                                    @endphp
                                    @if($isSystemMessage)
                                        <!-- System Message - Aligné à droite comme WhatsApp -->
                                        <div class="flex items-start gap-3 justify-end my-2" data-message-id="{{ $message->id }}">
                                            <div class="flex-1 flex justify-end">
                                                <div class="max-w-[70%]">
                                                    <div class="bg-gray-200 rounded-lg px-3 py-2 inline-block">
                                                        <p class="text-xs text-gray-600">{{ $message->content }}</p>
                                                    </div>
                                                    <p class="text-xs text-gray-400 mt-1 text-right">{{ $message->created_at->format('d/m/Y H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($isSender)
                                        <!-- Formateur's Message -->
                                        <div class="flex items-start gap-3 justify-end" data-message-id="{{ $message->id }}">
                                            <div class="flex-1 flex justify-end">
                                                <div class="max-w-[70%]">
                                                    <div class="text-white rounded-lg p-3" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                                        <p class="text-sm">{{ $message->content }}</p>
                                                    </div>
                                                    <p class="text-xs text-gray-500 mt-1 text-right">{{ $timeFormat }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Apprenant's Message -->
                                        <div class="flex items-start gap-3" data-message-id="{{ $message->id }}">
                                            <div class="flex-1">
                                                <div class="inline-block max-w-[70%]">
                                                <div class="bg-white rounded-lg p-3 border border-gray-200">
                                                    <p class="text-sm text-gray-700">{{ $message->content }}</p>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">{{ $timeFormat }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <div class="text-center py-12">
                                        <p class="text-sm text-gray-500">Aucun message dans cette conversation</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Message Input -->
                        <div class="p-6 border-t border-gray-200 bg-white relative">
                            <!-- Emoji Picker -->
                            <div id="emojiPicker" class="hidden absolute bottom-full left-0 mb-2 w-80 bg-white border border-gray-200 rounded-lg shadow-xl p-4" style="max-height: 300px; overflow-y: auto; z-index: 9999;">
                                <div class="grid grid-cols-8 gap-2">
                                        @php
                                            $emojis = [
                                                '😀', '😃', '😄', '😁', '😆', '😅', '🤣', '😂', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩', '😘', '😗', '😚', '😙', '😋', '😛', '😜', '🤪', '😝', '🤑', '🤗', '🤭', '🤫', '🤔', '🤐', '🤨', '😐', '😑', '😶', '😏', '😒', '🙄', '😬', '🤥', '😌', '😔', '😪', '🤤', '😴', '😷', '🤒', '🤕', '🤢', '🤮', '🤧', '🥵', '🥶', '😵', '🤯', '🤠', '🥳', '😎', '🤓', '🧐', '😕', '😟', '🙁', '😮', '😯', '😲', '😳', '🥺', '😦', '😧', '😨', '😰', '😥', '😢', '😭', '😱', '😖', '😣', '😞', '😓', '😩', '😫', '🥱', '😤', '😡', '😠', '🤬', '😈', '👿', '💀', '☠️', '💩', '🤡', '👹', '👺', '👻', '👽', '👾', '🤖',
                                                '😺', '😸', '😹', '😻', '😼', '😽', '🙀', '😿', '😾', '🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼', '🐨', '🐯', '🦁', '🐮', '🐷', '🐽', '🐸', '🐵', '🙈', '🙉', '🙊', '🐒', '🐔', '🐧', '🐦', '🐤', '🐣', '🐥', '🦆', '🦅', '🦉', '🦇', '🐺', '🐗', '🐴', '🦄', '🐝', '🐛', '🦋', '🐌', '🐞', '🐜', '🦟', '🦗', '🕷️', '🦂', '🐢', '🐍', '🦎', '🦖', '🦕', '🐙', '🦑', '🦐', '🦞', '🦀', '🐡', '🐠', '🐟', '🐬', '🐳', '🐋', '🦈', '🐊', '🐅', '🐆', '🦓', '🦍', '🦧', '🐘', '🦛', '🦏', '🐪', '🐫', '🦒', '🦘', '🦬', '🐃', '🐂', '🐄', '🐎', '🐖', '🐏', '🐑', '🦙', '🐐', '🦌', '🐕', '🐩', '🦮', '🐕‍🦺', '🐈', '🐓', '🦃', '🦤', '🦚', '🦜', '🦢', '🦩', '🕊️', '🐇', '🦝', '🦨', '🦡', '🦦', '🦥', '🐁', '🐀', '🐿️', '🦔',
                                                '❤️', '🧡', '💛', '💚', '💙', '💜', '🖤', '🤍', '🤎', '💔', '❣️', '💕', '💞', '💓', '💗', '💖', '💘', '💝', '💟',
                                                '👋', '🤚', '🖐️', '✋', '🖖', '👌', '🤌', '🤏', '✌️', '🤞', '🤟', '🤘', '🤙', '👈', '👉', '👆', '🖕', '👇', '☝️', '👍', '👎', '✊', '👊', '🤛', '🤜', '👏', '🙌', '👐', '🤲', '🤝', '🙏', '✍️', '💪', '🦾', '🦿', '🦵', '🦶', '👂', '🦻', '👃', '🧠', '🫀', '🫁', '🦷', '🦴', '👀', '👁️', '👅', '👄',
                                                '💋', '💌', '💍', '💎', '🔇', '🔈', '🔉', '🔊', '📢', '📣', '📯', '🔔', '🔕', '🎵', '🎶', '💿', '📀', '📱', '☎️', '📞', '📟', '📠', '🔋', '🔌', '💻', '🖥️', '🖨️', '⌨️', '🖱️', '🖲️', '🕹️', '🗜️', '💾', '📼', '📷', '📸', '📹', '🎥', '📽️', '🎞️', '📺', '📻', '🎙️', '🎚️', '🎛️', '⏱️', '⏲️', '⏰', '🕰️', '⌚', '📡', '💡', '🔦', '🕯️', '🪔', '🧯', '🛢️', '💸', '💵', '💴', '💶', '💷', '💰', '💳', '⚖️', '🛒', '🛍️', '🎁', '🎈', '🎉', '🎊', '🎀', '🎗️', '🏆', '🥇', '🥈', '🥉', '⚽', '🏀', '🏈', '⚾', '🎾', '🏐', '🏉', '🎱', '🏓', '🏸', '🥅', '🏒', '🏑', '🏏', '🥃', '🥤', '🧃', '🧉', '🧊', '🥢', '🍽️', '🍴', '🥄', '🔪', '🏺', '🌍', '🌎', '🌏', '🌐', '🗺️', '🧭', '🏔️', '⛰️', '🌋', '🗻', '🏕️', '🏖️', '🏜️', '🏝️', '🏞️', '🏟️', '🏛️', '🏗️', '🧱', '🏘️', '🏚️', '🏠', '🏡', '🏢', '🏣', '🏤', '🏥', '🏦', '🏨', '🏩', '🏪', '🏫', '🏬', '🏭', '🏯', '🏰', '💒', '🗼', '🗽', '⛪', '🕌', '🛕', '🕍', '⛩️', '🕋', '⛲', '⛺', '🌁', '🌃', '🏙️', '🌄', '🌅', '🌆', '🌇', '🌉', '♨️', '🎠', '🎡', '🎢', '💈', '🎪', '🚂', '🚃', '🚄', '🚅', '🚆', '🚇', '🚈', '🚉', '🚊', '🚝', '🚞', '🚋', '🚌', '🚍', '🚎', '🚐', '🚑', '🚒', '🚓', '🚔', '🚕', '🚖', '🚗', '🚘', '🚙', '🚚', '🚛', '🚜', '🏎️', '🏍️', '🛵', '🦽', '🦼', '🛴', '🚲', '🛺', '🚁', '🛸', '✈️', '🛩️', '🛫', '🛬', '🪂', '💺', '🚀', '🚤', '⛵', '🛥️', '🛳️', '⛴️', '🚢', '⚓', '⛽', '🚧', '🚦', '🚥', '🗿', '🛂', '🛃', '🛄', '🛅', '⚠️', '🚸', '⛔', '🚫', '🚳', '🚭', '🚯', '🚱', '🚷', '📵', '🔞', '☢️', '☣️', '⬆️', '↗️', '➡️', '↘️', '⬇️', '↙️', '⬅️', '↖️', '↕️', '↔️', '↩️', '↪️', '⤴️', '⤵️', '🔃', '🔄', '🔙', '🔚', '🔛', '🔜', '🔝'
                                            ];
                                        @endphp
                                    @foreach($emojis as $emoji)
                                        <button type="button" class="emoji-item text-2xl hover:bg-gray-100 rounded p-1 transition-colors" data-emoji="{{ $emoji }}">{{ $emoji }}</button>
                                    @endforeach
                                </div>
                            </div>
                            <form id="messageForm" class="flex items-center gap-3">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $activeApprenant->id ?? '' }}" id="receiverId">
                                <button type="button" id="emojiBtn" class="p-2 text-gray-400 hover:text-gray-600 transition-colors relative">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                                <button type="button" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                    </svg>
                                </button>
                                <input type="text" name="content" placeholder="Message" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 text-sm" style="--tw-ring-color: #1a1f3a;" required id="messageInput">
                                <button type="submit" class="p-3 text-white rounded-lg transition-colors" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        @else
                            <div class="flex-1 flex items-center justify-center">
                                <div class="text-center">
                                    <p class="text-sm text-gray-500">Sélectionnez un apprenant pour commencer une conversation</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Profile dropdown menu
        document.addEventListener('DOMContentLoaded', function() {
            const profileDropdownBtn = document.getElementById('profileDropdownBtn');
            const profileDropdownMenu = document.getElementById('profileDropdownMenu');

            if (profileDropdownBtn && profileDropdownMenu) {
                profileDropdownBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileDropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!profileDropdownBtn.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                        profileDropdownMenu.classList.add('hidden');
                    }
                });

                profileDropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
            
            // Supprimer définitivement tout badge "0" à côté de l'icône de profil
            function removeZeroBadgeNearProfile() {
                const profileBtn = document.getElementById('profileDropdownBtn');
                if (profileBtn && profileBtn.parentElement) {
                    // Chercher tous les badges dans le conteneur du bouton de profil
                    const profileContainer = profileBtn.parentElement;
                    const allBadges = profileContainer.querySelectorAll('.badge, [class*="badge"], span[class*="badge-danger"], span[class*="badge-circle"]');
                    allBadges.forEach(badge => {
                        const text = badge.textContent.trim();
                        if (text === '0' || text === '' || badge.textContent === '0') {
                            badge.style.display = 'none';
                            badge.style.visibility = 'hidden';
                            badge.style.opacity = '0';
                            badge.remove();
                        }
                    });
                }
            }
            
            // Exécuter immédiatement et après un court délai
            removeZeroBadgeNearProfile();
            setTimeout(removeZeroBadgeNearProfile, 100);
            setTimeout(removeZeroBadgeNearProfile, 500);
            setTimeout(removeZeroBadgeNearProfile, 1000);

            // Cours dropdown menu
            const coursDropdownBtn = document.getElementById('coursDropdownBtn');
            const coursDropdownMenu = document.getElementById('coursDropdownMenu');
            const sidebar = document.getElementById('sidebar');

            // S'assurer que le dropdown est fermé au chargement
            if (coursDropdownMenu) {
                coursDropdownMenu.classList.add('hidden');
            }

            if (coursDropdownBtn && coursDropdownMenu) {
                coursDropdownBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    coursDropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!coursDropdownBtn.contains(e.target) && !coursDropdownMenu.contains(e.target)) {
                        coursDropdownMenu.classList.add('hidden');
                    }
                });

                coursDropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });

                // Fermer le menu déroulant quand le sidebar se ferme (largeur réduite)
                if (sidebar) {
                    let lastSidebarWidth = sidebar.offsetWidth;
                    
                    // Vérifier périodiquement si le sidebar est fermé
                    setInterval(function() {
                        const currentSidebarWidth = sidebar.offsetWidth;
                        
                        // Si la largeur a changé et le sidebar est maintenant fermé (≤ 85px)
                        if (lastSidebarWidth > 85 && currentSidebarWidth <= 85) {
                            coursDropdownMenu.classList.add('hidden');
                        }
                        
                        lastSidebarWidth = currentSidebarWidth;
                    }, 100);
                }
            }

            // Gestion du chat
            const chatItems = document.querySelectorAll('.chat-item');
            const messageForm = document.getElementById('messageForm');
            const messageInput = document.getElementById('messageInput');
            const messagesArea = document.getElementById('messagesArea');
            const receiverIdInput = document.getElementById('receiverId');
            const searchContacts = document.getElementById('searchContacts');

            // Recherche de contacts
            if (searchContacts) {
                searchContacts.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    chatItems.forEach(item => {
                        const contactName = item.querySelector('.text-sm.font-semibold')?.textContent.toLowerCase() || '';
                        if (contactName.includes(searchTerm)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }

            // Gérer le clic sur un contact
            chatItems.forEach(item => {
                item.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    
                    // Mettre à jour l'état actif
                    chatItems.forEach(ci => {
                        ci.classList.remove('active');
                        ci.style.backgroundColor = '';
                        ci.style.borderLeft = '';
                    });
                    this.classList.add('active');
                    this.style.backgroundColor = 'rgba(26, 31, 58, 0.1)';
                    this.style.borderLeft = '4px solid #1a1f3a';
                    
                    // Charger les messages
                    // Sauvegarder l'onglet actif dans l'URL et localStorage
                    const currentUrl = new URL(window.location.href);
                    currentUrl.searchParams.set('chat', userId);
                    window.history.pushState({ chat: userId }, '', currentUrl.toString());
                    localStorage.setItem('activeChatId', userId);
                    
                    loadThread(userId);
                });
            });
            
            // Restaurer l'onglet actif au chargement de la page
            document.addEventListener('DOMContentLoaded', function() {
                // Vérifier d'abord l'URL, puis localStorage
                const urlParams = new URLSearchParams(window.location.search);
                let activeChatId = urlParams.get('chat');
                
                if (!activeChatId) {
                    activeChatId = localStorage.getItem('activeChatId');
                }
                
                if (activeChatId) {
                    // Attendre un peu pour que le DOM soit complètement chargé
                    setTimeout(function() {
                        const chatItem = document.querySelector(`.chat-item[data-user-id="${activeChatId}"]`);
                        if (chatItem) {
                            console.log('✅ [FORMATEUR] Restauration de l\'onglet actif:', activeChatId);
                            chatItem.click();
                        } else {
                            console.warn('⚠️ [FORMATEUR] Onglet actif non trouvé:', activeChatId);
                        }
                    }, 100);
                }
            });

            // Charger le thread de messages
            function loadThread(receiverId) {
                console.log('🔍 [DEBUG formateur] loadThread appelé pour receiverId:', receiverId);
                const baseUrl = '{{ url("/formateur/messages/thread") }}';
                const url = `${baseUrl}/${receiverId}`;
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('🔍 [DEBUG formateur] Réponse de loadThread:', data);
                    if (data.success) {
                        console.log('🔍 [DEBUG formateur] Nombre de messages reçus:', data.messages ? data.messages.length : 0);
                        // Vérifier les messages système dans la réponse
                        if (data.messages && data.messages.length > 0) {
                            const systemMsgs = data.messages.filter(m => m.label === 'System' || (m.content && (m.content.includes('📞❌') || m.content.includes('📞✅') || m.content.includes('Appel manqué') || m.content.includes('Appel terminé'))));
                            console.log('🔍 [DEBUG formateur] Messages système dans la réponse:', systemMsgs.length);
                            if (systemMsgs.length > 0) {
                                console.log('🔍 [DEBUG formateur] Détails des messages système:', systemMsgs.map(m => ({ id: m.id, label: m.label, content: m.content, sender_id: m.sender_id, receiver_id: m.receiver_id })));
                            }
                        }
                        receiverIdInput.value = receiverId;
                        displayMessages(data.messages, data.receiver);
                        
                        // Marquer les messages comme lus
                        markMessagesAsRead(receiverId);
                    } else {
                        alert(data.message || 'Erreur lors du chargement des messages');
                    }
                })
                .catch(error => {
                    console.error('❌ [DEBUG formateur] Erreur lors du chargement:', error);
                });
            }

            // Afficher les messages
            function displayMessages(messages, receiver) {
                // Mettre à jour le header du chat
                const chatHeader = document.querySelector('#chatPanel .p-6.border-b');
                if (chatHeader && receiver) {
                    const receiverName = (receiver.prenom || '') + ' ' + (receiver.nom || '');
                    const receiverInitials = ((receiver.prenom || '').charAt(0) + (receiver.nom || '').charAt(0)).toUpperCase();
                    
                    // Calculer le statut en ligne
                    let isOnline = false;
                    let statusText = 'Jamais en ligne';
                    let statusColor = 'text-gray-500';
                    let statusDotColor = 'bg-gray-400';
                    
                    if (receiver.last_seen) {
                        const lastSeen = new Date(receiver.last_seen);
                        const now = new Date();
                        const diffMinutes = Math.floor((now - lastSeen) / (1000 * 60));
                        isOnline = diffMinutes < 5;
                        
                        if (isOnline) {
                            statusText = 'En ligne';
                            statusColor = 'text-green-600';
                            statusDotColor = 'bg-green-500';
                        } else {
                            // Formater le temps de manière naturelle
                            const diffHours = Math.floor(diffMinutes / 60);
                            const diffDays = Math.floor(diffHours / 24);
                            const diffWeeks = Math.floor(diffDays / 7);
                            const diffMonths = Math.floor(diffDays / 30);
                            
                            if (diffMinutes < 60) {
                                statusText = `En ligne il y a ${diffMinutes} minute${diffMinutes > 1 ? 's' : ''}`;
                            } else if (diffHours < 24) {
                                statusText = `En ligne il y a ${diffHours} heure${diffHours > 1 ? 's' : ''}`;
                            } else if (diffDays < 7) {
                                statusText = `En ligne il y a ${diffDays} jour${diffDays > 1 ? 's' : ''}`;
                            } else if (diffWeeks < 4) {
                                statusText = `En ligne il y a ${diffWeeks} semaine${diffWeeks > 1 ? 's' : ''}`;
                            } else if (diffMonths < 12) {
                                statusText = `En ligne il y a ${diffMonths} mois`;
                            } else {
                                const diffYears = Math.floor(diffMonths / 12);
                                statusText = `En ligne il y a ${diffYears} an${diffYears > 1 ? 's' : ''}`;
                            }
                        }
                    }
                    
                    const headerContent = `
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    ${receiver.photo ? `<img src="/storage/${receiver.photo}" alt="${receiverName}" class="w-12 h-12 rounded-full object-cover">` : `<div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">${receiverInitials}</div>`}
                                    <span class="absolute bottom-0 right-0 w-3 h-3 ${statusDotColor} border-2 border-white rounded-full"></span>
                                </div>
                                <div>
                                    <p class="text-base font-bold text-gray-900">${receiverName}</p>
                                    <p class="text-sm ${statusColor} font-medium">${statusText}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2 text-sm font-medium text-gray-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    Appeler
                                </button>
                                <button class="px-4 py-2 text-white rounded-lg transition-colors flex items-center gap-2 text-sm font-medium" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Appel video
                                </button>
                            </div>
                        </div>
                    `;
                    chatHeader.innerHTML = headerContent;
                }

                const messagesContainer = messagesArea.querySelector('.space-y-4');
                if (messagesContainer) {
                    const currentUserId = {{ $user->id }};
                    
                    // SÉCURITÉ CRITIQUE : Filtrer les messages pour ne garder que ceux de cette conversation
                    // Un message doit être soit envoyé par l'utilisateur connecté au receiver, soit envoyé par le receiver à l'utilisateur connecté
                    // Cette vérification s'applique AUSSI aux messages système (Appel manqué, Appel terminé)
                    const filteredMessages = messages.filter(function(message) {
                        const isFromUser = message.sender_id == currentUserId && message.receiver_id == receiver.id;
                        const isToUser = message.sender_id == receiver.id && message.receiver_id == currentUserId;
                        
                        // SÉCURITÉ : Les messages système doivent aussi respecter cette règle stricte
                        const isSystemMessage = message.label === 'System' || 
                                              (message.content && (
                                                  message.content.includes('📞❌') || 
                                                  message.content.includes('📞✅') ||
                                                  message.content.includes('Appel manqué') ||
                                                  message.content.includes('Appel terminé')
                                              ));
                        
                        // Si c'est un message système, vérifier qu'il appartient bien à cette conversation
                        if (isSystemMessage) {
                            const systemMessageValid = isFromUser || isToUser;
                            if (!systemMessageValid) {
                                console.warn(`⚠️ [SÉCURITÉ formateur] Message système (ID: ${message.id}) filtré - n'appartient pas à cette conversation. sender_id: ${message.sender_id}, receiver_id: ${message.receiver_id}, currentUserId: ${currentUserId}, receiver.id: ${receiver.id}`);
                            }
                            return systemMessageValid;
                        }
                        
                        return isFromUser || isToUser;
                    });
                    
                    console.log('🔍 [DEBUG formateur] Messages reçus:', messages.length);
                    console.log('🔍 [DEBUG formateur] Messages filtrés pour receiver.id=' + receiver.id + ':', filteredMessages.length);
                    console.log('🔍 [DEBUG formateur] currentUserId:', currentUserId);
                    
                    // Vérifier les messages système dans les messages reçus
                    const systemMessagesInReceived = messages.filter(m => m.label === 'System' || (m.content && (m.content.includes('📞❌') || m.content.includes('📞✅') || m.content.includes('Appel manqué') || m.content.includes('Appel terminé'))));
                    console.log('🔍 [DEBUG formateur] Messages système dans messages reçus:', systemMessagesInReceived.length);
                    if (systemMessagesInReceived.length > 0) {
                        console.log('🔍 [DEBUG formateur] Détails des messages système reçus:', systemMessagesInReceived.map(m => ({ 
                            id: m.id, 
                            label: m.label, 
                            content: m.content, 
                            sender_id: m.sender_id, 
                            receiver_id: m.receiver_id,
                            created_at: m.created_at
                        })));
                    } else {
                        console.warn('⚠️ [DEBUG formateur] AUCUN message système trouvé dans les messages reçus!');
                        console.log('🔍 [DEBUG formateur] Tous les messages reçus:', messages.map(m => ({ 
                            id: m.id, 
                            label: m.label, 
                            content: m.content ? m.content.substring(0, 50) : 'null',
                            sender_id: m.sender_id, 
                            receiver_id: m.receiver_id 
                        })));
                    }
                    
                    // Vérifier les messages système dans les messages filtrés
                    const systemMessagesInFiltered = filteredMessages.filter(m => m.label === 'System' || (m.content && (m.content.includes('📞❌') || m.content.includes('📞✅') || m.content.includes('Appel manqué') || m.content.includes('Appel terminé'))));
                    console.log('🔍 [DEBUG formateur] Messages système dans messages filtrés:', systemMessagesInFiltered.length);
                    if (systemMessagesInFiltered.length > 0) {
                        console.log('🔍 [DEBUG formateur] Détails des messages système filtrés:', systemMessagesInFiltered.map(m => ({ 
                            id: m.id, 
                            label: m.label, 
                            content: m.content, 
                            sender_id: m.sender_id, 
                            receiver_id: m.receiver_id,
                            created_at: m.created_at
                        })));
                    } else {
                        console.warn('⚠️ [DEBUG formateur] AUCUN message système trouvé dans les messages filtrés!');
                        console.log('🔍 [DEBUG formateur] Tous les messages filtrés:', filteredMessages.map(m => ({ 
                            id: m.id, 
                            label: m.label, 
                            content: m.content ? m.content.substring(0, 50) : 'null',
                            sender_id: m.sender_id, 
                            receiver_id: m.receiver_id 
                        })));
                    }
                    
                    // Vider le conteneur avant d'afficher les nouveaux messages
                    messagesContainer.innerHTML = '';
                    
                    if (filteredMessages.length === 0) {
                        messagesContainer.innerHTML = '<div class="text-center py-12"><p class="text-sm text-gray-500">Aucun message dans cette conversation</p></div>';
                        return;
                    }
                    
                    filteredMessages.forEach(message => {
                        const isSender = message.sender_id == currentUserId;
                        const otherUser = isSender ? message.receiver : message.sender;
                        const senderName = (otherUser.prenom || '') + ' ' + (otherUser.nom || '');
                        const senderInitials = ((otherUser.prenom || '').charAt(0) + (otherUser.nom || '').charAt(0)).toUpperCase();
                        const messageDate = new Date(message.created_at);
                        // Format de date identique à l'apprenant : d/m/Y H:i
                        const day = String(messageDate.getDate()).padStart(2, '0');
                        const month = String(messageDate.getMonth() + 1).padStart(2, '0');
                        const year = messageDate.getFullYear();
                        const hours = String(messageDate.getHours()).padStart(2, '0');
                        const minutes = String(messageDate.getMinutes()).padStart(2, '0');
                        const timeFormat = `${day}/${month}/${year} ${hours}:${minutes}`;
                        
                        // Vérifier si c'est un message système
                        const isSystemMessage = message.label === 'System' || 
                                              (message.content && (
                                                  message.content.includes('📞❌') || 
                                                  message.content.includes('📞✅') ||
                                                  message.content.includes('Appel manqué') ||
                                                  message.content.includes('Appel terminé')
                                              ));
                        
                        // Log pour chaque message pour déboguer
                        if (message.content && (message.content.includes('📞❌') || message.content.includes('📞✅') || message.content.includes('Appel manqué') || message.content.includes('Appel terminé'))) {
                            console.log('🔍 [DEBUG formateur] Message avec contenu d\'appel détecté:', {
                                id: message.id,
                                label: message.label,
                                content: message.content,
                                sender_id: message.sender_id,
                                receiver_id: message.receiver_id,
                                isSystemMessage: isSystemMessage
                            });
                        }
                        
                        if (isSystemMessage) {
                            console.log('✅ [DEBUG formateur] Affichage d\'un message système:', { 
                                id: message.id, 
                                content: message.content, 
                                label: message.label,
                                sender_id: message.sender_id,
                                receiver_id: message.receiver_id,
                                created_at: message.created_at,
                                timeFormat: timeFormat
                            });
                            // Message système aligné à droite comme les messages envoyés (style WhatsApp)
                            const systemMessageHtml = `
                                <div class="flex items-start gap-3 justify-end my-2" data-message-id="${message.id}">
                                    <div class="flex-1 flex justify-end">
                                        <div class="max-w-[70%]">
                                            <div class="bg-gray-200 rounded-lg px-3 py-2 inline-block">
                                                <p class="text-xs text-gray-600">${escapeHtml(message.content)}</p>
                                            </div>
                                            <p class="text-xs text-gray-400 mt-1 text-right">${timeFormat}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                            messagesContainer.innerHTML += systemMessageHtml;
                            console.log('✅ [DEBUG formateur] Message système HTML ajouté au DOM:', message.id);
                        } else if (isSender) {
                            // Log pour les messages non-système pour déboguer
                            if (message.content && (message.content.includes('📞') || message.content.includes('Appel'))) {
                                console.warn('⚠️ [DEBUG formateur] Message avec contenu d\'appel mais non détecté comme système:', {
                                    id: message.id,
                                    label: message.label,
                                    content: message.content,
                                    isSystemMessage: isSystemMessage
                                });
                            }
                            messagesContainer.innerHTML += `
                                <div class="flex items-start gap-3 justify-end" data-message-id="${message.id}">
                                    <div class="flex-1 flex justify-end">
                                        <div class="max-w-[70%]">
                                            <div class="text-white rounded-lg p-3" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                                <p class="text-sm">${escapeHtml(message.content)}</p>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1 text-right">${timeFormat}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                        } else {
                            messagesContainer.innerHTML += `
                                <div class="flex items-start gap-3" data-message-id="${message.id}">
                                    <div class="flex-1">
                                        <div class="inline-block max-w-[70%]">
                                        <div class="bg-white rounded-lg p-3 border border-gray-200">
                                            <p class="text-sm text-gray-700">${escapeHtml(message.content)}</p>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">${timeFormat}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                    });
                    
                    // Log final pour vérifier combien de messages système ont été affichés
                    const displayedSystemMessages = messagesContainer.querySelectorAll('[data-message-id]');
                    const displayedSystemMessagesCount = Array.from(displayedSystemMessages).filter(el => {
                        const msgId = el.getAttribute('data-message-id');
                        const msg = filteredMessages.find(m => m.id == msgId);
                        return msg && (msg.label === 'System' || (msg.content && (msg.content.includes('📞❌') || msg.content.includes('📞✅') || msg.content.includes('Appel manqué') || msg.content.includes('Appel terminé'))));
                    }).length;
                    console.log('✅ [DEBUG formateur] Messages système affichés dans le DOM:', displayedSystemMessagesCount);
                    console.log('✅ [DEBUG formateur] Total messages affichés:', displayedSystemMessages.length);
                    
                    messagesArea.scrollTop = messagesArea.scrollHeight;
                } else {
                    console.error('❌ [DEBUG formateur] messagesContainer (.space-y-4) non trouvé dans messagesArea!');
                }
            }

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            // Envoyer un message
            if (messageForm) {
                messageForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const content = messageInput.value.trim();
                    const receiverId = receiverIdInput.value;
                    
                    if (!content || !receiverId) {
                        return;
                    }
                    
                    const formData = new FormData();
                    formData.append('content', content);
                    formData.append('receiver_id', receiverId);
                    formData.append('_token', '{{ csrf_token() }}');
                    
                    fetch('{{ route("formateur.messages.send") }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            messageInput.value = '';
                            loadThread(receiverId);
                        } else {
                            alert(data.message || 'Erreur lors de l\'envoi du message');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Erreur lors de l\'envoi du message');
                    });
                });
            }

            // Emoji picker functionality - délégation d'événements
            // Utiliser la délégation d'événements pour gérer les clics même après chargement dynamique
            document.addEventListener('click', function(e) {
                // Gérer le clic sur le bouton emoji
                if (e.target.closest('#emojiBtn') || e.target.closest('#emojiBtn svg') || e.target.closest('#emojiBtn path')) {
                    e.preventDefault();
                    e.stopPropagation();
                    const emojiBtn = document.getElementById('emojiBtn');
                    const emojiPicker = document.getElementById('emojiPicker');
                    if (emojiBtn && emojiPicker) {
                        const isHidden = emojiPicker.classList.contains('hidden');
                        if (isHidden) {
                            emojiPicker.classList.remove('hidden');
                        } else {
                            emojiPicker.classList.add('hidden');
                        }
                        return;
                    }
                }

                // Gérer le clic sur un emoji
                const emojiItem = e.target.closest('.emoji-item');
                if (emojiItem) {
                    e.preventDefault();
                    e.stopPropagation();
                    const emoji = emojiItem.getAttribute('data-emoji');
                    const messageInput = document.getElementById('messageInput');
                    const emojiPicker = document.getElementById('emojiPicker');
                    if (emoji && messageInput) {
                        const cursorPos = messageInput.selectionStart || messageInput.value.length;
                        const textBefore = messageInput.value.substring(0, cursorPos);
                        const textAfter = messageInput.value.substring(cursorPos);
                        messageInput.value = textBefore + emoji + textAfter;
                        messageInput.focus();
                        const newPos = cursorPos + emoji.length;
                        messageInput.setSelectionRange(newPos, newPos);
                        if (emojiPicker) {
                            emojiPicker.classList.add('hidden');
                        }
                    }
                    return;
                }

                // Fermer le sélecteur d'emojis si on clique ailleurs
                const emojiBtn = document.getElementById('emojiBtn');
                const emojiPicker = document.getElementById('emojiPicker');
                if (emojiBtn && emojiPicker && !emojiBtn.contains(e.target) && !emojiPicker.contains(e.target)) {
                    emojiPicker.classList.add('hidden');
                }
            });

            // Système de rafraîchissement automatique des messages
            let pollingInterval = null;

            function startMessagePolling() {
                // Arrêter le polling précédent s'il existe
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                }

                // Ne pas démarrer le polling si aucun contact n'est sélectionné
                if (!receiverIdInput || !receiverIdInput.value) {
                    return;
                }

                // Démarrer le polling toutes les 3 secondes
                pollingInterval = setInterval(function() {
                    if (!receiverIdInput || !receiverIdInput.value) {
                        clearInterval(pollingInterval);
                        return;
                    }

                    const receiverId = receiverIdInput.value;
                    loadThread(receiverId);
                }, 3000); // Vérifier toutes les 3 secondes
            }

            // Fonction pour marquer les messages comme lus
            function markMessagesAsRead(receiverId) {
                if (!receiverId) return;
                
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                             document.querySelector('input[name="_token"]')?.value;
                
                if (!token) {
                    console.error('Token CSRF non trouvé');
                    return;
                }
                
                fetch('{{ route("formateur.messages.mark-as-read") }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        receiver_id: receiverId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mettre à jour le compteur dans la sidebar
                        updateUnreadCount(data.total_unread);
                        
                        // Mettre à jour le compteur dans la liste des contacts
                        updateContactUnreadCount(receiverId, 0);
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du marquage des messages comme lus:', error);
                });
            }
            
            // Fonction pour mettre à jour le compteur de messages non lus dans la sidebar
            function updateUnreadCount(count) {
                // Mettre à jour le badge dans l'interface des messages
                const unreadBadge = document.querySelector('.unread-badge');
                const unreadText = document.querySelector('.unread-text');
                if (unreadBadge) {
                    if (count === 0) {
                        // Ne jamais afficher le badge si count est 0
                        unreadBadge.style.display = 'none';
                        unreadBadge.style.visibility = 'hidden';
                        unreadBadge.textContent = '';
                    } else {
                        unreadBadge.textContent = count;
                        unreadBadge.style.display = 'flex';
                        unreadBadge.style.visibility = 'visible';
                    }
                }
                if (unreadText) {
                    unreadText.textContent = count + ' nouveaux messages';
                }
                
                // Mettre à jour le badge dans la sidebar principale
                const sidebarBadge = document.querySelector('#sidebarUnreadBadge');
                if (sidebarBadge) {
                    if (count === 0) {
                        // Ne jamais afficher le badge si count est 0 - le supprimer complètement
                        sidebarBadge.style.display = 'none';
                        sidebarBadge.style.visibility = 'hidden';
                        sidebarBadge.style.opacity = '0';
                        sidebarBadge.textContent = '';
                        sidebarBadge.innerHTML = '';
                        // Supprimer le badge du DOM
                        try {
                            sidebarBadge.remove();
                        } catch(e) {
                            // Ignorer si déjà supprimé
                        }
                    } else {
                        sidebarBadge.textContent = count;
                        sidebarBadge.style.display = 'flex';
                        sidebarBadge.style.visibility = 'visible';
                        sidebarBadge.style.opacity = '1';
                    }
                } else if (count > 0) {
                    // Si le badge n'existe pas encore dans la sidebar, le créer SEULEMENT si count > 0
                    const sidebarLink = document.querySelector('a[href*="formateur.messages"]');
                    if (sidebarLink && !sidebarLink.querySelector('#sidebarUnreadBadge')) {
                        const badge = document.createElement('span');
                        badge.id = 'sidebarUnreadBadge';
                        badge.className = 'badge badge-md badge-circle badge-floating badge-danger border-white';
                        badge.textContent = count;
                        sidebarLink.appendChild(badge);
                    }
                }
                
                // S'assurer qu'aucun badge avec "0" n'apparaît à côté de l'icône de profil
                const profileBtn = document.getElementById('profileDropdownBtn');
                if (profileBtn) {
                    // Supprimer tous les badges à côté du bouton de profil
                    const badgesNearProfile = profileBtn.parentElement.querySelectorAll('.badge-danger, .badge-circle, .badge-floating');
                    badgesNearProfile.forEach(badge => {
                        if (badge.textContent === '0' || badge.textContent.trim() === '0') {
                            badge.remove();
                        }
                    });
                }
            }
            
            // Fonction pour mettre à jour le compteur de messages non lus d'un contact spécifique
            function updateContactUnreadCount(userId, count) {
                const contactItem = document.querySelector(`.chat-item[data-user-id="${userId}"]`);
                if (contactItem) {
                    // Chercher le badge de messages non lus existant
                    let unreadBadge = contactItem.querySelector('.flex.items-center.justify-end span[style*="background: linear-gradient"]');
                    
                    if (count > 0) {
                        if (!unreadBadge) {
                            // Créer le badge s'il n'existe pas
                            const flexContainer = contactItem.querySelector('.flex.items-center.justify-end');
                            if (flexContainer) {
                                unreadBadge = document.createElement('span');
                                unreadBadge.className = 'w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold text-white';
                                unreadBadge.style.background = 'linear-gradient(180deg, #1a1f3a 0%, #161b33 100%)';
                                flexContainer.appendChild(unreadBadge);
                            }
                        }
                        if (unreadBadge) {
                            unreadBadge.textContent = count;
                            unreadBadge.style.display = 'flex';
                        }
                    } else {
                        // Supprimer le badge si count est 0
                        if (unreadBadge) {
                            unreadBadge.remove();
                        }
                        // Afficher la coche verte si le message a été lu
                        const flexContainer = contactItem.querySelector('.flex.items-center.justify-end');
                        if (flexContainer && !flexContainer.querySelector('svg')) {
                            const checkIcon = document.createElement('svg');
                            checkIcon.className = 'w-4 h-4 text-green-500';
                            checkIcon.setAttribute('fill', 'currentColor');
                            checkIcon.setAttribute('viewBox', '0 0 20 20');
                            checkIcon.innerHTML = '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>';
                            flexContainer.appendChild(checkIcon);
                        }
                    }
                }
            }
            
            function stopMessagePolling() {
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                    pollingInterval = null;
                }
            }

            // Démarrer le polling quand un contact est sélectionné
            if (receiverIdInput && receiverIdInput.value) {
                startMessagePolling();
            }

            // Redémarrer le polling quand on change de contact
            chatItems.forEach(item => {
                item.addEventListener('click', function() {
                    stopMessagePolling();
                    setTimeout(() => {
                        startMessagePolling();
                    }, 1000);
                });
            });

            // Arrêter le polling quand on quitte la page
            window.addEventListener('beforeunload', function() {
                stopMessagePolling();
            });

            // Support Modal - Initialisation après chargement du DOM
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

    <!-- Call Interface Modal -->
    <div id="callModal" class="call-modal-overlay">
        <div class="call-interface">
            <!-- Profile Section -->
            <div class="call-profile-section">
                <div class="call-profile-image" id="callProfileImage">
                    <span id="callProfileInitials"></span>
                </div>
                <h2 class="call-name" id="callName">Nom de l'appelant</h2>
                <p class="call-status" id="callStatus">Appel en cours...</p>
                <div class="call-timer" id="callTimer" style="display: none;">00:00</div>
                <div class="call-audio-visualizer" id="audioVisualizer" style="display: none;">
                    <div class="audio-bar"></div>
                    <div class="audio-bar"></div>
                    <div class="audio-bar"></div>
                    <div class="audio-bar"></div>
                    <div class="audio-bar"></div>
                </div>
            </div>

            <!-- Call Controls -->
            <div class="call-controls">
                <!-- Mute Button -->
                <button id="muteBtn" class="call-btn call-btn-mute" title="Microphone">
                    <svg id="muteIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: block;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                    </svg>
                    <svg id="muteIconOff" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6" style="stroke: #ef4444;"></path>
                    </svg>
                </button>

                <!-- Speaker Button -->
                <button id="speakerBtn" class="call-btn call-btn-speaker" title="Haut-parleur">
                    <svg id="speakerIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: block;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                    </svg>
                    <svg id="speakerIconOff" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6" style="stroke: #ef4444;"></path>
                    </svg>
                </button>

                <!-- Answer Button (only visible when receiving call) -->
                <button id="answerBtn" class="call-btn call-btn-answer" title="Décrocher" style="display: none;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </button>

                <!-- Reject Button (only visible when receiving call) -->
                <button id="rejectBtn" class="call-btn call-btn-reject" title="Rejeter" style="display: none;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- End Call Button (visible during active call) -->
                <button id="endCallBtn" class="call-btn call-btn-end" title="Raccrocher" style="display: none;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Audio Element -->
            <audio id="remoteAudio" autoplay style="display: none;"></audio>
        </div>
    </div>

    <!-- Socket.io and WebRTC Scripts -->
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
    <script>
        // WebRTC Call Manager pour formateurs
        class CallManager {
            constructor() {
                this.socket = null;
                this.localStream = null;
                this.remoteStream = null;
                this.peerConnection = null;
                this.currentCall = null;
                this.callTimer = null;
                this.callStartTime = null;
                this.missedCallTimeout = null;
                this.isMuted = false;
                this.isSpeakerOn = false;
                this.userId = {{ auth()->id() }};
                this.userName = '{{ auth()->user()->prenom ?? "" }} {{ auth()->user()->nom ?? "" }}';
                this.userPhoto = '{{ auth()->user()->photo ?? null }}';
                
                this.init();
            }

            init() {
                // Initialize Socket.io
                try {
                    this.socket = io('http://localhost:6001', {
                        transports: ['websocket', 'polling'],
                        reconnection: true,
                        reconnectionDelay: 1000,
                        reconnectionAttempts: 5
                    });

                    this.socket.on('connect', () => {
                        console.log('✅ [FORMATEUR] Socket.io connecté, ID:', this.socket.id);
                        console.log('✅ [FORMATEUR] Envoi de user-connected avec userId:', this.userId);
                        this.socket.emit('user-connected', { userId: this.userId });
                    });

                    this.socket.on('disconnect', () => {
                        console.log('Socket.io disconnected');
                    });

                    // Listen for incoming calls
                    this.socket.on('incoming-call', (data) => {
                        console.log('📞 [FORMATEUR] Appel entrant reçu via Socket.io:', data);
                        this.handleIncomingCall(data);
                    });

                    // Listen for call accepted
                    this.socket.on('call-accepted', (data) => {
                        this.handleCallAccepted(data);
                    });

                    // Listen for call rejected
                    this.socket.on('call-rejected', (data) => {
                        this.handleCallRejected(data);
                    });

                    // Listen for call ended
                    this.socket.on('call-ended', (data) => {
                        this.handleCallEnded(data);
                    });

                    // Listen for ICE candidates
                    this.socket.on('ice-candidate', async (data) => {
                        await this.handleIceCandidate(data);
                    });

                    // Listen for offer
                    this.socket.on('offer', async (data) => {
                        await this.handleOffer(data);
                    });

                    // Listen for answer
                    this.socket.on('answer', async (data) => {
                        await this.handleAnswer(data);
                    });
                } catch (error) {
                    console.error('Socket.io connection error:', error);
                }

                // Setup UI event listeners
                this.setupEventListeners();
            }

            setupEventListeners() {
                // Call button - Formateur interface
                document.addEventListener('click', (e) => {
                    const callBtn = e.target.closest('button');
                    if (callBtn && callBtn.textContent.includes('Appeler')) {
                        // Récupérer l'ID depuis le champ receiverId
                        const receiverIdInput = document.getElementById('receiverId');
                        if (receiverIdInput && receiverIdInput.value) {
                            const userId = receiverIdInput.value;
                            
                            // Récupérer le nom et la photo depuis le header du chat
                            const chatHeader = document.querySelector('#chatHeader') || 
                                             callBtn.closest('.p-6.border-b') ||
                                             callBtn.closest('.flex.items-center.justify-between')?.closest('.p-6');
                            
                            let userName = 'Contact';
                            let userPhoto = null;
                            
                            if (chatHeader) {
                                // Chercher le nom dans le header
                                const nameElement = chatHeader.querySelector('p.text-base.font-bold') || 
                                                   chatHeader.querySelector('p.font-bold');
                                if (nameElement) {
                                    userName = nameElement.textContent.trim();
                                }
                                
                                // Chercher la photo dans le header
                                const photoElement = chatHeader.querySelector('img');
                                if (photoElement && photoElement.src) {
                                    // Extraire le chemin de la photo depuis l'URL complète
                                    const photoSrc = photoElement.src;
                                    if (photoSrc.includes('/storage/')) {
                                        userPhoto = photoSrc.split('/storage/')[1];
                                    } else if (photoSrc.includes('storage/')) {
                                        userPhoto = photoSrc.split('storage/')[1];
                                    } else {
                                        userPhoto = photoSrc;
                                    }
                                }
                            }
                            
                            if (userId) {
                                console.log('Initiation d\'appel pour:', userId, userName, userPhoto);
                                this.initiateCall(userId, userName, userPhoto);
                            } else {
                                console.error('Aucun receiverId trouvé');
                                alert('Veuillez sélectionner un contact pour passer un appel.');
                            }
                        } else {
                            // Fallback: essayer de trouver depuis un élément parent avec data-user-id
                            const contactItem = callBtn.closest('[data-user-id]');
                            if (contactItem) {
                                const userId = contactItem.getAttribute('data-user-id');
                                const userName = contactItem.querySelector('p')?.textContent || 'Contact';
                                const photoElement = contactItem.querySelector('img');
                                let userPhoto = null;
                                if (photoElement && photoElement.src) {
                                    const photoSrc = photoElement.src;
                                    if (photoSrc.includes('/storage/')) {
                                        userPhoto = photoSrc.split('/storage/')[1];
                                    } else if (photoSrc.includes('storage/')) {
                                        userPhoto = photoSrc.split('storage/')[1];
                                    }
                                }
                                if (userId) {
                                    this.initiateCall(userId, userName, userPhoto);
                                }
                            } else {
                                alert('Veuillez sélectionner un contact pour passer un appel.');
                            }
                        }
                    }
                });

                // Answer button
                document.getElementById('answerBtn')?.addEventListener('click', () => {
                    this.answerCall();
                });

                // Reject button
                document.getElementById('rejectBtn')?.addEventListener('click', () => {
                    this.rejectCall();
                });

                // End call button
                document.getElementById('endCallBtn')?.addEventListener('click', () => {
                    this.endCall(true);
                });

                // Mute button
                document.getElementById('muteBtn')?.addEventListener('click', () => {
                    this.toggleMute();
                });

                // Speaker button
                document.getElementById('speakerBtn')?.addEventListener('click', () => {
                    this.toggleSpeaker();
                });
            }

            async initiateCall(receiverId, receiverName, receiverPhoto) {
                try {
                    this.localStream = await navigator.mediaDevices.getUserMedia({ 
                        audio: true, 
                        video: false 
                    });

                    this.peerConnection = this.createPeerConnection();

                    this.localStream.getAudioTracks().forEach(track => {
                        this.peerConnection.addTrack(track, this.localStream);
                    });

                    const offer = await this.peerConnection.createOffer();
                    await this.peerConnection.setLocalDescription(offer);

                    this.currentCall = {
                        receiverId: receiverId,
                        receiverName: receiverName,
                        receiverPhoto: receiverPhoto,
                        isIncoming: false,
                        startedAt: new Date().toISOString(),
                        callStartTime: null
                    };

                    this.showCallInterface(receiverName, receiverPhoto, 'Appel en cours...', false);
                    this.playDialTone();

                    if (this.socket && this.socket.connected) {
                        this.socket.emit('call-user', {
                            to: receiverId,
                            offer: offer,
                            callerName: this.userName,
                            callerPhoto: this.userPhoto
                        });
                    }
                } catch (error) {
                    console.error('Error initiating call:', error);
                    alert('Impossible de démarrer l\'appel. Vérifiez vos permissions de microphone.');
                    this.actuallyEndCall();
                }
            }

            handleIncomingCall(data) {
                console.log('📞 [FORMATEUR] handleIncomingCall appelé avec:', data);
                
                this.currentCall = {
                    callerId: data.from,
                    callerName: data.callerName,
                    callerPhoto: data.callerPhoto,
                    offer: data.offer,
                    isIncoming: true,
                    startedAt: new Date().toISOString(),
                    callStartTime: null
                };

                console.log('📞 [FORMATEUR] Affichage de l\'interface d\'appel pour:', data.callerName);
                this.showCallInterface(
                    data.callerName, 
                    data.callerPhoto, 
                    'Appel entrant...', 
                    true
                );

                console.log('📞 [FORMATEUR] Lecture de la sonnerie');
                this.playRingtone();
                
                this.missedCallTimeout = setTimeout(() => {
                    if (this.currentCall && this.currentCall.isIncoming && !this.callStartTime) {
                        this.showCallEndedMessage('Appel manqué');
                        if (this.socket && this.socket.connected) {
                            this.socket.emit('call-missed', { to: this.currentCall.callerId });
                        }
                        setTimeout(() => {
                            this.endCall();
                        }, 2000);
                    }
                }, 30000);
            }

            async answerCall() {
                try {
                    if (!this.currentCall || !this.currentCall.offer) {
                        console.error('No incoming call to answer');
                        return;
                    }

                    this.localStream = await navigator.mediaDevices.getUserMedia({ 
                        audio: true, 
                        video: false 
                    });

                    this.peerConnection = this.createPeerConnection();

                    this.localStream.getAudioTracks().forEach(track => {
                        this.peerConnection.addTrack(track, this.localStream);
                    });

                    await this.peerConnection.setRemoteDescription(
                        new RTCSessionDescription(this.currentCall.offer)
                    );

                    const answer = await this.peerConnection.createAnswer();
                    await this.peerConnection.setLocalDescription(answer);

                    if (this.socket && this.socket.connected) {
                        this.socket.emit('call-accepted', {
                            to: this.currentCall.callerId,
                            answer: answer
                        });
                    }

                    if (this.currentCall) {
                        this.currentCall.callStartTime = Date.now();
                    }

                    this.stopRingtone();

                    this.showCallInterface(
                        this.currentCall.callerName,
                        this.currentCall.callerPhoto,
                        'En communication...',
                        false
                    );
                    this.startCallTimer();

                } catch (error) {
                    console.error('Error answering call:', error);
                    alert('Impossible de répondre à l\'appel.');
                    this.actuallyEndCall();
                }
            }

            rejectCall() {
                console.log('🔍 [DEBUG formateur] rejectCall appelé:', { currentCall: this.currentCall });
                this.stopRingtone();
                
                if (this.currentCall && this.currentCall.isIncoming) {
                    if (this.socket && this.socket.connected) {
                        this.socket.emit('call-rejected', {
                            to: this.currentCall.callerId
                        });
                    }
                    this.currentCall.status = 'rejected';
                }
                console.log('🔍 [DEBUG formateur] rejectCall: appel de showCallEndedMessage avec "Appel manqué"');
                this.showCallEndedMessage('Appel manqué');
                setTimeout(() => {
                    this.actuallyEndCall();
                }, 2000);
            }

            async handleCallAccepted(data) {
                this.stopDialTone();

                await this.peerConnection.setRemoteDescription(
                    new RTCSessionDescription(data.answer)
                );

                if (this.currentCall) {
                    this.currentCall.callStartTime = Date.now();
                }

                this.showCallInterface(
                    this.currentCall.receiverName,
                    this.currentCall.receiverPhoto,
                    'En communication...',
                    false
                );
                this.startCallTimer();
            }

            handleCallRejected(data) {
                console.log('🔍 [DEBUG formateur] handleCallRejected appelé:', data);
                console.log('🔍 [DEBUG formateur] handleCallRejected: appel de showCallEndedMessage avec "Appel manqué"');
                this.showCallEndedMessage('Appel manqué');
                setTimeout(() => {
                    this.endCall();
                }, 2000);
            }

            handleCallEnded(data) {
                console.log('🔍 [DEBUG formateur] handleCallEnded appelé:', data);
                const wasAnswered = this.currentCall?.callStartTime !== null || data?.wasAnswered === true;
                const message = wasAnswered ? 'Appel terminé' : 'Appel manqué';
                console.log('🔍 [DEBUG formateur] handleCallEnded: appel de showCallEndedMessage avec:', message);
                this.showCallEndedMessage(message);
                setTimeout(() => {
                    this.actuallyEndCall();
                }, 2000);
            }

            endCall(showMessage = false) {
                console.log('🔍 [DEBUG formateur] endCall appelé:', { showMessage, currentCall: this.currentCall });
                this.stopRingtone();
                this.stopDialTone();
                
                if (showMessage && this.currentCall) {
                    const wasAnswered = this.currentCall?.callStartTime !== null;
                    const message = wasAnswered ? 'Appel terminé' : 'Appel manqué';
                    console.log('🔍 [DEBUG formateur] endCall: showMessage=true, appel de showCallEndedMessage avec:', message);
                    this.showCallEndedMessage(message);
                    
                    if (this.socket && this.socket.connected) {
                        if (this.currentCall.isIncoming) {
                            this.socket.emit('call-ended', { 
                                to: this.currentCall.callerId,
                                wasAnswered: wasAnswered
                            });
                        } else {
                            this.socket.emit('call-ended', { 
                                to: this.currentCall.receiverId,
                                wasAnswered: wasAnswered
                            });
                        }
                    }
                    
                    setTimeout(() => {
                        this.actuallyEndCall();
                    }, 2000);
                    return;
                }

                if (this.currentCall && this.socket && this.socket.connected) {
                    const wasAnswered = this.currentCall?.callStartTime !== null;
                    if (this.currentCall.isIncoming) {
                        this.socket.emit('call-ended', { 
                            to: this.currentCall.callerId,
                            wasAnswered: wasAnswered
                        });
                    } else {
                        this.socket.emit('call-ended', { 
                            to: this.currentCall.receiverId,
                            wasAnswered: wasAnswered
                        });
                    }
                }

                this.actuallyEndCall();
            }

            actuallyEndCall() {
                this.saveCallToDatabase();

                if (this.missedCallTimeout) {
                    clearTimeout(this.missedCallTimeout);
                    this.missedCallTimeout = null;
                }

                if (this.localStream) {
                    this.localStream.getTracks().forEach(track => track.stop());
                    this.localStream = null;
                }

                if (this.peerConnection) {
                    this.peerConnection.close();
                    this.peerConnection = null;
                }

                this.stopCallTimer();

                this.stopRingtone();
                this.stopDialTone();

                this.isMuted = false;
                this.isSpeakerOn = false;
                this.updateMuteIcon(false);
                this.updateSpeakerIcon(false);

                this.hideCallInterface();
                this.currentCall = null;
            }

            saveCallToDatabase() {
                if (!this.currentCall) return;

                let callerId, receiverId, status, wasAnswered;
                
                if (this.currentCall.isIncoming) {
                    callerId = this.currentCall.callerId;
                    receiverId = this.userId;
                } else {
                    callerId = this.userId;
                    receiverId = this.currentCall.receiverId;
                }

                wasAnswered = this.currentCall.callStartTime !== null;
                
                if (this.currentCall.status === 'rejected') {
                    status = 'rejected';
                } else if (!wasAnswered) {
                    status = 'missed';
                } else {
                    status = 'ended';
                }

                let duration = null;
                let endedAt = new Date().toISOString();
                
                if (wasAnswered && this.currentCall.callStartTime) {
                    duration = Math.floor((Date.now() - this.currentCall.callStartTime) / 1000);
                }

                const startedAt = this.currentCall.startedAt || new Date().toISOString();

                const formData = new FormData();
                formData.append('receiver_id', receiverId);
                formData.append('started_at', startedAt);
                formData.append('ended_at', endedAt);
                formData.append('duration', duration || 0);
                formData.append('status', status);
                formData.append('was_answered', wasAnswered ? 1 : 0);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');

                fetch('{{ route("formateur.calls.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Appel enregistré avec succès:', data.call);
                    } else {
                        console.error('Erreur lors de l\'enregistrement de l\'appel:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de l\'enregistrement de l\'appel:', error);
                });
            }

            createPeerConnection() {
                const configuration = {
                    iceServers: [
                        { urls: 'stun:stun.l.google.com:19302' },
                        { urls: 'stun:stun1.l.google.com:19302' }
                    ]
                };
                const pc = new RTCPeerConnection(configuration);

                pc.onicecandidate = (event) => {
                    if (event.candidate) {
                        const targetId = this.currentCall?.isIncoming 
                            ? this.currentCall.callerId 
                            : this.currentCall?.receiverId;
                        if (targetId && this.socket && this.socket.connected) {
                            this.socket.emit('ice-candidate', {
                                to: targetId,
                                candidate: event.candidate
                            });
                        }
                    }
                };

                pc.ontrack = (event) => {
                    this.remoteStream = event.streams[0];
                    const remoteAudio = document.getElementById('remoteAudio');
                    if (remoteAudio) {
                        remoteAudio.srcObject = this.remoteStream;
                        remoteAudio.volume = this.isSpeakerOn ? 1.0 : 0;
                    }
                };

                return pc;
            }

            async handleIceCandidate(data) {
                if (this.peerConnection && data.candidate) {
                    await this.peerConnection.addIceCandidate(
                        new RTCIceCandidate(data.candidate)
                    );
                }
            }

            async handleOffer(data) {
                // Handled in handleIncomingCall
            }

            async handleAnswer(data) {
                // Handled in handleCallAccepted
            }

            showCallInterface(name, photo, status, isIncoming) {
                const modal = document.getElementById('callModal');
                const callName = document.getElementById('callName');
                const callStatus = document.getElementById('callStatus');
                const callProfileImage = document.getElementById('callProfileImage');
                const callProfileInitials = document.getElementById('callProfileInitials');
                const callTimer = document.getElementById('callTimer');
                const audioVisualizer = document.getElementById('audioVisualizer');
                const answerBtn = document.getElementById('answerBtn');
                const rejectBtn = document.getElementById('rejectBtn');
                const endCallBtn = document.getElementById('endCallBtn');
                const muteBtn = document.getElementById('muteBtn');
                const speakerBtn = document.getElementById('speakerBtn');

                if (callName) callName.textContent = name;
                if (callStatus) {
                    callStatus.textContent = status;
                    callStatus.style.color = 'rgba(255, 255, 255, 0.8)';
                    callStatus.style.fontWeight = '400';
                }

                // Set profile image
                if (photo && photo.trim() !== '' && photo !== 'null') {
                    let photoPath = photo;
                    if (!photo.startsWith('http') && !photo.startsWith('/')) {
                        photoPath = `/storage/${photo}`;
                    } else if (photo.startsWith('storage/')) {
                        photoPath = `/${photo}`;
                    }
                    if (callProfileInitials) callProfileInitials.textContent = '';
                    const initials = this.getInitials(name);
                    callProfileImage.innerHTML = `<img src="${photoPath}" alt="${this.escapeHtml(name)}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.style.display='none'; if(document.getElementById('callProfileInitials')) document.getElementById('callProfileInitials').textContent='${initials}';">`;
                } else {
                    const initials = this.getInitials(name);
                    if (callProfileInitials) callProfileInitials.textContent = initials;
                    if (callProfileImage) {
                        const img = callProfileImage.querySelector('img');
                        if (img) img.remove();
                    }
                }

                if (modal) modal.classList.add('active');
                document.body.style.overflow = 'hidden';

                if (isIncoming) {
                    if (answerBtn) answerBtn.style.display = 'flex';
                    if (rejectBtn) rejectBtn.style.display = 'flex';
                    if (endCallBtn) endCallBtn.style.display = 'none';
                    if (muteBtn) muteBtn.style.display = 'none';
                    if (speakerBtn) speakerBtn.style.display = 'none';
                    if (callProfileImage) callProfileImage.classList.add('call-ringing-animation');
                } else {
                    if (answerBtn) answerBtn.style.display = 'none';
                    if (rejectBtn) rejectBtn.style.display = 'none';
                    if (endCallBtn) endCallBtn.style.display = 'flex';
                    if (muteBtn) muteBtn.style.display = 'flex';
                    if (speakerBtn) speakerBtn.style.display = 'flex';
                    if (callProfileImage) callProfileImage.classList.remove('call-ringing-animation');
                }
            }

            hideCallInterface() {
                const modal = document.getElementById('callModal');
                if (modal) modal.classList.remove('active');
                document.body.style.overflow = '';
            }

            showCallEndedMessage(message) {
                console.log('🔍 [DEBUG formateur] showCallEndedMessage appelé:', { message, currentCall: this.currentCall });
                const callStatus = document.getElementById('callStatus');
                const callTimer = document.getElementById('callTimer');
                const audioVisualizer = document.getElementById('audioVisualizer');
                
                if (callStatus) {
                    callStatus.textContent = message;
                    callStatus.style.color = message === 'Appel manqué' ? '#ef4444' : '#6b7280';
                    callStatus.style.fontWeight = '600';
                }
                
                if (callTimer) {
                    callTimer.style.display = 'none';
                }
                
                if (audioVisualizer) {
                    audioVisualizer.style.display = 'none';
                }

                console.log('🔍 [DEBUG formateur] Appel de sendSystemMessage depuis showCallEndedMessage');
                this.sendSystemMessage(message);
                
                const answerBtn = document.getElementById('answerBtn');
                const rejectBtn = document.getElementById('rejectBtn');
                const endCallBtn = document.getElementById('endCallBtn');
                const muteBtn = document.getElementById('muteBtn');
                const speakerBtn = document.getElementById('speakerBtn');
                
                if (answerBtn) answerBtn.style.display = 'none';
                if (rejectBtn) rejectBtn.style.display = 'none';
                if (endCallBtn) endCallBtn.style.display = 'flex';
                if (muteBtn) muteBtn.style.display = 'none';
                if (speakerBtn) speakerBtn.style.display = 'none';
            }

            startCallTimer() {
                this.callStartTime = Date.now();
                const timerElement = document.getElementById('callTimer');
                if (timerElement) {
                    timerElement.style.display = 'block';
                    timerElement.textContent = '00:00';
                }

                this.callTimer = setInterval(() => {
                    if (this.callStartTime && timerElement) {
                        const elapsed = Math.floor((Date.now() - this.callStartTime) / 1000);
                        const minutes = Math.floor(elapsed / 60);
                        const seconds = elapsed % 60;
                        timerElement.textContent = 
                            `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                    }
                }, 1000);
            }

            stopCallTimer() {
                if (this.callTimer) {
                    clearInterval(this.callTimer);
                    this.callTimer = null;
                }
                const timerElement = document.getElementById('callTimer');
                if (timerElement) timerElement.style.display = 'none';
                this.callStartTime = null;
            }

            toggleMute() {
                if (this.localStream) {
                    this.isMuted = !this.isMuted;
                    this.localStream.getAudioTracks().forEach(track => {
                        track.enabled = !this.isMuted;
                    });
                    
                    this.updateMuteIcon(this.isMuted);
                    console.log('Micro ' + (this.isMuted ? 'désactivé (arrêt immédiat - 0 seconde)' : 'activé'));
                }
            }

            updateMuteIcon(isMuted) {
                const muteIcon = document.getElementById('muteIcon');
                const muteIconOff = document.getElementById('muteIconOff');
                const muteBtn = document.getElementById('muteBtn');
                
                if (muteIcon && muteIconOff) {
                    if (isMuted) {
                        muteIcon.style.display = 'none';
                        muteIconOff.style.display = 'block';
                    } else {
                        muteIcon.style.display = 'block';
                        muteIconOff.style.display = 'none';
                    }
                }
                
                if (muteBtn) {
                    muteBtn.classList.toggle('active', isMuted);
                }
            }

            toggleSpeaker() {
                this.isSpeakerOn = !this.isSpeakerOn;
                const remoteAudio = document.getElementById('remoteAudio');
                if (remoteAudio) {
                    if (!this.isSpeakerOn) {
                        remoteAudio.volume = 0;
                        remoteAudio.pause();
                    } else {
                        remoteAudio.volume = 1.0;
                        remoteAudio.play();
                    }
                }
                
                if (!this.isSpeakerOn) {
                    this.stopDialTone();
                } else {
                    if (this.currentCall && !this.currentCall.isIncoming && !this.currentCall.callStartTime) {
                        this.playDialTone();
                    }
                }
                
                this.updateSpeakerIcon(this.isSpeakerOn);
                console.log('Haut-parleur ' + (this.isSpeakerOn ? 'activé' : 'désactivé (arrêt immédiat)'));
            }

            updateSpeakerIcon(isOn) {
                const speakerIcon = document.getElementById('speakerIcon');
                const speakerIconOff = document.getElementById('speakerIconOff');
                const speakerBtn = document.getElementById('speakerBtn');
                
                if (speakerIcon && speakerIconOff) {
                    if (isOn) {
                        speakerIcon.style.display = 'block';
                        speakerIconOff.style.display = 'none';
                    } else {
                        speakerIcon.style.display = 'none';
                        speakerIconOff.style.display = 'block';
                    }
                }
                
                if (speakerBtn) {
                    speakerBtn.classList.toggle('active', isOn);
                }
            }

            playRingtone() {
                if (window.playRingtoneAudio) {
                    window.playRingtoneAudio();
                } else {
                    const ringtone = document.getElementById('ringtoneAudio');
                    if (ringtone) {
                        ringtone.loop = true;
                        ringtone.volume = 0.7;
                        ringtone.play().catch(error => {
                            console.error('Error playing ringtone:', error);
                        });
                    }
                }
            }

            stopRingtone() {
                if (window.stopRingtoneAudio) {
                    window.stopRingtoneAudio();
                } else {
                    const ringtone = document.getElementById('ringtoneAudio');
                    if (ringtone) {
                        ringtone.pause();
                        ringtone.currentTime = 0;
                        ringtone.src = '';
                    }
                }
            }

            playDialTone() {
                if (window.playDialToneAudio) {
                    window.playDialToneAudio();
                } else {
                    const dialTone = document.getElementById('dialToneAudio');
                    if (dialTone) {
                        dialTone.loop = true;
                        dialTone.volume = 0.5;
                        dialTone.play().catch(error => {
                            console.error('Error playing dial tone:', error);
                        });
                    }
                }
            }

            stopDialTone() {
                if (window.stopDialToneAudio) {
                    window.stopDialToneAudio();
                } else {
                    const dialTone = document.getElementById('dialToneAudio');
                    if (dialTone) {
                        dialTone.pause();
                        dialTone.currentTime = 0;
                        dialTone.src = '';
                    }
                }
            }

            sendSystemMessage(message) {
                console.log('🔍 [DEBUG formateur] sendSystemMessage appelé:', { message, currentCall: this.currentCall });
                if (!this.currentCall) {
                    console.warn('⚠️ [DEBUG formateur] sendSystemMessage: currentCall est null');
                    return;
                }

                const receiverId = this.currentCall.isIncoming 
                    ? this.currentCall.callerId 
                    : this.currentCall.receiverId;

                if (!receiverId) {
                    console.warn('⚠️ [DEBUG formateur] sendSystemMessage: receiverId est null');
                    return;
                }

                const icon = message === 'Appel manqué' ? '📞❌' : '📞✅';
                const content = `${icon} ${message}`;

                console.log('🔍 [DEBUG formateur] Envoi du message système:', { receiverId, content, message });

                const formData = new FormData();
                formData.append('receiver_id', receiverId);
                formData.append('content', content);
                formData.append('label', 'System');
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');

                fetch('{{ route("formateur.messages.send") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('🔍 [DEBUG formateur] Réponse du serveur pour sendSystemMessage:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('🔍 [DEBUG formateur] Données reçues du serveur:', data);
                    if (data.success && data.message) {
                        console.log('✅ [DEBUG formateur] Message système créé avec succès:', data.message);
                        const receiverIdInput = document.getElementById('receiverId');
                        const messagesArea = document.getElementById('messagesArea');
                        
                        console.log('🔍 [DEBUG formateur] Vérification de l\'affichage:', {
                            receiverIdInput: receiverIdInput ? receiverIdInput.value : 'null',
                            receiverId: receiverId,
                            messagesArea: messagesArea ? 'trouvé' : 'non trouvé'
                        });
                        
                        if (receiverIdInput && receiverIdInput.value == receiverId && messagesArea) {
                            console.log('✅ [DEBUG formateur] Ajout direct du message système à l\'UI');
                            this.addSystemMessageToUI(data.message);
                        } else {
                            console.log('🔄 [DEBUG formateur] Rechargement du thread pour afficher le message système');
                            if (typeof loadThread === 'function') {
                                loadThread(receiverId);
                            }
                        }
                    } else {
                        console.error('❌ [DEBUG formateur] Erreur lors de la création du message système:', data);
                    }
                })
                .catch(error => {
                    console.error('❌ [DEBUG formateur] Erreur lors de l\'envoi du message système:', error);
                });
            }

            addSystemMessageToUI(message) {
                // Ajouter directement un message système dans l'interface
                const messagesArea = document.getElementById('messagesArea');
                if (!messagesArea) {
                    console.error('❌ [FORMATEUR] messagesArea non trouvé');
                    return;
                }

                // Trouver le conteneur .space-y-4 à l'intérieur de messagesArea
                const messagesContainer = messagesArea.querySelector('.space-y-4');
                if (!messagesContainer) {
                    console.error('❌ [FORMATEUR] Conteneur .space-y-4 non trouvé dans messagesArea');
                    // Fallback: utiliser messagesArea directement
                    const fallbackContainer = messagesArea;
                    const existingMessage = fallbackContainer.querySelector(`[data-message-id="${message.id}"]`);
                    if (existingMessage) {
                        console.log('Message système déjà présent dans l\'interface');
                        return;
                    }
                } else {
                    // Vérifier si le message n'existe pas déjà
                    const existingMessage = messagesContainer.querySelector(`[data-message-id="${message.id}"]`);
                    if (existingMessage) {
                        console.log('Message système déjà présent dans l\'interface');
                        return;
                    }
                }

                // Créer l'élément du message système - Aligné à droite comme WhatsApp
                const messageDiv = document.createElement('div');
                messageDiv.className = 'flex items-start gap-3 justify-end my-2';
                messageDiv.setAttribute('data-message-id', message.id);

                // Formater la date
                const messageDate = new Date(message.created_at);
                const day = String(messageDate.getDate()).padStart(2, '0');
                const month = String(messageDate.getMonth() + 1).padStart(2, '0');
                const year = messageDate.getFullYear();
                const hours = String(messageDate.getHours()).padStart(2, '0');
                const minutes = String(messageDate.getMinutes()).padStart(2, '0');
                const timeFormat = `${day}/${month}/${year} ${hours}:${minutes}`;

                messageDiv.innerHTML = `
                    <div class="flex-1 flex justify-end">
                        <div class="max-w-[70%]">
                            <div class="bg-gray-200 rounded-lg px-3 py-2 inline-block">
                                <p class="text-xs text-gray-600">${this.escapeHtml(message.content)}</p>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 text-right">${timeFormat}</p>
                        </div>
                    </div>
                `;

                // Ajouter le message à la fin de la conversation
                const targetContainer = messagesContainer || messagesArea;
                targetContainer.appendChild(messageDiv);

                // Faire défiler vers le bas pour voir le nouveau message
                messagesArea.scrollTop = messagesArea.scrollHeight;

                console.log('✅ [FORMATEUR] Message système ajouté à l\'interface:', message.id);
            }

            escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            getInitials(name) {
                if (!name) return '??';
                const parts = name.trim().split(' ').filter(p => p.length > 0);
                if (parts.length === 0) return '??';
                if (parts.length === 1) return parts[0].substring(0, 2).toUpperCase();
                return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
            }
        }

        // Initialize Call Manager when page loads
        let callManager;
        document.addEventListener('DOMContentLoaded', () => {
            callManager = new CallManager();
        });

        // Generate ringtone (melody for incoming call)
        function generateRingtone() {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const sampleRate = audioContext.sampleRate;
            const duration = 0.5;
            const buffer = audioContext.createBuffer(1, sampleRate * duration, sampleRate);
            const data = buffer.getChannelData(0);
            
            for (let i = 0; i < data.length; i++) {
                const t = i / sampleRate;
                const tone1 = Math.sin(2 * Math.PI * 440 * t) * 0.3;
                const tone2 = Math.sin(2 * Math.PI * 554 * t) * 0.3;
                const fade = Math.sin(Math.PI * t / duration);
                data[i] = (tone1 + tone2) * fade;
            }
            
            return buffer;
        }

        // Generate dial tone (continuous tone for outgoing call)
        function generateDialTone() {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const sampleRate = audioContext.sampleRate;
            const duration = 2;
            const buffer = audioContext.createBuffer(1, sampleRate * duration, sampleRate);
            const data = buffer.getChannelData(0);
            
            for (let i = 0; i < data.length; i++) {
                const t = i / sampleRate;
                const tone1 = Math.sin(2 * Math.PI * 350 * t) * 0.2;
                const tone2 = Math.sin(2 * Math.PI * 440 * t) * 0.2;
                data[i] = tone1 + tone2;
            }
            
            return buffer;
        }

        // Initialize audio when page loads
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const ringtoneBuffer = generateRingtone();
                const dialToneBuffer = generateDialTone();
                
                let ringtoneSource = null;
                let dialToneSource = null;
                
                window.playRingtoneAudio = function() {
                    // Activer l'audioContext si nécessaire (sans attendre pour jouer immédiatement)
                    if (audioContext.state === 'suspended') {
                        audioContext.resume().catch(err => {
                            console.error('Erreur lors de l\'activation de l\'audioContext:', err);
                        });
                    }
                    
                    if (ringtoneSource) {
                        try {
                            ringtoneSource.stop(0);
                        } catch (e) {}
                        ringtoneSource.disconnect();
                    }
                    ringtoneSource = audioContext.createBufferSource();
                    ringtoneSource.buffer = ringtoneBuffer;
                    ringtoneSource.connect(audioContext.destination);
                    ringtoneSource.loop = true;
                    ringtoneSource.start(0);
                };
                
                window.stopRingtoneAudio = function() {
                    if (ringtoneSource) {
                        try {
                            ringtoneSource.stop(0);
                        } catch (e) {}
                        ringtoneSource.disconnect();
                        ringtoneSource = null;
                    }
                };
                
                window.playDialToneAudio = function() {
                    // Activer l'audioContext si nécessaire (sans attendre pour jouer immédiatement)
                    if (audioContext.state === 'suspended') {
                        audioContext.resume().catch(err => {
                            console.error('Erreur lors de l\'activation de l\'audioContext:', err);
                        });
                    }
                    
                    if (dialToneSource) {
                        try {
                            dialToneSource.stop(0);
                        } catch (e) {}
                        dialToneSource.disconnect();
                    }
                    dialToneSource = audioContext.createBufferSource();
                    dialToneSource.buffer = dialToneBuffer;
                    dialToneSource.connect(audioContext.destination);
                    dialToneSource.loop = true;
                    dialToneSource.start(0);
                };
                
                window.stopDialToneAudio = function() {
                    if (dialToneSource) {
                        try {
                            dialToneSource.stop(0);
                        } catch (e) {}
                        dialToneSource.disconnect();
                        dialToneSource = null;
                    }
                };
            } catch (error) {
                console.error('Error initializing audio:', error);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Paramètres Button
            const parametresBtn = document.getElementById('parametresBtn');
            
            if (parametresBtn) {
                parametresBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    window.location.href = '{{ route('formateur.parametres') }}';
                });
            }
        });
        
        // Group Modal functions for formateur
        function openGroupModal(groupId) {
            const chatItem = document.querySelector(`.chat-item[data-group-id="${groupId}"]`);
            let name = 'Groupe';
            let description = '';
            let avatar = null;
            if (chatItem) {
                name = chatItem.getAttribute('data-group-name') || name;
                description = chatItem.getAttribute('data-group-description') || '';
                avatar = chatItem.getAttribute('data-group-avatar') || '';
            }
            
            // Create or update modal
            let modal = document.getElementById('groupDetailsModal');
            if (!modal) {
                const modalHtml = `
                <div id="groupDetailsModal" class="fixed inset-0 z-50 hidden items-center justify-center">
                    <div class="absolute inset-0 bg-black opacity-40"></div>
                    <div class="bg-white rounded-lg shadow-xl w-11/12 max-w-3xl relative z-10 overflow-hidden">
                        <div class="p-4 border-b flex items-center justify-between">
                            <h3 id="groupModalTitle" class="text-lg font-semibold">Groupe</h3>
                            <button id="groupCloseBtn" class="px-3 py-1 text-sm bg-gray-100 rounded hover:bg-gray-200">Fermer</button>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center gap-4 mb-4">
                                <div id="groupAvatar" class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center relative overflow-hidden"></div>
                                <div class="flex-1">
                                    <label class="block text-xs text-gray-600">Nom du groupe</label>
                                    <input id="groupNameInput" class="w-full border rounded px-2 py-1 bg-gray-50" readonly />
                                    <label class="block text-xs text-gray-600 mt-2">Description</label>
                                    <textarea id="groupDescriptionInput" class="w-full border rounded px-2 py-1 bg-gray-50" rows="3" readonly></textarea>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-2">Membres</h4>
                                <div id="groupMembersList" class="space-y-2 max-h-64 overflow-y-auto border rounded p-2"></div>
                            </div>
                        </div>
                    </div>
                </div>`;
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                modal = document.getElementById('groupDetailsModal');
                document.getElementById('groupCloseBtn').addEventListener('click', () => {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                });
            }
            
            document.getElementById('groupModalTitle').textContent = name;
            document.getElementById('groupNameInput').value = name;
            document.getElementById('groupDescriptionInput').value = description;
            
            // Load avatar
            const avatarEl = document.getElementById('groupAvatar');
            if (avatar && avatar.trim() !== '') {
                avatarEl.style.backgroundImage = `url(/storage/${avatar})`;
                avatarEl.style.backgroundSize = 'cover';
                avatarEl.style.backgroundPosition = 'center';
                avatarEl.innerHTML = '';
            } else {
                avatarEl.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                avatarEl.innerHTML = '<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>';
            }
            
            // Load members - fetch from server
            const membersList = document.getElementById('groupMembersList');
            membersList.innerHTML = '<p class="text-center text-gray-500 py-4">Chargement des membres...</p>';
            
            fetch(`/formateur/forum/groups/${groupId}/members`)
                .then(r => r.json())
                .then(data => {
                    if (data.success && data.members) {
                        membersList.innerHTML = '';
                        data.members.forEach(m => {
                            const div = document.createElement('div');
                            div.className = 'flex items-center gap-2';
                            div.innerHTML = `${m.photo ? `<img src="/storage/${m.photo}" class="w-8 h-8 rounded-full">` : `<div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-xs">${(m.prenom||'').charAt(0)}${(m.nom||'').charAt(0)}</div>`}<div><div class="font-medium">${m.prenom} ${m.nom}</div><div class="text-xs text-gray-500">${m.email}</div></div>`;
                            membersList.appendChild(div);
                        });
                    } else {
                        membersList.innerHTML = '<p class="text-center text-gray-500 py-4">Erreur lors du chargement des membres.</p>';
                    }
                })
                .catch(err => {
                    console.error('Erreur chargement membres:', err);
                    membersList.innerHTML = '<p class="text-center text-gray-500 py-4">Erreur lors du chargement des membres.</p>';
                });
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    </script>
@include('components.video-session-notification')</body>
</html>

