@extends('layouts.master')

@section('title', __('main.public_profile'))

@section('content')
    <!-- Profile Page -->
    <div class="kt-container-fixed">
        <!-- Header/Cover Section -->
        <div class="kt-card mb-10 overflow-hidden">
            <!-- Cover Image -->
            <div class="h-48 sm:h-64 bg-cover bg-no-repeat relative group"
                style="background-image: url('{{ asset('metronic/media/images/2600x1600/bg-2.png') }}'); background-position: center;">
                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors"></div>
            </div>

            <div class="px-8 pb-8 flex flex-col items-center sm:items-start">
                <!-- Avatar & Action Row -->
                <div class="relative -mt-16 mb-6 flex flex-col sm:flex-row items-end gap-6 w-full">
                    <div
                        class="size-32 sm:size-40 rounded-3xl border-4 border-background overflow-hidden shadow-xl bg-muted shrink-0">
                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('metronic/media/avatars/blank.png') }}"
                            alt="{{ $user->name }}" class="size-full object-cover">
                    </div>

                    <div
                        class="flex-1 flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 text-center sm:text-start">
                        <div>
                            <h1 class="text-3xl font-extrabold text-foreground mb-1">{{ $user->name }}</h1>
                            <div
                                class="flex flex-wrap items-center justify-center sm:justify-start gap-4 text-sm font-medium text-secondary-foreground">
                                <span class="flex items-center gap-1.5">
                                    <i class="ki-filled ki-briefcase fs-5 text-primary"></i>
                                    {{ $user->position ?? 'Software Developer' }}
                                </span>
                                <span class="flex items-center gap-1.5 border-l border-border pl-4">
                                    <i class="ki-filled ki-geolocation fs-5 text-success"></i>
                                    {{ strip_tags($user->address ?? 'Amman, Jordan') }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-center gap-2.5">
                            <button class="kt-btn kt-btn-primary rounded-xl px-8 shadow-lg shadow-primary/20">
                                <i class="ki-filled ki-plus"></i> Follow
                            </button>
                            <button class="kt-btn kt-btn-icon kt-btn-outline rounded-xl shrink-0">
                                <i class="ki-filled ki-messages"></i>
                            </button>
                            <div class="relative">
                                <button class="kt-btn kt-btn-icon kt-btn-outline rounded-xl shrink-0"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="ki-filled ki-setting-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bio / Quick Stats -->
                <div class="w-full flex flex-col lg:flex-row gap-8 items-start">
                    <div class="flex-1">
                        <p class="text-secondary-foreground text-lg leading-relaxed max-w-3xl">
                            {!! htmlspecialchars_decode($user->bio ?? 'No bio available for this professional profile yet.') !!}
                        </p>
                    </div>
                    <div class="flex items-center gap-6 lg:gap-12 shrink-0">
                        <div class="text-center">
                            <div class="text-2xl font-black text-foreground">1.2k</div>
                            <div class="text-xs font-bold text-secondary-foreground uppercase tracking-widest">
                                {{ __('main.followers') }}</div>
                        </div>
                        <div class="text-center border-l border-border pl-6 lg:pl-12">
                            <div class="text-2xl font-black text-foreground">428</div>
                            <div class="text-xs font-bold text-secondary-foreground uppercase tracking-widest">
                                {{ __('main.following') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Info Card -->
                <div class="kt-card">
                    <div class="kt-card-header border-b-border/60">
                        <h3 class="kt-card-title">{{ __('main.profile_details') }}</h3>
                    </div>
                    <div class="kt-card-body p-6 space-y-6">
                        <div class="flex flex-col gap-1">
                            <span
                                class="text-xs font-bold text-secondary-foreground uppercase tracking-wider">{{ __('main.email_address') }}</span>
                            <span class="text-sm font-semibold text-foreground break-all">{{ $user->email }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span
                                class="text-xs font-bold text-secondary-foreground uppercase tracking-wider">{{ __('main.phone_number') }}</span>
                            <span class="text-sm font-semibold text-foreground">{{ $user->phone ?? '—' }}</span>
                        </div>
                        @if ($user->company_website)
                            <div class="flex flex-col gap-1">
                                <span
                                    class="text-xs font-bold text-secondary-foreground uppercase tracking-wider">{{ __('main.website') }}</span>
                                <a href="{{ $user->company_website }}" target="_blank"
                                    class="text-sm font-semibold text-primary hover:underline">
                                    {{ $user->company_website }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Feed / Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Posts/About Tab Placeholder -->
                <div
                    class="kt-card min-h-[400px] flex items-center justify-center text-center p-12 bg-muted/10 border-dashed border-2">
                    <div class="max-w-sm">
                        <div class="size-20 bg-muted/40 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <i class="ki-filled ki-abstract-26 text-secondary-foreground fs-1"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-foreground mb-4">No Activity Yet</h3>
                        <p class="text-secondary-foreground">
                            This user hasn't shared any public updates or posts yet. Stay tuned for future insights and
                            contributions.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
