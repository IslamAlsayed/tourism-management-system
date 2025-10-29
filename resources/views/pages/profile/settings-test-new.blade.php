@extends('layouts.master')

@section('title', 'Profile Settings')

@section('content')
    <!-- Container with Hero Background -->
    <style>
        .hero-bg {
            background-image: url('{{ asset('metronic/media/images/2600x1200/bg-1.png') }}');
        }

        .dark .hero-bg {
            background-image: url('{{ asset('metronic/media/images/2600x1200/bg-1-dark.png') }}');
        }
    </style>

    <div class="bg-center bg-cover bg-no-repeat hero-bg">
        <!-- Container -->
        <div class="kt-container-fixed">
            <div class="flex flex-col items-center gap-2 lg:gap-3.5 py-4 lg:pt-5 lg:pb-10">
                <img class="rounded-full border-3 border-green-500 size-[100px] shrink-0"
                    src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('metronic/media/avatars/300-2.png') }}">
                <div class="flex items-center gap-1.5">
                    <div class="text-lg leading-5 font-semibold text-mono">
                        {{ $user->name }}
                    </div>
                    <svg class="text-primary" fill="none" height="16" viewbox="0 0 15 16" width="15"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M14.5425 6.89749L13.5 5.83999C13.4273 5.76877 13.3699 5.6835 13.3312 5.58937C13.2925 5.49525 13.2734 5.39424 13.275 5.29249V3.79249C13.274 3.58699 13.2324 3.38371 13.1527 3.19432C13.0729 3.00494 12.9565 2.83318 12.8101 2.68892C12.6638 2.54466 12.4904 2.43073 12.2998 2.35369C12.1093 2.27665 11.9055 2.23801 11.7 2.23999H10.2C10.0982 2.24159 9.99722 2.22247 9.9031 2.18378C9.80898 2.1451 9.72371 2.08767 9.65249 2.01499L8.60249 0.957487C8.30998 0.665289 7.91344 0.50116 7.49999 0.50116C7.08654 0.50116 6.68999 0.665289 6.39749 0.957487L5.33999 1.99999C5.26876 2.07267 5.1835 2.1301 5.08937 2.16879C4.99525 2.20747 4.89424 2.22659 4.79249 2.22499H3.29249C3.08699 2.22597 2.88371 2.26754 2.69432 2.34731C2.50494 2.42709 2.33318 2.54349 2.18892 2.68985C2.3362 2.8362 1.93073 3.00961 1.85369 3.20013C1.77665 3.39064 1.73801 3.5945 1.73999 3.79999V5.29999C1.74159 5.40174 1.72247 5.50275 1.68378 5.59687C1.6451 5.691 1.58767 5.77627 1.51499 5.84749L0.457487 6.89749C0.165289 7.19 0.00115967 7.58654 0.00115967 7.99999C0.00115967 8.41344 0.165289 8.80998 0.457487 9.10249L1.49999 10.16C1.57267 10.2312 1.6301 10.3165 1.66878 10.4106C1.70747 10.5047 1.72659 10.6057 1.72499 10.7075V12.2075C1.72597 12.413 1.76754 12.6163 1.84731 12.8056C1.92709 12.995 2.04349 13.1668 2.18985 13.3111C2.3362 13.4553 2.50961 13.5692 2.70013 13.6463C2.89064 13.7233 3.0945 13.762 3.29999 13.76H4.79999C4.90174 13.7584 5.00275 13.7775 5.09687 13.8162C5.191 13.8549 5.27627 13.9123 5.34749 13.985L6.40499 15.0425C6.69749 15.3347 7.09404 15.4988 7.50749 15.4988C7.92094 15.4988 8.31748 15.3347 8.60999 15.0425L9.65999 14C9.73121 13.9273 9.81647 13.8699 9.9106 13.8312C10.0047 13.7925 10.1057 13.7734 10.2075 13.775H11.7075C12.1212 13.775 12.518 13.6106 12.8106 13.3181C13.1031 13.0255 13.2675 12.6287 13.2675 12.215V10.715C13.2659 10.6132 13.285 10.5122 13.3237 10.4181C13.3624 10.324 13.4198 10.2387 13.4925 10.1675L14.55 9.10999C14.6953 8.96452 14.8104 8.79176 14.8887 8.60164C14.9671 8.41152 15.007 8.20779 15.0063 8.00218C15.0056 7.79656 14.9643 7.59311 14.8847 7.40353C14.8051 7.21394 14.6888 7.04197 14.5425 6.89749ZM10.635 6.64999L6.95249 10.25C6.90055 10.3026 6.83864 10.3443 6.77038 10.3726C6.70212 10.4009 6.62889 10.4153 6.55499 10.415C6.48062 10.4139 6.40719 10.3982 6.33896 10.3685C6.27073 10.3389 6.20905 10.2961 6.15749 10.2425L4.37999 8.44249C4.32532 8.39044 4.28169 8.32793 4.25169 8.25867C4.22169 8.18941 4.20593 8.11482 4.20536 8.03934C4.20479 7.96387 4.21941 7.88905 4.24836 7.81934C4.27731 7.74964 4.31999 7.68647 4.37387 7.63361C4.42774 7.58074 4.4917 7.53926 4.56194 7.51163C4.63218 7.484 4.70726 7.47079 4.78271 7.47278C4.85816 7.47478 4.93244 7.49194 5.00112 7.52324C5.0698 7.55454 5.13148 7.59935 5.18249 7.65499L6.56249 9.05749L9.84749 5.84749C9.95296 5.74215 10.0959 5.68298 10.245 5.68298C10.394 5.68298 10.537 5.74215 10.6425 5.84749C10.6953 5.90034 10.737 5.96318 10.7653 6.03234C10.7935 6.1015 10.8077 6.1756 10.807 6.25031C10.8063 6.32502 10.7908 6.39884 10.7612 6.46746C10.7317 6.53608 10.6888 6.59813 10.635 6.64999Z"
                            fill="currentColor">
                        </path>
                    </svg>
                </div>
                <div class="flex flex-wrap justify-center gap-1 lg:gap-4.5 text-sm">
                    <div class="flex gap-1.25 items-center">
                        <i class="ki-filled ki-abstract-41 text-muted-foreground text-sm"></i>
                        <span class="text-secondary-foreground font-medium">
                            {{ $user->department ?? 'KeenThemes' }}
                        </span>
                    </div>
                    <div class="flex gap-1.25 items-center">
                        <i class="ki-filled ki-geolocation text-muted-foreground text-sm"></i>
                        <span class="text-secondary-foreground font-medium">
                            {{ $user->address ?? 'SF, Bay Area' }}
                        </span>
                    </div>
                    <div class="flex gap-1.25 items-center">
                        <i class="ki-filled ki-sms text-muted-foreground text-sm"></i>
                        <a class="text-secondary-foreground font-medium hover:text-primary"
                            href="mailto:{{ $user->email }}">
                            {{ $user->email }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Container -->
    </div>

    /* Statistics Cards - Enhanced */
    .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
    }

    .stat-card {
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 16px;
    padding: 2rem;
    border: 1px solid #e2e8f0;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    transition: width 0.3s ease;
    }

    .stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .stat-card:hover::before {
    width: 100%;
    opacity: 0.05;
    }

    .stat-card.primary::before { background: #3b82f6; }
    .stat-card.success::before { background: #10b981; }
    .stat-card.warning::before { background: #f59e0b; }
    .stat-card.info::before { background: #8b5cf6; }

    .stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    font-size: 24px;
    }

    .stat-card.primary .stat-icon { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    .stat-card.success .stat-icon { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .stat-card.warning .stat-icon { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .stat-card.info .stat-icon { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }

    .stat-value {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1;
    margin-bottom: 0.5rem;
    }

    .stat-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    }

    /* Navigation Pills - Enhanced */
    .nav-container {
    background: white;
    border-radius: 20px;
    padding: 1rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
    }

    .nav-pills-custom {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    background: #f8fafc;
    padding: 0.5rem;
    border-radius: 16px;
    }

    .nav-pills-custom .nav-link {
    background: transparent;
    border: none;
    border-radius: 12px;
    padding: 12px 20px;
    color: #64748b;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    }

    .nav-pills-custom .nav-link:hover {
    color: #3b82f6;
    background: rgba(59, 130, 246, 0.1);
    transform: translateY(-1px);
    }

    .nav-pills-custom .nav-link.active {
    background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    transform: translateY(-2px);
    }

    .nav-pills-custom .nav-link.active::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(45deg, rgba(255,255,255,0.2), transparent);
    border-radius: 12px;
    pointer-events: none;
    }

    /* Form Sections - Enhanced */
    .content-grid {
    display: grid;
    gap: 2rem;
    }

    .form-section {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    position: relative;
    }

    .form-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #1e40af);
    border-radius: 20px 20px 0 0;
    }

    .form-section:hover {
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
    }

    .section-title {
    color: #1e293b;
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 12px;
    }

    .section-title i {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    }

    .custom-avatar {
    width: 120px;
    height: 120px;
    border-radius: 20px;
    border: 4px solid white;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    object-fit: cover;
    transition: transform 0.3s ease;
    }

    .custom-avatar:hover {
    transform: scale(1.05);
    }

    .btn-upload {
    background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .btn-upload:hover {
    background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    color: white;
    }

    .form-control-modern {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 14px 16px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
    background: #f8fafc;
    color: #1e293b;
    }

    .form-control-modern:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    background: white;
    outline: none;
    }

    .form-label {
    font-weight: 600;
    font-size: 0.875rem;
    color: #374151;
    margin-bottom: 8px;
    }

    /* Info Cards */
    .info-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    }

    .info-label {
    font-size: 0.75rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 4px;
    }

    .info-value {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    }

    /* Security Options */
    .security-option {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
    }

    .security-option:hover {
    background: #ffffff;
    border-color: #009ef7;
    box-shadow: 0 2px 10px rgba(0, 158, 247, 0.1);
    }

    /* Notification Options */
    .notification-group {
    margin-bottom: 30px;
    }

    .notification-group-title {
    font-size: 14px;
    font-weight: 700;
    color: #3f4254;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 20px;
    padding-bottom: 8px;
    border-bottom: 2px solid #f1f3f8;
    }

    .notification-option {
    background: #ffffff;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: 18px;
    margin-bottom: 12px;
    transition: all 0.3s ease;
    }

    .notification-option:hover {
    border-color: #009ef7;
    box-shadow: 0 2px 8px rgba(0, 158, 247, 0.15);
    transform: translateY(-1px);
    }

    /* Timeline Modern */
    .timeline-modern {
    padding-left: 20px;
    border-left: 2px solid #f1f3f8;
    position: relative;
    }

    .timeline-item-modern {
    position: relative;
    padding-bottom: 20px;
    margin-bottom: 20px;
    }

    .timeline-item-modern::before {
    content: '';
    position: absolute;
    left: -26px;
    top: 5px;
    width: 8px;
    height: 8px;
    background: #009ef7;
    border-radius: 50%;
    border: 2px solid #ffffff;
    box-shadow: 0 0 0 2px #009ef7;
    }

    /* Enhanced Form Switches */
    .form-check-input:checked {
    background-color: #009ef7;
    border-color: #009ef7;
    }

    .form-check-input:focus {
    border-color: #009ef7;
    box-shadow: 0 0 0 0.25rem rgba(0, 158, 247, 0.25);
    }

    /* Notice Enhancements */
    .notice {
    position: relative;
    overflow: hidden;
    }

    .notice::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    }

    .notice-light-primary::before { background: #009ef7; }
    .notice-light-success::before { background: #50cd89; }
    .notice-light-info::before { background: #7239ea; }

    /* Responsive Design */
    @media (max-width: 768px) {
    .profile-container {
    padding: 0 10px;
    }

    .profile-hero {
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
    }

    .profile-hero h1 {
    font-size: 1.8rem !important;
    }

    .custom-avatar {
    width: 80px;
    height: 80px;
    margin-bottom: 1rem;
    }

    .stats-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
    }

    .stat-card {
    padding: 1.5rem;
    }

    .stat-value {
    font-size: 2rem;
    }

    .nav-pills-custom {
    flex-direction: column;
    gap: 0.25rem;
    }

    .nav-pills-custom .nav-link {
    justify-content: center;
    }

    .form-section {
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    }

    .section-title {
    font-size: 1.25rem;
    margin-bottom: 1.5rem;
    }
    }

    @media (max-width: 480px) {
    .stats-grid {
    grid-template-columns: 1fr;
    }

    .profile-hero .d-flex {
    flex-direction: column;
    text-align: center;
    }

    .custom-avatar {
    margin: 0 auto 1rem;
    }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
    .nav-pills-custom {
    flex-direction: column;
    }

    .nav-pills-custom .nav-link {
    margin-bottom: 8px;
    text-align: center;
    }

    .profile-hero {
    padding: 1.5rem;
    }

    .custom-avatar {
    width: 80px;
    height: 80px;
    }

    .form-section {
    padding: 1.5rem;
    margin-bottom: 15px;
    }
    }
    </style>
@endpush

@section('content')
    <div class="profile-container">

        <!-- Hero Section -->
        <div class="profile-hero">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('metronic/media/avatars/300-2.png') }}"
                            alt="Profile Picture" class="custom-avatar me-4">
                        <div>
                            <h1 class="text-white fw-bold mb-3" style="font-size: 2.5rem;">{{ $user->name }}</h1>
                            <div class="d-flex align-items-center text-white opacity-90 mb-3">
                                <i class="ki-filled ki-briefcase fs-4 me-2"></i>
                                <span class="me-4 fw-semibold">{{ $user->position ?? 'Software Developer' }}</span>
                                <i class="ki-filled ki-geolocation fs-4 me-2"></i>
                                <span class="fw-semibold">{{ $user->address ?? 'Amman, Jordan' }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="badge bg-success bg-opacity-20 text-success px-3 py-2 rounded-pill">
                                    <i class="ki-filled ki-verify fs-6 me-1"></i>
                                    <span class="fw-semibold">Verified Account</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="badge bg-white bg-opacity-20 text-white fs-6 fw-bold px-4 py-3 rounded-pill">
                        <i class="ki-filled ki-check-circle me-2"></i>
                        Profile 95% Complete
                    </div>
                </div>
            </div>
        </div>

        <!-- Container -->
        <div class="kt-container-fixed">
            <div
                class="flex items-center flex-wrap md:flex-nowrap lg:items-end justify-between border-b border-b-border gap-3 lg:gap-6 mb-5 lg:mb-10">
                <div class="grid">
                    <div class="kt-scrollable-x-auto">
                        <div class="kt-menu gap-3" data-kt-menu="true">
                            <div
                                class="kt-menu-item border-b-2 border-b-transparent kt-menu-item-active:border-b-primary kt-menu-item-here:border-b-primary">
                                <a class="kt-menu-link gap-1.5 pb-2 lg:pb-4 px-2" href="#overview" data-bs-toggle="pill"
                                    data-bs-target="#overview">
                                    <span
                                        class="kt-menu-title text-nowrap font-medium text-sm text-secondary-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-item-here:text-primary kt-menu-item-here:font-semibold">
                                        Overview
                                    </span>
                                </a>
                            </div>
                            <div
                                class="kt-menu-item border-b-2 border-b-transparent kt-menu-item-active:border-b-primary kt-menu-item-here:border-b-primary">
                                <a class="kt-menu-link gap-1.5 pb-2 lg:pb-4 px-2" href="#personal" data-bs-toggle="pill"
                                    data-bs-target="#personal">
                                    <span
                                        class="kt-menu-title text-nowrap font-medium text-sm text-secondary-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-item-here:text-primary kt-menu-item-here:font-semibold">
                                        Personal Info
                                    </span>
                                </a>
                            </div>
                            <div
                                class="kt-menu-item border-b-2 border-b-transparent kt-menu-item-active:border-b-primary kt-menu-item-here:border-b-primary">
                                <a class="kt-menu-link gap-1.5 pb-2 lg:pb-4 px-2" href="#security" data-bs-toggle="pill"
                                    data-bs-target="#security">
                                    <span
                                        class="kt-menu-title text-nowrap font-medium text-sm text-secondary-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-item-here:text-primary kt-menu-item-here:font-semibold">
                                        Security
                                    </span>
                                </a>
                            </div>
                            <div
                                class="kt-menu-item border-b-2 border-b-transparent kt-menu-item-active:border-b-primary kt-menu-item-here:border-b-primary">
                                <a class="kt-menu-link gap-1.5 pb-2 lg:pb-4 px-2" href="#notifications"
                                    data-bs-toggle="pill" data-bs-target="#notifications">
                                    <span
                                        class="kt-menu-title text-nowrap font-medium text-sm text-secondary-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-item-here:text-primary kt-menu-item-here:font-semibold">
                                        Notifications
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end grow lg:grow-0 lg:pb-4 gap-2.5 mb-3 lg:mb-0">
                    <a href="{{ route('profile.edit') }}" class="kt-btn kt-btn-primary">
                        <i class="ki-filled ki-setting-2"></i>
                        Edit Profile
                    </a>
                    <button class="kt-btn kt-btn-icon kt-btn-outline">
                        <i class="ki-filled ki-messages"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- End of Container -->

        <!-- Container -->
        <div class="kt-container-fixed">
            <!-- begin: grid -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 lg:gap-6">

                <!-- Tab Content -->
                <div class="tab-content col-span-1 xl:col-span-3" id="profileTabsContent">

                    <!-- Overview Tab -->
                    <div class="tab-pane fade show active" id="overview" role="tabpanel">
                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 lg:gap-6">
                            <div class="col-span-1">
                                <div class="grid gap-4 lg:gap-6">
                                    <div class="kt-card">
                                        <div class="kt-card-header">
                                            <h3 class="kt-card-title">Profile Summary</h3>
                                        </div>
                                        <div class="kt-card-content pb-7.5">
                                            <div class="table-responsive">
                                                <table class="table table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-muted fw-semibold">Full Name</td>
                                                            <td class="fw-bold">{{ $user->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted fw-semibold">Email</td>
                                                            <td class="fw-bold">{{ $user->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted fw-semibold">Phone</td>
                                                            <td class="fw-bold">{{ $user->phone ?? 'Not provided' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted fw-semibold">Department</td>
                                                            <td class="fw-bold">{{ $user->department ?? 'Not specified' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="kt-card">
                                        <div class="kt-card-header">
                                            <h3 class="kt-card-title">Account Statistics</h3>
                                        </div>
                                        <div class="kt-card-content pb-7.5">
                                            <div class="grid grid-cols-2 gap-3">
                                                <div
                                                    class="flex flex-col gap-1 items-center border border-dashed border-gray-300 rounded-lg p-4">
                                                    <div class="text-2xl font-bold text-primary">15</div>
                                                    <div class="text-xs text-muted-foreground">Projects</div>
                                                </div>
                                                <div
                                                    class="flex flex-col gap-1 items-center border border-dashed border-gray-300 rounded-lg p-4">
                                                    <div class="text-2xl font-bold text-success">8</div>
                                                    <div class="text-xs text-muted-foreground">Active</div>
                                                </div>
                                                <div
                                                    class="flex flex-col gap-1 items-center border border-dashed border-gray-300 rounded-lg p-4">
                                                    <div class="text-2xl font-bold text-warning">42</div>
                                                    <div class="text-xs text-muted-foreground">Team</div>
                                                </div>
                                                <div
                                                    class="flex flex-col gap-1 items-center border border-dashed border-gray-300 rounded-lg p-4">
                                                    <div class="text-2xl font-bold text-info">96%</div>
                                                    <div class="text-xs text-muted-foreground">Success</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-1 xl:col-span-2">
                                <div class="grid gap-4 lg:gap-6">
                                    <div class="kt-card">
                                        <div class="kt-card-header">
                                            <h3 class="kt-card-title">Recent Activity</h3>
                                        </div>
                                        <div class="kt-card-content pb-7.5">
                                            <div class="flex flex-col gap-5">
                                                <div class="flex items-start gap-3.5">
                                                    <div
                                                        class="flex items-center justify-center size-8 bg-success-light rounded-full border border-success-clarity">
                                                        <i class="ki-filled ki-check text-success text-xs"></i>
                                                    </div>
                                                    <div class="flex flex-col gap-1">
                                                        <div class="text-sm font-medium">Profile Updated</div>
                                                        <div class="text-xs text-muted-foreground">
                                                            {{ $user->updated_at ? $user->updated_at->diffForHumans() : '2 hours ago' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex items-start gap-3.5">
                                                    <div
                                                        class="flex items-center justify-center size-8 bg-primary-light rounded-full border border-primary-clarity">
                                                        <i class="ki-filled ki-user text-primary text-xs"></i>
                                                    </div>
                                                    <div class="flex flex-col gap-1">
                                                        <div class="text-sm font-medium">Account Created</div>
                                                        <div class="text-xs text-muted-foreground">
                                                            {{ $user->created_at ? $user->created_at->diffForHumans() : '1 week ago' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Info Tab -->
                    <div class="tab-pane fade" id="personal" role="tabpanel">
                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 lg:gap-6">
                            <div class="col-span-1 xl:col-span-2">
                                <div class="kt-card">
                                    <div class="kt-card-header">
                                        <h3 class="kt-card-title">Personal Information</h3>
                                    </div>
                                    <div class="kt-card-content pb-7.5">
                                        <form>
                                            <!-- Photo Upload -->
                                            <div class="row mb-6">
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Photo</label>
                                                <div class="col-lg-8">
                                                    <div class="d-flex align-items-center gap-4">
                                                        <div class="symbol symbol-100px">
                                                            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('metronic/media/avatars/300-2.png') }}"
                                                                alt="photo"
                                                                class="w-100 h-100 rounded-circle object-fit-cover">
                                                        </div>
                                                        <div>
                                                            <button type="button"
                                                                class="kt-btn kt-btn-primary kt-btn-sm me-2">Upload
                                                                New</button>
                                                            <button type="button"
                                                                class="kt-btn kt-btn-light kt-btn-sm">Remove</button>
                                                            <div class="form-text mt-2">Allowed JPG, GIF or PNG. Max size
                                                                2MB</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Name Fields -->
                                            <div class="row mb-6">
                                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Full
                                                    Name</label>
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-6 mb-3 mb-lg-0">
                                                            <input type="text" name="fname"
                                                                class="form-control form-control-lg form-control-solid"
                                                                value="{{ explode(' ', $user->name)[0] ?? '' }}" />
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" name="lname"
                                                                class="form-control form-control-lg form-control-solid"
                                                                value="{{ explode(' ', $user->name)[1] ?? '' }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Email and Phone -->
                                            <div class="row mb-6">
                                                <label
                                                    class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
                                                <div class="col-lg-8">
                                                    <input type="email" name="email" value="{{ $user->email }}"
                                                        class="form-control form-control-lg form-control-solid" />
                                                </div>
                                            </div>

                                            <div class="row mb-6">
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Phone</label>
                                                <div class="col-lg-8">
                                                    <input type="tel" name="phone"
                                                        value="{{ $user->phone ?? '' }}"
                                                        class="form-control form-control-lg form-control-solid" />
                                                </div>
                                            </div>

                                            <!-- Department and Position -->
                                            <div class="row mb-6">
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Department</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="department"
                                                        value="{{ $user->department ?? '' }}"
                                                        class="form-control form-control-lg form-control-solid" />
                                                </div>
                                            </div>

                                            <div class="row mb-6">
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Position</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="position"
                                                        value="{{ $user->position ?? '' }}"
                                                        class="form-control form-control-lg form-control-solid" />
                                                </div>
                                            </div>

                                            <!-- Bio -->
                                            <div class="row mb-6">
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Bio</label>
                                                <div class="col-lg-8">
                                                    <input id="bio" type="hidden" name="bio"
                                                        value="{{ $user->bio }}">
                                                    <trix-editor input="bio"></trix-editor>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end">
                                                <button type="reset" class="kt-btn kt-btn-light me-3">Discard</button>
                                                <button type="submit" class="kt-btn kt-btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-1">
                                <div class="kt-card">
                                    <div class="kt-card-header">
                                        <h3 class="kt-card-title">Profile Tips</h3>
                                    </div>
                                    <div class="kt-card-content pb-7.5">
                                        <div
                                            class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
                                            <i class="ki-filled ki-information fs-2tx text-primary me-4"></i>
                                            <div class="d-flex flex-stack flex-grow-1">
                                                <div class="fw-semibold">
                                                    <h4 class="text-gray-900 fw-bold">Complete Your Profile</h4>
                                                    <div class="fs-6 text-gray-700">Adding more information helps
                                                        colleagues find and connect with you.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div class="tab-pane fade" id="security" role="tabpanel">
                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 lg:gap-6">
                            <div class="col-span-1 xl:col-span-2">
                                <!-- Change Password Card -->
                                <div class="kt-card mb-5 lg:mb-7.5">
                                    <div class="kt-card-header">
                                        <h3 class="kt-card-title">Change Password</h3>
                                    </div>
                                    <div class="kt-card-content pb-7.5">
                                        <form>
                                            <div class="row mb-6">
                                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Current
                                                    Password</label>
                                                <div class="col-lg-8">
                                                    <input type="password" name="current_password"
                                                        class="form-control form-control-lg form-control-solid" />
                                                </div>
                                            </div>

                                            <div class="row mb-6">
                                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">New
                                                    Password</label>
                                                <div class="col-lg-8">
                                                    <input type="password" name="new_password"
                                                        class="form-control form-control-lg form-control-solid" />
                                                    <div class="form-text">Password must be at least 8 characters long
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-6">
                                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Confirm
                                                    Password</label>
                                                <div class="col-lg-8">
                                                    <input type="password" name="confirm_password"
                                                        class="form-control form-control-lg form-control-solid" />
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end">
                                                <button type="reset" class="kt-btn kt-btn-light me-3">Reset</button>
                                                <button type="submit" class="kt-btn kt-btn-primary">Update
                                                    Password</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Two-Factor Authentication Card -->
                                <div class="kt-card">
                                    <div class="kt-card-header">
                                        <h3 class="kt-card-title">Two-Factor Authentication</h3>
                                    </div>
                                    <div class="kt-card-content pb-7.5">
                                        <div class="row mb-6">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <i class="ki-filled ki-shield-cross fs-2x text-primary me-4"></i>
                                                        <div>
                                                            <h5 class="mb-1">Secure your account with 2FA</h5>
                                                            <div class="text-muted">Add an extra layer of security to your
                                                                account</div>
                                                        </div>
                                                    </div>
                                                    <label
                                                        class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="two_factor" />
                                                        <span class="form-check-label fw-semibold text-muted">Enable
                                                            2FA</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="separator border-gray-200 my-6"></div>

                                        <div class="row">
                                            <div class="col-12">
                                                <h6 class="mb-4">Login Sessions</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                                                        <thead>
                                                            <tr
                                                                class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                                                <th>Location</th>
                                                                <th>Device</th>
                                                                <th>IP Address</th>
                                                                <th>Time</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>New York, USA</td>
                                                                <td>Chrome - Windows</td>
                                                                <td>192.168.1.1</td>
                                                                <td>23 minutes ago</td>
                                                                <td>
                                                                    <span class="badge badge-light-success">Current</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>London, UK</td>
                                                                <td>Safari - Mac</td>
                                                                <td>192.168.1.2</td>
                                                                <td>2 hours ago</td>
                                                                <td>
                                                                    <a href="#"
                                                                        class="btn btn-sm btn-light-danger">Revoke</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-1">
                                <!-- Security Tips Card -->
                                <div class="kt-card mb-5 lg:mb-7.5">
                                    <div class="kt-card-header">
                                        <h3 class="kt-card-title">Security Tips</h3>
                                    </div>
                                    <div class="kt-card-content pb-7.5">
                                        <div class="d-flex flex-column gap-4">
                                            <div class="d-flex align-items-start">
                                                <i class="ki-filled ki-check-circle fs-3 text-success me-3 mt-1"></i>
                                                <div>
                                                    <h6 class="mb-1">Use a strong password</h6>
                                                    <div class="text-muted fs-7">At least 8 characters with numbers and
                                                        symbols</div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start">
                                                <i class="ki-filled ki-check-circle fs-3 text-success me-3 mt-1"></i>
                                                <div>
                                                    <h6 class="mb-1">Enable 2FA</h6>
                                                    <div class="text-muted fs-7">Add an extra layer of security</div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start">
                                                <i class="ki-filled ki-information-5 fs-3 text-warning me-3 mt-1"></i>
                                                <div>
                                                    <h6 class="mb-1">Monitor login activity</h6>
                                                    <div class="text-muted fs-7">Review and revoke suspicious sessions
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Recent Activity Card -->
                                <div class="kt-card">
                                    <div class="kt-card-header">
                                        <h3 class="kt-card-title">Recent Activity</h3>
                                    </div>
                                    <div class="kt-card-content pb-7.5">
                                        <div class="timeline">
                                            <div class="timeline-item">
                                                <div class="timeline-line w-40px"></div>
                                                <div class="timeline-icon symbol symbol-circle symbol-40px">
                                                    <div class="symbol-label bg-light-success">
                                                        <i class="ki-filled ki-check fs-2 text-success"></i>
                                                    </div>
                                                </div>
                                                <div class="timeline-content mb-10 mt-n1">
                                                    <div class="pe-3 mb-5">
                                                        <div class="fs-6 text-gray-800 fw-semibold mb-2">Password changed
                                                        </div>
                                                        <div class="d-flex align-items-center mt-1 fs-7">
                                                            <div class="text-muted me-2">2 hours ago</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="timeline-item">
                                                <div class="timeline-line w-40px"></div>
                                                <div class="timeline-icon symbol symbol-circle symbol-40px">
                                                    <div class="symbol-label bg-light-warning">
                                                        <i class="ki-filled ki-profile-user fs-2 text-warning"></i>
                                                    </div>
                                                </div>
                                                <div class="timeline-content mb-10 mt-n1">
                                                    <div class="pe-3 mb-5">
                                                        <div class="fs-6 text-gray-800 fw-semibold mb-2">Profile updated
                                                        </div>
                                                        <div class="d-flex align-items-center mt-1 fs-7">
                                                            <div class="text-muted me-2">1 day ago</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications Tab -->
                    <div class="tab-pane fade" id="notifications" role="tabpanel">
                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 lg:gap-6">
                            <div class="col-span-1 xl:col-span-2">
                                <!-- Email Notifications Card -->
                                <div class="kt-card mb-5 lg:mb-7.5">
                                    <div class="kt-card-header">
                                        <h3 class="kt-card-title">Email Notifications</h3>
                                    </div>
                                    <div class="kt-card-content pb-7.5">
                                        <!-- Account Activity -->
                                        <div class="mb-8">
                                            <h5 class="text-gray-900 fw-bold mb-4">Account Activity</h5>

                                            <div class="row mb-6">
                                                <label class="col-lg-8 col-form-label fw-semibold fs-6">
                                                    Profile Updates
                                                    <div class="text-muted fs-7">Get notified when your profile information
                                                        is changed</div>
                                                </label>
                                                <div class="col-lg-4 d-flex justify-content-end">
                                                    <label
                                                        class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="profile_updates" checked />
                                                        <span class="form-check-label"></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="row mb-6">
                                                <label class="col-lg-8 col-form-label fw-semibold fs-6">
                                                    Security Alerts
                                                    <div class="text-muted fs-7">Important security notifications about
                                                        your account</div>
                                                </label>
                                                <div class="col-lg-4 d-flex justify-content-end">
                                                    <label
                                                        class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="security_alerts" checked />
                                                        <span class="form-check-label"></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="row mb-6">
                                                <label class="col-lg-8 col-form-label fw-semibold fs-6">
                                                    Login Notifications
                                                    <div class="text-muted fs-7">Get notified of new device logins</div>
                                                </label>
                                                <div class="col-lg-4 d-flex justify-content-end">
                                                    <label
                                                        class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="login_notifications" />
                                                        <span class="form-check-label"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Communication -->
                                        <div class="separator border-gray-200 my-6"></div>

                                        <div class="mb-8">
                                            <h5 class="text-gray-900 fw-bold mb-4">Communication</h5>

                                            <div class="row mb-6">
                                                <label class="col-lg-8 col-form-label fw-semibold fs-6">
                                                    System Updates
                                                    <div class="text-muted fs-7">Notifications about system maintenance and
                                                        updates</div>
                                                </label>
                                                <div class="col-lg-4 d-flex justify-content-end">
                                                    <label
                                                        class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="system_updates" checked />
                                                        <span class="form-check-label"></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="row mb-6">
                                                <label class="col-lg-8 col-form-label fw-semibold fs-6">
                                                    Newsletter
                                                    <div class="text-muted fs-7">Weekly newsletter with updates and tips
                                                    </div>
                                                </label>
                                                <div class="col-lg-4 d-flex justify-content-end">
                                                    <label
                                                        class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="newsletter" />
                                                        <span class="form-check-label"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="reset" class="kt-btn kt-btn-light me-3">Reset</button>
                                            <button type="submit" class="kt-btn kt-btn-primary">Save Preferences</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-1">
                                <!-- Notification Settings Card -->
                                <div class="kt-card mb-5 lg:mb-7.5">
                                    <div class="kt-card-header">
                                        <h3 class="kt-card-title">Notification Settings</h3>
                                    </div>
                                    <div class="kt-card-content pb-7.5">
                                        <div
                                            class="notice d-flex bg-light-info rounded border-info border border-dashed p-6 mb-6">
                                            <i class="ki-filled ki-information fs-2tx text-info me-4"></i>
                                            <div class="d-flex flex-stack flex-grow-1">
                                                <div class="fw-semibold">
                                                    <h4 class="text-gray-900 fw-bold">Stay Informed</h4>
                                                    <div class="fs-6 text-gray-700">Customize your notifications to stay
                                                        updated with what matters to you.</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column gap-3">
                                            <button type="button" class="kt-btn kt-btn-light-primary kt-btn-sm">
                                                <i class="ki-filled ki-notification-on me-2"></i>
                                                Enable All Notifications
                                            </button>
                                            <button type="button" class="kt-btn kt-btn-light-danger kt-btn-sm">
                                                <i class="ki-filled ki-notification-off me-2"></i>
                                                Disable All Notifications
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Frequency Card -->
                                <div class="kt-card">
                                    <div class="kt-card-header">
                                        <h3 class="kt-card-title">Email Frequency</h3>
                                    </div>
                                    <div class="kt-card-content pb-7.5">
                                        <div class="d-flex flex-column gap-4">
                                            <label class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="frequency"
                                                    value="immediate" checked />
                                                <span class="form-check-label fw-semibold">
                                                    Immediate
                                                    <div class="text-muted fs-7">Get notifications as they happen</div>
                                                </span>
                                            </label>
                                            <label class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="frequency"
                                                    value="daily" />
                                                <span class="form-check-label fw-semibold">
                                                    Daily Summary
                                                    <div class="text-muted fs-7">Once a day digest</div>
                                                </span>
                                            </label>
                                            <label class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="frequency"
                                                    value="weekly" />
                                                <span class="form-check-label fw-semibold">
                                                    Weekly Summary
                                                    <div class="text-muted fs-7">Once a week digest</div>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comparison Links -->
                <div class="form-section text-center mt-5">
                    <h3 class="mb-4" style="color: #1e293b;">🔄 مقارنة الصفحات</h3>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                            <i class="ki-filled ki-arrow-left fs-4 me-2"></i>الصفحة الحالية (القديمة)
                        </a>
                        <a href="{{ route('profile.settings.test') }}" class="btn btn-outline-warning">
                            <i class="ki-filled ki-design-1 fs-4 me-2"></i>الصفحة التجريبية (الأولى)
                        </a>
                        <a href="{{ route('profile.settings.final') }}" class="btn btn-outline-success">
                            <i class="ki-filled ki-rocket fs-4 me-2"></i>الصفحة النهائية الاحترافية 🚀
                        </a>
                        <a href="{{ route('user.profile') }}" class="btn btn-outline-info">
                            <i class="ki-filled ki-profile-user fs-4 me-2"></i>صفحة البروفايل الرئيسية
                        </a>
                    </div>
                </div>

            </div>
        @endsection

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Initialize Bootstrap tabs
                    const tabTriggerList = document.querySelectorAll('#profileTabs button')
                    const tabList = [...tabTriggerList].map(tabTriggerEl => new bootstrap.Tab(tabTriggerEl))

                    // Add smooth transitions
                    document.querySelectorAll('#profileTabs button').forEach(tab => {
                        tab.addEventListener('click', function() {
                            // Update URL without page reload
                            const targetId = this.getAttribute('data-bs-target').substring(1);
                            history.replaceState(null, null, `#${targetId}`);
                        });
                    });

                    // Check URL hash on page load
                    const hash = window.location.hash;
                    if (hash) {
                        const targetTab = document.querySelector(`#profileTabs button[data-bs-target="${hash}"]`);
                        if (targetTab) {
                            new bootstrap.Tab(targetTab).show();
                        }
                    }

                    // Form validation and enhancement
                    const modernInputs = document.querySelectorAll('.form-control-modern');
                    modernInputs.forEach(input => {
                        input.addEventListener('focus', function() {
                            this.closest('.form-section')?.classList.add('focused');
                        });

                        input.addEventListener('blur', function() {
                            this.closest('.form-section')?.classList.remove('focused');
                        });
                    });

                    // Smooth scrolling for better UX
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
                });
            </script>
        @endpush
