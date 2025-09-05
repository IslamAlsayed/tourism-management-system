@extends('pages.dashboard.quote.layout', ['step' => 2])

@section('form-content')
    <form method="POST" action="{{ route('dashboard.quote.postStep2', ['id' => $booking->id]) }}" class="space-y-8">
        @csrf

        <livewire:quote.step2.hotels :id="$booking->id" />

        <livewire:quote.step2.transportation :id="$booking->id" />

        <livewire:quote.step2.otherServices :id="$booking->id" />

        <div class="flex justify-between">
            <a href="{{ route('dashboard.quote.step1') }}" class="kt-btn kt-btn-light">Back</a>
            <button class="kt-btn kt-btn-primary">Next</button>
        </div>
    </form>
@endsection
