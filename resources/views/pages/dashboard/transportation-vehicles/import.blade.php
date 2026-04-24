```html
@extends('layouts.master')

@section('content')
    <div class="kt-container-fixed">
        {{ __('main.export') }}
        </a>
    </div>

    @if (env('DB_MODE') != 'production')
        <strong class="block mt-6 mb-2">{{ __('main.fields') }}</strong>
        <table class="border min-w-half divide-y text-center divide-gray-200">
            <thead class="bg-yellow-100">
                <tr>
                    <th class="border px-2">route</th>
                    <th class="border px-2">route_ar</th>
                    <th class="border px-2">duration (hours)</th>
                    <th class="border px-2">distance (km)</th>
                    <th class="border px-2">seats</th>
                    <th class="border px-2">currency_id</th>
                    <th class="border px-2">price</th>
                </tr>
            </thead>
            <tbody class="background divide-y divide-gray-200">
                <tr>
                    <td class="border px-2">
                        Rum 01 - Lawrence spring (Rum Village - Nabataean Temple - Lawrence spring)
                    </td>
                    <td class="border px-2">عين لورانس (قرية رم - المعبد النبطي - عين لورانس)</td>
                    <td class="border px-2">1</td>
                    <td class="border px-2">14</td>
                    <td class="border px-2">6</td>
                    <td class="border px-2">67</td>
                    <td class="border px-2">30</td>
                </tr>
            </tbody>
        </table>
    @endif
    </x-import-form>
    </div>
@endsection
