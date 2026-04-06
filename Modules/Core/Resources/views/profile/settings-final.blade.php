@extends('layouts.master')

@section('title', 'Account Settings')

@section('content')
    <!-- Hero Section -->
    <div class="position-relative mb-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 0 0 20px 20px;">
        <div class="container-fluid py-5">
            <div class="text-center">
                <img class="rounded-circle border border-3 border-success mb-3"
                    src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('metronic/media/avatars/300-2.png') }}"
                    style="width: 100px; height: 100px; object-fit: cover;">
                <h2 class="text-white fw-bold mb-2">{{ $user->name }}</h2>
                <div class="d-flex justify-content-center flex-wrap gap-3 text-white-50">
                    <div class="d-flex align-items-center">
                        <i class="fa-duotone fa-solid fa-diagram-project me-2"></i>
                        <span>{{ $user->department ?? 'KeenThemes' }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fa-duotone fa-solid fa-envelope me-2"></i>
                        <a class="text-white text-decoration-none" href="mailto:{{ $user->email }}">
                            {{ $user->email }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="h3 text-gray-900 mb-2">Account Settings</h1>
                <p class="text-muted mb-0">Manage your account settings and preferences</p>
            </div>
        </div>

        <!-- Content Area -->
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3 col-xl-2 mb-4">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="nav nav-pills flex-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active rounded-0 border-0 text-start" id="v-pills-overview-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-overview" type="button" role="tab">
                                <i class="fa-duotone fa-solid fa-user-circle me-3"></i>
                                Overview
                            </button>
                            <button class="nav-link rounded-0 border-0 text-start" id="v-pills-personal-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-personal" type="button" role="tab">
                                <i class="fa-duotone fa-solid fa-id-badge me-3"></i>
                                Personal Info
                            </button>
                            <button class="nav-link rounded-0 border-0 text-start" id="v-pills-security-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-security" type="button" role="tab">
                                <i class="fa-duotone fa-solid fa-shield-check me-3"></i>
                                Security
                            </button>
                            <button class="nav-link rounded-0 border-0 text-start" id="v-pills-notifications-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-notifications" type="button" role="tab">
                                <i class="fa-duotone fa-solid fa-bell-status me-3"></i>
                                Notifications
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="col-lg-9 col-xl-10">
                <div class="tab-content" id="v-pills-tabContent">
                    <!-- Overview Tab -->
                    <div class="tab-pane fade show active" id="v-pills-overview" role="tabpanel">
                        <div class="row">
                            <div class="col-xl-8 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Account Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td class="fw-semibold text-muted">Full Name</td>
                                                        <td class="text-end">
                                                            <span class="fw-bold">{{ $user->name }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-semibold text-muted">Email</td>
                                                        <td class="text-end">
                                                            <span class="fw-bold">{{ $user->email }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-semibold text-muted">Department</td>
                                                        <td class="text-end">
                                                            <span class="fw-bold">{{ $user->department ?? 'Not Set' }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-semibold text-muted">Phone</td>
                                                        <td class="text-end">
                                                            <span class="fw-bold">{{ $user->phone ?? 'Not Set' }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-semibold text-muted">Last Updated</td>
                                                        <td class="text-end">
                                                            <span class="fw-bold">{{ $user->updated_at->format('M d, Y') }}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Profile Completion</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="progress flex-grow-1 me-3" style="height: 6px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 85%">
                                                </div>
                                            </div>
                                            <span class="fw-bold text-muted">85%</span>
                                        </div>
                                        <p class="text-muted small mb-0">Complete your profile to get the most out of your
                                            account.</p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Quick Actions</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-primary btn-sm">
                                                <i class="fa-duotone fa-solid fa-id-card me-2"></i>
                                                Edit Profile
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm">
                                                <i class="fa-duotone fa-solid fa-key me-2"></i>
                                                Change Password
                                            </button>
                                            <button type="button" class="btn btn-info btn-sm">
                                                <i class="fa-duotone fa-solid fa-bell-bing me-2"></i>
                                                Notification Settings
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Info Tab -->
                    <div class="tab-pane fade" id="v-pills-personal" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Personal Information</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row mb-4">
                                        <label class="col-lg-3 col-form-label fw-semibold">Full Name</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="name" class="form-control form-control-lg" value="{{ $user->name }}" />
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label class="col-lg-3 col-form-label fw-semibold">Email</label>
                                        <div class="col-lg-9">
                                            <input type="email" name="email" class="form-control form-control-lg" value="{{ $user->email }}" />
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label class="col-lg-3 col-form-label fw-semibold">Phone</label>
                                        <div class="col-lg-9">
                                            <input type="tel" name="phone" class="form-control form-control-lg" value="{{ $user->phone ?? '' }}" />
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="reset" class="btn btn-light">Discard</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div class="tab-pane fade" id="v-pills-security" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Security Settings</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-4">Change Password</h6>
                                <form>
                                    <div class="row mb-4">
                                        <label class="col-lg-3 col-form-label fw-semibold">Current Password</label>
                                        <div class="col-lg-9">
                                            <input type="password" name="current_password" class="form-control form-control-lg" />
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label class="col-lg-3 col-form-label fw-semibold">New Password</label>
                                        <div class="col-lg-9">
                                            <input type="password" name="new_password" class="form-control form-control-lg" />
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
                    <div class="tab-pane fade" id="v-pills-notifications" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Email Notifications</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-lg-8">
                                        <label class="fw-semibold">Profile Updates</label>
                                        <div class="text-muted small">Get notified when your profile information is changed
                                        </div>
                                    </div>
                                    <div class="col-lg-4 text-end">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="profile_updates" checked />
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-8">
                                        <label class="fw-semibold">Security Alerts</label>
                                        <div class="text-muted small">Important security notifications about your account
                                        </div>
                                    </div>
                                    <div class="col-lg-4 text-end">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="security_alerts" checked />
                                        </div>
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
        <div class="text-center py-5">
            <h5 class="mb-4">🔗 روابط التنقل</h5>
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <a href="{{ route('dashboard.core.profile.edit') }}" class="btn btn-outline-primary">
                    <i class="fa-duotone fa-solid fa-arrow-left me-2"></i>الصفحة القديمة
                </a>
                <a href="{{ route('dashboard.core.profile.settings.test') }}" class="btn btn-outline-warning">
                    <i class="fa-duotone fa-solid fa-palette-1 me-2"></i>التجريبية الأولى
                </a>
                <a href="{{ route('dashboard.core.profile.settings.new') }}" class="btn btn-outline-info">
                    <i class="fa-duotone fa-solid fa-palette me-2"></i>التجريبية الثانية
                </a>
                <a href="{{ route('dashboard.core.profile.settings.final') }}" class="btn btn-primary">
                    <i class="fa-duotone fa-solid fa-palette me-2"></i>الصفحة النهائية الاحترافية ⭐
                </a>
                <a href="{{ route('dashboard.core.user.profile') }}" class="btn btn-outline-success">
                    <i class="fa-duotone fa-solid fa-id-card me-2"></i>البروفايل الرئيسي
                </a>
            </div>
        </div>
    </div>
@endsection
