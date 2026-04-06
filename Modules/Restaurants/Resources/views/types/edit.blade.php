@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.restaurant_type')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.restaurant_type')]) }}
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.restaurants.types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.restaurant_types')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form class="space-y-6" method="POST"
                    action="{{ route('dashboard.restaurants.types.update', $type->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 lg:gap-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-end gap-6">
                            <div class="align-self-end">
                                <label for="name" class="kt-label mb-1">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $type->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $type->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @include('components.elements.input-text-editor', [
                            'name' => 'description',
                            'value' => $type->description,
                        ])

                        @include('components.elements.input-text-editor', [
                            'name' => 'notes',
                            'value' => $type->notes,
                        ])

                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_active',
                                'id' => 'is_active',
                                'value' => '1',
                                'checked' => $type->is_active,
                                'label' => __('main.is_active'),
                            ])
                        </div>

                        <x-custom-fields module-name="restaurants" entity-type="RestaurantType" :entity="$type" />

                        @include('components.elements.update-submit', [
                            'models' => 'dashboard.restaurants.types',
                            'model' => 'type',
                        ])
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
