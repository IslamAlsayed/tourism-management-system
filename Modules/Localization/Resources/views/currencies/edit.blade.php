@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.currency')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.currency')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.currency')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.localization.currencies.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.currencies')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-6">
            <!-- Currency Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.currency_information') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('dashboard.localization.currencies.update', $currency->id) }}" class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Currency Name -->
                            <div class="">
                                <label for="name" class="kt-label mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" value="{{ $currency->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency Code -->
                            <div class="">
                                <label for="code" class="kt-label mb-2">{{ __('main.currency_code_iso') }}</label>
                                <input type="text" name="code" id="code" class="kt-input h-[45px]" maxlength="3" value="{{ $currency->code }}" />
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency Symbol -->
                            <div class="">
                                <label for="symbol" class="kt-label mb-2">{{ __('main.currency_symbol') }}</label>
                                <input type="text" name="symbol" id="symbol" class="kt-input h-[45px]" maxLength="5" value="{{ $currency->symbol }}">
                                @error('symbol')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Currency Settings -->
                        <div class="space-y-4">
                            <h4 class="mb-2 font-semibold">{{ __('main.currency_settings') }}</h4>
                            <div class="grid lg:grid-cols-1 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_active" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'is_active',
                                        'id' => 'is_active',
                                        'value' => '1',
                                        'checked' => $currency->is_active,
                                        'label' => __('main.active'),
                                    ])
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="auto_update_rate" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'auto_update_rate',
                                        'id' => 'auto_update_rate',
                                        'value' => '1',
                                        'disabled' => true,
                                        'label' => __('main.auto_update_rate'),
                                    ])
                                </div>
                            </div>

                            <!-- Update Submit Buttons -->
                            @include('components.elements.update-submit', [
                                'models' => 'dashboard.localization.currencies',
                                'model' => 'currency',
                            ])
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
