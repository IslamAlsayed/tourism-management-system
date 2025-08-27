@extends('layouts.master')

@section('title', __('main.account_settings'))

@section('content')
    <!-- Hero Section -->
    <div class="position-relative mb-5"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 0 0 20px 20px;">
        <div class="container-fluid py-5">
            <div class="text-center">
                <img class="rounded-circle border border-3 border-success mb-3"
                    src="{{ $user->avatar_url ? asset('storage/' . $user->avatar_url) : asset('metronic/media/avatars/300-2.png') }}"
                    style="width: 100px; height: 100px; object-fit: cover;">
                <h2 class="text-white fw-bold mb-2">{{ $user->name }}</h2>
                <div class="d-flex justify-content-center flex-wrap gap-3 text-white-50">
                    <div class="d-flex align-items-center">
                        <i class="ki-filled ki-abstract-41 me-2"></i>
                        <span>{{ $user->department ?? 'KeenThemes' }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="ki-filled ki-sms me-2"></i>
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
                <h1 class="h3 text-gray-900 mb-2">{{ __('main.account_settings') }}</h1>
                <p class="text-muted mb-0">{{ __('main.manage_account_settings') }}</p>
            </div>
        </div>

        <!-- Content Area -->
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3 col-xl-2 mb-4">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="nav nav-pills flex-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active rounded-0 border-0 text-start" id="v-pills-overview-tab"
                                data-bs-toggle="pill" data-bs-target="#v-pills-overview" type="button" role="tab">
                                <i class="ki-filled ki-profile-circle me-3"></i>
                                {{ __('main.overview') }}
                            </button>
                            <button class="nav-link rounded-0 border-0 text-start" id="v-pills-personal-tab"
                                data-bs-toggle="pill" data-bs-target="#v-pills-personal" type="button" role="tab">
                                <i class="ki-filled ki-badge me-3"></i>
                                {{ __('main.personal_info') }}
                            </button>
                            <button class="nav-link rounded-0 border-0 text-start" id="v-pills-security-tab"
                                data-bs-toggle="pill" data-bs-target="#v-pills-security" type="button" role="tab">
                                <i class="ki-filled ki-shield-tick me-3"></i>
                                {{ __('main.security') }}
                            </button>
                            <button class="nav-link rounded-0 border-0 text-start" id="v-pills-notifications-tab"
                                data-bs-toggle="pill" data-bs-target="#v-pills-notifications" type="button" role="tab">
                                <i class="ki-filled ki-notification-status me-3"></i>
                                {{ __('main.notifications') }}
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
                                        <h5 class="card-title mb-0">{{ __('main.account_information') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td class="fw-semibold text-muted">{{ __('main.full_name') }}</td>
                                                        <td class="text-end">
                                                            <span class="fw-bold">{{ $user->name }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-semibold text-muted">{{ __('main.email') }}</td>
                                                        <td class="text-end">
                                                            <span class="fw-bold">{{ $user->email }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-semibold text-muted">{{ __('main.department') }}</td>
                                                        <td class="text-end">
                                                            <span
                                                                class="fw-bold">{{ $user->department ?? __('main.not_set') }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-semibold text-muted">{{ __('main.phone') }}</td>
                                                        <td class="text-end">
                                                            <span
                                                                class="fw-bold">{{ $user->phone ?? __('main.not_set') }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-semibold text-muted">{{ __('main.last_updated') }}
                                                        </td>
                                                        <td class="text-end">
                                                            <span
                                                                class="fw-bold">{{ $user->updated_at->format('M d, Y') }}</span>
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
                                        <h6 class="card-title mb-0">{{ __('main.profile_completion') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="progress flex-grow-1 me-3" style="height: 6px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 85%">
                                                </div>
                                            </div>
                                            <span class="fw-bold text-muted">85%</span>
                                        </div>
                                        <p class="text-muted small mb-0">{{ __('main.complete_profile_message') }}</p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">{{ __('main.quick_actions') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-primary btn-sm">
                                                <i class="ki-filled ki-profile-user me-2"></i>
                                                {{ __('main.edit_profile') }}
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm">
                                                <i class="ki-filled ki-key me-2"></i>
                                                {{ __('main.change_password') }}
                                            </button>
                                            <button type="button" class="btn btn-info btn-sm">
                                                <i class="ki-filled ki-notification-bing me-2"></i>
                                                {{ __('main.notification_settings') }}
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
                                <h5 class="card-title mb-0">{{ __('main.personal_information') }}</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row mb-4">
                                        <label
                                            class="col-lg-3 col-form-label fw-semibold">{{ __('main.full_name') }}</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="name" class="form-control form-control-lg"
                                                placeholder="{{ __('main.full_name') }}" value="{{ $user->name }}" />
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label class="col-lg-3 col-form-label fw-semibold">{{ __('main.email') }}</label>
                                        <div class="col-lg-9">
                                            <input type="email" name="email" class="form-control form-control-lg"
                                                placeholder="{{ __('main.email_address') }}"
                                                value="{{ $user->email }}" />
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label class="col-lg-3 col-form-label fw-semibold">{{ __('main.phone') }}</label>
                                        <div class="col-lg-9">
                                            <input type="tel" name="phone" class="form-control form-control-lg"
                                                placeholder="{{ __('main.phone_number') }}"
                                                value="{{ $user->phone ?? '' }}" />
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="reset" class="btn btn-light">{{ __('main.discard') }}</button>
                                        <button type="submit"
                                            class="btn btn-primary">{{ __('main.save_changes') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div class="tab-pane fade" id="v-pills-security" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ __('main.security_settings') }}</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-4">{{ __('main.change_password') }}</h6>
                                <form>
                                    <div class="row mb-4">
                                        <label
                                            class="col-lg-3 col-form-label fw-semibold">{{ __('main.current_password') }}</label>
                                        <div class="col-lg-9">
                                            <input type="password" name="current_password"
                                                class="form-control form-control-lg"
                                                placeholder="{{ __('main.enter_current_password') }}" />
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label
                                            class="col-lg-3 col-form-label fw-semibold">{{ __('main.new_password') }}</label>
                                        <div class="col-lg-9">
                                            <input type="password" name="new_password"
                                                class="form-control form-control-lg"
                                                placeholder="{{ __('main.enter_new_password') }}" />
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit"
                                            class="btn btn-primary">{{ __('main.update_password') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications Tab -->
                    <div class="tab-pane fade" id="v-pills-notifications" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ __('main.email_notifications') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-lg-8">
                                        <label class="fw-semibold">{{ __('main.profile_updates') }}</label>
                                        <div class="text-muted small">{{ __('main.profile_updates_desc') }}</div>
                                    </div>
                                    <div class="col-lg-4 text-end">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="profile_updates"
                                                checked />
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-8">
                                        <label class="fw-semibold">{{ __('main.security_alerts') }}</label>
                                        <div class="text-muted small">{{ __('main.security_alerts_desc') }}</div>
                                    </div>
                                    <div class="col-lg-4 text-end">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="security_alerts"
                                                checked />
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit"
                                        class="btn btn-primary">{{ __('main.save_preferences') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="text-center py-5">
            <h5 class="mb-4">🔗 {{ __('main.navigation_links') }}</h5>
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                    <i class="ki-filled ki-arrow-left me-2"></i>{{ __('main.old_page') }}
                </a>
                <a href="{{ route('profile.settings.test') }}" class="btn btn-outline-warning">
                    <i class="ki-filled ki-design-1 me-2"></i>{{ __('main.first_test') }}
                </a>
                <a href="{{ route('profile.settings.new') }}" class="btn btn-outline-info">
                    <i class="ki-filled ki-design me-2"></i>{{ __('main.second_test') }}
                </a>
                <a href="{{ route('profile.settings.final') }}" class="btn btn-primary">
                    <i class="ki-filled ki-design me-2"></i>{{ __('main.final_professional_page') }} ⭐
                </a>
                <a href="{{ route('user.profile') }}" class="btn btn-outline-success">
                    <i class="ki-filled ki-profile-user me-2"></i>{{ __('main.main_profile') }}
                </a>
            </div>
        </div>
    </div>
@endsection
