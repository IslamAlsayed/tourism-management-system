@extends('layouts.master')

@section('title', __('main.integration_settings'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.integration_settings') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.configure_third_party_services') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('settings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.settings')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                <!-- Google Maps Integration -->
                <div class="kt-card h-fit"
                    style="background: var(--color-{{ $settings->app_google_maps_key == 1 ? '' : 'yellow' }}-100);">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.google_maps_api') }}
                            <span class="inline-block font-medium px-2 py-0.5 rounded-full ms-2 bg-danger/10 text-red-600">
                                {{ __('sidebar.soon') }}
                            </span>
                        </h3>
                    </div>
                    <div class="kt-card-body disabled">
                        <div class="space-y-6 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div class="p-4 ps-0 rounded bg-info-light">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-info-circle text-xl text-info"></i>
                                        <div>
                                            <div class="font-semibold">
                                                {{ __('main.configured_in_env') }}
                                                @if (getActiveUser()->is_admin)
                                                    <span class="font-semibold text-primary underline cursor-pointer"
                                                        toggle-button style="user-select: none;"
                                                        onclick="document.getElementById('google-maps-api')?.classList.toggle('hidden');">
                                                        {{ __('main.edit') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-sm">{{ __('main.get_key_from_google_cloud') }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="kt-label mb-2">{{ __('main.current_status') }}</label>
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="kt-badge kt-badge-{{ $settings->app_google_maps_key ? 'success' : 'danger' }}">
                                            {{ $settings->app_google_maps_key ? __('main.connected') : __('main.not_connected') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if (getActiveUser()->is_admin)
                                <form method="POST" action="{{ route('settings.update', $settings->id) }}"
                                    class="mt-4 hidden" id="google-maps-api">
                                    @csrf
                                    @method('PUT')

                                    <!-- Ably Key Integration -->
                                    <div class="kt-card">
                                        <div class="kt-card-body p-6">
                                            <div class="space-y-6">
                                                <div>
                                                    <label class="kt-label mb-2">{{ __('main.api_key') }}</label>
                                                    <input type="text" name="app_google_maps_key"
                                                        class="kt-input h-[45px]"
                                                        value="{{ isset($settings->app_google_maps_key) && $settings->app_google_maps_key ? $settings->app_google_maps_key : config('app.google_maps_key') }}"
                                                        placeholder="YfoutQ.XXXXXXXXXXXXXXXXXXXXXXXXXXXX" />
                                                    <div class="text-xs text-secondary-foreground mt-1">
                                                        {{ __('main.get_key_from_google_cloud') }}
                                                        <a href="https://cloud.google.com/maps-platform/" target="_blank"
                                                            rel="noopener noreferrer">cloud.google.com</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="flex items-center justify-start gap-4 px-6 pb-6">
                                            <button type="submit" class="kt-btn kt-btn-primary"
                                                wire:confirm="Are you sure you want to save these changes?">
                                                <i class="fas fa-check text-sm me-2"></i>
                                                {{ __('main.save') }}
                                            </button>
                                            <span class="kt-btn bg-danger"
                                                onclick="document.getElementById('google-maps-api')?.classList.add('hidden');">
                                                <i class="fas fa-times text-sm me-2"></i>
                                                {{ __('main.cancel') }}
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Ably Integration (Real-time Notifications) -->
                <div class="kt-card h-fit"
                    style="background: var(--color-{{ $settings->app_ably_key ? '' : 'yellow' }}-100);">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.ably_realtime') }}</h3>
                    </div>
                    <div class="kt-card-body">
                        <div class="space-y-6 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div class="p-4 ps-0 rounded bg-info-light">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-info-circle text-xl text-info"></i>
                                        <div>
                                            <div class="font-semibold">
                                                {{ __('main.configured_in_env') }}
                                                @if (getActiveUser()->is_admin)
                                                    <span class="font-semibold text-primary underline cursor-pointer"
                                                        toggle-button style="user-select: none;"
                                                        onclick="document.getElementById('ably-key')?.classList.toggle('hidden');">
                                                        {{ __('main.edit') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-sm">{{ __('main.ably_key_configured_message') }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="kt-label mb-2">{{ __('main.current_status') }}</label>
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="kt-badge kt-badge-{{ $settings->app_ably_key ? 'success' : 'danger' }}">
                                            {{ $settings->app_ably_key ? __('main.connected') : __('main.not_connected') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if (getActiveUser()->is_admin)
                                <form method="POST" action="{{ route('settings.update', $settings->id) }}"
                                    class="mt-4 hidden" id="ably-key">
                                    @csrf
                                    @method('PUT')

                                    <!-- Ably Key Integration -->
                                    <div class="kt-card">
                                        <div class="kt-card-body p-4">
                                            <div class="space-y-6">
                                                <div>
                                                    <label class="kt-label mb-2">{{ __('main.api_key') }}</label>
                                                    <input type="text" name="app_ably_key" class="kt-input h-[45px]"
                                                        value="{{ isset($settings->app_ably_key) && $settings->app_ably_key ? $settings->app_ably_key : config('app.ably_key') }}"
                                                        placeholder="YfoutQ.XXXXXXXXXXXXXXXXXXXXXXXXXXXX" />
                                                    <div class="text-xs text-secondary-foreground mt-1">
                                                        {{ __('main.get_key_from_ably') }}
                                                        <a href="https://ably.com" target="_blank"
                                                            rel="noopener noreferrer">ably.com</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="flex items-center justify-start gap-4 px-6 pb-6">
                                            <button type="submit" class="kt-btn kt-btn-primary"
                                                wire:confirm="Are you sure you want to save these changes?">
                                                <i class="fas fa-check text-sm me-2"></i>
                                                {{ __('main.save') }}
                                            </button>
                                            <span class="kt-btn bg-danger"
                                                onclick="document.getElementById('ably-key')?.classList.add('hidden');">
                                                <i class="fas fa-times text-sm me-2"></i>
                                                {{ __('main.cancel') }}
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Email (SMTP) Settings --}}
            <form method="POST" action="{{ route('settings.update', $settings->id) }}" id="smtp-settings-form">
                @csrf
                @method('PUT')

                <!-- Email (SMTP) Settings -->
                <div class="kt-card">
                    <div class="kt-card-header px-6">
                        <h3 class="kt-card-title">{{ __('main.smtp_settings') }}</h3>
                    </div>
                    <div class="kt-card-body p-6">
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="kt-label mb-2">{{ __('main.smtp_host') }}</label>
                                    <input type="text" name="app_smtp_host" class="kt-input h-[45px]"
                                        value="{{ $settings->app_smtp_host ?? config('mail.mailers.smtp.host') }}"
                                        placeholder="smtp.gmail.com" />
                                </div>

                                <div>
                                    <label class="kt-label mb-2">{{ __('main.smtp_port') }}</label>
                                    <input type="number" name="app_smtp_port" class="kt-input h-[45px]"
                                        value="{{ $settings->app_smtp_port ?? config('mail.mailers.smtp.port') }}"
                                        placeholder="587" />
                                </div>

                                <div>
                                    <label class="kt-label mb-2">{{ __('main.smtp_username') }}</label>
                                    <input type="text" name="app_smtp_username" class="kt-input h-[45px]"
                                        value="{{ $settings->app_smtp_username ?? config('mail.mailers.smtp.username') }}"
                                        placeholder="your-email@gmail.com" />
                                </div>

                                <div>
                                    <label class="kt-label mb-2">{{ __('main.smtp_password') }}</label>
                                    <input type="text" name="app_smtp_password" class="kt-input h-[45px]"
                                        value="{{ $settings->app_smtp_password ?? config('mail.mailers.smtp.password') }}"
                                        placeholder="••••••••" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-start gap-4 px-6 pb-6">
                        <button type="submit" form="smtp-settings-form" class="kt-btn kt-btn-primary">
                            <i class="fas fa-check text-sm me-2"></i>
                            {{ __('main.save') }}
                        </button>
                    </div>
                </div>
            </form>


            <!-- Notification Channels -->
            <form method="POST" action="{{ route('settings.update', $settings->id) }}" id="notification-channels-form">
                @csrf
                @method('PUT')

                <div class="kt-card mb-4">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.notification_channels') }}</h3>
                    </div>
                    <div class="kt-card-body">
                        <div class="space-y-4 p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                                <div class="kt-card p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-semibold">{{ __('main.email_notifications') }}</div>
                                            <div class="text-sm text-secondary-foreground">
                                                {{ __('main.receive_notifications_via_email') }}
                                            </div>
                                        </div>
                                        <input type="hidden" name="app_email_notifications" value="0" />
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'app_email_notifications',
                                            'id' => 'app_email_notifications',
                                            'value' => 1,
                                            'checked' => $settings->app_email_notifications == 1,
                                        ])
                                    </div>
                                </div>

                                <div class="kt-card p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-semibold">{{ __('main.push_notifications') }}</div>
                                            <div class="text-sm text-secondary-foreground">
                                                {{ __('main.instant_browser_notifications') }}
                                            </div>
                                        </div>
                                        <input type="hidden" name="app_push_notifications" value="0" />
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'app_push_notifications',
                                            'id' => 'app_push_notifications',
                                            'value' => 1,
                                            'checked' => $settings->app_push_notifications == 1,
                                        ])
                                    </div>
                                </div>

                                <div class="kt-card disabled p-4"
                                    style="background: var(--color-{{ $settings->app_sms_notifications == 1 ? '' : 'yellow' }}-100);">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-semibold">{{ __('main.sms_notifications') }}</div>
                                            <div class="text-sm text-secondary-foreground">
                                                {{ __('main.receive_notifications_via_sms') }}
                                            </div>
                                        </div>
                                        <input type="hidden" name="app_sms_notifications" value="0" />
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'app_sms_notifications',
                                            'id' => 'app_sms_notifications',
                                            'value' => 1,
                                            'checked' => $settings->app_sms_notifications == 1,
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-start gap-4 px-6 pb-6">
                        <button type="submit" form="notification-channels-form" class="kt-btn kt-btn-primary">
                            <i class="fas fa-check text-sm me-2"></i>
                            {{ __('main.save') }}
                        </button>
                    </div>
                </div>
            </form>

            {{-- Notification Types --}}
            <form method="POST" action="{{ route('settings.update', $settings->id) }}" id="notification-types-form"
                class="disabled-option">
                @csrf
                @method('PUT')

                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.notification_types') }}</h3>
                    </div>
                    <div class="kt-card-body">
                        <div class="space-y-4 p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                                <div class="kt-card p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-semibold">{{ __('main.new_record') }}</div>
                                            <div class="text-sm text-secondary-foreground">
                                                {{ __('main.when_new_record_registers') }}
                                            </div>
                                        </div>
                                        <input type="hidden" name="app_notifications_new_record" value="0" />
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'app_notifications_new_record',
                                            'id' => 'app_notifications_new_record',
                                            'value' => 1,
                                            'checked' => $settings->app_notifications_new_record == 1,
                                        ])
                                    </div>
                                </div>

                                <div class="kt-card p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-semibold">{{ __('main.data_updates') }}</div>
                                            <div class="text-sm text-secondary-foreground">
                                                {{ __('main.when_important_data_updates') }}
                                            </div>
                                        </div>
                                        <input type="hidden" name="app_notifications_data_updates" value="0" />
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'app_notifications_data_updates',
                                            'id' => 'app_notifications_data_updates',
                                            'value' => 1,
                                            'checked' => $settings->app_notifications_data_updates == 1,
                                        ])
                                    </div>
                                </div>

                                <div class="kt-card p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-semibold">{{ __('main.data_deletes') }}</div>
                                            <div class="text-sm text-secondary-foreground">
                                                {{ __('main.when_important_data_deletes') }}
                                            </div>
                                        </div>
                                        <input type="hidden" name="app_notifications_data_deletes" value="0" />
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'app_notifications_data_deletes',
                                            'id' => 'app_notifications_data_deletes',
                                            'value' => 1,
                                            'checked' => $settings->app_notifications_data_deletes == 1,
                                        ])
                                    </div>
                                </div>

                                <div class="kt-card disabled p-4"
                                    style="background: var(--color-{{ $settings->app_notifications_system_reports == 1 ? '' : 'yellow' }}-100);">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-semibold">{{ __('main.system_reports') }}</div>
                                            <div class="text-sm text-secondary-foreground">
                                                {{ __('main.periodic_reports_on_system_status') }}
                                            </div>
                                        </div>
                                        <input type="hidden" name="app_notifications_system_reports" value="0" />
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'app_notifications_system_reports',
                                            'id' => 'app_notifications_system_reports',
                                            'value' => 1,
                                            'checked' => $settings->app_notifications_system_reports == 1,
                                        ])
                                    </div>
                                </div>

                                <div class="kt-card disabled p-4"
                                    style="background: var(--color-{{ $settings->app_notifications_security_updates == 1 ? '' : 'yellow' }}-100);">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-semibold">{{ __('main.security_updates') }}</div>
                                            <div class="text-sm text-secondary-foreground">
                                                {{ __('main.important_security_notifications') }}
                                            </div>
                                        </div>
                                        <input type="hidden" name="app_notifications_security_updates" value="0" />
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'app_notifications_security_updates',
                                            'id' => 'app_notifications_security_updates',
                                            'value' => 1,
                                            'checked' => $settings->app_notifications_security_updates == 1,
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-start gap-4 px-6 pb-6">
                        <button type="submit" form="notification-types-form" class="kt-btn kt-btn-primary">
                            <i class="fas fa-check text-sm me-2"></i>
                            {{ __('main.save') }}
                        </button>
                    </div>
                </div>
            </form>

            {{-- Test Send Email --}}
            <div class="kt-card md:w-full w-half disabled-option" id="test-email-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.test_send_email') }}</h3>
                </div>
                <div class="kt-card-body p-6 pt-2">
                    <form action="{{ route('web-push-notifications') }}" method="POST" class="space-y-6"
                        id="web-push-form">
                        @csrf

                        <!-- Recipient Options -->
                        <div class="mb-2">
                            <div class="mb-2 p-2" id="all_users_wrapper">
                                <input type="hidden" name="" value="0" />
                                @include('components.elements.checkbox-button', [
                                    'name' => 'all_users',
                                    'id' => 'all_users',
                                    'value' => 1,
                                    'checked' => true,
                                    'label' => __('main.all_users'),
                                ])
                            </div>

                            <div id="recipient_email_wrapper">
                                <label class="kt-label mb-2">{{ __('main.recipient_email') }}</label>
                                {{-- <input type="email" name="test_recipient_email" id="test_recipient_email"
                                    class="kt-input h-[45px]" placeholder="recipient@example.com" /> --}}

                                <select name="recipient_user_id" id="recipient_user_id" class="kt-input h-[45px]"
                                    special-search>
                                    <option value="">{{ __('main.select_user') }}</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} - ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Notification Type -->
                        <div class="mb-6 p-2" id="notification_type_wrapper">
                            <label class="kt-label mb-2">{{ __('main.notification_type') }}</label>
                            <div class="flex gap-6">
                                @if ($settings->app_email_notifications == 1)
                                    <div class="flex items-center gap-4">
                                        <input type="hidden" name="email" value="0" />
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'notification_type[email]',
                                            'id' => 'email',
                                            'value' => 1,
                                            'label' => __('main.email'),
                                        ])
                                    </div>
                                @endif
                                @if ($settings->app_push_notifications == 1)
                                    <div class="flex items-center gap-4">
                                        <input type="hidden" name="notification" value="0" />
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'notification_type[notification]',
                                            'id' => 'notification',
                                            'value' => 1,
                                            'checked' => true,
                                            'label' => __('main.notification'),
                                        ])
                                    </div>
                                @endif
                                @if ($settings->app_sms_notifications == 1)
                                    <div class="flex items-center gap-4">
                                        <input type="hidden" name="sms" value="0" />
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'notification_type[sms]',
                                            'id' => 'sms',
                                            'value' => 1,
                                            'label' => __('main.sms'),
                                        ])
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Subject -->
                        <div class="mb-4">
                            <label class="kt-label mb-2">
                                {{ __('main.subject') }}</label>
                            <input type="text" name="subject" class="kt-input h-[45px]" placeholder="Test Subject"
                                value="صباح الخير" />
                        </div>

                        <!-- Message Body -->
                        <div class="mb-4">
                            <label class="kt-label mb-2">{{ __('main.message') }}</label>
                            <textarea name="message" id="message" class="kt-textarea pt-1" rows="3" placeholder="Test message...">صباح الخير يا مهندسين، انا الادمن هنا فاهمين!</textarea>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" form="web-push-form" class="kt-btn kt-btn-primary">
                                <span class="hidden" id="loading-spinner">
                                    @include('components.load-data', ['color' => 'var(--color-white)'])
                                </span>
                                {{ __('main.send') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const testEmailCard = document.getElementById("test-email-card");
            const webPushForm = document.getElementById("web-push-form");
            const allUsersCheckbox = document.getElementById("all_users");
            const allUsersWrapper = document.getElementById("all_users_wrapper");
            const emailWrapper = document.getElementById("recipient_email_wrapper");
            const recipientUser = document.getElementById("recipient_user_id");
            let emailValue = '';
            const notificationTypeWrapper = document.getElementById("notification_type_wrapper");
            const form = document.querySelector('form[action="{{ route('web-push-notifications') }}"]');
            let styleBorder = '1px var(--tw-border-style) var(--input)';

            if (testEmailCard.classList.contains('disabled-option')) {
                setTimeout(() => testEmailCard.classList.remove('disabled-option'), 250);
            }

            // Toggle email field
            allUsersCheckbox.addEventListener("change", () => {
                if (allUsersCheckbox.checked) {
                    emailValue = "";
                    recipientUser.disabled = true;
                    emailWrapper.querySelector('.search-select-tag')?.classList.add('disabled-option');
                } else {
                    recipientUser.disabled = false;
                    emailWrapper.querySelector('.search-select-tag')?.classList.remove('disabled-option');
                }
            });

            recipientUser?.addEventListener("updatedSelect", async (e) => {
                emailValue = e.detail.value;
                if (emailValue) {
                    allUsersCheckbox.checked = false;
                    recipientUser.disabled = false;
                    emailWrapper.querySelector('.search-select-tag')?.classList.remove(
                        'disabled-option');
                } else {
                    recipientUser.disabled = true;
                    emailWrapper.querySelector('.search-select-tag')?.classList.add('disabled-option');
                }
            });

            // Submit handler
            form.addEventListener("submit", async function(e) {
                e.preventDefault();

                const allUsersChecked = allUsersCheckbox.checked;
                const messageArea = document.getElementById("message");
                const notificationTypes = document.querySelectorAll(
                    "input[name^='notification_type']:checked");

                // Reset borders
                recipientUser.style.border = styleBorder;
                allUsersWrapper.style.border = "none";
                messageArea.style.border = styleBorder;
                notificationTypes.forEach(el => el.style.outline = styleBorder);

                // Frontend validations
                if (!allUsersChecked && emailValue.trim() === "") {
                    window.showToast({
                        type: 'error',
                        title: '{{ __('main.error') }}',
                        message: "{{ __('main.select_all_users_or_email') }}",
                    });
                    recipientUser.focus();
                    recipientUser.style.border = "1px solid red";
                    allUsersWrapper.style.border = "1px solid red";
                    return;
                }

                if (notificationTypes.length === 0) {
                    window.showToast({
                        type: 'error',
                        title: '{{ __('main.error') }}',
                        message: "{{ __('main.select_at_least_one_notification_type') }}",
                    });
                    notificationTypeWrapper.style.border = "1px solid red";
                    return;
                }

                if (!messageArea.value.trim()) {
                    window.showToast({
                        type: 'error',
                        title: '{{ __('main.error') }}',
                        message: "{{ __('main.message_cannot_be_empty') }}",
                    });
                    messageArea.focus();
                    messageArea.style.border = "1px solid red";
                    return;
                }

                // Submit via AJAX
                const formData = new FormData(form);
                const loadingSpinner = document.getElementById("loading-spinner");
                const submitButton = loadingSpinner?.parentElement;

                if (submitButton) submitButton.disabled = true;
                loadingSpinner?.classList.remove("hidden");
                try {
                    const response = await fetch(form.action, {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    });

                    const result = await response.json();

                    if (response.ok) {
                        // Clear errors
                        emailWrapper.style.border = styleBorder;
                        recipientUser.style.border = styleBorder;
                        messageArea.style.border = styleBorder;
                        notificationTypes.forEach(el => el.style.outline = styleBorder);

                        if (submitButton) submitButton.disabled = false;
                        loadingSpinner?.classList.add("hidden");
                    } else {
                        window.showToast({
                            type: 'error',
                            title: '{{ __('main.error') }}',
                            message: result.message || "{{ __('main.something_went_wrong') }}",
                        });

                        if (submitButton) submitButton.disabled = false;
                        loadingSpinner?.classList.add("hidden");
                    }
                } catch (error) {
                    console.error(error);
                    window.showToast({
                        type: 'error',
                        title: '{{ __('main.error') }}',
                        message: "{{ __('main.connection_failed') }}",
                    });

                    if (submitButton) submitButton.disabled = false;
                    loadingSpinner?.classList.add("hidden");
                }
            });
        });
    </script>
@endpush
