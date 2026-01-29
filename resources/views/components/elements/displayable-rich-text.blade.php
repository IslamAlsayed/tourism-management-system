@if (hasDisplayableRichText($record ?? null, $column))
    <div class="col-span-full border-custom rounded-lg p-4 {{ isset($classes) ? $classes : '' }}">
        <label class="kt-label mb-2 text-lg">{{ __('main.' . (isset($column) ? $column : '')) }}</label>
        <p class="text-xs text-secondary-foreground text-gray-100">
            {!! $record->{$column} ?? '' !!}
        </p>
    </div>
@endif
