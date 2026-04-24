@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4">
        <div class="w-full max-w-5xl mx-auto">
            <div class="card card-flush">
                <div class="kt-card-body">
                    {{-- Stepper --}}
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            @php($labels = ['Traveler Info', 'Services', 'Itinerary', 'Review'])
                            @for ($i = 1; $i <= 4; $i++)
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-9 h-9 rounded-full flex items-center justify-center {{ ($step ?? 1) >= $i ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600' }}">
                                        {{ $i }}
                                    </div>
                                    <div class="hidden md:block">
                                        <div class="font-semibold">{{ $labels[$i - 1] }}</div>
                                    </div>
                                </div>
                                @if ($i < 4)
                                    <div class="flex-1 h-1 mx-2 {{ ($step ?? 1) > $i ? 'bg-primary' : 'bg-gray-200' }}">
                                    </div>
                                @endif
                            @endfor
                        </div>
                    </div>

                    @yield('form-content')
                </div>
            </div>
        </div>
    </div>
@endsection
