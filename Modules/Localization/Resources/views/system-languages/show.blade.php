@extends('layouts.master')

@section('title', __('main.show_type', ['type' => __('main.language')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.show_type', ['type' => __('main.language')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.show_type_description', ['type' => __('main.language')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.localization.system-languages.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.languages')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid gap-5 lg:gap-6">
            <!-- Language Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_language_info') }}</h3>
                </div>
                <div class="kt-card-body">
                    <div class="space-y-6 p-4">
                        <!-- Languages Photo -->
                        @if($language->photo)
                        <div class="mb-4">
                            <label class="kt-label mb-2 block">{{ __('main.flag') }}</label>
                            <img src="{{ asset('storage/' . $language->photo) }}" class="w-32 h-auto rounded border shadow-sm" alt="{{ $language->code }} flag">
                        </div>
                        @else
                            <div class="mb-4">
                                <label class="kt-label mb-2 block">{{ __('main.flag') }}</label>
                                <div class="w-32 h-20 bg-gray-100 flex items-center justify-center rounded border text-gray-400">
                                    <i class="fa-duotone fa-solid fa-location-dot text-2xl"></i>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Language Code -->
                            <div class="">
                                <label class="kt-label mb-2">{{ __('main.code') }}</label>
                                <input type="text" class="kt-input h-[45px] bg-gray-50 border-gray-200 text-gray-600" disabled
                                    value="{{ $language->code }}">
                            </div>

                            <!-- Language Name (Arabic) -->
                            <div class="">
                                <label class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" class="kt-input h-[45px] bg-gray-50 border-gray-200 text-gray-600" disabled
                                    value="{{ $language->name_ar }}">
                            </div>

                            <!-- Language Name -->
                            <div class="">
                                <label class="kt-label mb-2">{{ __('main.name') }}</label>
                                <input type="text" class="kt-input h-[45px] bg-gray-50 border-gray-200 text-gray-600" disabled
                                    value="{{ $language->name }}">
                            </div>

                            <!-- Native Name -->
                            <div class="">
                                <label class="kt-label mb-2">{{ __('main.native_name') }}</label>
                                <input type="text" class="kt-input h-[45px] bg-gray-50 border-gray-200 text-gray-600" disabled
                                    value="{{ $language->native }}">
                            </div>

                            <!-- Language Direction -->
                            <div class="">
                                <label class="kt-label mb-2">{{ __('main.direction') }}</label>
                                <input type="text" class="kt-input h-[45px] bg-gray-50 border-gray-200 uppercase text-gray-600" disabled
                                    value="{{ $language->dir }}">
                            </div>
                        </div>

                        <div class="mt-5 pt-4 border-t border-gray-100 flex items-center gap-3">
                             <a href="{{ route('dashboard.localization.system-languages.edit', $language->id) }}" class="kt-btn kt-btn-primary">
                                 <i class="fa-duotone fa-solid fa-pen-to-square text-md"></i> {{ __('main.edit') }}
                             </a>
                             <a href="{{ route('dashboard.localization.system-languages.index') }}" class="kt-btn kt-btn-ghost text-gray-600">
                                 {{ __('main.cancel') }}
                             </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
