@extends('layouts.master')

@section('title', __('main.accommodation_details'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $accommodation->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $accommodation->accommodation_type?->name }} • {{ $accommodation->city?->name }},
                    {{ $accommodation->country?->name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('accommodations.edit', $accommodation->id) }}" class="kt-btn kt-btn-primary">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('accommodations.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_accommodations') }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Basic Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name_en') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $accommodation->name ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                            <p class="text-sm text-secondary-foreground" dir="rtl">
                                {{ $accommodation->name_ar ?: __('main.na') }}</p>
                        </div>
                        
                        <!-- Types (Many-to-Many) -->
                        <div class="lg:col-span-2">
                            <label class="kt-label mb-1">{{ __('main.types') }}</label>
                            <div class="flex flex-wrap gap-2">
                                @forelse($accommodation->types as $type)
                                    <span class="kt-badge kt-badge-primary">{{ $type->type->name }}</span>
                                @empty
                                    <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                                @endforelse
                            </div>
                        </div>
                        
                        <!-- Seasons (Many-to-Many) -->
                        <div class="lg:col-span-2">
                            <label class="kt-label mb-1">{{ __('main.seasons') }}</label>
                            <div class="flex flex-wrap gap-2">
                                @forelse($accommodation->seasons as $season)
                                    <span class="kt-badge kt-badge-info">{{ $season->season->name }}</span>
                                @empty
                                    <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                                @endforelse
                            </div>
                        </div>
                        
                        <div>
                            <label class="kt-label mb-1">{{ __('main.classification') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $accommodation->classification ?: __('main.na') }}</p>
                        </div>
                        @if ($accommodation->stars)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.star_rating') }}</label>
                                <div class="flex items-center gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $accommodation->stars)
                                            <i class="ki-filled ki-star text-yellow-400 text-sm"></i>
                                        @else
                                            <i class="ki-outline ki-star text-gray-300 text-sm"></i>
                                        @endif
                                    @endfor
                                    <span class="text-sm text-secondary-foreground ml-2">{{ $accommodation->stars }}
                                        {{ __('main.stars') }}</span>
                                </div>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.status') }}</label>
                            <div class="flex items-center gap-2">
                                @if ($accommodation->is_active)
                                    <span class="kt-badge kt-badge-success">{{ __('main.active') }}</span>
                                @else
                                    <span class="kt-badge kt-badge-danger">{{ __('main.inactive') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- @if ($accommodation->description) --}}
                    <div class="mt-6">
                        <label class="kt-label mb-1">{{ __('main.description') }}</label>
                        <div class="text-sm text-secondary-foreground prose max-w-none">
                            {!! $accommodation->description !!}
                        </div>
                    </div>
                    {{-- @endif --}}
                </div>
            </div>

            <!-- Location Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.location_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.country') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $accommodation->country?->name ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.city') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $accommodation->city?->name ?: __('main.na') }}
                            </p>
                        </div>
                        @if ($accommodation->region)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.region') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->region->name }}</p>
                            </div>
                        @endif
                        @if ($accommodation->subregion)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->subregion->name }}</p>
                            </div>
                        @endif
                        @if ($accommodation->street)
                            <div class="lg:col-span-2">
                                <label class="kt-label mb-1">{{ __('main.street_address') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->street }}</p>
                            </div>
                        @endif
                        @if ($accommodation->latitude && $accommodation->longitude)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.coordinates') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->latitude }},
                                    {{ $accommodation->longitude }}</p>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.map') }}</label>
                                <a href="https://maps.google.com?q={{ $accommodation->latitude }},{{ $accommodation->longitude }}"
                                    target="_blank" class="text-sm text-primary hover:underline">
                                    {{ __('main.view_on_google_maps') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid lg:grid-cols-2 gap-6">
                        @if ($accommodation->general_mobile)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.general_mobile') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="tel:{{ $accommodation->general_mobile }}"
                                        class="text-primary hover:underline">
                                        {{ $accommodation->general_mobile }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->general_email)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.general_email') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="mailto:{{ $accommodation->general_email }}"
                                        class="text-primary hover:underline">
                                        {{ $accommodation->general_email }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->phone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="tel:{{ $accommodation->phone }}" class="text-primary hover:underline">
                                        {{ $accommodation->phone }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->website)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.website') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="{{ $accommodation->website }}" target="_blank"
                                        class="text-primary hover:underline">
                                        {{ $accommodation->website }}
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>

                    @if (
                        $accommodation->contact_person ||
                            $accommodation->contact_position ||
                            $accommodation->contact_mobile ||
                            $accommodation->contact_email)
                        <div class="border-t pt-4 mt-4">
                            <h4 class="text-lg font-medium mb-4">{{ __('main.contact_person') }}</h4>
                            <div class="grid lg:grid-cols-2 gap-6">
                                @if ($accommodation->contact_person)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $accommodation->contact_person }}
                                        </p>
                                    </div>
                                @endif
                                @if ($accommodation->contact_position)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.position') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $accommodation->contact_position }}
                                        </p>
                                    </div>
                                @endif
                                @if ($accommodation->contact_mobile)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.mobile') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            <a href="tel:{{ $accommodation->contact_mobile }}"
                                                class="text-primary hover:underline">
                                                {{ $accommodation->contact_mobile }}
                                            </a>
                                        </p>
                                    </div>
                                @endif
                                @if ($accommodation->contact_email)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            <a href="mailto:{{ $accommodation->contact_email }}"
                                                class="text-primary hover:underline">
                                                {{ $accommodation->contact_email }}
                                            </a>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Additional Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.additional_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid lg:grid-cols-2 gap-6">
                        @if ($accommodation->default_currency)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.default_currency') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->default_currency }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $accommodation->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        @if ($accommodation->updated_at != $accommodation->created_at)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.last_updated') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodation->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                <a href="{{ route('accommodations.edit', $accommodation->id) }}" class="kt-btn kt-btn-primary">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit_accommodation') }}
                </a>
                <form action="{{ route('accommodations.destroy', $accommodation->id) }}" method="POST"
                    onsubmit="return confirm('{{ __('main.confirm_delete_message') }}')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="kt-btn kt-btn-danger">
                        <i class="ki-filled ki-trash text-sm me-2"></i>
                        {{ __('main.delete') }}
                    </button>
                </form>
                <a href="{{ route('accommodations.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_accommodations') }}
                </a>
            </div>
        </div>
    </div>
@endsection
