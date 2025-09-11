@extends('pages.dashboard.quote.v1.layout', ['step' => 2])

@section('form-content')
    <form method="POST" action="{{ route('dashboard.v1.quote.postStep2', ['id' => $booking->id]) }}" class="space-y-8">
        @csrf

        <livewire:quote.v1.step2.hotels :id="$booking->id" />

        <livewire:quote.v1.step2.transportation :id="$booking->id" />

        <livewire:quote.v1.step2.otherServices :id="$booking->id" />

        <div class="flex justify-between">
            <a href="{{ route('dashboard.v1.quote.step1') }}" class="kt-btn kt-btn-light">Back</a>
            <button class="kt-btn kt-btn-primary">Next</button>
        </div>
    </form>
@endsection
