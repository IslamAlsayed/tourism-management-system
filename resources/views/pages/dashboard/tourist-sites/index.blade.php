@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => 'Tourist Sites',
        'description' => 'Manage tourist sites and entrance fees',
        'page_add_url' => '#',
        'page_add_title' => 'Add New Tourist Site',
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <div class="kt-card-header">
                <h3 class="kt-card-title">All Tourist Sites</h3>
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
                                <th class="min-w-150px">Site Name</th>
                                <th class="min-w-140px">Type</th>
                                <th class="min-w-120px">Location</th>
                                <th class="min-w-100px">Entrance Fee</th>
                                <th class="min-w-100px">Rating</th>
                                <th class="min-w-100px">Status</th>
                                <th class="min-w-100px">Visitors/Month</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $touristSites = [
                                    [
                                        'id' => 1,
                                        'name' => 'Al-Ula Heritage Site',
                                        'name_ar' => 'موقع العلا التراثي',
                                        'type' => 'Historical Site',
                                        'location' => 'Al-Ula, Saudi Arabia',
                                        'entrance_fee' => '150 SAR',
                                        'rating' => 5,
                                        'status' => 'active',
                                        'visitors_per_month' => '25,000',
                                        'description' => 'Ancient Nabatean city with rock-cut tombs and archaeological wonders',
                                        'opening_hours' => '8:00 AM - 6:00 PM',
                                        'phone' => '+966 14 884 4444',
                                        'website' => 'www.experiencealula.com'
                                    ],
                                    [
                                        'id' => 2,
                                        'name' => 'Red Sea Mall',
                                        'name_ar' => 'مول البحر الأحمر',
                                        'type' => 'Shopping Center',
                                        'location' => 'Jeddah, Saudi Arabia',
                                        'entrance_fee' => 'Free',
                                        'rating' => 4,
                                        'status' => 'active',
                                        'visitors_per_month' => '500,000',
                                        'description' => 'Largest shopping mall in Jeddah with international brands and entertainment',
                                        'opening_hours' => '10:00 AM - 12:00 AM',
                                        'phone' => '+966 12 657 2222',
                                        'website' => 'www.redseamall.com'
                                    ],
                                    [
                                        'id' => 3,
                                        'name' => 'Edge of the World',
                                        'name_ar' => 'حافة العالم',
                                        'type' => 'Natural Wonder',
                                        'location' => 'Riyadh, Saudi Arabia',
                                        'entrance_fee' => '50 SAR',
                                        'rating' => 5,
                                        'status' => 'active',
                                        'visitors_per_month' => '15,000',
                                        'description' => 'Dramatic cliff formation offering breathtaking views of the desert',
                                        'opening_hours' => '6:00 AM - 6:00 PM',
                                        'phone' => '+966 11 123 4567',
                                        'website' => 'www.edgeoftheworld.com'
                                    ],
                                    [
                                        'id' => 4,
                                        'name' => 'King Fahd Fountain',
                                        'name_ar' => 'نافورة الملك فهد',
                                        'type' => 'Landmark',
                                        'location' => 'Jeddah, Saudi Arabia',
                                        'entrance_fee' => 'Free',
                                        'rating' => 4,
                                        'status' => 'active',
                                        'visitors_per_month' => '100,000',
                                        'description' => 'World\'s tallest fountain, a symbol of Jeddah\'s waterfront',
                                        'opening_hours' => '24/7',
                                        'phone' => '+966 12 657 2222',
                                        'website' => 'www.jeddah.gov.sa'
                                    ],
                                    [
                                        'id' => 5,
                                        'name' => 'Masmak Fortress',
                                        'name_ar' => 'قصر المصمك',
                                        'type' => 'Museum',
                                        'location' => 'Riyadh, Saudi Arabia',
                                        'entrance_fee' => '10 SAR',
                                        'rating' => 4,
                                        'status' => 'active',
                                        'visitors_per_month' => '30,000',
                                        'description' => 'Historic fortress and museum showcasing Saudi Arabia\'s founding',
                                        'opening_hours' => '8:00 AM - 9:00 PM',
                                        'phone' => '+966 11 123 4567',
                                        'website' => 'www.riyadh.gov.sa'
                                    ],
                                    [
                                        'id' => 6,
                                        'name' => 'Al-Balad Historic District',
                                        'name_ar' => 'حي البلد التاريخي',
                                        'type' => 'Historic District',
                                        'location' => 'Jeddah, Saudi Arabia',
                                        'entrance_fee' => 'Free',
                                        'rating' => 4,
                                        'status' => 'active',
                                        'visitors_per_month' => '75,000',
                                        'description' => 'UNESCO World Heritage site with traditional architecture',
                                        'opening_hours' => '24/7',
                                        'phone' => '+966 12 657 2222',
                                        'website' => 'www.jeddah.gov.sa'
                                    ]
                                ];
                            @endphp
                            @foreach($touristSites as $site)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-45px me-5">
                                            <img src="{{ asset('metronic/media/avatars/300-6.png') }}" alt="{{ $site['name'] }}">
                                        </div>
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="#" class="text-dark fw-bold text-hover-primary fs-6">{{ $site['name'] }}</a>
                                            <span class="text-muted fw-semibold text-muted d-block fs-7">{{ $site['name_ar'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="kt-badge kt-badge-light-{{ $site['type'] == 'Historical Site' ? 'primary' : ($site['type'] == 'Shopping Center' ? 'success' : ($site['type'] == 'Natural Wonder' ? 'info' : ($site['type'] == 'Landmark' ? 'warning' : ($site['type'] == 'Museum' ? 'danger' : 'secondary')))) }}">
                                        {{ $site['type'] }}
                                    </span>
                                </td>
                                <td class="text-muted fw-semibold text-muted">{{ $site['location'] }}</td>
                                <td>
                                    <span class="kt-badge kt-badge-light-{{ $site['entrance_fee'] == 'Free' ? 'success' : 'primary' }}">
                                        {{ $site['entrance_fee'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="ki-filled ki-star text-{{ $i <= $site['rating'] ? 'warning' : 'muted' }} fs-7"></i>
                                        @endfor
                                        <span class="text-muted fw-semibold text-muted ms-1">{{ $site['rating'] }}/5</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="kt-badge kt-badge-light-success">Active</span>
                                </td>
                                <td class="text-muted fw-semibold text-muted">{{ $site['visitors_per_month'] }}</td>
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


