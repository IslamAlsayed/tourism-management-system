@extends('pages.dashboard.layouts.index')

@section('table-content')
    <div class="">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-2xl font-semibold text-gray-600">
                    {{ __('main.subscriptions') }}
                </h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 background border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    {{ __('main.dashboard') }}
                </a>
            </div>
        </div>

        <!-- Available Modules -->
        <div class="background rounded-lg shadow-sm border border-gray-200 mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-600">{{ __('main.available_modules') }}</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($availableModules as $key => $module)
                        @php
                            $subscription = $subscriptions->firstWhere('module_key', $key);
                            $isActive = $subscription && $subscription->isCurrentlyActive();
                            $isExpired = $subscription && $subscription->isExpired();
                        @endphp
                        <div
                            class="border-2 rounded-lg p-6 h-full {{ $isActive ? 'border-green-500 bg-green-50' : ($isExpired ? 'border-red-500 bg-red-50' : 'border-gray-200 background') }}">
                            <!-- Module Header -->
                            <div class="flex items-start gap-4 mb-4">
                                <div class="text-4xl text-blue-600">
                                    <i class="{{ $module['icon'] }}"></i>
                                </div>
                                <div class="flex-1">
                                    <h5 class="text-lg font-semibold text-gray-600 mb-2">{{ $module['name'] }}</h5>
                                    @if ($isActive)
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold text-white bg-green-600 rounded-full">{{ __('main.active') }}</span>
                                    @elseif($isExpired)
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded-full">{{ __('main.expired') }}</span>
                                    @elseif($subscription)
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold text-white bg-yellow-600 rounded-full">{{ __('main.inactive') }}</span>
                                    @else
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold text-white bg-gray-600 rounded-full">{{ __('main.not_subscribed') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Module Description -->
                            <p class="text-sm text-gray-600 mb-4">{{ $module['description'] }}</p>

                            <!-- Features Section -->
                            @if (!empty($module['features']))
                                <div class="mb-4 pb-4 border-b border-gray-200">
                                    <h6 class="text-sm font-semibold text-gray-700 mb-2">{{ __('main.features') }}:</h6>
                                    <ul class="space-y-1">
                                        @foreach ($module['features'] as $feature)
                                            <li class="text-sm text-gray-600">
                                                <i class="fas fa-check text-green-600 mr-2"></i>{{ $feature }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Pricing Section -->
                            <div class="mb-4 pb-4 border-b border-gray-200">
                                <h6 class="text-sm font-semibold text-gray-700 mb-2">{{ __('main.pricing') }}:</h6>
                                <div class="grid grid-cols-2 gap-3">
                                    @if ($module['price_monthly'])
                                        <div class="bg-blue-50 p-2 rounded">
                                            <div class="text-xs text-gray-600">{{ __('main.monthly') }}</div>
                                            <div class="text-lg font-bold text-blue-600">${{ number_format($module['price_monthly'], 2) }}</div>
                                        </div>
                                    @endif
                                    @if ($module['price_yearly'])
                                        <div class="bg-green-50 p-2 rounded">
                                            <div class="text-xs text-gray-600">{{ __('main.yearly') }}</div>
                                            <div class="text-lg font-bold text-green-600">${{ number_format($module['price_yearly'], 2) }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Trial Section -->
                            @if ($module['trial_days'] > 0)
                                <div class="mb-4 pb-4 border-b border-gray-200">
                                    <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded p-2">
                                        <i class="fas fa-star text-blue-600 dark:text-blue-400 mr-2"></i>
                                        <span class="text-sm text-blue-800 dark:text-blue-300 font-semibold">{{ __('main.trial') }}: {{ $module['trial_days'] }}
                                            {{ __('main.days') }}</span>
                                    </div>
                                </div>
                            @endif

                            @if ($subscription)
                                <!-- Subscription Details -->
                                <div class="space-y-2 mb-4 pb-4 border-b border-gray-200 text-sm text-gray-600">
                                    @if ($subscription->starts_at)
                                        <div><i class="fas fa-calendar-start mr-2"></i> {{ __('main.starts') }}: {{ $subscription->starts_at->format('Y-m-d') }}
                                        </div>
                                    @endif
                                    @if ($subscription->ends_at)
                                        <div><i class="fas fa-calendar-end mr-2"></i> {{ __('main.ends') }}: {{ $subscription->ends_at->format('Y-m-d') }}</div>
                                        @if (!$isExpired && $subscription->daysRemaining() !== null)
                                            <div><i class="fas fa-clock mr-2"></i> {{ $subscription->daysRemaining() }} {{ __('main.days_remaining') }}</div>
                                        @endif
                                    @else
                                        <div><i class="fas fa-infinity mr-2"></i> {{ __('main.unlimited') }}</div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    @if ($subscription->is_active && !$isExpired)
                                        <form action="{{ route('dashboard.subscriptions.deactivate', $key) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                class="w-full px-3 py-2 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 transition">
                                                <i class="fas fa-pause mr-1"></i> {{ __('main.deactivate') }}
                                            </button>
                                        </form>
                                    @elseif(!$isExpired)
                                        <form action="{{ route('dashboard.subscriptions.activate', $key) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                class="w-full px-3 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
                                                <i class="fas fa-play mr-1"></i> {{ __('main.activate') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <!-- Contact Admin Message -->
                                <div class="px-4 py-3 bg-blue-100 border border-blue-400 rounded-lg text-sm text-blue-700">
                                    <i class="fas fa-info-circle mr-2"></i> {{ __('main.contact_admin_to_subscribe') }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="px-4 py-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-300 dark:border-yellow-700 rounded-lg text-sm text-yellow-700 dark:text-yellow-300">
                                <i class="fas fa-exclamation-triangle mr-2"></i> {{ __('main.no_modules_available') }}
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Subscription History -->
        <div class="background rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-600">{{ __('main.subscription_history') }}</h3>
            </div>
            <div class="p-6 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('main.module') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('main.status') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('main.starts_at') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('main.ends_at') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('main.days_remaining') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('main.created_at') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $subscription)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-gray-600">
                                    <i class="{{ $availableModules[$subscription->module_key]['icon'] ?? 'fas fa-box' }} mr-2"></i>
                                    {{ $availableModules[$subscription->module_key]['name'] ?? $subscription->module_key }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($subscription->isCurrentlyActive())
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold text-white bg-green-600 rounded-full">{{ __('main.active') }}</span>
                                    @elseif($subscription->isExpired())
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded-full">{{ __('main.expired') }}</span>
                                    @else
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold text-white bg-yellow-600 rounded-full">{{ __('main.inactive') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $subscription->starts_at ? $subscription->starts_at->format('Y-m-d') : '-' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $subscription->ends_at ? $subscription->ends_at->format('Y-m-d') : __('main.unlimited') }}
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    @if ($subscription->daysRemaining() !== null)
                                        {{ $subscription->daysRemaining() }} {{ __('main.days') }}
                                    @else
                                        <i class="fas fa-infinity"></i>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $subscription->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-600">
                                    {{ __('main.no_subscriptions_found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
