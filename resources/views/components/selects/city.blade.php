@php
    $name = isset($name) ? $name : 'city_id';
    $cities = \Modules\Geography\Entities\City::orderBy('name')->get(['id', 'name']);
@endphp
<div>
    <label for="{{ isset($name) ? $name : '' }}" class="kt-label mb-2 flex items-center justify-between">
        <div>
            {{ __('main.' . (isset($name) ? str_replace('_id', '', $name) : '')) }}
            <strong class="dataLength text-primary">
                ({{ count($cities) ?: 0 }})
            </strong>
        </div>
        <a href="{{ route('dashboard.geography.cities.create') }}" class="text-blue-600 text-2sm">
            {{ __('main.add') }}
        </a>
    </label>
    <select name="{{ isset($name) ? $name : '' }}" id="{{ isset($name) ? $name : '' }}" class="kt-select basic-single">
        @if (!isset($record) || !isset($record->{isset($name) ? $name : ''}))
            <option value="" selected disabled></option>
        @endif
        @forelse ($cities as $city)
            <option value="{{ $city->id }}"
                {{ isset($record->{isset($name) ? $name : ''}) && $record->{isset($name) ? $name : ''} == $city->id ? 'selected' : '' }}>
                {{ $city->name }}
            </option>
        @empty
            <option value="">{{ __('messages.no_records_found') }}</option>
        @endforelse
    </select>
    @error(isset($name) ? $name : '')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
