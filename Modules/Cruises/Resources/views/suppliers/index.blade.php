@extends('layouts.master')

@section('title', __('main.cruise-suppliers'))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.cruise-suppliers') }}
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.cruises.suppliers.create') }}" class="kt-btn kt-btn-primary">
                    <i class="fa-duotone fa-solid fa-plus-squared text-lg"></i>
                    {{ __('main.add_new') }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        @livewire('cruises::supplier-list')
    </div>
@endsection
