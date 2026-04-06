@extends('layouts.master')

@section('title', __('main.mcp'))

@section('content')
    <div class="container-fixed">
        <div class="kt-card">
            <div class="kt-card-header">
                <h3 class="kt-card-title">{{ __('main.mcp') }} - Google Drive</h3>
            </div>
            <div class="kt-card-body p-10 text-center">
                <div class="mb-5">
                    <i class="fa-duotone fa-solid fa-folder text-success fs-4x"></i>
                </div>
                <h2 class="fs-2x fw-bolder mb-2">Google Drive Integration</h2>
                <p class="text-gray-400 fs-4 fw-bold mb-10">
                    This tool will allow you to sync files and import data from Google Sheets automatically.
                </p>
                <span class="kt-badge kt-badge-light kt-badge-warning fs-base px-4 py-3">Coming Soon</span>
            </div>
        </div>
    </div>
@endsection
