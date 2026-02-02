@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.subregion')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.subregion')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.subregion')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('subregions.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.subregions')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Subregion Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.subregion')]) }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('subregions.update', $subregion->id) }}" class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Region -->
                            <div class="">
                                <label for="region_id" class="kt-label mb-2">
                                    <div>
                                        {{ __('main.region') }}
                                        <strong class="dataLength text-primary">
                                            ({{ count($regions) ?: 0 }})
                                        </strong>
                                    </div>
                                </label>
                                <select name="region_id" id="region_id" class="kt-input basic-single">
                                    <option value="" selected disabled></option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}" {{ $region->id == $subregion->region_id ? 'selected' : '' }}>
                                            {{ $region->name }}</option>
                                    @endforeach
                                </select>
                                @error('region_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Subregion Name (Arabic) -->
                            <div class="">
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.type_name_arabic', ['type' => __('main.subregion')]) }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" value="{{ $subregion->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Subregion Name (English) -->
                            <div class="">
                                <label for="name" class="kt-label mb-2">{{ __('main.type_name_english', ['type' => __('main.subregion')]) }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" value="{{ $subregion->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Wiki data id -->
                            <div class="">
                                <label for="wiki_data_id" class="kt-label mb-2">{{ __('main.wiki_data_id') }}</label>
                                <input type="text" name="wiki_data_id" id="wiki_data_id" class="kt-input h-[45px]" value="{{ $subregion->wiki_data_id }}">
                                @error('wiki_data_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Update Submit Buttons -->
                        @include('components.elements.update-submit', ['models' => 'subregions'])
                    </form>
                </div>
            </div>

            <!-- Quick Info -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.important_information') }}</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-information text-primary"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.ensure_data_accuracy') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.geographic_coordinates') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-geolocation text-success"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.geographic_coordinates') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.use_map_services') }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">
                                    {{ __('main.type_selection', ['type' => __('main.subregion')]) }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.region'), 'type2' => __('main.subregion')]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
