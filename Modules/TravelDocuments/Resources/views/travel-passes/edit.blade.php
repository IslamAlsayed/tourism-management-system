@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.travel-pass')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.travel-pass')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.travel-pass')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.traveldocuments.travel-passes.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.travel-passes')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <form action="{{ route('dashboard.traveldocuments.travel-passes.update', $travelPass->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid gap-4 lg:gap-6">
                <!-- Basic Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.basic_information') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- Name (EN) -->
                            <div class="">
                                <label for="name" class="kt-label mb-2">{{ __('main.name_en') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" value="{{ $travelPass->name }}"
                                    placeholder="e.g. Jordan Explorer">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name (AR) -->
                            <div class="">
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" dir="rtl" value="{{ $travelPass->name_ar }}"
                                    placeholder="مثال: جوردان اكسبلورر">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country -->
                            @include('components.selects.country', [
                                'name' => 'country_id',
                                'record' => $travelPass,
                            ])

                            <!-- Pass Type -->
                            <div class="">
                                <label for="pass_type" class="kt-label mb-2">
                                    {{ __('main.pass_type') }}
                                    <strong class="dataLength text-primary">
                                        ({{ count($passTypes) ?: 0 }})
                                    </strong>
                                </label>
                                <select name="pass_type" id="pass_type" class="kt-select basic-single">
                                    @foreach ($passTypes as $type)
                                        <option value="{{ $type }}" {{ $travelPass->pass_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('pass_type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Sort Order -->
                            <div class="">
                                <label for="sort_order" class="kt-label mb-2">{{ __('main.sort_order') }}</label>
                                <input type="number" min="0" name="sort_order" id="sort_order" class="kt-input h-[45px]"
                                    value="{{ $travelPass->sort_order }}">
                                @error('sort_order')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing and Validity -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.pricing_and_validity') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Price -->
                            <div class="">
                                <label for="price" class="kt-label mb-2">{{ __('main.price') }}</label>
                                <input type="number" step="0.01" min="0" name="price" id="price" class="kt-input h-[45px]"
                                    value="{{ $travelPass->price }}">
                                @error('price')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency -->
                            @include('components.selects.currency', [
                                'name' => 'currency_id',
                                'record' => $travelPass,
                            ])

                            <!-- Validity Days -->
                            <div class="">
                                <label for="validity_days" class="kt-label mb-2">{{ __('main.validity_days') }}</label>
                                <input type="number" min="1" name="validity_days" id="validity_days" class="kt-input h-[45px]"
                                    value="{{ $travelPass->validity_days }}">
                                @error('validity_days')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Special Attraction Days -->
                            <div class="">
                                <label for="special_attraction_days" class="kt-label mb-2">{{ __('main.special_attraction_days') }}</label>
                                <input type="number" min="0" name="special_attraction_days" id="special_attraction_days" class="kt-input h-[45px]"
                                    value="{{ $travelPass->special_attraction_days }}">
                                <span class="text-xs text-gray-500">{{ __('main.special_attraction_days_hint') }}</span>
                            </div>

                            <!-- Min Stay Nights -->
                            <div class="">
                                <label for="min_stay_nights" class="kt-label mb-2">{{ __('main.min_stay_nights') }}</label>
                                <input type="number" min="0" name="min_stay_nights" id="min_stay_nights" class="kt-input h-[45px]"
                                    value="{{ $travelPass->min_stay_nights }}">
                                <span class="text-xs text-gray-500">{{ __('main.min_stay_nights_hint') }}</span>
                            </div>

                            <!-- Official Purchase URL -->
                            <div class="md:col-span-2">
                                <label for="official_purchase_url" class="kt-label mb-2">{{ __('main.official_purchase_url') }}</label>
                                <input type="url" name="official_purchase_url" id="official_purchase_url" class="kt-input h-[45px]"
                                    value="{{ $travelPass->official_purchase_url }}" placeholder="https://...">
                                @error('official_purchase_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Included Sites -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.included_sites') }}
                            <strong class="dataLength text-primary">
                                ({{ count($touristSites) ?: 0 }})
                            </strong>
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div data-kt-stepper="true">
                            <div class="kt-card">
                                <div class="kt-card-header h-auto border-0 absolute">
                                    @php
                                        $stepsCount = ceil(count($touristSites) / 9);
                                    @endphp
                                    @for ($i = 1; $i <= $stepsCount; $i++)
                                        <div data-kt-stepper-item="#stepper_{{ $i }}"></div>
                                    @endfor
                                </div>

                                <div class="kt-card-content px-5 py-20">
                                    @php
                                        $stepsCount = ceil(count($touristSites) / 9);
                                    @endphp
                                    @for ($step = 1; $step <= $stepsCount; $step++)
                                        <div id="stepper_{{ $step }}" class="{{ $step === 1 ? '' : 'hidden' }}">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                                @foreach ($touristSites as $index => $site)
                                                    @if ($index >= ($step - 1) * 9 && $index < $step * 9)
                                                        <div class="flex items-center gap-3 p-3 border-custom rounded-lg hover:bg-gray-100">
                                                            @component('components.elements.checkbox-button', [
                                                                'name' => 'sites[]',
                                                                'id' => 'site_' . $site->id,
                                                                'value' => $site->id,
                                                                'checked' => $travelPass->touristSites->contains('id', $site->id),
                                                                'label' => $site->name,
                                                            ])
                                                                @if ($site->name_ar)
                                                                    @slot('checkboxSlot')
                                                                        <label for="site_{{ $site->id }}"
                                                                            class="text-sm text-gray-500 !py-0 block">{{ $site->name_ar }}</label>
                                                                    @endslot
                                                                @endif
                                                            @endcomponent
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                                <div class="kt-card-footer justify-between p-5">
                                    <div>
                                        <button class="kt-btn kt-btn-secondary kt-stepper-first:hidden" data-kt-stepper-back="true" toggle-button>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-arrow-left" aria-hidden="true">
                                                <path d="m12 19-7-7 7-7"></path>
                                                <path d="M19 12H5"></path>
                                            </svg>
                                            {{ __('main.back') }}
                                        </button>
                                    </div>
                                    <div>
                                        <button class="kt-btn kt-btn-secondary kt-stepper-last:hidden" data-kt-stepper-next="true" toggle-button>
                                            {{ __('main.next') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-arrow-right" aria-hidden="true">
                                                <path d="M5 12h14"></path>
                                                <path d="m12 5 7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'description',
                    'value' => $travelPass->description,
                    'record' => $travelPass,
                ])

                {{-- Notes --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'notes',
                    'value' => $travelPass->notes,
                    'record' => $travelPass,
                ])

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => $travelPass->is_active,
                            'label' => __('main.is_active'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_featured" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_featured',
                            'id' => 'is_featured',
                            'value' => '1',
                            'checked' => $travelPass->is_featured,
                            'label' => __('main.is_featured'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="waives_visa_fee" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'waives_visa_fee',
                            'id' => 'waives_visa_fee',
                            'value' => '1',
                            'checked' => $travelPass->waives_visa_fee,
                            'label' => __('main.waives_visa_fee'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="must_purchase_before_arrival" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'must_purchase_before_arrival',
                            'id' => 'must_purchase_before_arrival',
                            'value' => '1',
                            'checked' => $travelPass->must_purchase_before_arrival,
                            'label' => __('main.must_purchase_before_arrival'),
                        ])
                    </div>
                </div>

                <!-- Update Submit -->
                @include('components.elements.update-submit', ['models' => 'dashboard.traveldocuments.travel-passes', 'model' => 'travel-pass'])
            </div>
        </form>
    </div>
@endsection
