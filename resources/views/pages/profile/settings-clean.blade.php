@extends('layouts.master')

@section('title', 'Account Settings')

@section('content')
    <!-- Hero Section with Metronic Background -->
    <div class="bg-center bg-cover bg-no-repeat"
        style="background-image: url('{{ asset('metronic/media/images/2600x1200/bg-1.png') }}');">
        <div class="container-fixed">
            <div class="flex flex-col items-center gap-2 lg:gap-3.5 py-4 lg:pt-5 lg:pb-10">
                <img class="rounded-full border-3 border-success size-[100px] shrink-0"
                    src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('metronic/media/avatars/300-2.png') }}">
                <div class="flex items-center gap-1.5">
                    <div class="text-lg leading-5 font-semibold text-gray-900">
                        {{ $user->name }}
                    </div>
                </div>
                <div class="flex flex-wrap justify-center gap-1 lg:gap-4.5 text-sm">
                    <div class="flex gap-1.25 items-center">
                        <i class="ki-filled ki-abstract-41 text-gray-500 text-sm"></i>
                        <span class="text-gray-600 font-medium">
                            {{ $user->department ?? 'KeenThemes' }}
                        </span>
                    </div>
                    <div class="flex gap-1.25 items-center">
                        <i class="ki-filled ki-sms text-gray-500 text-sm"></i>
                        <a class="text-gray-600 font-medium hover:text-primary" href="mailto:{{ $user->email }}">
                            {{ $user->email }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-semibold leading-none text-gray-900">Account Settings</h1>
                <div class="flex items-center gap-2 text-sm font-medium text-gray-600">
                    <span>Manage your account settings and preferences</span>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-5 lg:gap-7.5">
            <!-- Sidebar Navigation -->
            <div class="col-span-1">
                <div class="card card-bordered">
                    <div class="card-body p-0">
                        <div
                            class="menu menu-default menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-active-bg-light-primary menu-hover-bg-light-primary menu-here-bg-light-primary menu-here-text-primary menu-state-text-primary">
                            <div class="menu-item">
                                <button class="menu-link active" data-bs-toggle="pill" data-bs-target="#overview"
                                    type="button" role="tab">
                                    <span class="menu-icon">
                                        <i class="ki-filled ki-profile-circle fs-2"></i>
                                    </span>
                                    <span class="menu-title">Overview</span>
                                </button>
                            </div>
                            <div class="menu-item">
                                <button class="menu-link" data-bs-toggle="pill" data-bs-target="#personal" type="button"
                                    role="tab">
                                    <span class="menu-icon">
                                        <i class="ki-filled ki-badge fs-2"></i>
                                    </span>
                                    <span class="menu-title">Personal Info</span>
                                </button>
                            </div>
                            <div class="menu-item">
                                <button class="menu-link" data-bs-toggle="pill" data-bs-target="#security" type="button"
                                    role="tab">
                                    <span class="menu-icon">
                                        <i class="ki-filled ki-shield-tick fs-2"></i>
                                    </span>
                                    <span class="menu-title">Security</span>
                                </button>
                            </div>
                            <div class="menu-item">
                                <button class="menu-link" data-bs-toggle="pill" data-bs-target="#notifications"
                                    type="button" role="tab">
                                    <span class="menu-icon">
                                        <i class="ki-filled ki-notification-status fs-2"></i>
                                    </span>
                                    <span class="menu-title">Notifications</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="col-span-1 lg:col-span-4">
                <div class="tab-content">
                    <!-- Overview Tab -->
                    <div class="tab-pane fade show active" id="overview" role="tabpanel">
                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 lg:gap-7.5">
                            <div class="col-span-1 xl:col-span-2">
                                <div class="card card-bordered">
                                    <div class="card-header">
                                        <h3 class="card-title">Account Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-row-dashed table-row-gray-300 gy-7">
                                                <tbody>
                                                    <tr>
                                                        <td class="fw-semibold text-muted">Full Name</td>
                                                        <td class="text-end">
                                                            <span
                                                                class="fw-bold text-gray-800 fs-6">{{ $user->name }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-semibold text-muted">Email</td>
                                                        <td class="text-end">
                                                            <span
                                                                class="fw-bold text-gray-800 fs-6">{{ $user->email }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-semibold text-muted">Department</td>
                                                        <td class="text-end">
                                                            <span
                                                                class="fw-bold text-gray-800 fs-6">{{ $user->department ?? 'Not Set' }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-semibold text-muted">Phone</td>
                                                        <td class="text-end">
                                                            <span
                                                                class="fw-bold text-gray-800 fs-6">{{ $user->phone ?? 'Not Set' }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-semibold text-muted">Last Updated</td>
                                                        <td class="text-end">
                                                            <span
                                                                class="fw-bold text-gray-800 fs-6">{{ $user->updated_at->format('M d, Y') }}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-1">
                                <div class="card card-bordered mb-5 lg:mb-7.5">
                                    <div class="card-header">
                                        <h3 class="card-title">Profile Completion</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-5">
                                            <div class="progress h-6px w-100 me-3">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 85%"
                                                    aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="fs-7 fw-bold text-gray-400">85%</span>
                                        </div>
                                        <p class="text-gray-600 fs-7">Complete your profile to get the most out of your
                                            account.</p>
                                    </div>
                                </div>

                                <div class="card card-bordered">
                                    <div class="card-header">
                                        <h3 class="card-title">Quick Actions</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-column gap-3">
                                            <button type="button" class="btn btn-primary btn-sm">
                                                <i class="ki-filled ki-profile-user me-2"></i>
                                                Edit Profile
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm">
                                                <i class="ki-filled ki-key me-2"></i>
                                                Change Password
                                            </button>
                                            <button type="button" class="btn btn-info btn-sm">
                                                <i class="ki-filled ki-notification-bing me-2"></i>
                                                Notification Settings
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Info Tab -->
                    <div class="tab-pane fade" id="personal" role="tabpanel">
                        <div class="card card-bordered">
                            <div class="card-header">
                                <h3 class="card-title">Personal Information</h3>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Full Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" name="name"
                                                class="form-control form-control-lg form-control-solid"
                                                value="{{ $user->name }}" />
                                        </div>
                                    </div>

                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Email</label>
                                        <div class="col-lg-8">
                                            <input type="email" name="email"
                                                class="form-control form-control-lg form-control-solid"
                                                value="{{ $user->email }}" />
                                        </div>
                                    </div>

                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Phone</label>
                                        <div class="col-lg-8">
                                            <input type="tel" name="phone"
                                                class="form-control form-control-lg form-control-solid"
                                                value="{{ $user->phone ?? '' }}" />
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="reset" class="btn btn-light me-3">Discard</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div class="tab-pane fade" id="security" role="tabpanel">
                        <div class="card card-bordered">
                            <div class="card-header">
                                <h3 class="card-title">Security Settings</h3>
                            </div>
                            <div class="card-body">
                                <h5 class="mb-4">Change Password</h5>
                                <form>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Current Password</label>
                                        <div class="col-lg-8">
                                            <input type="password" name="current_password"
                                                class="form-control form-control-lg form-control-solid" />
                                        </div>
                                    </div>

                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">New Password</label>
                                        <div class="col-lg-8">
                                            <input type="password" name="new_password"
                                                class="form-control form-control-lg form-control-solid" />
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Update Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications Tab -->
                    <div class="tab-pane fade" id="notifications" role="tabpanel">
                        <div class="card card-bordered">
                            <div class="card-header">
                                <h3 class="card-title">Email Notifications</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-6">
                                    <label class="col-lg-8 col-form-label fw-semibold fs-6">
                                        Profile Updates
                                        <div class="text-muted fs-7">Get notified when your profile information is changed
                                        </div>
                                    </label>
                                    <div class="col-lg-4 d-flex justify-content-end">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="profile_updates"
                                                checked />
                                            <span class="form-check-label"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="row mb-6">
                                    <label class="col-lg-8 col-form-label fw-semibold fs-6">
                                        Security Alerts
                                        <div class="text-muted fs-7">Important security notifications about your account
                                        </div>
                                    </label>
                                    <div class="col-lg-4 d-flex justify-content-end">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="security_alerts"
                                                checked />
                                            <span class="form-check-label"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Save Preferences</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="flex flex-wrap items-center justify-center gap-5 py-10">
            <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">🔗 روابط التنقل</h3>
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline btn-outline-primary">
                        <i class="ki-filled ki-arrow-left me-2"></i>الصفحة القديمة
                    </a>
                    <a href="{{ route('profile.settings.test') }}" class="btn btn-outline btn-outline-warning">
                        <i class="ki-filled ki-design-1 me-2"></i>التجريبية الأولى
                    </a>
                    <a href="{{ route('profile.settings.new') }}" class="btn btn-outline btn-outline-info">
                        <i class="ki-filled ki-design me-2"></i>التجريبية الثانية
                    </a>
                    <a href="{{ route('profile.settings.final') }}" class="btn btn-primary">
                        <i class="ki-filled ki-design me-2"></i>الصفحة النهائية الاحترافية ⭐
                    </a>
                    <a href="{{ route('user.profile') }}" class="btn btn-outline btn-outline-success">
                        <i class="ki-filled ki-profile-user me-2"></i>البروفايل الرئيسي
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tabs for pills navigation
            const tabTriggerList = document.querySelectorAll('[data-bs-toggle="pill"]')

            // Add smooth transitions and URL updates
            tabTriggerList.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all menu links
                    document.querySelectorAll('.menu-link').forEach(link => {
                        link.classList.remove('active');
                    });

                    // Add active class to clicked link
                    this.classList.add('active');

                    // Show the corresponding tab pane
                    const targetPane = document.querySelector(this.getAttribute('data-bs-target'));
                    if (targetPane) {
                        // Hide all tab panes
                        document.querySelectorAll('.tab-pane').forEach(pane => {
                            pane.classList.remove('show', 'active');
                        });

                        // Show target pane
                        targetPane.classList.add('show', 'active');

                        // Update URL hash
                        const targetId = this.getAttribute('data-bs-target').substring(1);
                        history.replaceState(null, null, `#${targetId}`);
                    }
                });
            });

            // Check URL hash on page load
            const hash = window.location.hash;
            if (hash) {
                const targetTab = document.querySelector(`[data-bs-target="${hash}"]`);
                if (targetTab) {
                    targetTab.click();
                }
            }
        });
    </script>
@endpush
