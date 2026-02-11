@extends('pages.dashboard.layouts.index')

@section('table-content')
    <div class="px-4 md:px-6">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-5 pb-6 mb-8">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-2xl font-semibold text-gray-600">
                    {{ __('main.my_modules') }}
                </h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard.subscriptions.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 background border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    {{ __('main.back_to_types', ['types' => __('main.subscriptions')]) }}
                </a>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
            <!-- Active Modules Card -->
            <div class="background rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600 mb-2">{{ $subscriptions->count() }}</div>
                    <div class="text-gray-600 text-sm">{{ __('main.active_modules') }}</div>
                </div>
            </div>

            <!-- Total Modules Card -->
            <div class="background rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">
                        {{ config('subscriptions.available_modules', []) ? count(config('subscriptions.available_modules')) : 0 }}</div>
                    <div class="text-gray-600 text-sm">{{ __('main.total_modules') }}</div>
                </div>
            </div>

            <!-- Expiring Soon Card -->
            <div class="background rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="text-center">
                    @php
                        $expiringSoon = $subscriptions->filter(fn($s) => $s->daysRemaining() !== null && $s->daysRemaining() <= 30)->count();
                    @endphp
                    <div class="text-3xl font-bold text-amber-600 mb-2">{{ $expiringSoon }}</div>
                    <div class="text-gray-600 text-sm">{{ __('main.expiring_soon') }}</div>
                </div>
            </div>

            <!-- Unlimited Card -->
            <div class="background rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="text-center">
                    @php
                        $unlimited = $subscriptions->filter(fn($s) => $s->ends_at === null)->count();
                    @endphp
                    <div class="text-3xl font-bold text-cyan-600 mb-2">{{ $unlimited }}</div>
                    <div class="text-gray-600 text-sm">{{ __('main.unlimited') }}</div>
                </div>
            </div>
        </div>

        <!-- Active Modules -->
        <div class="background rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-600">
                    <i class="fas fa-puzzle-piece mr-2"></i> {{ __('main.my_active_modules') }}
                </h3>
            </div>
            <div class="p-6">
                @if ($subscriptions->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($subscriptions as $subscription)
                            @php
                                $moduleConfig = config('subscriptions.available_modules.' . $subscription->module_key, [
                                    'name' => $subscription->module_key,
                                    'description' => 'Module',
                                    'icon' => 'fas fa-box',
                                ]);
                            @endphp
                            <div class="border-2 border-green-500 rounded-lg p-6 bg-green-50 h-full">
                                <!-- Module Header -->
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="flex-shrink-0">
                                        <div class="bg-green-100 rounded-lg p-3">
                                            <i class="{{ $moduleConfig['icon'] }} text-2xl text-green-600"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow">
                                        <h5 class="text-lg font-semibold text-gray-600 mb-1">{{ $moduleConfig['name'] }}</h5>
                                        <span class="inline-block px-3 py-1 text-xs font-semibold text-white bg-green-600 rounded-full">
                                            <i class="fas fa-check-circle mr-1"></i> {{ __('main.active') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Module Description -->
                                <p class="text-sm text-gray-600 mb-4">
                                    {{ $moduleConfig['description'] }}
                                </p>

                                <!-- Subscription Details -->
                                <div class="border-t border-gray-200 pt-4 space-y-3">
                                    @if ($subscription->starts_at)
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-calendar-start text-blue-600 mt-0.5"></i>
                                            <div>
                                                <div class="text-xs font-semibold text-gray-600">{{ __('main.started') }}</div>
                                                <div class="text-sm text-gray-600">{{ $subscription->starts_at->format('Y-m-d') }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($subscription->ends_at)
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-calendar-end text-red-600 mt-0.5"></i>
                                            <div>
                                                <div class="text-xs font-semibold text-gray-600">{{ __('main.expires') }}</div>
                                                <div class="text-sm text-gray-600">{{ $subscription->ends_at->format('Y-m-d') }}</div>
                                            </div>
                                        </div>

                                        @if ($subscription->daysRemaining() !== null)
                                            @php
                                                $daysLeft = $subscription->daysRemaining();
                                                $progressColor = $daysLeft > 30 ? 'emerald' : ($daysLeft > 7 ? 'amber' : 'red');
                                                $badgeColor = $daysLeft > 30 ? 'bg-emerald-600' : ($daysLeft > 7 ? 'bg-amber-600' : 'bg-red-600');
                                                $barColor = $daysLeft > 30 ? 'bg-emerald-500' : ($daysLeft > 7 ? 'bg-amber-500' : 'bg-red-500');
                                                $totalDays = $subscription->starts_at ? $subscription->starts_at->diffInDays($subscription->ends_at) : 365;
                                                $progress = $totalDays > 0 ? (($totalDays - $daysLeft) / $totalDays) * 100 : 0;
                                            @endphp
                                            <div class="w-full mt-2">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="text-xs font-semibold text-gray-600">
                                                        <i class="fas fa-clock mr-1"></i> {{ __('main.time_remaining') }}
                                                    </span>
                                                    <span class="px-2 py-1 text-xs font-semibold text-white {{ $badgeColor }} rounded-full">
                                                        {{ $daysLeft }} {{ __('main.days') }}
                                                    </span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                    <div class="{{ $barColor }} h-1.5 rounded-full transition-all duration-300"
                                                        style="width: {{ $progress }}%"></div>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <div class="px-4 py-2 bg-blue-100 border border-blue-400 rounded-lg text-sm text-blue-700">
                                            <i class="fas fa-infinity mr-2"></i> {{ __('main.unlimited_subscription') }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="border-t border-gray-200 pt-4 mt-4">
                                    <form action="{{ route('dashboard.subscriptions.deactivate', $subscription->module_key) }}" method="POST"
                                        onsubmit="return confirm('{{ __('main.confirm_deactivate_module') }}')">
                                        @csrf
                                        <button type="submit"
                                            class="w-full px-3 py-2 text-sm font-medium text-red-600 border border-red-600 rounded-lg hover:bg-red-50 transition">
                                            <i class="fas fa-pause mr-1"></i> {{ __('main.deactivate_module') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-5xl text-gray-600 mb-4"></i>
                        <h5 class="text-lg font-semibold text-gray-600 mb-2">{{ __('main.no_active_modules') }}</h5>
                        <p class="text-gray-600 mb-6">{{ __('main.visit_subscriptions_to_activate') }}</p>
                        <a href="{{ route('dashboard.subscriptions.index') }}"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-plus mr-2"></i> {{ __('main.view_available_modules') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
