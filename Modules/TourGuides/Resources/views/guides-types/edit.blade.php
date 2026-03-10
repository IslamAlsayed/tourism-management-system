@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.tours.guide-type')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.tours.guide-type')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.tours.guide-type')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.tourguides.guides-types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tours.guide-types')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form class="space-y-6" method="POST"
            action="{{ route('dashboard.tourguides.guides-types.update', $tourGuideType->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">
                {{-- Location Information --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        {{-- Regions [country, state, city] --}}
                        @livewire('geography::livewire.regions.location-select-base', ['record' => $tourGuideType, 'multiple' => ['states', 'cities']])

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            {{-- Currency --}}
                            @include('components.selects.currency', ['record' => $tourGuideType])
                        </div>
                    </div>
                </div>

                {{-- Tour Guide Type Information --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.tours.guide-type')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            {{-- Type --}}
                            <div class="">
                                <label for="type" class="kt-label mb-2">{{ __('main.type') }}</label>
                                <input type="text" name="type" id="type" class="kt-input h-[45px]"
                                    value="{{ $tourGuideType->type }}">
                                @error('type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Price --}}
                            <div class="">
                                <label for="price" class="kt-label mb-2">{{ __('main.price') }}</label>
                                <input type="text" name="price" min="1" id="price" class="kt-input h-[45px]"
                                    value="{{ $tourGuideType->price }}">
                                @error('price')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @include('components.elements.input-text-editor', [
                    'column' => 'description',
                    'value' => $tourGuideType->description,
                ])

                {{-- Notes --}}
                @include('components.elements.input-text-editor', [
                    'column' => 'notes',
                    'value' => $tourGuideType->notes,
                ])

                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    @include('components.elements.checkbox-button', [
                        'name' => 'is_active',
                        'id' => 'is_active',
                        'value' => '1',
                        'checked' => $tourGuideType->is_active,
                        'label' => __('main.is_active'),
                    ])
                </div>

                {{-- Dynamic Custom Fields --}}
                <x-custom-fields module-name="tour_guides" entity-type="TourGuideType" :entity="$tourGuideType" />

                {{-- Update Buttons --}}
                @include('components.elements.update-submit', [
                    'models' => 'dashboard.tourguides.guides-types',
                    'model' => 'tours.guide-type',
                ])
            </div>
        </form>
    </div>
@endsection
