<div class="flex items-center gap-4">
    <button id="formButtonSaveRecord" type="submit" class="kt-btn kt-btn-primary">
        <i class="ki-filled ki-check text-sm me-2"></i>
        {{ __('main.save_type', ['type' => __('main.' . (isset($model) ? $model : singularLowerCaseName($models)))]) }}
    </button>
    <button type="submit" name="save_and_add" value="1" class="kt-btn kt-btn-outline kt-btn-outline-primary">
        <i class="ki-filled ki-plus text-sm me-2"></i>
        {{ __('main.save_and_add_another') }}
    </button>
    <a href="{{ isset($cancel_route) ? $cancel_route : route($models . '.index') }}" class="kt-btn kt-btn-outline">
        {{ __('main.cancel') }}
    </a>
</div>
