{{-- Rooms --}}
<div class="kt-card bg-green-100">
    <div class="kt-card-header">
        <h3 class="kt-card-title">
            {{ __('main.rooms') }}
            (<span class="font-semibold text-primary">{{ $record->rooms->count() }}</span>)
        </h3>
        <div class="kt-card-toolbar">
            <a href="{{ route('rooms.create') }}" class="kt-btn kt-btn-sm kt-btn-primary">
                <i class="ki-filled ki-plus text-sm me-1"></i>
                {{ __('main.add_type', ['type' => __('main.room')]) }}
            </a>
        </div>
    </div>
    <div class="kt-card-body p-4">
        <div class="grid lg:grid-cols-2 gap-4">
            @forelse($record->rooms as $room)
                <div wire:key="room-{{ $room->id }}"
                    class="kt-card background rounded-lg p-4 pt-2 record-rooms-{{ $room->id }}">
                    <div class="grid lg:grid-cols-2 gap-4">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $room->name ?: __('main.na') }}</p>
                        </div>
                        @if ($room->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $room->name_ar }}</p>
                            </div>
                        @endif
                        @if ($room->max_occupancy)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.max_occupancy') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $room->max_occupancy }}</p>
                            </div>
                        @endif
                        @if ($room->occupancy_details)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.occupancy_details') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $room->occupancy_details }}
                                </p>
                            </div>
                        @endif
                        <div class="col-span-2 flex items-center gap-10 mb-2">
                            <div wire:key="toggle-{{ $room->id }}-is_active">
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $room->id,
                                        'modelType' => '\\App\\Models\\Room',
                                        'field' => 'is_active',
                                        'value' => (bool) $room->is_active,
                                        'table' => 'rooms',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Room Pricing Information --}}
                    @if ($room->season || $room->price_per_person_double)
                        <div class="lg:col-span-2 mt-3 border-custom-t pt-3">
                            <label
                                class="kt-label mb-2">{{ __('main.type_information', ['type' => __('main.pricing')]) }}</label>
                            <div class="bg-blue-100 p-3 rounded-lg">
                                @if ($room->season)
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-medium text-sm">{{ $room->season->name }}</span>
                                        <span
                                            class="text-xs text-gray-500">{{ $room->season->season_from->format('Y-m-d') }}
                                            → {{ $room->season->season_to->format('Y-m-d') }}</span>
                                    </div>
                                @endif
                                <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 text-xs">
                                    @if ($room->price_per_person_double)
                                        <div>
                                            <span
                                                class="text-gray-600">{{ __('main.price_per_person_double') }}:</span>
                                            <span
                                                class="font-semibold">{{ number_format($room->price_per_person_double, 2) }}
                                                {{ $room->currency?->code }}</span>
                                        </div>
                                    @endif
                                    @if ($room->single_room_supplement)
                                        <div>
                                            <span class="text-gray-600">{{ __('main.single_room_supplement') }}:</span>
                                            <span
                                                class="font-semibold">{{ number_format($room->single_room_supplement, 2) }}
                                                {{ $room->currency?->code }}</span>
                                        </div>
                                    @endif
                                    @if ($room->triple_room_discount)
                                        <div>
                                            <span class="text-gray-600">{{ __('main.triple_room_discount') }}:</span>
                                            <span
                                                class="font-semibold">{{ number_format($room->triple_room_discount, 2) }}
                                                {{ $room->currency?->code }}</span>
                                        </div>
                                    @endif
                                    @if ($room->third_person_price)
                                        <div>
                                            <span class="text-gray-600">{{ __('main.third_person_price') }}:</span>
                                            <span
                                                class="font-semibold">{{ number_format($room->third_person_price, 2) }}
                                                {{ $room->currency?->code }}</span>
                                        </div>
                                    @endif
                                    @if ($room->extra_bed_price)
                                        <div>
                                            <span class="text-gray-600">{{ __('main.extra_bed_price') }}:</span>
                                            <span class="font-semibold">{{ number_format($room->extra_bed_price, 2) }}
                                                {{ $room->currency?->code }}</span>
                                        </div>
                                    @endif
                                    @if ($room->sea_view_supplement)
                                        <div>
                                            <span class="text-gray-600">{{ __('main.sea_view_supplement') }}:</span>
                                            <span
                                                class="font-semibold">{{ number_format($room->sea_view_supplement, 2) }}
                                                {{ $room->currency?->code }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($room->description)
                        <div class="lg:col-span-2 mt-2 border-custom-t pt-2">
                            <label class="kt-label mb-1">{{ __('main.description') }}</label>
                            <div class="text-sm text-secondary-foreground prose max-w-none">
                                {!! $room->description !!}</div>
                        </div>
                    @endif
                    <div class="lg:col-span-2 flex gap-2 mt-4">
                        @include('components.elements.show-button', [
                            'models' => 'rooms',
                            'id' => $room->id,
                        ])
                        @include('components.elements.edit-button', [
                            'models' => 'rooms',
                            'id' => $room->id,
                        ])
                        @livewire('delete-bottom', [
                            'type' => 'rooms',
                            'modelId' => $room->id,
                            'modelType' => '\\App\\Models\\Room',
                            'table' => 'rooms',
                        ])
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-8 text-secondary-foreground">
                    <i class="ki-filled ki-information text-4xl mb-2"></i>
                    <p>{{ __('main.no_data_available') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
