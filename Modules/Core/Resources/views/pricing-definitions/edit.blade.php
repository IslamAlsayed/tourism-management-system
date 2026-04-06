@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.pricing-definition')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.pricing-definition')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.pricing-definition')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.core.pricing-definitions.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.pricing-definitions')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <form action="{{ route('dashboard.core.pricing-definitions.update', $pricing->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">

                {{-- Identity & Info --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.pricing')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            {{-- Code (readonly) --}}
                            <div>
                                <label for="code" class="kt-label mb-1">{{ __('main.code') }}</label>
                                <input type="text" class="kt-input h-[45px] bg-gray-100" id="code"
                                    value="{{ $pricing->code }}" readonly>
                            </div>

                            {{-- UUID (readonly) --}}
                            <div>
                                <label for="uuid" class="kt-label mb-1">UUID</label>
                                <input type="text" class="kt-input h-[45px] bg-gray-100 text-xs" id="uuid"
                                    value="{{ $pricing->uuid }}" readonly>
                            </div>

                            {{-- Name (English) --}}
                            <div>
                                <label for="name" class="kt-label mb-1">{{ __('main.name') }}</label>
                                <input type="text" class="kt-input h-[45px]" id="name" name="name"
                                    value="{{ $pricing->name }}">
                                @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name (Arabic) --}}
                            <div>
                                <label for="name_ar" class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <input type="text" class="kt-input h-[45px]" id="name_ar" name="name_ar"
                                    value="{{ $pricing->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Key (readonly) --}}
                            <div>
                                <label for="key" class="kt-label mb-1">{{ __('main.key') }}</label>
                                <input type="text" name="key" id="key" class="kt-input h-[45px] bg-gray-100"
                                    value="{{ $pricing->key }}" readonly>
                            </div>

                            {{-- Category --}}
                            <div>
                                <label for="category" class="kt-label mb-1">{{ __('main.category') }}</label>
                                <select name="category" id="category" class="kt-select h-[45px]">
                                    <option value="">-- {{ __('main.select') }} --</option>
                                    @foreach (\Modules\Core\Entities\PricingDefinition::getCategories() as $catKey => $catLabel)
                                        <option value="{{ $catKey }}"
                                            {{ $pricing->category == $catKey ? 'selected' : '' }}>
                                            {{ $catLabel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Module Assignments --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">📦 Used In Modules</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <p class="text-sm text-gray-500 mb-4">
                            Select which modules and sections this definition should be available in.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach (\Modules\Core\Entities\PricingDefinition::getAvailableModules() as $modKey => $modLabel)
                                @php
                                    $assignment = $pricing->moduleAssignments->where('module_name', $modKey)->first();
                                @endphp
                                <div
                                    class="border rounded-lg p-4 {{ $assignment ? 'bg-blue-50/50 border-blue-200' : 'bg-gray-50/30' }}">
                                    <div class="flex items-center gap-3 mb-2">
                                        <input type="checkbox" name="modules[{{ $modKey }}][enabled]"
                                            id="module_{{ $modKey }}" value="1" class="kt-checkbox w-5 h-5"
                                            {{ $assignment ? 'checked' : '' }}>
                                        <label for="module_{{ $modKey }}" class="font-semibold cursor-pointer">
                                            {{ $modLabel }}
                                        </label>
                                    </div>
                                    <div class="ml-8">
                                        <input type="text" name="modules[{{ $modKey }}][field_name]"
                                            class="kt-input h-[35px] text-sm"
                                            placeholder="Field name (e.g. room_price_unit)"
                                            value="{{ $assignment->field_name ?? '' }}">
                                        <input type="text" name="modules[{{ $modKey }}][section_label]"
                                            class="kt-input h-[35px] text-sm mt-1"
                                            placeholder="Section label (e.g. Additional Pricing)"
                                            value="{{ $assignment->section_label ?? '' }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'description',
                    'value' => $pricing->description?->body,
                ])

                {{-- Notes --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'notes',
                    'value' => $pricing->notes?->body,
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
                    'models' => 'dashboard.core.pricing-definitions',
                    'model' => 'pricing-definition',
                ])
            </div>
        </form>
    </div>
@endsection
