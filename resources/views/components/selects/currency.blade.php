<div>
    <label for="{{ isset($name) ? $name : '' }}"
        class="kt-label mb-2">{{ __('main.' . (isset($name) ? $name : '')) }}</label>
    <select name="{{ isset($name) ? $name : '' }}" id="{{ isset($name) ? $name : '' }}" class="kt-select basic-single">
        @if (!isset($record) || !isset($record->{isset($name) ? $name : ''}))
            <option value="" selected disabled>--</option>
        @endif
        @foreach ($currencies as $currency)
            <option value="{{ $currency->code }}"
                {{ isset($record->{isset($name) ? $name : ''}) && $record->{isset($name) ? $name : ''} == $currency->code ? 'selected' : '' }}>
                {{ $currency->code }} - {{ $currency->name }}
            </option>
        @endforeach
    </select>
    @error(isset($name) ? $name : '')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
