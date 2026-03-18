@extends('layouts.master')

@section('title', __('main.whatsapp'))

@section('content')
    <div class="kt-container-fixed">
        <div class="kt-card">
            <div class="kt-card-header border-0 pt-6">
                <div class="kt-card-title">
                    <h2>{{ __('main.whatsapp') }}</h2>
                </div>
            </div>
            <div class="kt-card-body pt-0 text-center py-20">
                <div class="mb-5">
                    <i class="ki-outline ki-message-notify text-success" style="font-size: 5rem;"></i>
                </div>
                <h2 class="fs-2x fw-bolder mb-2">{{ __('main.whatsapp') }}</h2>
                <p class="text-gray-400 fs-4 fw-bold mb-10">
                    ربط وإدارة خدمة رسائل واتساب وإرسال الإشعارات للمرشدين والسياح بشكل تلقائي.
                </p>
                <span class="kt-badge kt-badge-light kt-badge-warning fs-base px-4 py-3">قريباً</span>
            </div>
        </div>
    </div>
@endsection
