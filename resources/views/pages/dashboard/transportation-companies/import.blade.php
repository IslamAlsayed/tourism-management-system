@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models">
        <div class="mt-4">
            <a href="{{ route('export.data', ['models' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (env('DB_MODE') != 'production')
            <strong class="block mt-6 mb-2">{{ __('main.fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">name</th>
                        <th class="border px-2">name_ar</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Alpha Tourist Transport</td>
                        <td class="border px-2">الفا للنقل السياحي</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
