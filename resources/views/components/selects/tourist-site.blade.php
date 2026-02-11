@php
    $name = isset($name) ? $name : 'site_id';
    $sites = \Modules\Tourists\Entities\TouristSite::orderBy('name')->get(['id', 'name']);
@endphp
<div>
    <label for="{{ isset($name) ? $name : '' }}" class="kt-label mb-2 flex items-center justify-between">
        <div>
            {{ __('main.' . (isset($name) ? str_replace('_id', '', $name) : '')) }}
            <strong class="dataLength text-primary">
                ({{ count($sites) ?: 0 }})
            </strong>
        </div>
        <a href="{{ route('dashboard.tourists.sites.create') }}" class="text-blue-600 text-2sm">
            {{ __('main.add') }}
        </a>
    </label>
    <select name="{{ isset($name) ? $name : '' }}" id="{{ isset($name) ? $name : '' }}" class="kt-select basic-single">
        @if (!isset($record) || !isset($record->{isset($name) ? $name : ''}))
            <option value="" selected disabled></option>
        @endif
        @forelse ($sites as $site)
            <option value="{{ $site->id }}"
                {{ isset($record->{isset($name) ? $name : ''}) && $record->{isset($name) ? $name : ''} == $site->id ? 'selected' : '' }}>
                {{ $site->name }}
            </option>
        @empty
            <option value="">{{ __('messages.no_records_found') }}</option>
        @endforelse
    </select>
    @error(isset($name) ? $name : '')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
