@extends('layouts.master')

@section('title', __('main.field-definitions'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.field-definitions') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.manage_type', ['type' => __('main.field-definitions')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.core.field-definitions.create') }}" class="kt-btn kt-btn-primary">
                    <i class="ki-outline ki-plus-squared"></i>
                    {{ __('main.create_type', ['type' => __('main.field-definition')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        @livewire('core::field-definitions')
    </div>
@endsection
