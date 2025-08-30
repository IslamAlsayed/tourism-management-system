@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.language_management_title'),
        'description' => __('main.language_management_description'),
        'import_url' => '#',
        'page_add_url' => route('languages.create'),
        'page_add_title' => __('main.add_new_language'),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="kt-card-content">
        <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="team_crew_table">
            <div class="kt-scrollable-x-auto">
                <table class="kt-table table-auto" data-kt-datatable-table="true">
                    <thead>
                        <tr>
                            <th class="w-[60px] px-4 py-3 text-center">
                                <input type="checkbox" id="selectAllCountries" class="kt-checkbox kt-checkbox-sm">
                            </th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.id') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.language_name') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.flag') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.active') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.created_at') }}</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $language)
                            <tr>
                                <td class="text-center">
                                    <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true"
                                        type="checkbox" value="1" />
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $language->id }}</td>
                                <td>{{ $language->name ?? '--' }}</td>
                                <td>
                                    <img src="{{ $key <= 1 ? asset('metronic/media/flags/languages/' . $language->flag) : asset('storage/' . $language->flag) }}"
                                        alt="{{ $language->name }}" class="w-[30px]">
                                <td>{{ $language->created_at ? $language->created_at->format('Y-m-d') : '' }}</td>
                                <td>
                                    <span
                                        class="text-{{ $language->code == getCurrentLocale() ? 'green' : 'red' }}-600 font-semibold">
                                        {{ $language->code == getCurrentLocale() ? __('main.active') : __('main.inactive') }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-end">
                                    @if ($language->code != getCurrentLocale())
                                        <a href="{{ route('languages.change', $language->code) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-primary text-white">
                                            {{ __('main.active') }}
                                        </a>
                                    @endif
                                    <a href="{{ route('languages.destroy', $language->id) }}"
                                        class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white">
                                        <form action="{{ route('languages.destroy', $language->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">{{ __('main.delete') }}</button>
                                        </form>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Enhanced Pagination Controls --}}
            @include('includes.pagination', ['data' => $data])
        </div>
    </div>
    <!-- End of Container -->
@endsection
