@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.tours.guide')]))

@section('content')
    <!-- Dashboard Header -->
    <div class="kt-container-fixed py-5 border-b mb-8">
        <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-6">
            <div class="flex flex-col md:flex-row items-center gap-6 text-center md:text-start">
                <!-- Avatar Section -->
                <div class="symbol symbol-100px symbol-circle border border-gray-300 shadow-sm overflow-hidden bg-gray-100">
                    @if($tourGuide->image)
                        <img src="{{ asset('storage/' . $tourGuide->image) }}" alt="{{ $tourGuide->name }}" class="object-cover w-full h-full">
                    @else
                        <div class="flex items-center justify-center w-full h-full text-gray-400">
                            <i class="ki-outline ki-user fs-1"></i>
                        </div>
                    @endif
                </div>

                <!-- Basic Info Section -->
                <div class="flex flex-col gap-2">
                    <h1 class="text-3xl font-bold text-gray-900 mb-0">
                        {{ $tourGuide->name }}
                    </h1>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                        <span class="kt-badge kt-badge-light kt-badge-primary font-bold">
                            {{ $tourGuide->guide_type?->type ?? __('main.na') }}
                        </span>
                        @if($tourGuide->is_active)
                            <span class="kt-badge kt-badge-light kt-badge-success font-bold">
                                {{ __('main.active') }}
                            </span>
                        @else
                            <span class="kt-badge kt-badge-light kt-badge-destructive font-bold">
                                {{ __('main.inactive') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard.tourguides.guides.edit', $tourGuide->id) }}" class="kt-btn kt-btn-primary kt-btn-sm">
                    <i class="ki-outline ki-pencil fs-4 me-1"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.tourguides.guides.index') }}" class="kt-btn kt-btn-outline kt-btn-sm">
                    <i class="ki-outline ki-arrow-left fs-4 me-1"></i>
                    {{ __('main.back') }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <!-- Left Column: Primary Details -->
            <div class="xl:col-span-2 space-y-6">
                <!-- Personal Information Card -->
                <div class="card shadow-sm">
                    <div class="card-header py-4">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-900">{{ __('main.type_information', ['type' => __('main.tours.guide')]) }}</span>
                            <span class="text-muted mt-1 fw-semibold fs-7">{{ __('main.personal_details') }}</span>
                        </h3>
                    </div>
                    <div class="card-body py-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="text-muted fs-7 fw-bold text-uppercase mb-2 d-block">{{ __('main.name_ar') }}</label>
                                <div class="fs-6 text-gray-800 fw-bold">{{ $tourGuide->name_ar ?: __('main.na') }}</div>
                            </div>
                            <div>
                                <label class="text-muted fs-7 fw-bold text-uppercase mb-2 d-block">{{ __('main.gender') }}</label>
                                <div class="fs-6 text-gray-800 fw-bold">
                                    <span class="kt-badge kt-badge-light kt-badge-info">{{ $tourGuide->gender ?: __('main.na') }}</span>
                                </div>
                            </div>
                            <div>
                                <label class="text-muted fs-7 fw-bold text-uppercase mb-2 d-block">{{ __('main.birth_date') }}</label>
                                <div class="fs-6 text-gray-800 fw-bold">{{ $tourGuide->birth_date ?: __('main.na') }}</div>
                            </div>
                            <div>
                                <label class="text-muted fs-7 fw-bold text-uppercase mb-2 d-block">{{ __('main.age') }}</label>
                                <div class="fs-5 text-primary fw-bolder">{{ $tourGuide->age ?: __('main.na') }} {{ __('main.years') }}</div>
                            </div>
                            <div>
                                <label class="text-muted fs-7 fw-bold text-uppercase mb-2 d-block">{{ __('main.national_guide_id') }}</label>
                                <div class="fs-6 text-gray-800 fw-bold">{{ $tourGuide->national_guide_id ?: __('main.na') }}</div>
                            </div>
                            <div>
                                <label class="text-muted fs-7 fw-bold text-uppercase mb-2 d-block">{{ __('main.tourism_ministry_code') }}</label>
                                <div class="fs-6 text-gray-800 fw-bold">{{ $tourGuide->tourism_ministry_code ?: __('main.na') }}</div>
                            </div>
                        </div>

                        <div class="separator my-8 border-gray-200"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <div>
                                <label class="text-muted fs-7 fw-bold text-uppercase mb-2 d-block">{{ __('main.fd_day_fees') }}</label>
                                <div class="fs-5 text-gray-900 fw-boldest">
                                    {{ number_format($tourGuide->fd_day_fees ?? 0) }} <span class="fs-8 text-muted fw-normal">{{ $tourGuide->currency?->code }}</span>
                                </div>
                            </div>
                            <div>
                                <label class="text-muted fs-7 fw-bold text-uppercase mb-2 d-block">{{ __('main.hd_day_fees') }}</label>
                                <div class="fs-5 text-gray-900 fw-boldest">
                                    {{ number_format($tourGuide->hd_day_fees ?? 0) }} <span class="fs-8 text-muted fw-normal">{{ $tourGuide->currency?->code }}</span>
                                </div>
                            </div>
                            <div>
                                <label class="text-muted fs-7 fw-bold text-uppercase mb-2 d-block">{{ __('main.languages') }}</label>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @forelse ($tourGuide->tourGuideLanguages as $tgl)
                                        <span class="kt-badge kt-badge-light kt-badge-primary fw-bold">
                                            {{ $tgl->language?->name }}
                                            @if($tgl->proficiency) <span class="ms-1 opacity-50 text-xs">({{ $tgl->proficiency }})</span> @endif
                                        </span>
                                    @empty
                                        <span class="text-muted fs-7 italic">{{ __('main.na') }}</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description & Notes -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header py-4">
                            <h3 class="card-title fw-bold text-gray-900">
                                <i class="ki-outline ki-text-align-left fs-4 text-primary me-2"></i>
                                {{ __('main.description') }}
                            </h3>
                        </div>
                        <div class="card-body">
                            @if($tourGuide->description)
                                <div class="text-gray-700 fs-6 leading-relaxed">
                                    {!! $tourGuide->description !!}
                                </div>
                            @else
                                <div class="text-center py-6">
                                    <span class="text-muted italic">{{ __('main.no_description') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card shadow-sm h-100 border-dashed border-gray-300">
                        <div class="card-header py-4">
                            <h3 class="card-title fw-bold text-gray-900">
                                <i class="ki-outline ki-note fs-4 text-warning me-2"></i>
                                {{ __('main.notes') }}
                            </h3>
                        </div>
                        <div class="card-body bg-light-warning bg-opacity-10 rounded">
                            @if($tourGuide->notes)
                                <div class="text-gray-700 fs-6 italic leading-relaxed">
                                    {!! $tourGuide->notes !!}
                                </div>
                            @else
                                <div class="text-center py-6">
                                    <span class="text-muted italic">{{ __('main.no_notes') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Location & Contact -->
            <div class="space-y-6">
                <!-- Location Card -->
                <div class="card shadow-sm">
                    <div class="card-header py-4 bg-light-primary bg-opacity-10">
                        <h3 class="card-title fw-bold text-gray-900">
                            <i class="ki-outline ki-geolocation fs-3 text-primary me-2"></i>
                            {{ __('main.location_info') }}
                        </h3>
                    </div>
                    <div class="card-body py-6 space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="symbol symbol-40px symbol-circle bg-light-primary">
                                <span class="symbol-label text-primary"><i class="ki-outline ki-global fs-2"></i></span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-muted fs-8 fw-bold uppercase">{{ __('main.country') }}</span>
                                <span class="fs-6 text-gray-800 fw-bold">{{ $tourGuide->country?->name ?? __('main.na') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="symbol symbol-40px symbol-circle bg-light-success">
                                <span class="symbol-label text-success"><i class="ki-outline ki-pointers fs-2"></i></span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-muted fs-8 fw-bold uppercase">{{ __('main.state') }}</span>
                                <span class="fs-6 text-gray-800 fw-bold">{{ $tourGuide->state?->name ?? __('main.na') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="symbol symbol-40px symbol-circle bg-light-info">
                                <span class="symbol-label text-info"><i class="ki-outline ki-map fs-2"></i></span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-muted fs-8 fw-bold uppercase">{{ __('main.city') }} ({{ __('main.home_city') }})</span>
                                <span class="fs-6 text-gray-800 fw-bold">{{ $tourGuide->home_city ?? $tourGuide->city?->name ?? __('main.na') }}</span>
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t">
                            <div class="flex flex-col mb-4">
                                <span class="text-muted fs-8 fw-bold uppercase mb-1">{{ __('main.street_address') }}</span>
                                <span class="fs-6 text-gray-700">{{ $tourGuide->street ?? __('main.na') }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col">
                                    <span class="text-muted fs-8 fw-bold uppercase mb-1">{{ __('main.postal_code') }}</span>
                                    <span class="fs-6 text-gray-700">{{ $tourGuide->postal_code ?? __('main.na') }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-muted fs-8 fw-bold uppercase mb-1">{{ __('main.box') }}</span>
                                    <span class="fs-6 text-gray-700">{{ $tourGuide->box ?? __('main.na') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="card shadow-sm border-2 border-primary border-opacity-10">
                    <div class="card-header py-4">
                        <h3 class="card-title fw-bold text-gray-900">
                            <i class="ki-outline ki-phone fs-4 text-success me-2"></i>
                            {{ __('main.contact_info') }}
                        </h3>
                    </div>
                    <div class="card-body py-6 space-y-5">
                        <div class="flex items-center gap-4 bg-light-light p-3 rounded hover:bg-light transition-colors">
                            <div class="symbol symbol-35px bg-white border">
                                <span class="symbol-label text-gray-600"><i class="ki-outline ki-sms fs-2"></i></span>
                            </div>
                            <div class="flex flex-col overflow-hidden">
                                <span class="text-muted fs-9 fw-bold uppercase">{{ __('main.email') }}</span>
                                <a href="mailto:{{ $tourGuide->email }}" class="fs-6 text-primary fw-bold hover:underline truncate">
                                    {{ $tourGuide->email ?? __('main.na') }}
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 bg-light-light p-3 rounded">
                            <div class="symbol symbol-35px bg-white border">
                                <span class="symbol-label text-success"><i class="ki-outline ki-whatsapp fs-2"></i></span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-muted fs-9 fw-bold uppercase">{{ __('main.mobile_01') }}</span>
                                <a href="tel:{{ $tourGuide->mobile_01 }}" class="fs-6 text-gray-800 fw-boldest hover:text-success transition-colors">
                                    {{ $tourGuide->mobile_01 ?? __('main.na') }}
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 bg-light-light p-3 rounded">
                            <div class="symbol symbol-35px bg-white border">
                                <span class="symbol-label text-gray-600"><i class="ki-outline ki-phone fs-2"></i></span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-muted fs-9 fw-bold uppercase">{{ __('main.mobile_02') }}</span>
                                <span class="fs-6 text-gray-700 font-medium">{{ $tourGuide->mobile_02 ?? __('main.na') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="card shadow-sm">
                    <div class="card-body py-6">
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="fs-6 fw-bold text-gray-800">{{ __('main.status_label') }}</span>
                                <span class="text-muted fs-8">{{ __('main.toggle_status_desc') }}</span>
                            </div>
                            @livewire('toggle-switch', [
                                'modelId' => $tourGuide->id,
                                'modelType' => '\\Modules\\TourGuides\\Entities\\TourGuide',
                                'field' => 'is_active',
                                'value' => (bool) $tourGuide->is_active,
                                'table' => 'tour-guides',
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Metadata Section -->
        <div class="mt-8 mb-6">
            @include('components.metadata', ['record' => $tourGuide])
        </div>

        <!-- Sticky Footer with Actions -->
        <div class="bottom-0 left-0 right-0 z-10 py-4 mt-6">
            <div class="flex items-center justify-center gap-4">
                <div class="bg-white px-8 py-3 rounded-full shadow-lg border border-gray-200 flex items-center gap-4">
                    <form action="{{ route('dashboard.tourguides.guides.destroy', $tourGuide->id) }}" method="POST" class="d-inline border-e pe-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="kt-btn kt-btn-icon kt-btn-light kt-btn-destructive kt-btn-sm border-0 border-transparent bg-transparent" onclick="return confirm('{{ __('main.confirm_delete') }}')">
                            <i class="ki-outline ki-trash fs-3"></i>
                        </button>
                    </form>
                    
                    <a href="{{ route('dashboard.tourguides.guides.edit', $tourGuide->id) }}" class="kt-btn kt-btn-icon kt-btn-light kt-btn-sm bg-transparent">
                        <i class="ki-outline ki-pencil fs-3"></i>
                    </a>

                    <div class="border-s ps-4">
                        <a href="{{ route('dashboard.tourguides.guides.index') }}" class="kt-btn kt-btn-sm kt-btn-light bg-transparent">
                            <i class="ki-outline ki-arrow-left fs-4 me-2"></i>
                            {{ __('main.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
