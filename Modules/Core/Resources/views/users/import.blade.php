@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view" :requirements="[
        [
            'condition' => \Modules\Geography\Entities\Country::count() > 0,
            'route' => route('dashboard.geography.countries.create'),
            'label' => __('main.countries_'),
        ],
    ]">
        <div class="mt-4">
            <a href="{{ route('export.data', ['models' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (env('DB_MODE') != 'production')
            <strong class="block mt-6 mb-2">{{ __('main.fields') }}</strong>
            <table class="border min-w-half divide-y text-center divide-gray-200">
                <thead>
                    <tr>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            name <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            email <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            password <span class="text-red-600">*</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">superadmin</td>
                        <td class="border px-2">email@gmail.com</td>
                        <td class="border px-2">12345678</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead>
                    <tr>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">photo</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">bio</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">phone</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">first_name</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">last_name</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">mobile</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">address</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">null</td>
                        <td class="border px-2">Lorem, ipsum dolor.</td>
                        <td class="border px-2">+46804646</td>
                        <td class="border px-2">super</td>
                        <td class="border px-2">admin</td>
                        <td class="border px-2">+46804646</td>
                        <td class="border px-2">
                            Lorem ipsum dolor sit amet consectetur adipisicing.
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead>
                    <tr>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">user_code</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">hire_date</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">department</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">position</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">preferred_language</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">timezone</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">preferences</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">CODE7845</td>
                        <td class="border px-2">05/04/2025</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">admin</td>
                        <td class="border px-2">en</td>
                        <td class="border px-2">africa</td>
                        <td class="border px-2">null</td>
                    </tr>
                </tbody>
            </table>

            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead>
                    <tr>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">role</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">is_active</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">is_verified</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">force_password_change</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">last_login_at</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">last_login_ip</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">notes</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">created_by</th>
                        <th class="border px-2 bg-blue-100" title="{{ __('main.optional') }}">updated_by</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">admin or superadmin or user</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">0</td>
                        <td class="border px-2">{{ date('d/m/Y H:i') }}</td>
                        <td class="border px-2">{{ fake()->ipv4() }}</td>
                        <td class="border px-2">Lorem ipsum dolor sit amet.</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
