@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => 'Vehicles',
        'description' => 'Manage tourist buses, transport vehicles, and 4x4 vehicles',
        'page_add_url' => '#',
        'page_add_title' => 'Add New Vehicle',
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <div class="kt-card-header">
                <h3 class="kt-card-title">All Vehicles</h3>
                <div class="kt-menu" data-kt-menu="true">
                    <div class="kt-menu-item" data-kt-menu-item-offset="0, 10px"
                        data-kt-menu-item-placement="bottom-start" data-kt-menu-item-toggle="dropdown"
                        data-kt-menu-item-trigger="click">
                        <button class="kt-menu-toggle kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost">
                            <i class="ki-filled ki-dots-vertical text-lg"></i>
                        </button>
                        <div class="kt-menu-dropdown kt-menu-default w-full max-w-[200px]"
                            data-kt-menu-dismiss="true">
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
                                <th class="min-w-150px">Vehicle Name</th>
                                <th class="min-w-140px">Type</th>
                                <th class="min-w-120px">Company</th>
                                <th class="min-w-100px">Capacity</th>
                                <th class="min-w-100px">Year</th>
                                <th class="min-w-100px">Status</th>
                                <th class="min-w-100px">Location</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $vehicles = [
                                    [
                                        'id' => 1,
                                        'name' => 'Mercedes Tourismo',
                                        'name_ar' => 'مرسيدس توريزمو',
                                        'type' => 'Tourist Bus',
                                        'company' => 'SAPTCO',
                                        'capacity' => 50,
                                        'year' => 2023,
                                        'status' => 'active',
                                        'location' => 'Riyadh, Saudi Arabia',
                                        'plate_number' => 'ABC-1234',
                                        'driver' => 'Ahmed Al-Rashid'
                                    ],
                                    [
                                        'id' => 2,
                                        'name' => 'Toyota Land Cruiser',
                                        'name_ar' => 'تويوتا لاند كروزر',
                                        'type' => '4x4 Vehicle',
                                        'company' => 'Desert Safari Tours',
                                        'capacity' => 7,
                                        'year' => 2022,
                                        'status' => 'active',
                                        'location' => 'Jeddah, Saudi Arabia',
                                        'plate_number' => 'DEF-5678',
                                        'driver' => 'Mohammed Al-Sheikh'
                                    ],
                                    [
                                        'id' => 3,
                                        'name' => 'Ford Transit',
                                        'name_ar' => 'فورد ترانزيت',
                                        'type' => 'Transport Vehicle',
                                        'company' => 'City Transport',
                                        'capacity' => 15,
                                        'year' => 2021,
                                        'status' => 'active',
                                        'location' => 'Dammam, Saudi Arabia',
                                        'plate_number' => 'GHI-9012',
                                        'driver' => 'Khalid Al-Mansouri'
                                    ],
                                    [
                                        'id' => 4,
                                        'name' => 'Volvo B12M',
                                        'name_ar' => 'فولفو بي 12 إم',
                                        'type' => 'Tourist Bus',
                                        'company' => 'Luxury Tours',
                                        'capacity' => 45,
                                        'year' => 2023,
                                        'status' => 'active',
                                        'location' => 'Riyadh, Saudi Arabia',
                                        'plate_number' => 'JKL-3456',
                                        'driver' => 'Omar Al-Zahrani'
                                    ],
                                    [
                                        'id' => 5,
                                        'name' => 'Nissan Patrol',
                                        'name_ar' => 'نيسان باترول',
                                        'type' => '4x4 Vehicle',
                                        'company' => 'Adventure Tours',
                                        'capacity' => 8,
                                        'year' => 2022,
                                        'status' => 'maintenance',
                                        'location' => 'Al Ula, Saudi Arabia',
                                        'plate_number' => 'MNO-7890',
                                        'driver' => 'Saeed Al-Ghamdi'
                                    ],
                                    [
                                        'id' => 6,
                                        'name' => 'Mercedes Sprinter',
                                        'name_ar' => 'مرسيدس سبرينتر',
                                        'type' => 'Transport Vehicle',
                                        'company' => 'Premium Transport',
                                        'capacity' => 12,
                                        'year' => 2023,
                                        'status' => 'active',
                                        'location' => 'Jeddah, Saudi Arabia',
                                        'plate_number' => 'PQR-1234',
                                        'driver' => 'Abdullah Al-Harbi'
                                    ]
                                ];
                            @endphp
                            @foreach($vehicles as $vehicle)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-45px me-5">
                                            <img src="{{ asset('metronic/media/avatars/300-5.png') }}" alt="{{ $vehicle['name'] }}">
                                        </div>
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="#" class="text-dark fw-bold text-hover-primary fs-6">{{ $vehicle['name'] }}</a>
                                            <span class="text-muted fw-semibold text-muted d-block fs-7">{{ $vehicle['name_ar'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="kt-badge kt-badge-light-{{ $vehicle['type'] == 'Tourist Bus' ? 'primary' : ($vehicle['type'] == '4x4 Vehicle' ? 'success' : 'info') }}">
                                        {{ $vehicle['type'] }}
                                    </span>
                                </td>
                                <td class="text-muted fw-semibold text-muted">{{ $vehicle['company'] }}</td>
                                <td class="text-muted fw-semibold text-muted">{{ $vehicle['capacity'] }} seats</td>
                                <td class="text-muted fw-semibold text-muted">{{ $vehicle['year'] }}</td>
                                <td>
                                    <span class="kt-badge kt-badge-light-{{ $vehicle['status'] == 'active' ? 'success' : 'warning' }}">
                                        {{ ucfirst($vehicle['status']) }}
                                    </span>
                                </td>
                                <td class="text-muted fw-semibold text-muted">{{ $vehicle['location'] }}</td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" title="View">
                                        <i class="ki-filled ki-eye fs-3"></i>
                                    </a>
                                    <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" title="Edit">
                                        <i class="ki-filled ki-pencil fs-3"></i>
                                    </a>
                                    <a href="#" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" title="Delete">
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


