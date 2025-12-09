@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :requirements="[
        [
            'condition' => \App\Models\Country::count() > 0,
            'route' => route('countries.index'),
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
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">name</th>
                        <th class="border px-2">email</th>
                        <th class="border px-2">password</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">superadmin</td>
                        <td class="border px-2">email@gmail.com</td>
                        <td class="border px-2">12345678</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">photo</th>
                        <th class="border px-2">bio</th>
                        <th class="border px-2">phone</th>
                        <th class="border px-2">first_name</th>
                        <th class="border px-2">last_name</th>
                        <th class="border px-2">mobile</th>
                        <th class="border px-2">address</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">null</td>
                        <td class="border px-2">Lorem, ipsum dolor.</td>
                        <td class="border px-2">+46804646</td>
                        <td class="border px-2">super</td>
                        <td class="border px-2">admin</td>
                        <td class="border px-2">+46804646</td>
                        <td class="border px-2">Lorem ipsum dolor sit amet consectetur adipisicing.</td>
                    </tr>
                </tbody>
            </table>

            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">user_code</th>
                        <th class="border px-2">hire_date</th>
                        <th class="border px-2">department</th>
                        <th class="border px-2">position</th>
                        <th class="border px-2">preferred_language</th>
                        <th class="border px-2">timezone</th>
                        <th class="border px-2">preferences</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">CODE7845</td>
                        <td class="border px-2">05/04/2025</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">admin</td>
                        <td class="border px-2">english</td>
                        <td class="border px-2">africa</td>
                        <td class="border px-2">null</td>
                    </tr>
                </tbody>
            </table>

            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">is_admin</th>
                        <th class="border px-2">is_active</th>
                        <th class="border px-2">is_verified</th>
                        <th class="border px-2">force_password_change</th>
                        <th class="border px-2">last_login_at</th>
                        <th class="border px-2">last_login_ip</th>
                        <th class="border px-2">notes</th>
                        <th class="border px-2">created_by</th>
                        <th class="border px-2">updated_by</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">1</td>
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
