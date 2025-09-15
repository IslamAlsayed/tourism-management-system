@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => 'Transportation',
        'description' => 'Manage transportation companies, car rentals, and limousine services',
        'page_add_url' => '#',
        'page_add_title' => 'Add New Transportation',
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <div class="kt-card-header">
                <h3 class="kt-card-title">All Transportation Services</h3>
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
                                <th class="min-w-150px">Company Name</th>
                                <th class="min-w-140px">Service Type</th>
                                <th class="min-w-120px">Location</th>
                                <th class="min-w-100px">Fleet Size</th>
                                <th class="min-w-100px">Rating</th>
                                <th class="min-w-100px">Price Range</th>
                                <th class="min-w-100px">Status</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $transportation = [
                                    [
                                        'id' => 1,
                                        'name' => 'SAPTCO Bus Company',
                                        'name_ar' => 'شركة سابتكو للنقل',
                                        'type' => 'Bus Service',
                                        'location' => 'Riyadh, Saudi Arabia',
                                        'fleet_size' => 500,
                                        'rating' => 4,
                                        'price_range' => '$$',
                                        'status' => 'active',
                                        'phone' => '+966 11 123 4567',
                                        'email' => 'info@saptco.com',
                                        'website' => 'www.saptco.com'
                                    ],
                                    [
                                        'id' => 2,
                                        'name' => 'Luxury Limousine',
                                        'name_ar' => 'ليموزين الفخامة',
                                        'type' => 'Limousine',
                                        'location' => 'Jeddah, Saudi Arabia',
                                        'fleet_size' => 25,
                                        'rating' => 5,
                                        'price_range' => '$$$',
                                        'status' => 'active',
                                        'phone' => '+966 12 234 5678',
                                        'email' => 'bookings@luxurylimo.com',
                                        'website' => 'www.luxurylimo.com'
                                    ],
                                    [
                                        'id' => 3,
                                        'name' => 'Budget Car Rental',
                                        'name_ar' => 'تأجير السيارات الاقتصادي',
                                        'type' => 'Car Rental',
                                        'location' => 'Dammam, Saudi Arabia',
                                        'fleet_size' => 200,
                                        'rating' => 4,
                                        'price_range' => '$',
                                        'status' => 'active',
                                        'phone' => '+966 13 345 6789',
                                        'email' => 'rentals@budgetcar.com',
                                        'website' => 'www.budgetcar.com'
                                    ],
                                    [
                                        'id' => 4,
                                        'name' => 'Desert Safari Tours',
                                        'name_ar' => 'جولات سفاري الصحراء',
                                        'type' => 'Tourist Transport',
                                        'location' => 'Riyadh, Saudi Arabia',
                                        'fleet_size' => 50,
                                        'rating' => 5,
                                        'price_range' => '$$',
                                        'status' => 'active',
                                        'phone' => '+966 11 456 7890',
                                        'email' => 'tours@desertsafari.com',
                                        'website' => 'www.desertsafari.com'
                                    ],
                                    [
                                        'id' => 5,
                                        'name' => 'City Taxi Service',
                                        'name_ar' => 'خدمة تاكسي المدينة',
                                        'type' => 'Taxi Service',
                                        'location' => 'Jeddah, Saudi Arabia',
                                        'fleet_size' => 300,
                                        'rating' => 3,
                                        'price_range' => '$',
                                        'status' => 'active',
                                        'phone' => '+966 12 567 8901',
                                        'email' => 'dispatch@citytaxi.com',
                                        'website' => 'www.citytaxi.com'
                                    ],
                                    [
                                        'id' => 6,
                                        'name' => 'Premium Car Service',
                                        'name_ar' => 'خدمة السيارات المميزة',
                                        'type' => 'Premium Transport',
                                        'location' => 'Riyadh, Saudi Arabia',
                                        'fleet_size' => 75,
                                        'rating' => 5,
                                        'price_range' => '$$$',
                                        'status' => 'active',
                                        'phone' => '+966 11 678 9012',
                                        'email' => 'service@premiumcar.com',
                                        'website' => 'www.premiumcar.com'
                                    ]
                                ];
                            @endphp
                            @foreach($transportation as $service)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-45px me-5">
                                            <img src="{{ asset('metronic/media/avatars/300-3.png') }}" alt="{{ $service['name'] }}">
                                        </div>
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="#" class="text-dark fw-bold text-hover-primary fs-6">{{ $service['name'] }}</a>
                                            <span class="text-muted fw-semibold text-muted d-block fs-7">{{ $service['name_ar'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="kt-badge kt-badge-light-{{ $service['type'] == 'Bus Service' ? 'primary' : ($service['type'] == 'Limousine' ? 'success' : ($service['type'] == 'Car Rental' ? 'info' : ($service['type'] == 'Tourist Transport' ? 'warning' : ($service['type'] == 'Taxi Service' ? 'danger' : 'secondary')))) }}">
                                        {{ $service['type'] }}
                                    </span>
                                </td>
                                <td class="text-muted fw-semibold text-muted">{{ $service['location'] }}</td>
                                <td class="text-muted fw-semibold text-muted">{{ $service['fleet_size'] }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="ki-filled ki-star text-{{ $i <= $service['rating'] ? 'warning' : 'muted' }} fs-7"></i>
                                        @endfor
                                        <span class="text-muted fw-semibold text-muted ms-1">{{ $service['rating'] }}/5</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="kt-badge kt-badge-light-{{ $service['price_range'] == '$' ? 'success' : ($service['price_range'] == '$$' ? 'warning' : 'danger') }}">
                                        {{ $service['price_range'] }}
                                    </span>
                                </td>
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


