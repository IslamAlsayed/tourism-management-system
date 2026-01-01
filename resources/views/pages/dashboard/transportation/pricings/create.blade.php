@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.transportation-pricing')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.transportation-pricing')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.transportation-pricing')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('transportation.pricings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.transportation-pricings')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('transportation.pricings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">
                <!-- Transportation pricings Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.pricing')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <livewire:transportation.pricing-steps />

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- Price -->
                            <div class="align-self-end">
                                <label for="price" class="kt-label required">
                                    {{ __('main.price') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="text" name="price" id="price" class="kt-input h-[45px]" required
                                    value="{{ old('price') }}">
                                @error('price')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pricing Unit -->
                            <div class="align-self-end">
                                <label for="pricing_unit_id" class="kt-label required">
                                    {{ __('main.pricing_unit') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="pricing_unit_id" id="pricing_unit_id" class="kt-input basic-single" required>
                                    <option value="" disabled selected>--</option>
                                    @foreach ($pricingUnits as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ old('pricing_unit_id') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pricing_unit_id')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'description',
                    'value' => old('description'),
                ])

                {{-- Notes --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'notes',
                    'value' => old('notes'),
                ])

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => 1,
                            'label' => __('main.active'),
                        ])
                    </div>
                </div>

                {{-- Save Buttons --}}
                @include('components.elements.save-submit', [
                    'models' => 'transportation.pricings',
                    'model' => 'pricing',
                ])
            </div>
        </form>
    </div>
@endsection
