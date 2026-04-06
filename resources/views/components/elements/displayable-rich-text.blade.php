@if (hasDisplayableRichText($record ?? null, $column))
    <div class="col-span-full border-custom rounded-lg p-4 {{ isset($classes) ? $classes : '' }}">
        <label class="kt-label mb-2 text-lg">{{ __('main.' . (isset($column) ? $column : '')) }}</label>
        <p class="text-xs text-secondary-foreground">
            {!! strip_tags($record->{$column} ?? '', '<p><br><b><strong><i><em><ul><ol><li><h1><h2><h3><h4><h5><h6><a><table><thead><tbody><tr><td><th>') !!}
        </p>
    </div>
@endif
