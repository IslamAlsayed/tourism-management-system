@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.transportation_vehicles')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.transportation_vehicles')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.transportation_vehicles')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('transportation-vehicles.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.transportation_vehicles')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- transportation_vehicles Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.type_information', ['type' => __('main.transportation_vehicles')]) }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('transportation-vehicles.update', $transportationCarRoute->id) }}"
                        class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 items-end mb-4">
                            <!-- Route -->
                            <div class="">
                                <label for="route" class="kt-label mb-2">{{ __('main.route') }}</label>
                                <input type="text" name="route" id="route" class="kt-input h-[45px]"
                                    value="{{ $transportationCarRoute->route }}">
                                @error('route')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Route ar -->
                            <div class="">
                                <label for="route_ar" class="kt-label mb-2">{{ __('main.route_ar') }}</label>
                                <input type="text" name="route_ar" id="route_ar" class="kt-input h-[45px]"
                                    value="{{ $transportationCarRoute->route_ar }}">
                                @error('route_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div class="">
                                <label for="duration" class="kt-label mb-2">{{ __('main.duration') }}
                                    ({{ __('main.hours') }})</label>
                                <input type="number" name="duration" id="duration" class="kt-input h-[45px]"
                                    value="{{ $transportationCarRoute->duration }}">
                                @error('duration')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Distance -->
                            <div class="">
                                <label for="distance" class="kt-label mb-2">{{ __('main.distance') }}
                                    ({{ __('main.kilometers') }})</label>
                                <input type="number" name="distance" id="distance" class="kt-input h-[45px]"
                                    value="{{ $transportationCarRoute->distance }}">
                                @error('distance')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Car route -->
                            <div class="">
                                <label for="car_route_id" class="kt-label mb-2">Car Route</label>
                                <select name="car_route_id" id="car_route_id" class="kt-input h-[45px]">
                                    <option value="">--</option>
                                    @foreach ($carRoutes as $carRoute)
                                        <option value="{{ $carRoute->id }}" title="{{ $carRoute->route }}"
                                            {{ $carRoute->id == $transportationCarRoute->details[0]->car_route_id ? 'selected' : '' }}>
                                            {{ limitedText($carRoute->route, 30) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Seats -->
                            <div class="">
                                <label for="seats" class="kt-label mb-2">{{ __('main.seats') }}</label>
                                <input type="number" name="seats" id="seats" class="kt-input h-[45px]"
                                    value="{{ $transportationCarRoute->details[0]->seats }}">
                                @error('seats')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Currency --}}
                            @include('components.selects.currency', [
                                'name' => 'currency_id',
                                'currencies' => $currencies,
                                'record' => $transportationCarRoute->details[0],
                            ])

                            <!-- Price -->
                            <div class="">
                                <label for="price" class="kt-label mb-2">{{ __('main.price') }}</label>
                                <input type="number" step="0.1" name="price" id="price" class="kt-input h-[45px]"
                                    value="{{ $transportationCarRoute->details[0]->price }}">
                                @error('price')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Update Submit Buttons -->
                        @include('components.elements.update-submit', [
                            'models' => 'transportation-vehicles',
                        ])
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
