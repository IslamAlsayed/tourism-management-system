@extends('pages.dashboard.quote.layout', ['step' => 1])

@section('form-content')
    <form method="POST" action="{{ route('dashboard.quote.postStep1') }}" class="space-y-6">
        @csrf

        <div class="grid lg:grid-cols-3 gap-6">
            <div>
                <label class="kt-label mb-2">First Name</label>
                <input type="text" name="first_name" class="kt-input" value="{{ old('first_name') }}">
                @error('first_name')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="kt-label mb-2">Last Name</label>
                <input type="text" name="last_name" class="kt-input" value="{{ old('last_name') }}">
                @error('last_name')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="kt-label mb-2">Email</label>
                <input type="email" name="email" class="kt-input" value="{{ old('email') }}">
                @error('email')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="kt-label mb-2">Phone</label>
                <input type="text" name="phone" class="kt-input" value="{{ old('phone') }}">
                @error('phone')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="kt-label mb-2">Nationality</label>
                <input type="text" name="nationality" class="kt-input" value="{{ old('nationality') }}">
            </div>

            <div>
                <label class="kt-label mb-2">Currency</label>
                <select name="currency_id" class="kt-select">
                    <option value="">Select currency</option>
                    @foreach ($currencies as $c)
                        <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->code }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="kt-label mb-2">Arrival Date</label>
                <input type="date" name="arrival_date" class="kt-input" value="{{ old('arrival_date') }}">
            </div>

            <div>
                <label class="kt-label mb-2">Departure Date</label>
                <input type="date" name="departure_date" class="kt-input" value="{{ old('departure_date') }}">
            </div>

            <div>
                <label class="kt-label mb-2">Adults</label>
                <input type="number" min="1" name="adults" class="kt-input" value="{{ old('adults', 1) }}">
            </div>

            <div>
                <label class="kt-label mb-2">Children</label>
                <input type="number" min="0" name="children" class="kt-input" value="{{ old('children', 0) }}">
            </div>

            <div>
                <label class="kt-label mb-2">Infants</label>
                <input type="number" min="0" name="infants" class="kt-input" value="{{ old('infants', 0) }}">
            </div>
        </div>

        <div class="flex justify-end">
            <button class="kt-btn kt-btn-primary">Next</button>
        </div>
    </form>
@endsection
