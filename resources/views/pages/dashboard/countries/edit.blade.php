
@extends('layouts.master')

@section('title', __('Edit Country'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('Edit Country') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('Update country information in the database') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('countries.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('Back to Countries') }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Country Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('Country Information') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('countries.update', $country->id) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Flag Upload -->
                        <div class="text-center">
                            <div class="relative inline-block">
                                <div class="w-32 h-20 rounded-lg bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden flex items-center justify-center">
                                    <img id="flag-preview" src="{{ $country->flag_url ?? '' }}" alt="{{ __('Country Flag') }}"
                                         class="w-full h-full object-cover @if(!$country->flag_url) hidden @endif">
                                    <div id="flag-placeholder" class="text-4xl @if($country->flag_url) hidden @endif">3f3e0f</div>
                                </div>
                                <label for="flag" class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 cursor-pointer hover:bg-primary-dark">
                                    <i class="ki-filled ki-camera text-sm"></i>
                                </label>
                                <input type="file" id="flag" name="flag" class="hidden" accept="image/*">
                            </div>
                            <div class="text-sm text-secondary-foreground">{{ __('Click to upload country flag') }}</div>
                            @error('flag')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Country Name (Arabic) -->
                            <div>
                                <label for="name_ar" class="kt-label required">{{ __('Country Name (Arabic)') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input"
                                       placeholder="{{ __('Enter country name in Arabic') }}" required value="{{ old('name_ar', $country->name_ar) }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Name (English) -->
                            <div>
                                <label for="name_en" class="kt-label required">{{ __('Country Name (English)') }}</label>
                                <input type="text" name="name_en" id="name_en" class="kt-input"
                                       placeholder="{{ __('Enter country name in English') }}" required value="{{ old('name_en', $country->name_en) }}">
                                @error('name_en')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- Country Code (ISO 2) -->
                            <div>
                                <label for="code_iso2" class="kt-label required">{{ __('Country Code (ISO 2)') }}</label>
                                <input type="text" name="code_iso2" id="code_iso2" class="kt-input"
                                       placeholder="{{ __('Example: SA, AE') }}" maxlength="2" required value="{{ old('code_iso2', $country->code_iso2) }}">
                                @error('code_iso2')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Code (ISO 3) -->
                            <div>
                                <label for="code_iso3" class="kt-label">{{ __('Country Code (ISO 3)') }}</label>
                                <input type="text" name="code_iso3" id="code_iso3" class="kt-input"
                                       placeholder="{{ __('Example: SAU, ARE') }}" maxlength="3" value="{{ old('code_iso3', $country->code_iso3) }}">
                                @error('code_iso3')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Code -->
                            <div>
                                <label for="phone_code" class="kt-label">{{ __('Phone Code') }}</label>
                                <input type="text" name="phone_code" id="phone_code" class="kt-input"
                                       placeholder="{{ __('Example: +966') }}" value="{{ old('phone_code', $country->phone_code) }}">
                                @error('phone_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Capital City -->
                            <div>
                                <label for="capital" class="kt-label">{{ __('Capital City') }}</label>
                                <input type="text" name="capital" id="capital" class="kt-input"
                                       placeholder="{{ __('Example: Riyadh') }}" value="{{ old('capital', $country->capital) }}">
                                @error('capital')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency -->
                            <div>
                                <label for="currency_id" class="kt-label">{{ __('Official Currency') }}</label>
                                <select name="currency_id" id="currency_id" class="kt-select">
                                    <option value="">{{ __('Select currency') }}</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->id }}" {{ old('currency_id', $country->currency_id) == $currency->id ? 'selected' : '' }}>
                                            {{ $currency->code }} - {{ $currency->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Population -->
                            <div>
                                <label for="population" class="kt-label">{{ __('Population') }}</label>
                                <input type="number" name="population" id="population" class="kt-input"
                                       placeholder="{{ __('Example: 35000000') }}" value="{{ old('population', $country->population) }}">
                                @error('population')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Area (km²) -->
                            <div>
                                <label for="area" class="kt-label">{{ __('Area (km²)') }}</label>
                                <input type="number" step="any" name="area" id="area" class="kt-input"
                                       placeholder="{{ __('Example: 2149690') }}" value="{{ old('area', $country->area) }}">
                                @error('area')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Continent -->
                            <div>
                                <label for="continent" class="kt-label">{{ __('Continent') }}</label>
                                <input type="text" name="continent" id="continent" class="kt-input"
                                       placeholder="{{ __('Example: Asia') }}" value="{{ old('continent', $country->continent) }}">
                                @error('continent')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="p-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                {{ __('Update Country') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
