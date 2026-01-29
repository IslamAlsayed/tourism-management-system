@php
    $name = isset($name) ? $name : 'timezone_id';
    $timezones = \App\Models\Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id']);
@endphp
<div>
    <label for="{{ isset($name) ? $name : '' }}" class="kt-label mb-2 flex items-center justify-between">
        <div>
            {{ __('main.' . (isset($name) ? str_replace('_id', '', str_replace('app_', '', $name)) : '')) }}
            <strong class="dataLength text-primary">
                ({{ count($timezones) ?: 0 }})
            </strong>
        </div>
        <a href="{{ route('timezones.create') }}" class="text-blue-600 text-2sm">
            {{ __('main.add') }}
        </a>
    </label>
    <select name="{{ isset($name) ? $name : '' }}" id="{{ isset($name) ? $name : '' }}" class="kt-select basic-single">
        @if (!isset($record) || !isset($record->{isset($name) ? $name : ''}))
            <option value="" selected disabled></option>
        @endif
        @forelse ($timezones as $timezone)
            <option value="{{ $timezone->id }}" {{ isset($record->{isset($name) ? $name : ''}) && $record->{isset($name) ? $name : ''} == $timezone->id ? 'selected' : '' }}>
                {{ app()->getLocale() == 'ar' ? ($timezone->name_ar ? $timezone->name_ar . ' ' : '') : ($timezone->name ? $timezone->name . ' ' : '') }}({{ $timezone->abbreviation }})
            </option>
        @empty
            <option value="">{{ __('messages.no_records_found') }}</option>
        @endforelse
    </select>
    @error(isset($name) ? $name : '')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
