@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.season')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.season')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.season')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.tourguides.seasons.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.seasons')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form class="space-y-6" method="POST"
                    action="{{ route('dashboard.tourguides.seasons.update', $season->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type" value="{{ request()->query('type') }}">

                    <div class="grid gap-4 lg:gap-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-end gap-6">
                            {{-- Polymorphic Model Select --}}
                            <livewire:polymorphic-model-select :record="$season" />

                            {{-- Name (English) --}}
                            <div class="align-self-end">
                                <label for="name" class="kt-label mb-1">
                                    {{ __('main.name') }}
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $season->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name (Arabic) --}}
                            <div>
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $season->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Season From --}}
                            <div class="align-self-end">
                                <label for="season_from" class="kt-label mb-1">
                                    {{ __('main.season_from') }}
                                </label>
                                <input type="date" name="season_from" id="season_from" class="kt-input h-[45px]"
                                    value="{{ old('season_from', $season->formatted_season_from) }}">
                                @error('season_from')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Season To --}}
                            <div class="align-self-end">
                                <label for="season_to" class="kt-label mb-1">
                                    {{ __('main.season_to') }}
                                </label>
                                <input type="date" name="season_to" id="season_to" class="kt-input h-[45px]"
                                    value="{{ old('season_to', $season->formatted_season_to) }}">
                                @error('season_to')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'description',
                            'value' => $season->description,
                        ])

                        {{-- Notes --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'notes',
                            'value' => $season->notes,
                        ])

                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_active',
                                'id' => 'is_active',
                                'value' => '1',
                                'checked' => $season->is_active,
                                'label' => __('main.active'),
                            ])
                        </div>

                        {{-- Dynamic Custom Fields --}}
                        <x-custom-fields module-name="tourguides" entity-type="Season" :entity="$season" />

                        <!-- Update Submit -->
                        @include('components.elements.update-submit', [
                            'models' => 'dashboard.tourguides.seasons',
                            'model' => 'season',
                        ])
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
