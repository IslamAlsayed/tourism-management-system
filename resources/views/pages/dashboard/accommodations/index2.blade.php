@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => 'Accommodations',
        'description' => 'Manage all accommodation types including hotels, resorts, camps, hostels, lodges, and apartments',
        'page_add_url' => '#',
        'page_add_title' => 'Add New Accommodation',
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="min-w-full kt-card kt-card-grid">
            <div class="kt-card-header">
                <h3 class="kt-card-title">All Accommodations</h3>
                <div class="kt-menu" data-kt-menu="true">
                    <div class="kt-menu-item" data-kt-menu-item-offset="0, 10px"
                        data-kt-menu-item-placement="bottom-start" data-kt-menu-item-toggle="dropdown"
                        data-kt-menu-item-trigger="click">
                        <button class="kt-menu-toggle kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost">
                            <i class="text-lg ki-filled ki-dots-vertical"></i>
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
            <div class="p-0 kt-card-body">
                <div class="overflow-x-auto">
                    <table class="align-middle kt-table kt-table-row-bordered kt-table-row-gray-300 gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="min-w-150px">Name</th>
                                <th class="min-w-140px">Type</th>
                                <th class="min-w-120px">Location</th>
                                <th class="min-w-100px">Rating</th>
                                <th class="min-w-100px">Rooms</th>
                                <th class="min-w-100px">Status</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $accommodations = [
                                    [
                                        'id' => 1,
                                        'name' => 'Grand Plaza Hotel',
                                        'name_ar' => 'فندق جراند بلازا',
                                        'type' => 'Hotel',
                                        'location' => 'Riyadh, Saudi Arabia',
                                        'rating' => 5,
                                        'rooms' => 250,
                                        'status' => 'active',
                                        'phone' => '+966 11 123 4567',
                                        'email' => 'info@grandplaza.com',
                                        'website' => 'www.grandplaza.com'
                                    ],
                                    [
                                        'id' => 2,
                                        'name' => 'Desert Oasis Resort',
                                        'name_ar' => 'منتجع واحة الصحراء',
                                        'type' => 'Resort',
                                        'location' => 'Al Ula, Saudi Arabia',
                                        'rating' => 4,
                                        'rooms' => 120,
                                        'status' => 'active',
                                        'phone' => '+966 14 234 5678',
                                        'email' => 'contact@desertoasis.com',
                                        'website' => 'www.desertoasis.com'
                                    ],
                                    [
                                        'id' => 3,
                                        'name' => 'Mountain View Lodge',
                                        'name_ar' => 'كوخ إطلالة الجبل',
                                        'type' => 'Lodge',
                                        'location' => 'Abha, Saudi Arabia',
                                        'rating' => 4,
                                        'rooms' => 45,
                                        'status' => 'active',
                                        'phone' => '+966 17 345 6789',
                                        'email' => 'info@mountainview.com',
                                        'website' => 'www.mountainview.com'
                                    ],
                                    [
                                        'id' => 4,
                                        'name' => 'City Center Hostel',
                                        'name_ar' => 'نزل وسط المدينة',
                                        'type' => 'Hostel',
                                        'location' => 'Jeddah, Saudi Arabia',
                                        'rating' => 3,
                                        'rooms' => 80,
                                        'status' => 'active',
                                        'phone' => '+966 12 456 7890',
                                        'email' => 'bookings@citycenter.com',
                                        'website' => 'www.citycenter.com'
                                    ],
                                    [
                                        'id' => 5,
                                        'name' => 'Red Sea Camp',
                                        'name_ar' => 'مخيم البحر الأحمر',
                                        'type' => 'Camp',
                                        'location' => 'Jeddah, Saudi Arabia',
                                        'rating' => 4,
                                        'rooms' => 30,
                                        'status' => 'active',
                                        'phone' => '+966 12 567 8901',
                                        'email' => 'info@redseacamp.com',
                                        'website' => 'www.redseacamp.com'
                                    ],
                                    [
                                        'id' => 6,
                                        'name' => 'Business Apartments',
                                        'name_ar' => 'شقق الأعمال',
                                        'type' => 'Apartment',
                                        'location' => 'Riyadh, Saudi Arabia',
                                        'rating' => 4,
                                        'rooms' => 60,
                                        'status' => 'active',
                                        'phone' => '+966 11 678 9012',
                                        'email' => 'reservations@businessapt.com',
                                        'website' => 'www.businessapt.com'
                                    ]
                                ];
                            @endphp
                            @foreach($accommodations as $accommodation)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-45px me-5">
                                            <img src="{{ asset('metronic/media/avatars/300-1.png') }}" alt="{{ $accommodation['name'] }}">
                                        </div>
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="#" class="text-dark fw-bold text-hover-primary fs-6">{{ $accommodation['name'] }}</a>
                                            <span class="text-muted fw-semibold d-block fs-7">{{ $accommodation['name_ar'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="kt-badge kt-badge-light-{{ $accommodation['type'] == 'Hotel' ? 'primary' : ($accommodation['type'] == 'Resort' ? 'success' : ($accommodation['type'] == 'Lodge' ? 'info' : ($accommodation['type'] == 'Hostel' ? 'warning' : ($accommodation['type'] == 'Camp' ? 'danger' : 'secondary')))) }}">
                                        {{ $accommodation['type'] }}
                                    </span>
                                </td>
                                <td class="text-muted fw-semibold">{{ $accommodation['location'] }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="ki-filled ki-star text-{{ $i <= $accommodation['rating'] ? 'warning' : 'muted' }} fs-7"></i>
                                        @endfor
                                        <span class="text-muted fw-semibold ms-1">{{ $accommodation['rating'] }}/5</span>
                                    </div>
                                </td>
                                <td class="text-muted fw-semibold">{{ $accommodation['rooms'] }}</td>
                                <td>
                                    <span class="kt-badge kt-badge-light-success">Active</span>
                                </td>
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


