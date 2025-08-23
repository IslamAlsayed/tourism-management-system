@extends('layouts.master')

@section('title', 'Dashboard Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard-home.css') }}">
@endpush

@section('content')
    <!-- Container -->
    <div class="kt-container-fixed" id="contentContainer"></div>
    <!-- End of Container -->

    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center justify-between gap-5 pb-7.5 lg:items-end">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Dashboard
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Central Hub for Personal Customization
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a class="kt-btn kt-btn-outline" href="{{ route('user.profile') }}">
                    View Profile
                </a>
            </div>
        </div>
    </div>
    <!-- End of Container -->

    {{-- Cards --}}
    <div class="card-category">
        <div class="basic-card basic-card-aqua">
            <div class="card-content w-100 flex flex-wrap items-center justify-between">
                <span class="card-title">Users</span>
                <span class="card-text" style="font-size: 20px">{{ $stats['users'] }}</span>
            </div>

            <div class="card-link">
                <a href="{{ route('users.index') }}" title="View Users"><span>View</span></a>
            </div>
        </div>

        <div class="basic-card basic-card-lips">
            <div class="card-content w-100 flex flex-wrap items-center justify-between">
                <span class="card-title">Countries</span>
                <span class="card-text" style="font-size: 20px">{{ $stats['countries'] }}</span>
            </div>

            <div class="card-link">
                <a href="{{ route('countries.index') }}" title="View Countries"><span>View</span></a>
            </div>
        </div>

        <div class="basic-card basic-card-light">
            <div class="card-content w-100 flex flex-wrap items-center justify-between">
                <span class="card-title">Cities</span>
                <span class="card-text" style="font-size: 20px">{{ $stats['cities'] }}</span>
            </div>

            <div class="card-link">
                <a href="{{ route('cities.index') }}" title="View Cities"><span>View</span></a>
            </div>
        </div>

        <div class="basic-card basic-card-dark">
            <div class="card-content w-100 flex flex-wrap items-center justify-between">
                <span class="card-title">Currencies</span>
                <span class="card-text" style="font-size: 20px">{{ $stats['currencies'] }}</span>
            </div>

            <div class="card-link">
                <a href="{{ route('currencies.index') }}" title="View Currencies"><span>View</span></a>
            </div>
        </div>
    </div>
    <!-- End of Cards -->
@endsection
