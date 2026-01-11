@php
    $name = isset($name) ? $name : 'timezone_id';
    $timezones = \App\Models\Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id']);
@endphp
<div>
    <label for="{{ isset($name) ? $name : '' }}" class="kt-label mb-2 flex items-center justify-between">
        {{ __('main.' . (isset($name) ? str_replace('_id', '', str_replace('app_', '', $name)) : '')) }}
        <a href="{{ route('timezones.create') }}" class="text-blue-600 text-2sm">
            {{ __('main.add') }}
        </a>
    </label>
    <select name="{{ isset($name) ? $name : '' }}" id="{{ isset($name) ? $name : '' }}" class="kt-select basic-single">
        @if (!isset($record) || !isset($record->{isset($name) ? $name : ''}))
            <option value="" selected disabled></option>
        @endif
        @foreach ($timezones as $timezone)
            <option value="{{ $timezone->id }}"
                {{ isset($record->{isset($name) ? $name : ''}) && $record->{isset($name) ? $name : ''} == $timezone->id ? 'selected' : '' }}>
                {{ app()->getLocale() == 'ar' ? ($timezone->name_ar ? $timezone->name_ar . ' ' : '') : ($timezone->name ? $timezone->name . ' ' : '') }}({{ $timezone->abbreviation }})
            </option>
        @endforeach
    </select>
    @error(isset($name) ? $name : '')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
