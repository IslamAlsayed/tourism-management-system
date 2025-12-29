@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.tour-guide-type')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.tour-guide-type')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.tour-guide-type')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tour-guides-types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tour-guide-types')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Tour Guides Types Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.tour-guide-type')]) }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('tour-guides-types.store') }}" enctype="multipart/form-data"
                        class="space-y-6 p-4">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Type --}}
                            <div class="">
                                <label for="type" class="kt-label required mb-2">{{ __('main.type') }}</label>
                                <input type="text" name="type" id="type" class="kt-input h-[45px]" required
                                    value="{{ old('type') }}">
                                @error('type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Price --}}
                            <div class="">
                                <label for="price" class="kt-label required mb-2">{{ __('main.price') }}</label>
                                <input type="text" name="price" min="1" id="price" class="kt-input h-[45px]"
                                    required value="{{ old('price') }}">
                                @error('price')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Currency --}}
                            @include('components.selects.currency', [
                                'name' => 'currency_id',
                                'currencies' => $currencies,
                            ])

                            {{-- Regions [region, subregion, country, state, city] --}}
                            @include('components.regions.create', [
                                'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                                'multiple' => true,
                            ])
                        </div>

                        <!-- Description -->
                        @include('components.elements.input-text-editor', [
                            'column' => 'description',
                            'value' => old('description'),
                        ])

                        <!-- Notes -->
                        @include('components.elements.input-text-editor', [
                            'column' => 'notes',
                            'value' => old('notes'),
                        ])

                        <div class="flex flex-wrap mb-4" style="gap: 10px 40px;">
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

                        <!-- Save Submit -->
                        @include('components.elements.save-submit', ['models' => 'tour-guides-types'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                filterByForeignId("region_id", "subregion", "subregion_id");
                filterByForeignId("subregion_id", "country", "country_id");
                filterByForeignId("country_id", "state", "state_id");
                filterByForeignId("state_id", "city", "city_id");
            }, 500);
        });
    </script>
@endpush

@include('components.regions.script-cascading')
