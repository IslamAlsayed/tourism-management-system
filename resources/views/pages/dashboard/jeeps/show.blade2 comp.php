@extends('layouts.master')

@section('title', __('main.jeep_details') . ' : ' . $jeep->route)

@section('content')
    <div class="kt-container-fixed">
        <!-- Header -->
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono flex items-center gap-2">
                    {{ $jeep->route }}
                    @if ($jeep->status == 'active')
                        <span class="kt-badge kt-badge-success kt-badge-inline">{{ __('main.active') }}</span>
                    @elseif($jeep->status == 'maintenance')
                        <span class="kt-badge kt-badge-warning kt-badge-inline">{{ __('main.maintenance') }}</span>
                    @else
                        <span class="kt-badge kt-badge-danger kt-badge-inline">{{ __('main.retired') }}</span>
                    @endif
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    <span class="text-lg">{{ $jeep->route_ar }}</span>
                    <span class="text-gray-300 mx-2">•</span>
                    <i class="ki-outline ki-geolocation fs-4"></i> {{ $jeep->start_point }} - {{ $jeep->end_point }}
                    <span class="text-gray-300 mx-2">•</span>
                    <i class="ki-outline ki-briefcase fs-4"></i> {{ $jeep->company->name ?? '-' }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('jeeps.edit', $jeep->id) }}" class="kt-btn kt-btn-primary">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('jeeps.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_list') }}
                </a>
            </div>
        </div>

        <div class="grid gap-6">

            <!-- 1. Trip Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.trip_information') }}</h3>
                </div>
                <div class="kt-card-body p-6">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                        <!-- Left: Photo -->
                        <div class="md:col-span-4 lg:col-span-3">
                            @if ($jeep->photo)
                                <div class="rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                                    <img src="{{ asset('storage/' . $jeep->photo) }}" class="w-full h-auto object-cover" alt="Jeep Photo">
                                </div>
                            @else
                                <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 h-40 flex items-center justify-center text-gray-400">
                                    <i class="ki-outline ki-picture fs-2tx"></i>
                                </div>
                            @endif

                            <!-- Quick Stats -->
                            <div class="mt-4 bg-gray-50 rounded p-4 border border-gray-200">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fs-7 text-gray-600">{{ __('main.start_point') }}</span>
                                    <span class="fs-7 fw-bold text-gray-800 text-end">{{ $jeep->start_point ?: '-' }}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fs-7 text-gray-600">{{ __('main.end_point') }}</span>
                                    <span class="fs-7 fw-bold text-gray-800 text-end">{{ $jeep->end_point ?: '-' }}</span>
                                </div>
                                <div class="separator separator-dashed my-2"></div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fs-7 text-gray-600">{{ __('main.duration') }}</span>
                                    <span class="fs-7 fw-bold text-gray-800">{{ $jeep->duration }} {{ __('main.' . $jeep->duration_unit) }}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="fs-7 text-gray-600">{{ __('main.distance') }}</span>
                                    <span class="fs-7 fw-bold text-gray-800">{{ $jeep->distance }} {{ __('main.' . $jeep->distance_unit) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Description & Itinerary -->
                        <div class="md:col-span-8 lg:col-span-9">
                            <div class="mb-6">
                                <h4 class="text-base font-bold text-gray-800 mb-2">{{ __('main.description') }}</h4>
                                <div class="text-gray-600 leading-relaxed text-sm">
                                    {{ $jeep->description ?: __('main.no_description') }}
                                </div>
                            </div>

                            <div class="mb-6">
                                <h4 class="text-base font-bold text-gray-800 mb-2">{{ __('main.itinerary') }}</h4>
                                @if (!empty($jeep->route_itinerary))
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        @foreach ($jeep->route_itinerary as $index => $stop)
                                            <div class="flex items-center gap-3 bg-gray-50 p-2 rounded border border-gray-100">
                                                <div class="symbol symbol-25px symbol-circle">
                                                    <span class="symbol-label bg-light-primary text-primary fw-bold text-xs">{{ $index + 1 }}</span>
                                                </div>
                                                <span class="text-sm font-medium text-gray-700">{{ $stop }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted text-sm italic">{{ __('main.no_itinerary') }}</span>
                                @endif
                            </div>

                            @if ($jeep->notes)
                                <div class="bg-amber-50 border border-amber-200 rounded p-4 flex gap-3">
                                    <i class="ki-outline ki-information fs-2 text-amber-500"></i>
                                    <div>
                                        <h5 class="text-amber-800 font-bold text-sm mb-1">{{ __('main.notes') }}</h5>
                                        <p class="text-amber-700 text-sm">{{ $jeep->notes }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Vehicle Specification -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.vehicle_specification') }}</h3>
                </div>
                <div class="kt-card-body p-6">
                    <div class="flex flex-wrap gap-4 mb-6">
                        <!-- Model -->
                        <div class="border rounded p-3 min-w-[200px] flex-1 bg-white">
                            <span class="text-xs text-gray-500 uppercase block mb-1">{{ __('main.vehicle_model') }}</span>
                            <div class="flex items-center gap-2">
                                <i class="ki-outline ki-car fs-2 text-primary"></i>
                                <span class="font-bold text-lg text-gray-800">{{ $jeep->vehicle_model ?? '-' }}</span>
                            </div>
                        </div>
                        <!-- Year -->
                        <div class="border rounded p-3 min-w-[150px] flex-1 bg-white">
                            <span class="text-xs text-gray-500 uppercase block mb-1">{{ __('main.model_year') }}</span>
                            <div class="flex items-center gap-2">
                                <i class="ki-outline ki-calendar fs-2 text-primary"></i>
                                <span class="font-bold text-lg text-gray-800">{{ $jeep->model_year ?? '-' }}</span>
                            </div>
                        </div>
                        <!-- Seats -->
                        <div class="border rounded p-3 min-w-[150px] flex-1 bg-white">
                            <span class="text-xs text-gray-500 uppercase block mb-1">{{ __('main.seating_capacity') }}</span>
                            <div class="flex items-center gap-2">
                                <i class="ki-outline ki-people fs-2 text-primary"></i>
                                <span class="font-bold text-lg text-gray-800">{{ $jeep->car_seats }} {{ __('main.seats') }}</span>
                            </div>
                        </div>
                        <!-- Plate -->
                        <div class="border rounded p-3 min-w-[150px] flex-1 bg-white">
                            <span class="text-xs text-gray-500 uppercase block mb-1">{{ __('main.license_plate') }}</span>
                            <div class="flex items-center gap-2">
                                <i class="ki-outline ki-postcard fs-2 text-primary"></i>
                                <span class="font-bold text-lg text-gray-800 font-mono">{{ $jeep->license_plate ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div>
                        <h5 class="text-sm font-bold text-gray-700 mb-3">{{ __('main.features') }}</h5>
                        <div class="flex gap-3 flex-wrap">
                            <span class="badge badge-light-{{ $jeep->has_ac ? 'success' : 'secondary' }} flex items-center gap-2 py-2 px-3">
                                <i class="ki-outline ki-snow fs-4 {{ $jeep->has_ac ? 'text-success' : 'text-gray-400' }}"></i>
                                {{ __('main.has_ac') }}
                            </span>
                            <span class="badge badge-light-{{ $jeep->has_driver ? 'primary' : 'secondary' }} flex items-center gap-2 py-2 px-3">
                                <i class="ki-outline ki-user fs-4 {{ $jeep->has_driver ? 'text-primary' : 'text-gray-400' }}"></i>
                                {{ __('main.has_driver') }}
                            </span>
                            <span class="badge badge-light-{{ $jeep->is_4x4 ? 'warning' : 'secondary' }} flex items-center gap-2 py-2 px-3">
                                <i class="ki-outline ki-compass fs-4 {{ $jeep->is_4x4 ? 'text-warning' : 'text-gray-400' }}"></i>
                                {{ __('main.is_4x4') }}
                            </span>
                            <span class="badge badge-light-{{ $jeep->has_camping_gear ? 'danger' : 'secondary' }} flex items-center gap-2 py-2 px-3">
                                <i class="ki-outline ki-bank fs-4 {{ $jeep->has_camping_gear ? 'text-danger' : 'text-gray-400' }}"></i>
                                {{ __('main.has_camping_gear') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Pricing & Seasons -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.pricing_and_seasons') }}</h3>
                </div>
                <div class="kt-card-body p-6">
                    <!-- Base Price Banner -->
                    <div class="flex items-center bg-blue-50 rounded p-4 border border-blue-100 mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mr-4">
                            <i class="ki-outline ki-tag fs-2"></i>
                        </div>
                        <div>
                            <span class="text-sm text-blue-600 font-bold uppercase tracking-wider">{{ __('main.base_price') }}</span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-2xl font-bold text-gray-900">{{ $jeep->price }}</span>
                                <span class="text-lg text-gray-600">{{ $jeep->currency->symbol ?? '' }}</span>
                                <span class="text-sm text-gray-500 ml-2">({{ __('main.default_standard_price') }})</span>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <thead>
                                <tr class="fw-bold text-muted bg-gray-50 border-b">
                                    <th class="ps-4 min-w-150px">{{ __('main.season_name') }}</th>
                                    <th class="min-w-140px">{{ __('main.dates') }}</th>
                                    <th class="text-end min-w-100px">{{ __('main.price_local') }}</th>
                                    <th class="text-end min-w-100px">{{ __('main.price_arab') }}</th>
                                    <th class="text-end pe-4 min-w-100px">{{ __('main.price_foreigner') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jeep->seasons as $season)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span class="text-dark fw-bold fs-6">{{ $season->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-primary fs-7">{{ $season->start_date }} <i class="ki-outline ki-arrow-right mx-1 text-gray-400"></i>
                                                {{ $season->end_date }}</span>
                                        </td>
                                        <td class="text-end">
                                            <span class="text-dark fw-bold d-block fs-7">{{ $season->price_local }}</span>
                                        </td>
                                        <td class="text-end">
                                            <span class="text-dark fw-bold d-block fs-7">{{ $season->price_arab }}</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <span class="text-dark fw-bold d-block fs-7">{{ $season->price_foreigner }}</span>
                                        </td>
                                    </tr>
                                    @if ($season->nationalityPrices->count() > 0)
                                        <tr>
                                            <td colspan="5" class="bg-gray-50 ps-10 pe-4 py-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="text-xs font-bold uppercase text-gray-500">{{ __('main.nationality_exceptions') }}:</span>
                                                    @foreach ($season->nationalityPrices as $np)
                                                        <span class="badge badge-white border border-gray-300 text-gray-600">
                                                            {{ $np->nationality->name ?? 'Unknown' }}: <b>{{ $np->price }}</b> ({{ $np->price_type }})
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-8">
                                            {{ __('main.no_seasons_defined') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 4. Gallery -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.gallery') }}</h3>
                </div>
                <div class="kt-card-body p-6">
                    @if (!empty($jeep->gallery))
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach ($jeep->gallery as $img)
                                <a href="{{ asset('storage/' . $img) }}" target="_blank" class="block group relative rounded-lg overflow-hidden border border-gray-200">
                                    <div class="aspect-w-16 aspect-h-12 bg-gray-100">
                                        <img src="{{ asset('storage/' . $img) }}" class="object-cover w-full h-40 transition-transform duration-300 group-hover:scale-105" alt="Gallery Image">
                                    </div>
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all flex items-center justify-center">
                                        <i class="ki-outline ki-eye text-white opacity-0 group-hover:opacity-100 fs-2x transition-opacity"></i>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded border border-dashed border-gray-300">
                            <i class="ki-outline ki-picture fs-3x text-gray-400 mb-2"></i>
                            <p class="text-gray-500 font-medium">{{ __('main.no_gallery_images') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Metadata -->
            <div class="kt-card">
                <div class="kt-card-body p-4 text-xs text-gray-500">
                    <div class="flex flex-wrap gap-6">
                        <span>{{ __('main.created_by') }}: <span class="fw-bold">{{ $jeep->creator->name ?? '-' }}</span> ({{ $jeep->created_at }})</span>
                        <span>{{ __('main.updated_by') }}: <span class="fw-bold">{{ $jeep->updater->name ?? '-' }}</span> ({{ $jeep->updated_at }})</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
