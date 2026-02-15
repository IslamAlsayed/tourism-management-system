@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.accommodation')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.accommodation')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.accommodation')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.accommodations.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.accommodations')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('dashboard.accommodations.update', $accommodation->id) }}" method="POST" enctype="multipart/form-data">
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
                                <label for="city_id" class="kt-label required mb-2 flex items-center justify-between">
                                    <div>
                                        {{ __('main.city') }}
                                        <strong class="dataLength text-primary">
                                            ({{ $countCities ?: 0 }})
                                        </strong>
                                    </div>
                                    <a href="{{ route('dashboard.geography.cities.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="city_id" id="city_id" class="kt-select cities-select" data-value="{{ $accommodation->city_id }}">
                                    <option value="" selected>--</option>
                                </select>
                                @error('city_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Currency --}}
                            @include('components.selects.currency', ['record' => $accommodation])

                            <!-- Street Address -->
                            <div class="align-self-end">
                                <label for="street" class="kt-label">{{ __('main.street_address') }}</label>
                                <input type="text" name="street" id="street" class="kt-input h-[45px]" value="{{ $accommodation->street }}"
                                    placeholder="Enter street address">
                                @error('street')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Latitude -->
                            @include('components.inputs.latitude', ['record' => $accommodation])

                            <!-- Longitude -->
                            @include('components.inputs.longitude', ['record' => $accommodation])
                        </div>
                    </div>
                </div>

                <!-- Accommodation Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.accommodation')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid lg:grid-cols-2 gap-6 items-end mb-4">
                            <!-- Name -->
                            <div class="align-self-end">
                                <label for="name" class="kt-label">
                                    {{ __('main.name') }}
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" value="{{ $accommodation->name }}">
                                @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name Arabic -->
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" value="{{ $accommodation->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6 mb-4">
                            {{-- Type --}}
                            @include('components.selects.type', ['record' => $accommodation])

                            <!-- Classification -->
                            <div class="align-self-end">
                                <label for="classification" class="kt-label">{{ __('main.classification') }}</label>
                                <input type="text" name="classification" id="classification" class="kt-input h-[45px]"
                                    value="{{ $accommodation->classification }}" placeholder="e.g., 5 Stars, Luxury">
                                @error('classification')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Stars Rating -->
                            <div class="align-self-end">
                                <label for="stars" class="kt-label mb-2">{{ __('main.star_rating') }}</label>
                                <select name="stars" id="stars" class="kt-select basic-single">
                                    <option value="" disabled selected></option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ $accommodation->stars == $i ? 'selected' : '' }}>
                                            {{ $i . ' ' . ($i > 1 ? __('main.stars') : __('main.star')) }}</option>
                                    @endfor
                                </select>
                                @error('stars')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'description',
                            'value' => $accommodation->description,
                            'classes' => 'mb-4',
                        ])

                        {{-- Notes --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'notes',
                            'value' => $accommodation->notes,
                        ])
                    </div>
                </div>

                <!-- Media Information -->
                @include('components.inputs.photo', ['record' => $accommodation])

                <!-- Contact Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.contact')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid lg:grid-cols-2 gap-6 items-end mb-4">
                            <!-- General Mobile -->
                            <div class="align-self-end">
                                <label for="general_mobile" class="kt-label">{{ __('main.general_mobile') }}</label>
                                <input type="tel" name="general_mobile" id="general_mobile" class="kt-input h-[45px]"
                                    value="{{ $accommodation->general_mobile }}" placeholder="+1234567890">
                                @error('general_mobile')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- General Email -->
                            <div class="align-self-end">
                                <label for="general_email" class="kt-label">{{ __('main.general_email') }}</label>
                                <input type="email" name="general_email" id="general_email" class="kt-input h-[45px]"
                                    value="{{ $accommodation->general_email }}" placeholder="info@accommodation.com">
                                @error('general_email')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6 items-end mb-4">
                            <!-- Phone -->
                            <div class="align-self-end">
                                <label for="phone" class="kt-label">{{ __('main.phone') }}</label>
                                <input type="tel" name="phone" id="phone" class="kt-input h-[45px]" value="{{ $accommodation->phone }}"
                                    placeholder="+1234567890">
                                @error('phone')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Website -->
                            <div class="align-self-end">
                                <label for="website" class="kt-label">{{ __('main.website') }}</label>
                                <input type="url" name="website" id="website" class="kt-input h-[45px]" value="{{ $accommodation->website }}"
                                    placeholder="https://www.accommodation.com">
                                @error('website')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Person Details -->
                        <div class="border-t pt-4 mt-4">
                            <h4 class="text-lg font-medium mb-4">{{ __('main.contact_person') }}</h4>
                            <div class="grid lg:grid-cols-2 gap-6 items-end mb-4">
                                <div class="align-self-end">
                                    <label for="contact_person" class="kt-label">{{ __('main.contact_person_name') }}</label>
                                    <input type="text" name="contact_person" id="contact_person" class="kt-input h-[45px]"
                                        value="{{ $accommodation->contact_person }}" placeholder="John Doe">
                                    @error('contact_person')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="align-self-end">
                                    <label for="contact_position" class="kt-label">{{ __('main.position') }}</label>
                                    <input type="text" name="contact_position" id="contact_position" class="kt-input h-[45px]"
                                        value="{{ $accommodation->contact_position }}" placeholder="Manager">
                                    @error('contact_position')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid lg:grid-cols-2 gap-6">
                                <div class="align-self-end">
                                    <label for="contact_mobile" class="kt-label">{{ __('main.contact_mobile') }}</label>
                                    <input type="tel" name="contact_mobile" id="contact_mobile" class="kt-input h-[45px]"
                                        value="{{ $accommodation->contact_mobile }}" placeholder="+1234567890">
                                    @error('contact_mobile')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="align-self-end">
                                    <label for="contact_email" class="kt-label">{{ __('main.contact_email') }}</label>
                                    <input type="email" name="contact_email" id="contact_email" class="kt-input h-[45px]"
                                        value="{{ $accommodation->contact_email }}" placeholder="manager@accommodation.com">
                                    @error('contact_email')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => $accommodation->is_active,
                            'label' => __('main.active'),
                        ])
                    </div>
                </div>

                {{-- Seasons Information --}}
                <livewire:morphic-forms.season-form :record="$accommodation" />

                {{-- Rooms Information --}}
                <livewire:morphic-forms.room-form :record="$accommodation" />

                {{-- Meals Information --}}
                <livewire:morphic-forms.meal-form :record="$accommodation" />

                {{-- Supplements Information --}}
                <livewire:morphic-forms.supplement-form :record="$accommodation" />

                <!-- Update Submit -->
                @include('components.elements.update-submit', [
                    'models' => 'dashboard.accommodations',
                    'model' => 'accommodation',
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
