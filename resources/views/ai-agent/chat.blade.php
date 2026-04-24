@extends('layouts.master')

@section('title', 'AI Agent Chat')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="kt-container-fixed d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('sidebar.Ai-Agent') ?? 'AI Agent' }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">{{ __('dashboard') ?? 'Home' }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('sidebar.Ai-Agent') ?? 'AI Agent Chat' }}</li>
                </ul>
            </div>
            <!--end::Page title-->
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="kt-container-fixed">
            <div class="kt-card" style="min-height: 700px; display: flex; flex-direction: column;">
                <div class="kt-card-header bg-light-primary rounded-top">
                    <h3 class="kt-card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1"><i class="fas fa-robot text-primary me-2"></i> {{ __('sidebar.Ai-Agent') ?? 'AI Assistant' }}</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">How can I help you today?</span>
                    </h3>
                </div>
                    <!-- AI Agent Chat Livewire Component -->
                    <livewire:ai-agent-chat />
            </div>
        </div>
    </div>
    <!--end::Content-->
</div>
@endsection
