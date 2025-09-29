@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models">
        <div class="mt-4">
            <a href="{{ route('export.data', ['model' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (env('DB_Mode') != 'production')
            <table class="border min-w-half divide-y text-center divide-gray-200 mt-6">
                <thead>
                    <tr>
                        <th class="border px-2">name</th>
                        <th class="border px-2">code</th>
                        <th class="border px-2">symbol</th>
                        <th class="border px-2">is_active</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Egyptian pound</td>
                        <td class="border px-2">EGP</td>
                        <td class="border px-2">ج.م</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
