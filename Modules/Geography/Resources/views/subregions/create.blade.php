@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.subregion')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.subregion')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.subregion')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.geography.subregions.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.subregions')]) }}
                </a>
            </div>
        </div>

        @include('components.must-add-first', [
            'requirements' => [
                [
                    'condition' => \Modules\Geography\Entities\Region::count() > 0,
                    'route' => route('dashboard.geography.regions.create'),
                    'label' => __('main.regions_'),
                ],
            ],
        ])
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Subregion Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.subregion')]) }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('dashboard.geography.subregions.store') }}" class="space-y-6 p-4">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Region id -->
                            <div class="">
                                <label for="region_id" class="kt-label required mb-2 flex items-center justify-between">
                                    <div>
                                        {{ __('main.region') }}
                                        <strong class="dataLength text-primary">
                                            ({{ count($regions) ?: 0 }})
                                        </strong>
                                    </div>
                                    <a href="{{ route('dashboard.geography.regions.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="region_id" id="region_id" class="kt-input basic-single">
                                    <option value="" selected disabled></option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                                @error('region_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Subregion Name (Arabic) -->
                            <div class="">
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.type_name_arabic', ['type' => __('main.subregion')]) }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Subregion Name (English) -->
                            <div class="">
                                <label for="name" class="kt-label required mb-2">{{ __('main.type_name_english', ['type' => __('main.subregion')]) }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required>
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Wiki data id -->
                            <div class="">
                                <label for="wiki_data_id" class="kt-label mb-2">{{ __('main.wiki_data_id') }}</label>
                                <input type="text" name="wiki_data_id" id="wiki_data_id" class="kt-input h-[45px]">
                                @error('wiki_data_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Save Submit Buttons -->
                        @include('components.elements.save-submit', ['models' => 'dashboard.geography.subregions', 'model' => 'subregion'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
