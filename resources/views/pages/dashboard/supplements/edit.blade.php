@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.supplement')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.supplement')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.supplement')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('supplements.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.supplements')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form class="space-y-6" method="POST" action="{{ route('supplements.update', $supplement->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 lg:gap-6">

                        <!-- Supplement Information -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-end gap-6">
                            {{-- Polymorphic Model Select --}}
                            <livewire:polymorphic-model-select :record="$supplement" />

                            {{-- Currency --}}
                            @include('components.selects.currency', [
                                'name' => 'currency_id',
                                'currencies' => $currencies,
                                'record' => $supplement,
                            ])

                            {{-- Name (English) --}}
                            <div class="align-self-end">
                                <label for="name" class="kt-label mb-1">
                                    {{ __('main.name') }}
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $supplement->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name (Arabic) --}}
                            <div>
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $supplement->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Price --}}
                            <div class="align-self-end">
                                <label for="price" class="kt-label mb-1">
                                    {{ __('main.price') }}
                                </label>
                                <input type="number" step="0.01" name="price" id="price" class="kt-input h-[45px]"
                                    value="{{ $supplement->price }}" min="0">
                                @error('price')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Price Type --}}
                            <div class="align-self-end">
                                <label for="price_type" class="kt-label mb-2">{{ __('main.price_type') }}</label>
                                <select name="price_type" id="price_type" class="kt-select basic-single">
                                    <option value="per_person"
                                        {{ $supplement->price_type == 'per_person' ? 'selected' : '' }}>
                                        {{ __('main.per_person') }}
                                    </option>
                                    <option value="per_room" {{ $supplement->price_type == 'per_room' ? 'selected' : '' }}>
                                        {{ __('main.per_room') }}
                                    </option>
                                    <option value="per_night"
                                        {{ $supplement->price_type == 'per_night' ? 'selected' : '' }}>
                                        {{ __('main.per_night') }}
                                    </option>
                                    <option value="one_time" {{ $supplement->price_type == 'one_time' ? 'selected' : '' }}>
                                        {{ __('main.one_time') }}
                                    </option>
                                </select>
                                @error('price_type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'description',
                            'value' => $supplement->description,
                        ])

                        {{-- Notes --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'notes',
                            'value' => $supplement->notes,
                        ])

                        <!-- Checkboxes -->
                        <div class="flex gap-6">
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_active" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_active',
                                    'id' => 'is_active',
                                    'value' => '1',
                                    'checked' => $supplement->is_active,
                                    'label' => __('main.is_active'),
                                ])
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_mandatory" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_mandatory',
                                    'id' => 'is_mandatory',
                                    'value' => '1',
                                    'checked' => $supplement->is_mandatory,
                                    'label' => __('main.is_mandatory'),
                                ])
                            </div>
                        </div>

                        <!-- Update Submit -->
                        @include('components.elements.update-submit', ['models' => 'supplements'])
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
