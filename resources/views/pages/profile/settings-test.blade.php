@extends('layouts.master')

@section('title', 'Profile Settings - Professional')

@push('styles')
    <style>
        .profile-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            color: white;
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .profile-hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(50%, -50%);
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid #e4e6ea;
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .stat-card.primary {
            border-left: 4px solid #3366ff;
        }

        .stat-card.success {
            border-left: 4px solid #50cd89;
        }

        .stat-card.warning {
            border-left: 4px solid #ffc700;
        }

        .stat-card.info {
            border-left: 4px solid #009ef7;
        }

        .nav-pills-custom .nav-link {
            background: transparent;
            border: 2px solid #e4e6ea;
            color: #7e8299;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 10px;
            margin-right: 10px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .nav-pills-custom .nav-link.active {
            background: #3366ff;
            border-color: #3366ff;
            color: white;
            box-shadow: 0 4px 15px rgba(51, 102, 255, 0.3);
        }

        .nav-pills-custom .nav-link:hover:not(.active) {
            border-color: #3366ff;
            color: #3366ff;
            background: rgba(51, 102, 255, 0.1);
        }

        .form-section {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid #e4e6ea;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            color: #181c32;
            font-weight: 700;
            font-size: 1.35rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
            color: #3366ff;
        }

        .custom-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            object-fit: cover;
        }

        .btn-upload {
            background: #3366ff;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-upload:hover {
            background: #2952cc;
            transform: translateY(-2px);
        }

        .form-control-modern {
            border: 2px solid #e4e6ea;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control-modern:focus {
            border-color: #3366ff;
            box-shadow: 0 0 0 0.2rem rgba(51, 102, 255, 0.15);
        }

        .timeline-modern {
            position: relative;
            padding-left: 2rem;
        }

        .timeline-modern::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #3366ff, #e4e6ea);
        }

        .timeline-item-modern {
            position: relative;
            margin-bottom: 2rem;
        }

        .timeline-item-modern::before {
            content: '';
            position: absolute;
            left: -25px;
            top: 8px;
            width: 12px;
            height: 12px;
            background: #3366ff;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 10px rgba(51, 102, 255, 0.3);
        }
    </style>
@endpush

@section('content')
    <div class="kt-container-fixed">

        <!-- Hero Section -->
        <div class="profile-hero">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('metronic/media/avatars/300-2.png') }}"
                            alt="Profile Picture" class="custom-avatar me-4">
                        <div>
                            <h1 class="text-white fw-bold mb-2">{{ $user->name }}</h1>
                            <div class="d-flex align-items-center text-white opacity-75 mb-3">
                                <i class="ki-filled ki-briefcase fs-4 me-2"></i>
                                <span class="me-4">{{ $user->position ?? 'Software Developer' }}</span>
                                <i class="ki-filled ki-geolocation fs-4 me-2"></i>
                                <span>{{ $user->address ?? 'Amman, Jordan' }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="ki-filled ki-verify fs-4 me-2"></i>
                                <span class="text-white opacity-75">Verified Account</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="text-center">
                        <div class="badge badge-light-success fs-7 fw-bold px-3 py-2">
                            <i class="ki-filled ki-check-circle me-1"></i>
                            Profile Complete
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-8">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card primary">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="text-primary">
                            <i class="ki-filled ki-abstract-26 fs-2x"></i>
                        </div>
                        <div class="text-end">
                            <div class="fs-2 fw-bold text-gray-800">15</div>
                            <div class="fs-7 fw-semibold text-muted">Projects</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card success">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="text-success">
                            <i class="ki-filled ki-abstract-35 fs-2x"></i>
                        </div>
                        <div class="text-end">
                            <div class="fs-2 fw-bold text-gray-800">8</div>
                            <div class="fs-7 fw-semibold text-muted">Active</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card warning">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="text-warning">
                            <i class="ki-filled ki-abstract-13 fs-2x"></i>
                        </div>
                        <div class="text-end">
                            <div class="fs-2 fw-bold text-gray-800">42</div>
                            <div class="fs-7 fw-semibold text-muted">Team Members</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card info">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="text-info">
                            <i class="ki-filled ki-abstract-11 fs-2x"></i>
                        </div>
                        <div class="text-end">
                            <div class="fs-2 fw-bold text-gray-800">96%</div>
                            <div class="fs-7 fw-semibold text-muted">Success Rate</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Navigation -->
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills nav-pills-custom mb-8" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="overview-tab" data-bs-toggle="pill" data-bs-target="#overview"
                            type="button" role="tab">
                            <i class="ki-filled ki-element-11 me-2"></i>
                            Overview
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="personal-tab" data-bs-toggle="pill" data-bs-target="#personal"
                            type="button" role="tab">
                            <i class="ki-filled ki-profile-user me-2"></i>
                            Personal Info
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="security-tab" data-bs-toggle="pill" data-bs-target="#security"
                            type="button" role="tab">
                            <i class="ki-filled ki-security-user me-2"></i>
                            Security
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="notifications-tab" data-bs-toggle="pill"
                            data-bs-target="#notifications" type="button" role="tab">
                            <i class="ki-filled ki-notification-bing me-2"></i>
                            Notifications
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="profileTabsContent">

            <!-- Overview Tab -->
            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="ki-filled ki-user"></i>
                                Profile Summary
                            </h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="fs-7 fw-bold text-muted mb-2">FULL NAME</label>
                                    <div class="fs-6 fw-semibold text-gray-800">{{ $user->name }}</div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="fs-7 fw-bold text-muted mb-2">EMAIL ADDRESS</label>
                                    <div class="fs-6 fw-semibold text-gray-800">{{ $user->email }}</div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="fs-7 fw-bold text-muted mb-2">PHONE NUMBER</label>
                                    <div class="fs-6 fw-semibold text-gray-800">{{ $user->phone ?? 'Not provided' }}</div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="fs-7 fw-bold text-muted mb-2">DEPARTMENT</label>
                                    <div class="fs-6 fw-semibold text-gray-800">{{ $user->department ?? 'Not specified' }}
                                    </div>
                                </div>
                                <div class="col-12 mb-4">
                                    <label class="fs-7 fw-bold text-muted mb-2">BIO</label>
                                    <div class="fs-6 fw-semibold text-gray-800">{{ $user->bio ?? 'No bio provided yet.' }}
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('profile.edit') }}" class="btn-upload">
                                    <i class="ki-filled ki-pencil me-2"></i>
                                    Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="ki-filled ki-chart-line-up-2"></i>
                                Recent Activity
                            </h3>
                            <div class="timeline-modern">
                                <div class="timeline-item-modern">
                                    <div class="fw-semibold text-gray-800 fs-6">Profile Updated</div>
                                    <div class="text-muted fs-7">
                                        {{ $user->updated_at ? $user->updated_at->diffForHumans() : '2 hours ago' }}</div>
                                    <div class="text-muted fs-7 mt-1">Personal information has been updated</div>
                                </div>
                                <div class="timeline-item-modern">
                                    <div class="fw-semibold text-gray-800 fs-6">Account Created</div>
                                    <div class="text-muted fs-7">
                                        {{ $user->created_at ? $user->created_at->diffForHumans() : '1 week ago' }}</div>
                                    <div class="text-muted fs-7 mt-1">Welcome to the platform!</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Info Tab -->
            <div class="tab-pane fade" id="personal" role="tabpanel">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="ki-filled ki-badge"></i>
                                Personal Information
                            </h3>
                            <form>
                                <!-- Photo Upload -->
                                <div class="row mb-6">
                                    <div class="col-12">
                                        <label class="fw-bold fs-6 mb-4">Profile Picture</label>
                                        <div class="d-flex align-items-center gap-4">
                                            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('metronic/media/avatars/300-2.png') }}"
                                                alt="photo" class="custom-avatar">
                                            <div>
                                                <button type="button" class="btn-upload me-3">
                                                    <i class="ki-filled ki-cloud-upload me-2"></i>
                                                    Upload New Photo
                                                </button>
                                                <button type="button" class="btn btn-light-danger btn-sm">
                                                    Remove
                                                </button>
                                                <div class="form-text mt-2">Allowed JPG, GIF or PNG. Max size 2MB</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Name Fields -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">First Name *</label>
                                        <input type="text" class="form-control form-control-modern"
                                            value="{{ explode(' ', $user->name)[0] ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Last Name *</label>
                                        <input type="text" class="form-control form-control-modern"
                                            value="{{ explode(' ', $user->name)[1] ?? '' }}">
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Email Address *</label>
                                        <input type="email" class="form-control form-control-modern"
                                            value="{{ $user->email }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Phone Number</label>
                                        <input type="tel" class="form-control form-control-modern"
                                            value="{{ $user->phone ?? '' }}">
                                    </div>
                                </div>

                                <!-- Work Information -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Department</label>
                                        <input type="text" class="form-control form-control-modern"
                                            value="{{ $user->department ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Position</label>
                                        <input type="text" class="form-control form-control-modern"
                                            value="{{ $user->position ?? '' }}">
                                    </div>
                                </div>

                                <!-- Bio -->
                                <div class="row mb-6">
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Bio</label>
                                        <input id="bio" type="hidden" name="bio"
                                            value="{{ $user->bio }}">
                                        <trix-editor input="bio"></trix-editor>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-3">
                                    <button type="button" class="btn btn-light">Cancel</button>
                                    <button type="submit" class="btn-upload">
                                        <i class="ki-filled ki-check me-2"></i>
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="ki-filled ki-information"></i>
                                Profile Tips
                            </h3>
                            <div class="notice notice-light-primary rounded border-primary border border-dashed p-4">
                                <div class="notice-icon">
                                    <i class="ki-filled ki-information-5 fs-2tx text-primary"></i>
                                </div>
                                <div class="notice-content">
                                    <div class="fw-semibold">Complete Your Profile</div>
                                    <div class="fs-7 text-muted">Adding more information helps colleagues find and connect
                                        with you.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Section -->
            <div id="security" class="mb-10">
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">Security Settings</h3>
                    </div>
                    <div class="kt-card-body">
                        <!-- Change Password -->
                        <div class="row mb-8">
                            <div class="col-12">
                                <h4 class="fw-bold mb-4">Change Password</h4>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label fw-semibold fs-6">Current Password</label>
                                <input type="password" class="form-control form-control-lg form-control-solid" />
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label fw-semibold fs-6">New Password</label>
                                <input type="password" class="form-control form-control-lg form-control-solid" />
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label fw-semibold fs-6">Confirm Password</label>
                                <input type="password" class="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>

                        <!-- 2FA Section -->
                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6 mb-6">
                            <i class="ki-filled ki-information fs-2tx text-warning me-4"></i>
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-semibold">
                                    <h4 class="text-gray-900 fw-bold">Two-Factor Authentication</h4>
                                    <div class="fs-6 text-gray-700">Add an extra layer of security to your account by
                                        enabling two-factor authentication.</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="kt-btn kt-btn-primary">Update Password</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications Section -->
            <div id="notifications" class="mb-10">
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">Notification Preferences</h3>
                    </div>
                    <div class="kt-card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6">
                                <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase">
                                        <th class="min-w-125px">Type</th>
                                        <th class="min-w-125px">Email</th>
                                        <th class="min-w-125px">SMS</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-semibold">
                                    <tr>
                                        <td>Security Alerts</td>
                                        <td>
                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" checked />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" checked />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Account Activity</td>
                                        <td>
                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Marketing Emails</td>
                                        <td>
                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" checked />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" />
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-6">
                            <button type="reset" class="kt-btn kt-btn-light me-3">Reset</button>
                            <button type="submit" class="kt-btn kt-btn-primary">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>

    <!-- Comparison Links -->
    <div class="kt-card mt-10">
        <div class="kt-card-body text-center p-9">
            <h3 class="mb-5">🔄 مقارنة الصفحات</h3>
            <div class="d-flex justify-content-center gap-4 flex-wrap">
                <a href="{{ route('profile.edit') }}" class="kt-btn kt-btn-light kt-btn-primary">
                    <i class="ki-filled ki-arrow-left fs-3 me-1"></i>الصفحة الحالية (القديمة)
                </a>
                <a href="{{ route('profile.settings.test') }}" class="kt-btn kt-btn-primary">
                    <i class="ki-filled ki-design-1 fs-3 me-1"></i>هذه الصفحة (التجريبية الأولى)
                </a>
                <a href="{{ route('profile.settings.new') }}" class="kt-btn kt-btn-light kt-btn-success">
                    <i class="ki-filled ki-design fs-3 me-1"></i>الصفحة الاحترافية الجديدة ⭐
                </a>
                <a href="{{ route('user.profile') }}" class="kt-btn kt-btn-light kt-btn-info">
                    <i class="ki-filled ki-profile-user fs-3 me-1"></i>صفحة البروفايل الرئيسية
                </a>
            </div>
        </div>
    </div>

    </div>
@endsection

@push('scripts')
    <script>
        // Smooth scrolling for navigation
        document.addEventListener('DOMContentLoaded', function() {
            // Get all menu links
            const menuLinks = document.querySelectorAll('.kt-menu-link[data-kt-scroll-toggle]');

            menuLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all menu items
                    document.querySelectorAll('.kt-menu-item').forEach(item => {
                        item.classList.remove('here');
                    });

                    // Add active class to clicked menu item
                    this.closest('.kt-menu-item').classList.add('here');

                    // Get target section
                    const targetId = this.getAttribute('href').substring(1);
                    const targetSection = document.getElementById(targetId);

                    if (targetSection) {
                        // Smooth scroll to target
                        targetSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Handle form switches
            document.querySelectorAll('.form-check-input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    console.log('Notification setting changed:', this.checked);
                });
            });
        });
    </script>
@endpush
