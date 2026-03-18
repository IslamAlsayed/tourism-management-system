@extends('layouts.master')

@section('title', __('main.mcp'))

@section('content')
    <div class="kt-container-fixed">
        <div class="kt-card">
            <div class="kt-card-header">
                <h3 class="kt-card-title">{{ __('main.mcp') }} - Google Maps</h3>
            </div>
            <div class="kt-card-body p-10 text-center">
                <div class="mb-5">
                    <i class="ki-outline ki-map text-primary fs-4x"></i>
                </div>
                <h2 class="fs-2x fw-bolder mb-2">Google Maps Integration</h2>
                <p class="text-gray-400 fs-4 fw-bold mb-10">
                    This tool will allow you to search for and import tourism locations directly into the system.
                </p>
                <span class="kt-badge kt-badge-light kt-badge-warning fs-base px-4 py-3">Coming Soon</span>
            </div>
        </div>
    </div>
@endsection
