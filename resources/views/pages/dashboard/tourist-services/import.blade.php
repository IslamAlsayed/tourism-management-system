@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view" :requirements="[
        [
            'condition' => \App\Models\Currency::count() > 0,
            'route' => route('currencies.create'),
            'label' => __('main.currencies'),
        ],
    ]">
        <div class="mt-4">
            <a href="{{ route('export.data', ['models' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>
        @if (env('DB_MODE') != 'production')
            <strong class="block mt-6 mb-2">{{ __('main.fields') }}</strong>

            <!-- Basic Information -->
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            name <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2" title="{{ __('main.optional') }}">name_ar</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">code</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">supplier_name</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">service_type</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">category</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">supplier_type</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Fakhreddin Restaurant</td>
                        <td class="border px-2">مطعم فخر الدين</td>
                        <td class="border px-2">TSERV-ABC12</td>
                        <td class="border px-2">Fakhreddin Company</td>
                        <td class="border px-2">restaurant</td>
                        <td class="border px-2">dining</td>
                        <td class="border px-2">vendor</td>
                    </tr>
                </tbody>
            </table>

            <!-- Location Information -->
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">address</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">latitude</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">longitude</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">rating</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Al-Rashid Street, Downtown</td>
                        <td class="border px-2">33.3128</td>
                        <td class="border px-2">44.3615</td>
                        <td class="border px-2">4.5</td>
                    </tr>
                </tbody>
            </table>

            <!-- Pricing Configuration -->
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">pricing_model</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">pricing_type</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">pricing_unit</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">pricing_unit_value</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">cost_adult</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">cost_child</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">flat</td>
                        <td class="border px-2">fixed</td>
                        <td class="border px-2">per_person</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">35000</td>
                        <td class="border px-2">25000</td>
                    </tr>
                </tbody>
            </table>

            <!-- Pricing Details -->
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">price_adult</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">price_child</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">price_foreigner_adult</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">price_foreigner_child</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">price_arab_adult</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">price_arab_child</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">35000</td>
                        <td class="border px-2">25000</td>
                        <td class="border px-2">45000</td>
                        <td class="border px-2">35000</td>
                        <td class="border px-2">40000</td>
                        <td class="border px-2">30000</td>
                    </tr>
                </tbody>
            </table>

            <!-- Additional Pricing -->
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">price_local_adult</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">price_local_child</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">price_resident_adult</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">price_resident_child</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_tax_inclusive</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">30000</td>
                        <td class="border px-2">22000</td>
                        <td class="border px-2">32000</td>
                        <td class="border px-2">24000</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>

            <!-- Contact Information -->
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">email</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">phone</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">mobile</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">contact_person</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">info@fakhreddin.com</td>
                        <td class="border px-2">+964 1 417 7710</td>
                        <td class="border px-2">+964 790 1234567</td>
                        <td class="border px-2">Ahmed Al-Rashid</td>
                    </tr>
                </tbody>
            </table>

            <!-- Operating Hours -->
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">opening_time</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">closing_time</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_24_7</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">operating_days</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">10:00</td>
                        <td class="border px-2">22:00</td>
                        <td class="border px-2">0</td>
                        <td class="border px-2">Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday</td>
                    </tr>
                </tbody>
            </table>

            <!-- Age & Participant Restrictions -->
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">child_min_age</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">child_max_age</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">min_participants</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">max_participants</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">duration_minutes</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">2</td>
                        <td class="border px-2">12</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">50</td>
                        <td class="border px-2">120</td>
                    </tr>
                </tbody>
            </table>

            <!-- Service Features & Policies -->
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">booking_required</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_refundable</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_free</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_verified</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_featured</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_active</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">0</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>

            <!-- Additional Details -->
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">difficulty_level</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">tags</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">video_url</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">easy</td>
                        <td class="border px-2">dining,restaurant,middle-eastern</td>
                        <td class="border px-2">https://youtube.com/watch?v=ABC123</td>
                    </tr>
                </tbody>
            </table>

            <!-- Description -->
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">description</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">notes</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Luxury dining with authentic Middle Eastern flavors and exceptional service</td>
                        <td class="border px-2">Prime location with excellent atmosphere</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
