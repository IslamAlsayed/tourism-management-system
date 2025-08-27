@extends('pages.dashboard.layouts.index')



@section('table-content')
    <div class="p-6">
        <div class="flex flex-col gap-4">
            <!-- Toolbar -->
            <div class="flex flex-wrap items-center gap-2 bg-white rounded-lg shadow px-4 py-3 mb-2">
                <h1 class="text-xl font-bold text-mono me-4">{{ __('main.countries') }}</h1>
                <form method="GET" class="flex items-center gap-2 flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="{{ __('main.search_placeholder') }}" class="kt-input min-w-[180px]"
                        oninput="this.form.submit()" />
                    <select name="status" class="kt-select min-w-[120px]" onchange="this.form.submit()">
                        <option value="">{{ __('main.select_status') }}</option>
                        <option value="1" @if (request('status') === '1') selected @endif>{{ __('main.active') }}
                        </option>
                        <option value="0" @if (request('status') === '0') selected @endif>{{ __('main.inactive') }}
                        </option>
                    </select>
                </form>
                <div class="flex items-center gap-2 ms-auto">
                    <button class="kt-btn kt-btn-outline">{{ __('main.export') }}</button>
                    <form method="POST" action="{{ route('countries.bulkEdit') }}" id="bulkEditForm">
                        @csrf
                        <input type="hidden" name="selected_ids" id="selectedCountriesInput">
                        <button type="submit" class="kt-btn kt-btn-outline" id="bulkEditBtn"
                            disabled>{{ __('main.bulk_edit') }}</button>
                    </form>
                    <a href="{{ route('countries.create') }}"
                        class="kt-btn kt-btn-primary">{{ __('main.add_country') }}</a>
                </div>
            </div>
            <!-- Table & Info -->
            <div class="flex items-center justify-between px-2">
                <div class="text-sm text-gray-600">
                    {{ __('main.showing_count') }} {{ $countries->count() }} {{ __('main.of_total') }}
                    {{ $countries->total() }} {{ __('main.country') }}
                </div>
                <div class="text-sm text-gray-600">
                    {{ __('main.page') }} {{ $countries->currentPage() }} {{ __('main.of_total') }}
                    {{ $countries->lastPage() }}
                </div>
            </div>
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200 kt-table table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-center">
                                <input type="checkbox" id="selectAllCountries" class="kt-checkbox kt-checkbox-sm">
                            </th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.id') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.country_name') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.code') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.currency') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.status') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.created_at') }}</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($countries as $country)
                            <tr>
                                <td class="px-4 py-2 text-center">
                                    <input type="checkbox" class="kt-checkbox kt-checkbox-sm country-checkbox"
                                        value="{{ $country->id }}">
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $country->id }}</td>
                                <td class="px-4 py-2 flex items-center gap-2">
                                    <span class="text-2xl">{{ $country->flag_emoji ?? '🏳️' }}</span>
                                    <span class="font-medium text-mono">{{ $country->name }}</span>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $country->code }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $country->currency_code }}</td>
                                <td class="px-4 py-2">
                                    <span
                                        class="inline-block px-2 py-1 rounded text-xs font-semibold {{ $country->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $country->is_active ? __('Active') : __('Inactive') }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-500">
                                    {{ $country->created_at ? $country->created_at->format('Y-m-d') : '-' }}</td>
                                <td class="px-4 py-2 text-end">
                                    <a href="{{ route('countries.edit', $country->id) }}"
                                        class="kt-btn kt-btn-sm kt-btn-outline">{{ __('Edit') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <script>
                // تحديد الكل
                document.addEventListener('DOMContentLoaded', function() {
                    const selectAll = document.getElementById('selectAllCountries');
                    const checkboxes = document.querySelectorAll('.country-checkbox');
                    const bulkEditBtn = document.getElementById('bulkEditBtn');
                    const selectedInput = document.getElementById('selectedCountriesInput');

                    function updateBulkEditState() {
                        const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);
                        bulkEditBtn.disabled = selected.length === 0;
                        selectedInput.value = selected.join(',');
                    }
                    selectAll.addEventListener('change', function() {
                        checkboxes.forEach(cb => cb.checked = selectAll.checked);
                        updateBulkEditState();
                    });
                    checkboxes.forEach(cb => {
                        cb.addEventListener('change', function() {
                            if (!cb.checked) selectAll.checked = false;
                            updateBulkEditState();
                        });
                    });
                });
            </script>
            <div class="pt-4">
                {{ $countries->links() }}
            </div>
        </div>
    </div>
@endsection
