<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.languages'),
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
        <div x-cloak x-show="$wire.selectedIds && $wire.selectedIds.length > 0"
                class="mb-4 flex flex-shrink flex-wrap items-center gap-2 px-1 bg-gray-50 p-3 rounded-lg border border-gray-200 shadow-sm">
                <span class="text-sm font-medium text-gray-700 me-2 p-2 bg-white rounded border border-gray-300">
                    {{ __('main.selected') }}: <span class="badge badge-primary" x-text="$wire.selectedIds.length"></span>
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
                                $wire.call('deleteSelected');
                            }
                        })
                    }
                }" class="flex flex-wrap gap-2 items-center">
                    <button type="button" x-on:click.prevent="confirmDelete"
                        class="kt-btn kt-btn-sm text-white bg-red-600 hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash me-1"></i>
                        {{ __('main.delete') }}
                    </button>
                    <button type="button" @click.prevent="$wire.selectedIds = []"
                        class="kt-btn kt-btn-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-times me-1"></i>
                        {{ __('main.cancel_selection') }}
                    </button>
                </div>
            </div>
        </div>

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
                        <select wire:change="toggleGridLength($event.target.value,'languages')"
                            wire:model.live="gridLength" class="kt-select">
                            @for ($length = 1; $length <= 10; $length++)
                                <option value="{{ $length }}" @if ($gridLength == $length) selected @endif>
                                    {{ $length }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                @php
                    $flagMap = [
                        'en' => 'us', 'ar' => 'sa', 'he' => 'il', 'ja' => 'jp', 'zh' => 'cn',
                        'ko' => 'kr', 'pt' => 'pt', 'ur' => 'pk', 'hi' => 'in', 'ru' => 'ru',
                        'tr' => 'tr', 'de' => 'de', 'es' => 'es', 'fr' => 'fr', 'it' => 'it'
                    ];
                @endphp

                <div class="grid gap-6 mb-4" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
                    @foreach ($data as $language)
                        @php
                            $sysLang = \Modules\Localization\Entities\SystemLanguage::where('code', $language->code)->first();
                            $photo = $sysLang ? $sysLang->photo : null;
                            $flagUrl = null;
                            if ($photo) {
                                $flagUrl = str_contains($photo, '/') ? asset('storage/' . $photo) : asset('assets/media/flags/' . $photo);
                            } elseif (isset($flagMap[$language->code])) {
                                $flagUrl = asset('assets/media/flags/' . $flagMap[$language->code] . '.svg');
                            }
                        @endphp
                        
                        <div wire:key="{{ $language->id }}" 
                             class="kt-card group relative overflow-hidden bg-white hover:bg-gray-50 text-center rounded-xl shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-md p-0">
                            
                            @if($flagUrl)
                                <!-- Background Watermark -->
                                <div class="absolute inset-0 opacity-10 pointer-events-none bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat transition-opacity duration-300 group-hover:opacity-15"
                                     style="background-image: url('{{ $flagUrl }}'); z-index: 0;"></div>
                            @endif
                            
                            {{-- Checkbox --}}
                            <div class="absolute top-4 right-4 z-10 flex items-center justify-between w-full px-4" style="width: auto; left: 0;">
                                <div class="text-start">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'selectedItems[]',
                                        'id' => 'selectedItems' . $language->id,
                                        'value' => $language->id,
                                    ])
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-5 flex flex-col items-center justify-center w-full gap-3 mt-4 relative z-10">
                                <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-dashed border-gray-300 flex items-center justify-center p-1 bg-white">
                                    @if($flagUrl)
                                        <img src="{{ $flagUrl }}" class="w-full h-full rounded-full object-cover" alt="{{ $language->code }} flag">
                                    @else
                                        <div class="w-full h-full rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-lg uppercase">
                                            {{ substr($language->code, 0, 2) }}
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex flex-col items-center gap-1 mt-2">
                                    <div class="kt-badge kt-badge-light kt-badge-primary rounded-full px-3 py-1 font-bold text-xs uppercase tracking-wider mb-1">
                                        {!! highlightSearch($language->code ?? '--', $search) !!}
                                    </div>
                                    <h3 class="font-bold text-gray-900 text-lg mb-0">{!! highlightSearch($language->name ?? '--', $search) !!}</h3>
                                    <span class="text-gray-500 text-sm">{!! highlightSearch($language->name_ar ?? '--', $search) !!}</span>
                                </div>
                                
                                <div class="w-full h-px bg-gray-100 my-2"></div>
                                
                                <div class="flex justify-center gap-2 w-full mt-1">
                                    @include('components.elements.edit-button', [
                                        'models' => 'dashboard.localization.languages',
                                        'id' => $language->id,
                                        'classes' => 'flex-1 justify-center'
                                    ])

                                    @include('components.elements.delete-button', [
                                        'id' => $language->id,
                                        'classes' => 'flex-1 justify-center'
                                    ])
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            
        @else
            <div wire:key="{{ $view ? $view : '' }}-view" data-kt-datatable="true" data-kt-datatable-state-save="false"
                id="team_crew_table">
                @component('components.data-table', [
                        'data' => $data,
                        'columns' => $columns,
                        'search' => $search,
                        'models' => 'dashboard.localization.languages',
                        'selectedIds' => $selectedIds ?? [],
                    ])
                    @endcomponent
            </div>
        @endif
    </div>

    @if (isset($data) && !empty($data) && $data->count() > 0)
        @include('includes.pagination', ['data' => $data])
    @endif
</div>

