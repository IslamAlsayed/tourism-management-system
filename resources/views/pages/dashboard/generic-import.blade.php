@extends('layouts.master')

@section('content')
    <div class="kt-container-fixed pt-4 pb-8">
        <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view ?? $models"
            :cancelRoute="url()->previous()" :requirements="[]" :googleDriveUrl="$googleDriveUrl ?? null" :lastImport="$lastImport ?? null" :history="$history ?? null">
        </x-import-form>
    </div>
@endsection
