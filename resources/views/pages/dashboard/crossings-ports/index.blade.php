@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => 'Crossings & Ports',
        'description' => 'Manage land crossings, airports, and seaports',
        'page_create_url' => '#',
        'page_create_title' => 'Add New Crossing/Port',
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <div class="kt-card-header">
                <h3 class="kt-card-title">All Crossings & Ports</h3>
                <div class="kt-menu" data-kt-menu="true">
                    <div class="kt-menu-item" data-kt-menu-item-offset="0, 10px" data-kt-menu-item-placement="bottom-start"
                        data-kt-menu-item-toggle="dropdown" data-kt-menu-item-trigger="click">
                        <button class="kt-menu-toggle kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost">
                            <i class="ki-filled ki-dots-vertical text-lg"></i>
                        </button>
                        <div class="kt-menu-dropdown kt-menu-default w-full max-w-[200px]" data-kt-menu-dismiss="true">
                            <div class="kt-menu-item">
                                <a class="kt-menu-link" href="#">
                                    <span class="kt-menu-icon">
                                        <i class="ki-filled ki-download"></i>
                                    </span>
                                    <span class="kt-menu-title">Export Data</span>
                                </a>
                            </div>
                            <div class="kt-menu-item">
                                <a class="kt-menu-link" href="#">
                                    <span class="kt-menu-icon">
                                        <i class="ki-filled ki-upload"></i>
                                    </span>
                                    <span class="kt-menu-title">Import Data</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-card-body p-0">
                <div class="overflow-x-auto">
                    <table class="kt-table kt-table-row-bordered kt-table-row-gray-300 align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="min-w-150px">Name</th>
                                <th class="min-w-140px">Type</th>
                                <th class="min-w-120px">Location</th>
                                <th class="min-w-100px">Code</th>
                                <th class="min-w-100px">Status</th>
                                <th class="min-w-100px">Capacity</th>
                                <th class="min-w-100px">Operating Hours</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $crossingsPorts = [
                                    [
                                        'id' => 1,
                                        'name' => 'King Fahd Causeway',
                                        'name_ar' => 'جسر الملك فهد',
                                        'type' => 'Land Crossing',
                                        'location' => 'Saudi Arabia - Bahrain',
                                        'code' => 'KFC',
                                        'status' => 'active',
                                        'capacity' => '50,000 vehicles/day',
                                        'operating_hours' => '24/7',
                                        'description' => 'Major land crossing connecting Saudi Arabia and Bahrain',
                                        'phone' => '+966 13 123 4567',
                                        'website' => 'www.kfc.gov.sa',
                                    ],
                                    [
                                        'id' => 2,
                                        'name' => 'King Khalid International Airport',
                                        'name_ar' => 'مطار الملك خالد الدولي',
                                        'type' => 'International Airport',
                                        'location' => 'Riyadh, Saudi Arabia',
                                        'code' => 'RUH',
                                        'status' => 'active',
                                        'capacity' => '35M passengers/year',
                                        'operating_hours' => '24/7',
                                        'description' =>
                                            'Major international airport serving Riyadh and central Saudi Arabia',
                                        'phone' => '+966 11 454 3333',
                                        'website' => 'www.kkaia.com',
                                    ],
                                    [
                                        'id' => 3,
                                        'name' => 'King Abdulaziz Port',
                                        'name_ar' => 'ميناء الملك عبدالعزيز',
                                        'type' => 'Seaport',
                                        'location' => 'Dammam, Saudi Arabia',
                                        'code' => 'DAM',
                                        'status' => 'active',
                                        'capacity' => '1.5M TEU/year',
                                        'operating_hours' => '24/7',
                                        'description' => 'Major commercial seaport on the Arabian Gulf',
                                        'phone' => '+966 13 883 3333',
                                        'website' => 'www.ports.gov.sa',
                                    ],
                                    [
                                        'id' => 4,
                                        'name' => 'Al-Batha Border Crossing',
                                        'name_ar' => 'معبر البطحاء الحدودي',
                                        'type' => 'Land Crossing',
                                        'location' => 'Saudi Arabia - UAE',
                                        'code' => 'ABC',
                                        'status' => 'active',
                                        'capacity' => '25,000 vehicles/day',
                                        'operating_hours' => '24/7',
                                        'description' => 'Land border crossing between Saudi Arabia and UAE',
                                        'phone' => '+966 11 123 4567',
                                        'website' => 'www.border.gov.sa',
                                    ],
                                    [
                                        'id' => 5,
                                        'name' => 'King Abdulaziz International Airport',
                                        'name_ar' => 'مطار الملك عبدالعزيز الدولي',
                                        'type' => 'International Airport',
                                        'location' => 'Jeddah, Saudi Arabia',
                                        'code' => 'JED',
                                        'status' => 'active',
                                        'capacity' => '30M passengers/year',
                                        'operating_hours' => '24/7',
                                        'description' =>
                                            'Major international airport serving Jeddah and western Saudi Arabia',
                                        'phone' => '+966 12 685 2000',
                                        'website' => 'www.kaia.com',
                                    ],
                                    [
                                        'id' => 6,
                                        'name' => 'Jubail Commercial Port',
                                        'name_ar' => 'ميناء الجبيل التجاري',
                                        'type' => 'Seaport',
                                        'location' => 'Jubail, Saudi Arabia',
                                        'code' => 'JUB',
                                        'status' => 'active',
                                        'capacity' => '1.2M TEU/year',
                                        'operating_hours' => '24/7',
                                        'description' => 'Major commercial and industrial seaport',
                                        'phone' => '+966 13 341 4444',
                                        'website' => 'www.ports.gov.sa',
                                    ],
                                ];
                            @endphp
                            @foreach ($crossingsPorts as $crossing)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-45px me-5">
                                                <img src="{{ asset('metronic/media/avatars/300-7.png') }}"
                                                    alt="{{ $crossing['name'] }}">
                                            </div>
                                            <div class="d-flex justify-content-start flex-column">
                                                <a href="#"
                                                    class="text-dark fw-bold text-hover-primary fs-6">{{ $crossing['name'] }}</a>
                                                <span
                                                    class="text-muted fw-semibold text-muted d-block fs-7">{{ $crossing['name_ar'] }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="kt-badge kt-badge-light-{{ $crossing['type'] == 'Land Crossing' ? 'primary' : ($crossing['type'] == 'International Airport' ? 'success' : 'info') }}">
                                            {{ $crossing['type'] }}
                                        </span>
                                    </td>
                                    <td class="text-muted fw-semibold text-muted">{{ $crossing['location'] }}</td>
                                    <td>
                                        <span class="kt-badge kt-badge-light-primary">{{ $crossing['code'] }}</span>
                                    </td>
                                    <td>
                                        <span class="kt-badge kt-badge-light-success">Active</span>
                                    </td>
                                    <td class="text-muted fw-semibold text-muted">{{ $crossing['capacity'] }}</td>
                                    <td class="text-muted fw-semibold text-muted">{{ $crossing['operating_hours'] }}</td>
                                    <td class="text-end">
                                        <a href="#"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            title="View">
                                            <i class="ki-filled ki-eye fs-3"></i>
                                        </a>
                                        <a href="#"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            title="Edit">
                                            <i class="ki-filled ki-pencil fs-3"></i>
                                        </a>
                                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm"
                                            title="Delete">
                                            <i class="ki-filled ki-trash fs-3"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Container -->
@endsection
