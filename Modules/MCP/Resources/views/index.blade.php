@extends('layouts.master')

@section('title', __('main.mcp'))

@section('content')
    <div class="container-fixed">
        <div class="kt-card">
            <div class="kt-card-header border-0 pt-6">
                <div class="kt-card-title">
                    <h2>{{ __('main.mcp') }} Dashboard</h2>
                </div>
            </div>
            <div class="kt-card-body pt-0">
                <p class="text-gray-600 fs-4 fw-medium">
                    Welcome to the Modular Connection Protocol (MCP) hub. Here you can manage all external AI and data integrations.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    <!-- Google Maps Card -->
                    <a href="{{ route('dashboard.mcp.google-maps') }}" class="kt-card shadow-sm hover:shadow-md transition-all p-8 flex items-center gap-4">
                        <div class="symbol symbol-50px">
                            <div class="symbol-label bg-light-primary">
                                <i class="fa-duotone fa-solid fa-map-location-dot text-primary fs-2"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-gray-900 fw-bold fs-3">Google Maps</span>
                            <div class="text-gray-400 fs-7">Location data & enrichment</div>
                        </div>
                    </a>

                    <!-- Google Drive Card -->
                    <a href="{{ route('dashboard.mcp.google-drive') }}" class="kt-card shadow-sm hover:shadow-md transition-all p-8 flex items-center gap-4">
                        <div class="symbol symbol-50px">
                            <div class="symbol-label bg-light-success">
                                <i class="fa-duotone fa-solid fa-folder text-success fs-2"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-gray-900 fw-bold fs-3">Google Drive</span>
                            <div class="text-gray-400 fs-7">Cloud storage & sheet sync</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
