@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.restaurant')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.restaurant')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.restaurant')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.restaurants.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.restaurants')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('dashboard.restaurants.update', $restaurant->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">
                <!-- Location Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- City -->
                            <div>
                                <label for="city_id" class="kt-label">
                                    {{ __('main.city') }}
                                    <strong class="dataLength text-primary">
                                        ({{ $citiesCount ?: 0 }})
                                    </strong>
                                </label>
                                <select name="city_id" id="city_id" class="kt-select cities-select" data-value="{{ $restaurant->city_id }}">
                                    <option value="" selected>--</option>
                                </select>
                                @error('city_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Latitude -->
                            @include('components.inputs.latitude', ['record' => $restaurant])

                            <!-- Longitude -->
                            @include('components.inputs.longitude', ['record' => $restaurant])

                            {{-- Timezone --}}
                            @include('components.selects.timezone', ['record' => $restaurant])

                            {{-- Currency --}}
                            @include('components.selects.currency', ['record' => $restaurant])

                            <!-- Street Address -->
                            <div class="align-self-end">
                                <label for="street" class="kt-label">{{ __('main.street') }}</label>
                                <input type="text" name="street" id="street" class="kt-input h-[45px]" value="{{ $restaurant->street }}">
                                @error('street')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div class="align-self-end">
                                <label for="postal_code" class="kt-label">{{ __('main.postal_code') }}</label>
                                <input type="text" name="postal_code" id="postal_code" class="kt-input h-[45px]" value="{{ $restaurant->postal_code }}">
                                @error('postal_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Box -->
                            <div class="align-self-end">
                                <label for="box" class="kt-label">{{ __('main.box') }}</label>
                                <input type="text" name="box" id="box" class="kt-input h-[45px]" value="{{ $restaurant->box }}">
                                @error('box')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Restaurant Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.restaurant')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Name -->
                            <div class="align-self-end">
                                <label for="name" class="kt-label">
                                    {{ __('main.name') }}
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" value="{{ $restaurant->name }}">
                                @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name Arabic -->
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" value="{{ $restaurant->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Company Name -->
                            <div class="align-self-end">
                                <label for="company_name" class="kt-label">{{ __('main.company_name') }}</label>
                                <input type="text" name="company_name" id="company_name" class="kt-input h-[45px]" value="{{ $restaurant->company_name }}">
                                @error('company_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Type --}}
                            @include('components.selects.type', ['record' => $restaurant])

                            <!-- Rating -->
                            <div class="align-self-end">
                                <label for="rating" class="kt-label mb-2">{{ __('main.rating') }}</label>
                                <select name="rating" id="rating" class="kt-select basic-single">
                                    <option value="" disabled selected></option>
                                    @foreach (range(1, 5) as $item)
                                        <option value="{{ $item }}" {{ $restaurant->rating == $item ? 'selected' : '' }}>
                                            {{ $item }} {{ __('main.stars') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rating')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Specialty -->
                            <div class="align-self-end">
                                <label for="specialty" class="kt-label">{{ __('main.specialty') }}</label>
                                <input type="text" name="specialty" id="specialty" class="kt-input h-[45px]" value="{{ $restaurant->specialty }}">
                                @error('specialty')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- description --}}
                        @include('components.elements.input-text-editor', [
                            'column' => 'description',
                            'value' => $restaurant->description,
                            'classes' => 'mb-4',
                        ])

                        {{-- notes --}}
                        @include('components.elements.input-text-editor', [
                            'column' => 'notes',
                            'value' => $restaurant->notes,
                        ])
                    </div>
                </div>

                <!-- Media Information -->
                @include('components.inputs.photo', ['record' => $restaurant])

                <!-- Contact Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.contact')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- Email 01 -->
                            <div class="align-self-end">
                                <label for="email_01" class="kt-label">{{ __('main.email_01') }}</label>
                                <input type="email" name="email_01" id="email_01" class="kt-input h-[45px]" value="{{ $restaurant->email_01 }}">
                                @error('email_01')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email 02 -->
                            <div class="align-self-end">
                                <label for="email_02" class="kt-label">{{ __('main.email_02') }}</label>
                                <input type="email" name="email_02" id="email_02" class="kt-input h-[45px]" value="{{ $restaurant->email_02 }}">
                                @error('email_02')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone 01 -->
                            <div class="align-self-end">
                                <label for="phone_01" class="kt-label">{{ __('main.phone_01') }}</label>
                                <input type="tel" name="phone_01" id="phone_01" class="kt-input h-[45px]" value="{{ $restaurant->phone_01 }}">
                                @error('phone_01')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone 02 -->
                            <div class="align-self-end">
                                <label for="phone_02" class="kt-label">{{ __('main.phone_02') }}</label>
                                <input type="tel" name="phone_02" id="phone_02" class="kt-input h-[45px]" value="{{ $restaurant->phone_02 }}">
                                @error('phone_02')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mobile -->
                            <div class="align-self-end">
                                <label for="mobile" class="kt-label">{{ __('main.mobile') }}</label>
                                <input type="tel" name="mobile" id="mobile" class="kt-input h-[45px]" value="{{ $restaurant->mobile }}">
                                @error('mobile')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fax -->
                            <div class="align-self-end">
                                <label for="fax" class="kt-label">{{ __('main.fax') }}</label>
                                <input type="text" name="fax" id="fax" class="kt-input h-[45px]" value="{{ $restaurant->fax }}">
                                @error('fax')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Contact Person --}}
                            <div class="align-self-end">
                                <label for="contact_person" class="kt-label">{{ __('main.contact_person') }}</label>
                                <input type="text" name="contact_person" id="contact_person" class="kt-input h-[45px]"
                                    value="{{ $restaurant->contact_person }}">
                                @error('contact_person')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Website --}}
                            <div class="align-self-end">
                                <label for="website" class="kt-label">{{ __('main.website') }}</label>
                                <input type="url" name="website" id="website" class="kt-input h-[45px]" value="{{ $restaurant->website }}">
                                @error('website')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="wheelchair_accessible" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'wheelchair_accessible',
                            'id' => 'wheelchair_accessible',
                            'value' => '1',
                            'checked' => $restaurant->wheelchair_accessible,
                            'label' => __('main.wheelchair_accessible'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="free_wifi" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'free_wifi',
                            'id' => 'free_wifi',
                            'value' => '1',
                            'checked' => $restaurant->free_wifi,
                            'label' => __('main.free_wifi'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="parking" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'parking',
                            'id' => 'parking',
                            'value' => '1',
                            'checked' => $restaurant->parking,
                            'label' => __('main.parking'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="swimming_pool" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'swimming_pool',
                            'id' => 'swimming_pool',
                            'value' => '1',
                            'checked' => $restaurant->swimming_pool,
                            'label' => __('main.swimming_pool'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="gym" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'gym',
                            'id' => 'gym',
                            'value' => '1',
                            'checked' => $restaurant->gym,
                            'label' => __('main.gym'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="indoor" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'indoor',
                            'id' => 'indoor',
                            'value' => '1',
                            'checked' => $restaurant->indoor,
                            'label' => __('main.indoor'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="outdoor" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'outdoor',
                            'id' => 'outdoor',
                            'value' => '1',
                            'checked' => $restaurant->outdoor,
                            'label' => __('main.outdoor'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="spa" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'spa',
                            'id' => 'spa',
                            'value' => '1',
                            'checked' => $restaurant->spa,
                            'label' => __('main.spa'),
                        ])
                    </div>
                </div>

                {{-- Seasons Information --}}
                <livewire:morphic-forms.season-form :record="$restaurant" />

                {{-- Meals Information --}}
                <livewire:morphic-forms.meal-form :record="$restaurant" />

                {{-- Supplements Information --}}
                <livewire:morphic-forms.supplement-form :record="$restaurant" />

                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    @include('components.elements.checkbox-button', [
                        'name' => 'is_active',
                        'id' => 'is_active',
                        'value' => '1',
                        'checked' => $restaurant->is_active,
                        'label' => __('main.is_active'),
                    ])
                </div>

                <!-- Update Submit -->
                @include('components.elements.update-submit', [
                    'models' => 'dashboard.restaurants',
                    'model' => 'restaurant',
                ])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const citiesSelects = $('.cities-select');

            // Initialize Select2
            citiesSelects.select2({
                ajax: {
                    url: '{{ route('routes.cities') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                },
                placeholder: '{{ __('main.search') }}...',
                allowClear: true,
                minimumInputLength: 0,
                language: {
                    inputTooShort: function() {
                        return '--';
                    },
                    noResults: function() {
                        return '{{ __('main.no_results_found') }}';
                    }
                }
            });

            // ✅ Handle EDIT MODE for each select
            citiesSelects.each(function() {
                const select = $(this); // ✅ مهم
                const selectedCityId = select.data('value');
                if (!selectedCityId) return;
                $.ajax({
                    url: '{{ url('api/routes/cities') }}/' + selectedCityId,
                    type: 'GET',
                    dataType: 'json'
                }).done(function(data) {
                    if (select.find("option[value='" + data.id + "']").length) {
                        return;
                    }
                    const option = new Option(data.text, data.id, true, true);
                    select.append(option).trigger('change');
                });
            });
        });
    </script>
@endpush
