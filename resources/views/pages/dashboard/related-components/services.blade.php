<!-- Tourist Services -->
<div class="kt-card bg-blue-100">
    <div class="kt-card-header">
        <h3 class="kt-card-title">
            {{ __('main.services') }}
            (<span class="font-semibold text-primary">{{ $record->services->count() }}</span>)
        </h3>
        <div class="kt-card-toolbar">
            <a href="{{ route('tourist-services.create', ['site_id' => $record->id]) }}"
                class="kt-btn kt-btn-sm kt-btn-primary">
                <i class="ki-filled ki-plus text-sm me-1"></i>
                {{ __('main.add_type', ['type' => __('main.service')]) }}
            </a>
        </div>
    </div>
    <div class="kt-card-body p-4">
        <div class="grid gap-4">
            @forelse($record->services as $service)
                <div wire:key="service-{{ $service->id }}"
                    class="kt-card background rounded-lg p-4 pt-2 record-services-{{ $service->id }}">

                    <!-- Pricing Section -->
                    <div class="mb-4 pb-4 border-b">
                        <h4 class="font-semibold text-sm mb-3">{{ __('main.pricing') }}</h4>
                        <div class="grid lg:grid-cols-4 gap-4">
                            @if ($service->per_adult_foreigners)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.per_adult_foreigners') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $service->per_adult_foreigners ?? __('main.na') }}
                                        {{ $service->currency?->code ?? $settings->app_default_currency }}</p>
                                </div>
                            @endif
                            @if ($service->per_adult_local)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.per_adult_local') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $service->per_adult_local ?? __('main.na') }}
                                        {{ $service->currency?->code ?? $settings->app_default_currency }}</p>
                                </div>
                            @endif
                            @if ($service->per_adult_arab)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.per_adult_arab') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $service->per_adult_arab ?? __('main.na') }}
                                        {{ $service->currency?->code ?? $settings->app_default_currency }}</p>
                                </div>
                            @endif
                            @if ($service->total_day_visit)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.total_day_visit') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $service->total_day_visit ?? __('main.na') }}
                                        {{ $service->currency?->code ?? $settings->app_default_currency }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Operating Hours Section -->
                    <div class="mb-4 pb-4 border-b">
                        <h4 class="font-semibold text-sm mb-3">{{ __('main.operating_hours') }}</h4>
                        <div class="grid lg:grid-cols-4 gap-4">
                            @if ($service->summer_opening_time)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.summer_opening_time') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <span
                                            class="inline-block bg-info/30 text-info text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            <i class="fa-duotone fa-clock text-info me-1"></i>
                                            {{ $service->summer_opening_time ?? __('main.na') }}
                                        </span>
                                    </p>
                                </div>
                            @endif
                            @if ($service->summer_closing_time)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.summer_closing_time') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <span
                                            class="inline-block bg-warning/30 text-warning text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            <i class="fa-duotone fa-clock text-warning me-1"></i>
                                            {{ $service->summer_closing_time ?? __('main.na') }}
                                        </span>
                                    </p>
                                </div>
                            @endif
                            @if ($service->winter_opening_time)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.winter_opening_time') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <span
                                            class="inline-block bg-info/30 text-info text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            <i class="fa-duotone fa-snowflake text-info me-1"></i>
                                            {{ $service->winter_opening_time ?? __('main.na') }}
                                        </span>
                                    </p>
                                </div>
                            @endif
                            @if ($service->winter_closing_time)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.winter_closing_time') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <span
                                            class="inline-block bg-warning/30 text-warning text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            <i class="fa-duotone fa-snowflake text-warning me-1"></i>
                                            {{ $service->winter_closing_time ?? __('main.na') }}
                                        </span>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="mb-4 pb-4 border-b">
                        <h4 class="font-semibold text-sm mb-3">{{ __('main.contact_information') }}</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @if ($service->person_name_01)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.person_name_01') }} 1</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $service->person_name_01 ?? __('main.na') }}</p>
                                </div>
                            @endif
                            @if ($service->phone)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $service->phone ?? __('main.na') }}
                                    </p>
                                </div>
                            @endif
                            @if ($service->email_01)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                    <p class="text-sm text-secondary-foreground break-all">
                                        {{ $service->email_01 ?? __('main.na') }}</p>
                                </div>
                            @endif
                            @if ($service->mobile_01)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.mobile') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $service->mobile_01 ?? __('main.na') }}</p>
                                </div>
                            @endif
                            @if ($service->fax)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.fax') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $service->fax ?? __('main.na') }}
                                    </p>
                                </div>
                            @endif
                            @if ($service->website)
                                <div class="col-span-2">
                                    <label class="kt-label mb-1">{{ __('main.website') }}</label>
                                    <p class="text-sm text-secondary-foreground break-all">
                                        {{ $service->website ?? __('main.na') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Features Section -->
                    <div class="mb-4 pb-4 border-b">
                        <h4 class="font-semibold text-sm mb-3">{{ __('main.features') }}</h4>
                        {{-- <div class="grid lg:grid-cols-3 gap-4"> --}}
                        <div class="flex flex-wrap" style="gap: 10px 40px;">
                            <div>
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $service->id,
                                        'modelType' => '\\App\\Models\\TouristService',
                                        'field' => 'is_active',
                                        'value' => (bool) $service->is_active,
                                        'table' => 'tourist_sites',
                                    ])
                                </div>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.include_unified_ticket') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $service->id,
                                        'modelType' => '\\App\\Models\\TouristService',
                                        'field' => 'include_unified_ticket',
                                        'value' => (bool) $service->include_unified_ticket,
                                        'table' => 'tourist_sites',
                                    ])
                                </div>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.local_guide_available') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $service->id,
                                        'modelType' => '\\App\\Models\\TouristService',
                                        'field' => 'local_guide_available',
                                        'value' => (bool) $service->local_guide_available,
                                        'table' => 'tourist_sites',
                                    ])
                                </div>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.credit_cards') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $service->id,
                                        'modelType' => '\\App\\Models\\TouristService',
                                        'field' => 'credit_cards',
                                        'value' => (bool) $service->credit_cards,
                                        'table' => 'tourist_sites',
                                    ])
                                </div>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.club_cars_available') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $service->id,
                                        'modelType' => '\\App\\Models\\TouristSite',
                                        'field' => 'club_cars_available',
                                        'value' => (bool) $service->club_cars_available,
                                        'table' => 'tourist_sites',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @include('components.elements.display-desc-or-notes', [
                        'record' => $service,
                        'column' => 'description',
                    ])

                    <!-- Actions -->
                    <div class="flex gap-2 mt-4">
                        @include('components.elements.show-button', [
                            'models' => 'tourist-services',
                            'id' => $service->id,
                        ])
                        @include('components.elements.edit-button', [
                            'models' => 'tourist-services',
                            'id' => $service->id,
                        ])
                        @livewire('delete-bottom', [
                            'type' => 'tourist-services',
                            'modelId' => $service->id,
                            'modelType' => '\\App\\Models\\TouristService',
                            'table' => 'tourist_services',
                        ])
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-secondary-foreground">
                    <i class="ki-filled ki-information text-4xl mb-2"></i>
                    <p>{{ __('main.no_data_available') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
