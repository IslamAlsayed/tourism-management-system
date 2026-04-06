@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => 'Food & Beverage',
        'description' => 'Manage restaurants, cafes, and dining establishments',
        'page_create_url' => '#',
        'page_create_title' => 'Add New Restaurant',
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <div class="kt-card-header">
                <h3 class="kt-card-title">All Restaurants</h3>
                <div class="kt-menu" data-kt-menu="true">
                    <div class="kt-menu-item" data-kt-menu-item-offset="0, 10px" data-kt-menu-item-placement="bottom-start"
                        data-kt-menu-item-toggle="dropdown" data-kt-menu-item-trigger="click">
                        <button class="kt-menu-toggle kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost">
                            <i class="fa-duotone fa-solid fa-ellipsis-vertical text-lg"></i>
                        </button>
                        <div class="kt-menu-dropdown kt-menu-default w-full max-w-[200px]" data-kt-menu-dismiss="true">
                            <div class="kt-menu-item">
                                <a class="kt-menu-link" href="#">
                                    <span class="kt-menu-icon">
                                        <i class="fa-solid fa-chevron-download"></i>
                                    </span>
                                    <span class="kt-menu-title">Export Data</span>
                                </a>
                            </div>
                            <div class="kt-menu-item">
                                <a class="kt-menu-link" href="#">
                                    <span class="kt-menu-icon">
                                        <i class="fa-solid fa-chevron-upload"></i>
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
                                <th class="min-w-100px">Cuisine</th>
                                <th class="min-w-100px">Rating</th>
                                <th class="min-w-100px">Price Range</th>
                                <th class="min-w-100px">Status</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $restaurants = [
                                    [
                                        'id' => 1,
                                        'name' => 'Al Baik Restaurant',
                                        'name_ar' => 'مطعم البيك',
                                        'type' => 'Fast Food',
                                        'location' => 'Riyadh, Saudi Arabia',
                                        'cuisine' => 'Arabic',
                                        'rating' => 4,
                                        'price_range' => '$',
                                        'status' => 'active',
                                        'phone' => '+966 11 123 4567',
                                        'email' => 'info@albaik.com',
                                        'website' => 'www.albaik.com',
                                    ],
                                    [
                                        'id' => 2,
                                        'name' => 'Najd Village',
                                        'name_ar' => 'قرية نجد',
                                        'type' => 'Traditional',
                                        'location' => 'Riyadh, Saudi Arabia',
                                        'cuisine' => 'Saudi',
                                        'rating' => 5,
                                        'price_range' => '$$',
                                        'status' => 'active',
                                        'phone' => '+966 11 234 5678',
                                        'email' => 'contact@najdvillage.com',
                                        'website' => 'www.najdvillage.com',
                                    ],
                                    [
                                        'id' => 3,
                                        'name' => 'Spazio Restaurant',
                                        'name_ar' => 'مطعم سبازيو',
                                        'type' => 'Fine Dining',
                                        'location' => 'Jeddah, Saudi Arabia',
                                        'cuisine' => 'Italian',
                                        'rating' => 5,
                                        'price_range' => '$$$',
                                        'status' => 'active',
                                        'phone' => '+966 12 345 6789',
                                        'email' => 'info@spazio.com',
                                        'website' => 'www.spazio.com',
                                    ],
                                    [
                                        'id' => 4,
                                        'name' => 'Shawarma House',
                                        'name_ar' => 'بيت الشاورما',
                                        'type' => 'Casual',
                                        'location' => 'Dammam, Saudi Arabia',
                                        'cuisine' => 'Middle Eastern',
                                        'rating' => 4,
                                        'price_range' => '$',
                                        'status' => 'active',
                                        'phone' => '+966 13 456 7890',
                                        'email' => 'orders@shawarmahouse.com',
                                        'website' => 'www.shawarmahouse.com',
                                    ],
                                    [
                                        'id' => 5,
                                        'name' => 'Sushi Master',
                                        'name_ar' => 'سوشي ماستر',
                                        'type' => 'Fine Dining',
                                        'location' => 'Riyadh, Saudi Arabia',
                                        'cuisine' => 'Japanese',
                                        'rating' => 5,
                                        'price_range' => '$$$',
                                        'status' => 'active',
                                        'phone' => '+966 11 567 8901',
                                        'email' => 'reservations@sushimaster.com',
                                        'website' => 'www.sushimaster.com',
                                    ],
                                    [
                                        'id' => 6,
                                        'name' => 'Café Central',
                                        'name_ar' => 'مقهى سنترال',
                                        'type' => 'Café',
                                        'location' => 'Jeddah, Saudi Arabia',
                                        'cuisine' => 'International',
                                        'rating' => 4,
                                        'price_range' => '$$',
                                        'status' => 'active',
                                        'phone' => '+966 12 678 9012',
                                        'email' => 'info@cafecentral.com',
                                        'website' => 'www.cafecentral.com',
                                    ],
                                ];
                            @endphp
                            @foreach ($restaurants as $restaurant)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-45px me-5">
                                                <img src="{{ asset('metronic/media/avatars/300-2.png') }}"
                                                    alt="{{ $restaurant['name'] }}">
                                            </div>
                                            <div class="d-flex justify-content-start flex-column">
                                                <a href="#"
                                                    class="text-dark fw-bold text-hover-primary fs-6">{{ $restaurant['name'] }}</a>
                                                <span
                                                    class="text-muted fw-semibold text-muted d-block fs-7">{{ $restaurant['name_ar'] }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="kt-badge kt-badge-light-{{ $restaurant['type'] == 'Fine Dining' ? 'primary' : ($restaurant['type'] == 'Traditional' ? 'success' : ($restaurant['type'] == 'Fast Food' ? 'warning' : ($restaurant['type'] == 'Casual' ? 'info' : 'secondary'))) }}">
                                            {{ $restaurant['type'] }}
                                        </span>
                                    </td>
                                    <td class="text-muted fw-semibold text-muted">{{ $restaurant['location'] }}</td>
                                    <td class="text-muted fw-semibold text-muted">{{ $restaurant['cuisine'] }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fa-duotone fa-solid fa-star text-{{ $i <= $restaurant['rating'] ? 'warning' : 'muted' }} fs-7"></i>
                                            @endfor
                                            <span
                                                class="text-muted fw-semibold text-muted ms-1">{{ $restaurant['rating'] }}/5</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="kt-badge kt-badge-light-{{ $restaurant['price_range'] == '$' ? 'success' : ($restaurant['price_range'] == '$$' ? 'warning' : 'danger') }}">
                                            {{ $restaurant['price_range'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="kt-badge kt-badge-light-success">Active</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#"
                                            class="kt-btn kt-btn-icon kt-btn-light kt-btn-primary kt-btn-sm me-1"
                                            title="View">
                                            <i class="fa-duotone fa-solid fa-eye fs-3"></i>
                                        </a>
                                        <a href="#"
                                            class="kt-btn kt-btn-icon kt-btn-light kt-btn-primary kt-btn-sm me-1"
                                            title="Edit">
                                            <i class="fa-duotone fa-solid fa-pen fs-3"></i>
                                        </a>
                                        <a href="#" class="kt-btn kt-btn-icon kt-btn-light kt-btn-destructive kt-btn-sm"
                                            title="Delete">
                                            <i class="fa-duotone fa-solid fa-trash fs-3"></i>
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
