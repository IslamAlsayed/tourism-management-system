@extends('layouts.master')

@section('content')
    <!-- begin::Content -->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!-- begin::Content container -->
        <div id="kt_app_content_container" class="container-fixed">
            <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :modelClass="$modelClass" :view="$view ?? $models"
                :cancelRoute="url()->previous()" :requirements="[]" :googleDriveUrl="$googleDriveUrl ?? null" :lastImport="$lastImport ?? null" :history="$history ?? null">
            </x-import-form>
        </div>
        <!-- end::Content container -->
    </div>
    <!-- end::Content -->
@endsection
