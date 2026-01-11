@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.meal')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.meal')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.meal')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('meals.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.meals')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form class="space-y-6" method="POST" action="{{ route('meals.update', $meal->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type" value="{{ request()->query('type') }}">

                    <div class="grid gap-4 lg:gap-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-end gap-6 mb-4">
                            {{-- Polymorphic Model Select --}}
                            <livewire:polymorphic-model-select :record="$meal" />

                            {{-- Currency --}}
                            @include('components.selects.currency', [
                                'name' => 'currency_id',
                                'currencies' => $currencies,
                                'record' => $meal,
                            ])

                            {{-- Name (English) --}}
                            <div class="align-self-end">
                                <label for="name" class="kt-label">
                                    {{ __('main.name') }}
                                </label>
                                <input type="text" class="kt-input h-[45px]" id="name" name="name"
                                    value="{{ $meal->name }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name (Arabic) --}}
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label"></label>
                                {{ __('main.name_ar') }}
                                </label>
                                <input type="text" class="kt-input h-[45px]" id="name_ar" name="name_ar"
                                    value="{{ $meal->name_ar }}">
                                @error('name_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Price --}}
                            <div class="align-self-end">
                                <label for="price" class="kt-label mb-1">
                                    {{ __('main.price') }}
                                </label>
                                <input type="number" step="0.01" name="price" id="price" class="kt-input h-[45px]"
                                    value="{{ $meal->price }}" minLength="0">
                                @error('price')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'description',
                            'value' => $meal->description,
                        ])

                        {{-- Notes --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'notes',
                            'value' => $meal->notes,
                        ])

                        <div class="flex flex-wrap gap-10">
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_active" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_active',
                                    'id' => 'is_active',
                                    'value' => '1',
                                    'checked' => $meal->is_active,
                                    'label' => __('main.is_active'),
                                ])
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_included" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_included',
                                    'id' => 'is_included',
                                    'value' => '1',
                                    'checked' => $meal->is_included,
                                    'label' => __('main.is_included'),
                                ])
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_supplement" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_supplement',
                                    'id' => 'is_supplement',
                                    'value' => '1',
                                    'checked' => $meal->is_supplement,
                                    'label' => __('main.is_supplement'),
                                ])
                            </div>
                        </div>

                        {{-- Update Submit --}}
                        @include('components.elements.update-submit', ['models' => 'meals'])
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
