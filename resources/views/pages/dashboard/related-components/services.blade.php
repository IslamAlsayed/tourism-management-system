<!-- Tourist Services -->
<div class="kt-card bg-blue-100">
    <div class="kt-card-header">
        <h3 class="kt-card-title">
            {{ __('main.services') }}
            (<span class="font-semibold text-primary">{{ $record->services->count() }}</span>)
        </h3>
        <div class="kt-card-toolbar">
            <button type="button" class="text-gray-500 hover:text-primary cursor-pointer toggle-all-services">
                <i class="ki-outline ki-arrow-down fs-2 inline-block"></i>
            </button>

            <a href="{{ route('tourist-services.create', ['site_id' => $record->id]) }}" class="kt-btn kt-btn-sm kt-btn-primary">
                <i class="ki-filled ki-plus text-sm me-1"></i>
                {{ __('main.add_type', ['type' => __('main.service')]) }}
            </a>
        </div>
    </div>
    <div class="kt-card-body p-4">
        <div class="grid gap-4">
            @forelse($record->services as $service)
                <div wire:key="service-{{ $service->id }}" class="service-item kt-card background rounded-lg record-services-{{ $service->id }}">
                    <!-- Pricing Section -->
                    <div>
                        <div class="flex justify-between gap-4 p-3">
                            <h4 class="font-semibold text-sm">{{ __('main.pricing') }} <span class="dots hidden">...</span></h4>
                            <button type="button" class="text-gray-500 hover:text-primary cursor-pointer toggle-service">
                                <i class="ki-outline ki-arrow-down fs-2 inline-block"></i>
                            </button>
                        </div>
                        <div class="grid lg:grid-cols-4 gap-4 p-4 pt-0 price">
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

                    <div class="p-4 hours-section">
                        <!-- Operating Hours Section -->
                        <div class="mb-4 pb-4 border-custom-b">
                            <h4 class="font-semibold text-sm mb-3">{{ __('main.operating_hours') }}</h4>
                            <div class="grid lg:grid-cols-4 gap-4">
                                @if ($service->summer_opening_time)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.summer_opening_time') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            <span class="inline-block bg-info/30 text-info text-xs font-medium px-2 py-0.5 rounded-[7px]">
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
                                            <span class="inline-block bg-warning/30 text-warning text-xs font-medium px-2 py-0.5 rounded-[7px]">
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
                                            <span class="inline-block bg-info/30 text-info text-xs font-medium px-2 py-0.5 rounded-[7px]">
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
                                            <span class="inline-block bg-warning/30 text-warning text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                                <i class="fa-duotone fa-snowflake text-warning me-1"></i>
                                                {{ $service->winter_closing_time ?? __('main.na') }}
                                            </span>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="mb-4 pb-4 border-custom-b">
                            <h4 class="font-semibold text-sm mb-3">{{ __('main.contact_information') }}</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @if ($service->person_name_01)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.person_name_01') }} 1</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $service->person_name_01 ?? __('main.na') }}
                                        </p>
                                    </div>
                                @endif
                                @if ($service->phone)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                        <div>
                                            <a href="tel:{{ $service->phone }}" target="_blank" class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                                {{ $service->phone }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                @if ($service->email_01)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                        <div>
                                            <a href="mailto:{{ $service->email_01 }}" target="_blank" class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                                {{ $service->email_01 }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                @if ($service->mobile_01)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.mobile') }}</label>
                                        <div>
                                            <a href="tel:{{ $service->mobile_01 }}" target="_blank" class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                                {{ $service->mobile_01 }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                @if ($service->fax)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.fax') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $service->fax ?? __('main.na') }}
                                        </p>
                                    </div>
                                @endif
                                @if ($service->website)
                                    <div class="col-span-2">
                                        <label class="kt-label mb-1">{{ __('main.website') }}</label>
                                        <a href="{{ $service->website }}" target="_blank" class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                                            {{ $service->website }}
                                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Features Section -->
                        <div class="mb-4 pb-4 border-custom-b">
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
                        @include('components.elements.displayable-rich-text', [
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

@push('scripts')
    <script>
        document.addEventListener('click', function(e) {

            const serviceBtn = e.target.closest('.toggle-service');
            const allBtn = e.target.closest('.toggle-all-services');

            function openService(item) {
                item.querySelector('.price').classList.remove('hidden');
                item.querySelector('.hours-section').classList.remove('hidden');
                item.querySelector('.dots').classList.add('hidden');

                const icon = item.querySelector('.toggle-service i');
                icon.classList.remove('ki-arrow-down');
                icon.classList.add('ki-arrow-up');
            }

            function closeService(item) {
                item.querySelector('.price').classList.add('hidden');
                item.querySelector('.hours-section').classList.add('hidden');
                item.querySelector('.dots').classList.remove('hidden');

                const icon = item.querySelector('.toggle-service i');
                icon.classList.remove('ki-arrow-up');
                icon.classList.add('ki-arrow-down');
            }

            function isServiceOpen(item) {
                return !item.querySelector('.price').classList.contains('hidden');
            }

            /* ===============================
               Toggle Single Service
            =============================== */
            if (serviceBtn) {
                const item = serviceBtn.closest('.service-item');
                isServiceOpen(item) ? closeService(item) : openService(item);
            }

            /* ===============================
               Toggle All Services (FINAL FIX)
            =============================== */
            if (allBtn) {
                const serviceItems = document.querySelectorAll('.service-item');
                const mainIcon = allBtn.querySelector('i');

                // 👈 هل في أي service مفتوح؟
                const hasOpenService = [...serviceItems].some(item => isServiceOpen(item));

                // لو في أي واحد مفتوح → نقفل الكل
                const shouldOpenAll = !hasOpenService;

                serviceItems.forEach(item => {
                    shouldOpenAll ? openService(item) : closeService(item);
                });

                // خزّن الحالة الجديدة
                allBtn.dataset.open = shouldOpenAll.toString();

                // أيقونة زر الكل
                if (shouldOpenAll) {
                    mainIcon.classList.remove('ki-arrow-down');
                    mainIcon.classList.add('ki-arrow-up');
                } else {
                    mainIcon.classList.remove('ki-arrow-up');
                    mainIcon.classList.add('ki-arrow-down');
                }
            }

        });
    </script>
@endpush
