@extends('layouts.master')

@section('title', 'Accommodation Details')

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
                    Edit
                </a>
                <a href="{{ route('accommodations.index') }}" class="kt-btn kt-btn-outline">
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Basic Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Basic Information</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <label class="kt-label mb-1">Name (English)</label>
                            <p class="text-sm text-secondary-foreground">{{ $accommodation->name ?: 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">Name (Arabic)</label>
                            <p class="text-sm text-secondary-foreground" dir="rtl">
                                {{ $accommodation->name_ar ?: 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">Accommodation Type</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $accommodation->accommodation_type?->name ?: 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">Classification</label>
                            <p class="text-sm text-secondary-foreground">{{ $accommodation->classification ?: 'N/A' }}</p>
                        </div>
                        @if ($accommodation->stars)
                            <div>
                                <label class="kt-label mb-1">Star Rating</label>
                                <div class="flex items-center gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $accommodation->stars)
                                            <i class="ki-filled ki-star text-yellow-400 text-sm"></i>
                                        @else
                                            <i class="ki-outline ki-star text-gray-300 text-sm"></i>
                                        @endif
                                    @endfor
                                    <span class="text-sm text-secondary-foreground ml-2">{{ $accommodation->stars }}
                                        Stars</span>
                                </div>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">Status</label>
                            <div class="flex items-center gap-2">
                                @if ($accommodation->is_active)
                                    <span class="kt-badge kt-badge-success">Active</span>
                                @else
                                    <span class="kt-badge kt-badge-danger">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- @if ($accommodation->description) --}}
                    <div class="mt-6">
                        <label class="kt-label mb-1">Description</label>
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
                    <h3 class="kt-card-title">Location Information</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <label class="kt-label mb-1">Country</label>
                            <p class="text-sm text-secondary-foreground">{{ $accommodation->country?->name ?: 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">City</label>
                            <p class="text-sm text-secondary-foreground">{{ $accommodation->city?->name ?: 'N/A' }}</p>
                        </div>
                        @if ($accommodation->region)
                            <div>
                                <label class="kt-label mb-1">Region</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->region->name }}</p>
                            </div>
                        @endif
                        @if ($accommodation->subregion)
                            <div>
                                <label class="kt-label mb-1">Subregion</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->subregion->name }}</p>
                            </div>
                        @endif
                        @if ($accommodation->street)
                            <div class="lg:col-span-2">
                                <label class="kt-label mb-1">Street Address</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->street }}</p>
                            </div>
                        @endif
                        @if ($accommodation->latitude && $accommodation->longitude)
                            <div>
                                <label class="kt-label mb-1">Coordinates</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->latitude }},
                                    {{ $accommodation->longitude }}</p>
                            </div>
                            <div>
                                <label class="kt-label mb-1">Map</label>
                                <a href="https://maps.google.com?q={{ $accommodation->latitude }},{{ $accommodation->longitude }}"
                                    target="_blank" class="text-sm text-primary hover:underline">
                                    View on Google Maps
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Contact Information</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid lg:grid-cols-2 gap-6">
                        @if ($accommodation->general_mobile)
                            <div>
                                <label class="kt-label mb-1">General Mobile</label>
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
                                <label class="kt-label mb-1">General Email</label>
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
                                <label class="kt-label mb-1">Phone</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="tel:{{ $accommodation->phone }}" class="text-primary hover:underline">
                                        {{ $accommodation->phone }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->website)
                            <div>
                                <label class="kt-label mb-1">Website</label>
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
                            <h4 class="text-lg font-medium mb-4">Contact Person</h4>
                            <div class="grid lg:grid-cols-2 gap-6">
                                @if ($accommodation->contact_person)
                                    <div>
                                        <label class="kt-label mb-1">Name</label>
                                        <p class="text-sm text-secondary-foreground">{{ $accommodation->contact_person }}
                                        </p>
                                    </div>
                                @endif
                                @if ($accommodation->contact_position)
                                    <div>
                                        <label class="kt-label mb-1">Position</label>
                                        <p class="text-sm text-secondary-foreground">{{ $accommodation->contact_position }}
                                        </p>
                                    </div>
                                @endif
                                @if ($accommodation->contact_mobile)
                                    <div>
                                        <label class="kt-label mb-1">Mobile</label>
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
                                        <label class="kt-label mb-1">Email</label>
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
                    <h3 class="kt-card-title">Additional Information</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid lg:grid-cols-2 gap-6">
                        @if ($accommodation->default_currency)
                            <div>
                                <label class="kt-label mb-1">Default Currency</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->default_currency }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">Created At</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $accommodation->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        @if ($accommodation->updated_at != $accommodation->created_at)
                            <div>
                                <label class="kt-label mb-1">Last Updated</label>
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
                    Edit Accommodation
                </a>
                <form action="{{ route('accommodations.destroy', $accommodation->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this accommodation?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="kt-btn kt-btn-danger">
                        <i class="ki-filled ki-trash text-sm me-2"></i>
                        Delete
                    </button>
                </form>
                <a href="{{ route('accommodations.index') }}" class="kt-btn kt-btn-outline">
                    Back to Accommodations
                </a>
            </div>
        </div>
    </div>
@endsection
