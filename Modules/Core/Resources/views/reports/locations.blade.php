@extends('layouts.master')

@section('title', __('main.location_reports'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.location_reports') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.location_statistics') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.core.reports.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.location_reports')]) }}
                </a>
                <button class="kt-btn kt-btn-primary">
                    {{ __('main.export_report') }}
                </button>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Location Statistics -->
            <div class="grid gap-5 lg:grid-cols-4">
                {{-- Total Countries --}}
                <div class="p-2 kt-card">
                    <div class="kt-card-body">
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-3xl font-bold text-primary">
                                {{ number_format($locationStats['total_countries']) }}
                            </span>
                            <span class="text-sm text-secondary-foreground">
                                {{ __('main.total_countries_count') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Total Cities --}}
                <div class="p-2 kt-card">
                    <div class="kt-card-body">
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-3xl font-bold text-primary">
                                {{ number_format($locationStats['total_cities']) }}
                            </span>
                            <span class="text-sm text-secondary-foreground">
                                {{ __('main.total_cities_count') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Avg Cities Per Country --}}
                <div class="p-2 kt-card">
                    <div class="kt-card-body">
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-3xl font-bold text-primary">
                                {{ number_format($locationStats['countries_without_cities']) }}
                            </span>
                            <span class="text-sm text-secondary-foreground">
                                {{ __('main.avg_cities_per_country') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Countries With Cities --}}
                <div class="p-2 kt-card">
                    <div class="kt-card-body">
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-3xl font-bold text-primary">
                                {{ number_format($locationStats['avg_cities_per_country']) }}
                            </span>
                            <span class="text-sm text-secondary-foreground">
                                {{ __('main.countries_with_cities') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Countries Table -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.top_countries_by_cities') }}</h3>
                </div>
                <div class="kt-card-body">
                    <div class="table-responsive">
                        <table class="kt-table">
                            <thead>
                                <tr>
                                    <th>{{ __('main.rank') }}</th>
                                    <th>{{ __('main.country_name') }}</th>
                                    <th>{{ __('main.cities_count') }}</th>
                                    <th>{{ __('main.percentage') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topCountries as $index => $country)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $country->name }}</td>
                                        <td>{{ number_format($country->cities_count) }}</td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <span>{{ $locationStats['total_cities'] > 0 ? (number_format(($country->cities_count / $locationStats['total_cities']) * 100, 1) <= 9 ? '0' . number_format(($country->cities_count / $locationStats['total_cities']) * 100, 1) : number_format(($country->cities_count / $locationStats['total_cities']) * 100, 1)) : 0 }}%</span>
                                                <div class="progress-bar bg-primary"
                                                    style="height: 5px;  width: {{ $locationStats['total_cities'] > 0 ? ($country->cities_count / $locationStats['total_cities']) * 100 : 0 }}%">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
