<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.system_languages'),
        'entityName' => __('main.language'),
        'sortField' => $sortField ?? null,
        'searchValue' => $search ?? null,
        'showSearch' => true,
    ])
        @if (isset($data) && !empty($data) && $data->count() > 0 && isset($allColumns))
            @include('components.columns', [
                'allColumns' => $allColumns ?? [],
                'selectedIds' => $selectedIds ?? [],
            ])
        @endif
    @endcomponent

    <div class="kt-card-content" id="pageContent" wire:loading.class="loading"
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,toggleGridLength">

        {{-- Bulk Action Buttons --}}
        @if (!empty($selectedIds) && count($selectedIds) > 0)
            <div
                class="mb-4 flex flex-shrink flex-wrap items-center gap-2 px-1 bg-gray-50 p-3 rounded-lg border border-gray-200 shadow-sm">
                <span class="text-sm font-medium text-gray-700 me-2 p-2 bg-white rounded border border-gray-300">
                    {{ __('main.selected') }}: <span class="badge badge-primary">{{ count($selectedIds) }}</span>
                </span>

                <div x-data="{
                    confirmDelete() {
                        Swal.fire({
                            title: '{{ __('messages.are_you_sure') }}',
                            text: `{{ __('messages.confirm_bulk_delete') }}`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: '{{ __('main.yes') }}',
                            cancelButtonText: '{{ __('main.no') }}'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                @this.call('deleteSelected');
                            }
                        })
                    }
                }" class="flex flex-wrap gap-2 items-center">
                    <button type="button" x-on:click.prevent="confirmDelete"
                        class="kt-btn kt-btn-sm text-white bg-red-600 hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash me-1"></i>
                        {{ __('main.delete') }}
                    </button>
                    <button type="button" wire:click.prevent="clearSelected"
                        class="kt-btn kt-btn-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-times me-1"></i>
                        {{ __('main.cancel_selection') }}
                    </button>
                </div>
            </div>
        @endif
        @if ($view == 'grid')
            <div class="kt-cards p-4" wire:key="{{ $view ? $view : '' }}-view">
                <div class="inline-flex text-nowrap items-center gap-2 text-center mb-2 cursor-pointer">
                    @include('components.elements.all-checkbox-button', [
                        'name' => 'selectAllItems',
                        'id' => 'selectAllItems',
                        'label' => __('main.select_type', ['type' => __('main.all')]),
                    ])

                    {{-- Grid length --}}
                    <div>
                        <select wire:change="toggleGridLength($event.target.value,'system_languages')"
                            wire:model.live="gridLength" class="kt-select">
                            @for ($length = 1; $length <= 10; $length++)
                                <option value="{{ $length }}">{{ $length }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4 mb-4">
                    @foreach ($data as $language)
                        <div wire:key="{{ $language->id }}"
                            style="width: calc((100% / {{ $gridLength }}) - {{ (($gridLength - 1) * 16) / $gridLength }}px)"
                            class="kt-card text-center p-4 rounded-lg shadow-sm {{ getCurrentLocale() == $language->code ? 'bg-gray-100 border-2 border-green-500' : 'hover:bg-gray-100' }}">
                            <span class="text-start">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'selectedItems[]',
                                    'id' => 'selectedItems' . $language->id,
                                    'value' => $language->id,
                                ])
                            </span>
                            <div class="kt-card-title">{!! highlightSearch($language->code ?? '--', $search) !!}</div>
                            <div class="kt-card-body pb-2">
                                <p>{!! highlightSearch($language->name ?? '--', $search) !!}</p>
                                @if ($language->name_ar)
                                    <p>{!! highlightSearch($language->name_ar ?? '--', $search) !!}</p>
                                @endif
                            </div>
                            <div class="kt-card-footer flex justify-center p-0 pt-2">
                                <div class="flex justify-center gap-2">
                                    @if (getCurrentLocale() != $language->code)
                                        <a href="{{ route('dashboard.localization.system-languages.change', $language->code) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-success text-white">
                                            {{ __('main.active') }}
                                        </a>
                                    @endif
                                    @include('components.elements.edit-button', [
                                        'models' => 'system-languages',
                                        'id' => $language->id,
                                    ])
                                    @include('components.elements.delete-button', [
                                        'id' => $language->id,
                                    ])
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div wire:key="{{ $view ? $view : '' }}-view" data-kt-datatable="true" data-kt-datatable-state-save="false"
                id="team_crew_table">
                <div class="kt-scrollable-x-auto" wire:loading.class="loading"
                    wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel">
                    <table class="kt-table table-auto text-nowrap">
                        <thead>
                            <tr>
                                <th class="w-[60px] px-4 py-3 text-center">
                                    @include('components.elements.all-checkbox-button', [
                                        'name' => 'selectAllItems',
                                        'id' => 'selectAllItems',
                                    ])
                                </th>
                                @foreach ($columns as $column)
                                    <th
                                        class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('main.' . $column) }}
                                    </th>
                                @endforeach
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $language)
                                <tr wire:key="{{ $language->id }}"
                                    class="{{ getCurrentLocale() == $language->code ? 'bg-gray-100' : 'hover:bg-gray-100' }}">
                                    <td class="text-center">
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'selectedItems[]',
                                            'id' => 'selectedItems' . $language->id,
                                            'value' => $language->id,
                                        ])
                                    </td>
                                    @foreach ($columns as $column)
                                        @include('components.static-columns', [
                                            'column' => $column,
                                            'model' => $language,
                                            'search' => $search,
                                        ])
                                    @endforeach
                                    <td class="px-4 py-2 text-end">
                                        <div class="flex items-center justify-end gap-2">
                                            @if (getCurrentLocale() != $language->code)
                                                <a href="{{ route('dashboard.localization.system-languages.change', $language->code) }}"
                                                    class="kt-btn kt-btn-sm kt-btn-outline bg-success text-white">
                                                    {{ __('main.active') }}
                                                </a>
                                            @else
                                                <span style="padding-inline: 17px"
                                                    class="kt-btn kt-btn-sm bg-yellow-500 text-white">
                                                    {{ __('main.currently') }}
                                                </span>
                                            @endif
                                            @include('components.elements.edit-button', [
                                                'models' => 'system-languages',
                                                'id' => $language->id,
                                            ])
                                            @include('components.elements.delete-button', [
                                                'id' => $language->id,
                                            ])
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if (isset($data) && !empty($data) && $data->count() > 0)
            @include('includes.pagination', ['data' => $data])
        @endif
    </div>
</div>
