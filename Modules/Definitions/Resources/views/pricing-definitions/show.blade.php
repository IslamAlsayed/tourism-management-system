@extends('layouts.master')

@section('title', __('main.view_type', ['type' => __('main.pricing-definition')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $pricing->display_name }}
                </h1>
                <div class="flex items-center gap-2 text-sm text-secondary-foreground">
                    <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded text-xs font-mono">{{ $pricing->code }}</span>
                    <span class="text-gray-300">|</span>
                    <span
                        class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs">{{ \Modules\Definitions\Entities\PricingDefinition::getCategories()[$pricing->category] ?? $pricing->category }}</span>
                    <span class="text-gray-300">|</span>
                    @if ($pricing->is_active)
                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs">{{ __('main.active') }}</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs">{{ __('main.inactive') }}</span>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.definitions.pricing-definitions.edit', $pricing->id) }}"
                    class="kt-btn kt-btn-primary">
                    <i class="fas fa-edit me-1"></i> {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.definitions.pricing-definitions.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.pricing-definitions')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid gap-4 lg:gap-6">

            {{-- Basic Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.pricing')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <div>
                            <label class="kt-label text-gray-500 text-xs">{{ __('main.code') }}</label>
                            <p class="font-mono text-lg mt-1">{{ $pricing->code }}</p>
                        </div>
                        <div>
                            <label class="kt-label text-gray-500 text-xs">UUID</label>
                            <p class="font-mono text-xs mt-1 break-all">{{ $pricing->uuid }}</p>
                        </div>
                        <div>
                            <label class="kt-label text-gray-500 text-xs">{{ __('main.key') }}</label>
                            <p class="font-mono mt-1">{{ $pricing->key }}</p>
                        </div>
                        <div>
                            <label class="kt-label text-gray-500 text-xs">{{ __('main.name') }}</label>
                            <p class="mt-1 font-semibold">{{ $pricing->name }}</p>
                        </div>
                        <div>
                            <label class="kt-label text-gray-500 text-xs">{{ __('main.name_ar') }}</label>
                            <p class="mt-1 font-semibold" dir="rtl">{{ $pricing->name_ar ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="kt-label text-gray-500 text-xs">{{ __('main.category') }}</label>
                            <p class="mt-1">
                                <span
                                    class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-sm">{{ \Modules\Definitions\Entities\PricingDefinition::getCategories()[$pricing->category] ?? $pricing->category }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Module Usage --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">📦 Used In Modules</h3>
                </div>
                <div class="kt-card-body p-4">
                    @if ($pricing->moduleAssignments->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($pricing->moduleAssignments as $assignment)
                                <div class="border rounded-lg p-4 bg-green-50/50 border-green-200">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                        <span class="font-semibold capitalize">{{ $assignment->module_name }}</span>
                                    </div>
                                    @if ($assignment->field_name)
                                        <p class="text-xs text-gray-500 ml-4">
                                            <i class="fas fa-code text-gray-400 me-1"></i>
                                            {{ $assignment->field_name }}
                                        </p>
                                    @endif
                                    @if ($assignment->section_label)
                                        <p class="text-xs text-gray-500 ml-4">
                                            <i class="fas fa-tag text-gray-400 me-1"></i>
                                            {{ $assignment->section_label }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-unlink text-3xl mb-2"></i>
                            <p>This definition is not assigned to any module yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Description --}}
            @if ($pricing->richTextDescription && $pricing->richTextDescription->body)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.description') }}</h3>
                    </div>
                    <div class="kt-card-body p-4 prose max-w-none">
                        {!! $pricing->richTextDescription->body !!}
                    </div>
                </div>
            @endif

            {{-- Notes --}}
            @if ($pricing->richTextNotes && $pricing->richTextNotes->body)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.notes') }}</h3>
                    </div>
                    <div class="kt-card-body p-4 prose max-w-none">
                        {!! $pricing->richTextNotes->body !!}
                    </div>
                </div>
            @endif

            {{-- Metadata --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') ?? 'Metadata' }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <label class="text-gray-500 text-xs">Created At</label>
                            <p class="mt-1">{{ $pricing->created_at?->format('Y-m-d H:i') ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="text-gray-500 text-xs">Updated At</label>
                            <p class="mt-1">{{ $pricing->updated_at?->format('Y-m-d H:i') ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="text-gray-500 text-xs">Status</label>
                            <p class="mt-1">
                                @if ($pricing->is_active)
                                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs">Active</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs">Inactive</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="text-gray-500 text-xs">ID</label>
                            <p class="mt-1 font-mono">{{ $pricing->id }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
