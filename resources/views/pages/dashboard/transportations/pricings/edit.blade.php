@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.transportations-pricing')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.transportations-pricing')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.transportations-pricing')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('transportations.pricings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.transportations-pricings')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('transportations.pricings.update', $pricing->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">
                <!-- Transportations pricings Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.pricing')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <livewire:transportations.pricing-steps :record="$pricing" />

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 items-end gap-6">
                            <!-- Price -->
                            <div>
                                <label for="price" class="kt-label">{{ __('main.price') }}</label>
                                <input type="number" name="price" id="price" class="kt-input h-[45px]"
                                    value="{{ $pricing->price }}" minlength="1">
                                @error('price')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tax -->
                            <div>
                                <label for="tax" class="kt-label">{{ __('main.tax') }}
                                    <span class="text-primary font-semibold">(%)</span>
                                </label>
                                <input type="number" name="tax" id="tax" class="kt-input h-[45px]"
                                    value="{{ $pricing->tax }}" minlength="0" maxlength="100">
                                @error('tax')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pricing Unit -->
                            <div>
                                <label for="pricing_unit_id" class="kt-label">
                                    {{ __('main.pricing_unit') }}
                                </label>
                                <select name="pricing_unit_id" id="pricing_unit_id" class="kt-input basic-single">
                                    <option value="" disabled selected>--</option>
                                    @foreach ($pricingUnits as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ $pricing->pricing_unit_id == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pricing_unit_id')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Currency --}}
                            @include('components.selects.currency', [
                                'name' => 'currency_id',
                                'currencies' => $currencies,
                                'record' => $pricing,
                            ])
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'description',
                    'value' => $pricing->description,
                ])

                {{-- Notes --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'notes',
                    'value' => $pricing->notes,
                ])

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => $pricing->is_active,
                            'label' => __('main.active'),
                        ])
                    </div>
                </div>

                {{-- Update Buttons --}}
                @include('components.elements.update-submit', [
                    'models' => 'transportations.pricings',
                    'model' => 'transportations-pricing',
                ])
            </div>
        </form>
    </div>
@endsection
