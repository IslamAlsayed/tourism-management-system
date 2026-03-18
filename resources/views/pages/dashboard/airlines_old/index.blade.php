@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => 'Airlines',
        'description' => 'Manage airports and airlines',
        'page_create_url' => '#',
        'page_create_title' => 'Add New Airline',
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <div class="kt-card-header">
                <h3 class="kt-card-title">All Air Transport Services</h3>
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
                                <th class="min-w-100px">Rating</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $airlines = [
                                    [
                                        'id' => 1,
                                        'name' => 'King Khalid International Airport',
                                        'name_ar' => 'مطار الملك خالد الدولي',
                                        'type' => 'International Airport',
                                        'location' => 'Riyadh, Saudi Arabia',
                                        'code' => 'RUH',
                                        'status' => 'active',
                                        'capacity' => '35M passengers/year',
                                        'rating' => 4,
                                        'phone' => '+966 11 454 3333',
                                        'email' => 'info@kkaia.com',
                                        'website' => 'www.kkaia.com',
                                    ],
                                    [
                                        'id' => 2,
                                        'name' => 'King Abdulaziz International Airport',
                                        'name_ar' => 'مطار الملك عبدالعزيز الدولي',
                                        'type' => 'International Airport',
                                        'location' => 'Jeddah, Saudi Arabia',
                                        'code' => 'JED',
                                        'status' => 'active',
                                        'capacity' => '30M passengers/year',
                                        'rating' => 4,
                                        'phone' => '+966 12 685 2000',
                                        'email' => 'info@kaia.com',
                                        'website' => 'www.kaia.com',
                                    ],
                                    [
                                        'id' => 3,
                                        'name' => 'Saudia Airlines',
                                        'name_ar' => 'الخطوط السعودية',
                                        'type' => 'Airline',
                                        'location' => 'Jeddah, Saudi Arabia',
                                        'code' => 'SV',
                                        'status' => 'active',
                                        'capacity' => '150 aircraft',
                                        'rating' => 4,
                                        'phone' => '+966 11 454 3333',
                                        'email' => 'info@saudia.com',
                                        'website' => 'www.saudia.com',
                                    ],
                                    [
                                        'id' => 4,
                                        'name' => 'Flynas',
                                        'name_ar' => 'طيران ناس',
                                        'type' => 'Airline',
                                        'location' => 'Riyadh, Saudi Arabia',
                                        'code' => 'XY',
                                        'status' => 'active',
                                        'capacity' => '50 aircraft',
                                        'rating' => 4,
                                        'phone' => '+966 11 454 3333',
                                        'email' => 'info@flynas.com',
                                        'website' => 'www.flynas.com',
                                    ],
                                    [
                                        'id' => 5,
                                        'name' => 'King Fahd International Airport',
                                        'name_ar' => 'مطار الملك فهد الدولي',
                                        'type' => 'International Airport',
                                        'location' => 'Dammam, Saudi Arabia',
                                        'code' => 'DMM',
                                        'status' => 'active',
                                        'capacity' => '12M passengers/year',
                                        'rating' => 4,
                                        'phone' => '+966 13 883 3333',
                                        'email' => 'info@kfia.com',
                                        'website' => 'www.kfia.com',
                                    ],
                                    [
                                        'id' => 6,
                                        'name' => 'Prince Mohammad Bin Abdulaziz Airport',
                                        'name_ar' => 'مطار الأمير محمد بن عبدالعزيز',
                                        'type' => 'Domestic Airport',
                                        'location' => 'Medina, Saudi Arabia',
                                        'code' => 'MED',
                                        'status' => 'active',
                                        'capacity' => '8M passengers/year',
                                        'rating' => 4,
                                        'phone' => '+966 14 842 4444',
                                        'email' => 'info@pmia.com',
                                        'website' => 'www.pmia.com',
                                    ],
                                ];
                            @endphp
                            @foreach ($airlines as $service)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-45px me-5">
                                                <img src="{{ asset('metronic/media/avatars/300-4.png') }}"
                                                    alt="{{ $service['name'] }}">
                                            </div>
                                            <div class="d-flex justify-content-start flex-column">
                                                <a href="#"
                                                    class="text-dark fw-bold text-hover-primary fs-6">{{ $service['name'] }}</a>
                                                <span
                                                    class="text-muted fw-semibold text-muted d-block fs-7">{{ $service['name_ar'] }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="kt-badge kt-badge-light-{{ $service['type'] == 'International Airport' ? 'primary' : ($service['type'] == 'Airline' ? 'success' : 'info') }}">
                                            {{ $service['type'] }}
                                        </span>
                                    </td>
                                    <td class="text-muted fw-semibold text-muted">{{ $service['location'] }}</td>
                                    <td>
                                        <span class="kt-badge kt-badge-light-primary">{{ $service['code'] }}</span>
                                    </td>
                                    <td>
                                        <span class="kt-badge kt-badge-light-success">Active</span>
                                    </td>
                                    <td class="text-muted fw-semibold text-muted">{{ $service['capacity'] }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="ki-filled ki-star text-{{ $i <= $service['rating'] ? 'warning' : 'muted' }} fs-7"></i>
                                            @endfor
                                            <span
                                                class="text-muted fw-semibold text-muted ms-1">{{ $service['rating'] }}/5</span>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <a href="#"
                                            class="kt-btn kt-btn-icon kt-btn-light kt-btn-primary kt-btn-sm me-1"
                                            title="View">
                                            <i class="ki-filled ki-eye fs-3"></i>
                                        </a>
                                        <a href="#"
                                            class="kt-btn kt-btn-icon kt-btn-light kt-btn-primary kt-btn-sm me-1"
                                            title="Edit">
                                            <i class="ki-filled ki-pencil fs-3"></i>
                                        </a>
                                        <a href="#" class="kt-btn kt-btn-icon kt-btn-light kt-btn-destructive kt-btn-sm"
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
