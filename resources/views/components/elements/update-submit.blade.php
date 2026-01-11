<div class="flex items-center gap-4">
    <button type="submit" class="kt-btn kt-btn-primary">
        <i class="ki-filled ki-check text-sm me-2"></i>
        {{ __('main.update_type', ['type' => __('main.' . (isset($model) ? $model : singularLowerCaseName($models)))]) }}
    </button>
    <a href="{{ route("$models.index") }}" class="kt-btn kt-btn-outline">
        {{ __('main.cancel') }}
    </a>
</div>
