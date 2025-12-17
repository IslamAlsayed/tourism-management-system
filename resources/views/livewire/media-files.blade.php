<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.media-files'),
        'entityName' => __('main.media-file'),
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

    <div class="kt-card-content px-3" wire:target="search,resetFilters,filterType,filterCollection,filterStatus"
        wire:loading.class="loading">
        <!-- Filters -->
        <div class="grid grid-cols-1 md-grid-cols-2 gap-4 filterTable" wire:ignore>
            {{-- Filter by Type --}}
            <div>
                <label for="filterType">{{ __('main.all_types') }}</label>
                <select wire:model.live="filterType" id="filterType" class="kt-select">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="image">{{ __('main.images') }}</option>
                    <option value="video">{{ __('main.videos') }}</option>
                    <option value="document">{{ __('main.documents') }}</option>
                    <option value="spreadsheet">{{ __('main.spreadsheets') }}</option>
                    <option value="other">{{ __('main.other') }}</option>
                </select>
            </div>

            {{-- Filter by Collection --}}
            <div>
                <label for="filterCollection">{{ __('main.all_collections') }}</label>
                <select wire:model.live="filterCollection" id="filterCollection" class="kt-select">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach ($collections as $collection)
                        <option value="{{ $collection }}">{{ ucfirst($collection) }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter by Status --}}
            <div>
                <label for="filterStatus">{{ __('main.all_status') }}</label>
                <select wire:model.live="filterStatus" id="filterStatus" class="kt-select">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
                </select>
            </div>

            {{-- Reset Sort Button --}}
            <div>
                <button type="button" wire:click="resetFilters" title="{{ __('main.reset_validate') }}" toggle-button
                    class="kt-btn kt-btn-outline bg-white px-3hover:bg-gray-50 transition-colors">
                    <i class="fas fa-arrow-rotate-left text-blue-600 me-1"></i>
                </button>
            </div>
        </div>

        {{-- Filters and Search --}}
        {{-- @if (count($selectedIds) > 0)
            <div class="kt-card mb-6">
                <div class="kt-card-body p-4">
                    Bulk Actions
                    <div class="flex items-center gap-3 p-3 bg-primary-light rounded-lg">
                        <span class="text-sm font-medium">
                            {{ __('main.selected_items', ['count' => count($selectedIds)]) }}
                        </span>
                        <button wire:click="deleteSelected" wire:confirm="{{ __('main.are_you_sure') }}"
                            class="kt-btn kt-btn-sm kt-btn-danger">
                            <i class="ki-filled ki-trash"></i>
                            {{ __('main.delete_selected') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif --}}

        <div class="kt-card-content" id="pageContent" wire:loading.class="loading" wire:target="toggleGridLength">
            @if ($view == 'grid')
                <div class="kt-cards" wire:key="{{ $view ? $view : '' }}-view">
                    <div class="inline-flex text-nowrap items-center gap-2 text-center mt-3 mb-3 cursor-pointer">
                        {{-- @include('components.elements.all-checkbox-button', [
                            'name' => 'selectAllItems',
                            'id' => 'selectAllItems',
                            'label' => __('main.select_type', ['type' => __('main.all')]),
                        ]) --}}

                        {{-- Grid length --}}
                        <div id="grid-length-selector">
                            <label for="gridLength">{{ __('main.grid_length') }}</label>
                            <select wire:change="toggleGridLength($event.target.value, 'media_files')"
                                wire:model.live="gridLength" class="kt-select" id="gridLength">
                                @for ($length = 1; $length <= 5; $length++)
                                    <option value="{{ $length }}">{{ $length }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    {{-- class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-{{ $gridLength }} gap-4 mb-4"> --}}
                    <div class="grid gap-2 md:gap-4 mb-4 tow"
                        style="grid-template-columns: repeat({{ $gridLength }}, minmax(0, 1fr));"
                        id="media-files-grid">
                        @forelse($data as $file)
                            {{-- style="width: calc((100% / {{ $gridLength }}) - {{ (($gridLength - 1) * 16) / $gridLength }}px)" --}}
                            <div
                                class="relative group rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                {{-- Checkbox --}}
                                {{-- <div class="absolute top-2 left-2 z-10">
                                    <input type="checkbox" wire:model.live="selectedIds" value="{{ $file->id }}"
                                        class="kt-checkbox">
                                </div> --}}

                                {{-- Preview --}}
                                <div class="aspect-square bg-gray-100 flex items-center justify-center overflow-hidden">
                                    @if ($file->is_image)
                                        <a href="{{ route('media-files.show', $file->id) }}"
                                            class="w-full; display: contents">
                                            <img src="{{ asset('storage/' . $file->file_path) }}"
                                                alt="{{ $file->alt_text ?? $file->file_name }}"
                                                class="w-full h-full object-cover" loading="lazy">
                                        </a>
                                    @else
                                        <div class="text-center p-4">
                                            <i class="ki-filled ki-file text-4xl text-gray-400"></i>
                                            <div class="text-xs text-gray-600 mt-2">
                                                {{ strtoupper($file->extension) }}
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- File Info --}}
                                <div class="p-3 bg-white">
                                    <div class="text-xs font-medium text-gray-900 truncate"
                                        title="{{ $file->file_name }}">
                                        {{ $file->file_name }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $file->human_file_size }}
                                    </div>
                                    <div class="flex items-end justify-between gap-1 mt-2">
                                        @if ($file->collection_name)
                                            <span
                                                class="px-2 py-1 text-xs bg-primary text-white rounded-full media-file-collection">
                                                {{ ucfirst($file->collection_name) }}
                                            </span>
                                        @endif
                                        <div class="flex gap-2 media-file-actions">
                                            @include('components.elements.show-button', [
                                                'models' => 'media-files',
                                                'id' => $file->id,
                                                'text' => '<i class="ki-filled ki-eye text-white"></i>',
                                            ])
                                            @include('components.elements.edit-button', [
                                                'models' => 'media-files',
                                                'id' => $file->id,
                                                'text' => '<i class="ki-filled ki-pencil text-white"></i>',
                                            ])
                                            @include('components.elements.delete-button', [
                                                'models' => 'media-files',
                                                'id' => $file->id,
                                                'text' => '<i class="ki-filled ki-trash text-white"></i>',
                                            ])
                                        </div>
                                    </div>
                                    @if ($file->width && $file->height)
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $file->width }} × {{ $file->height }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <i class="ki-filled ki-picture text-6xl text-gray-300"></i>
                                <p class="text-gray-500 mt-4">{{ __('main.no_files_found') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @else
                <div wire:key="{{ $view ? $view : '' }}-view" data-kt-datatable="true"
                    data-kt-datatable-state-save="false" id="team_crew_table">
                    <div class="kt-scrollable-x-auto" wire:target="search" wire:loading.class="loading">
                        @component('components.data-table', [
                            'data' => $data,
                            'columns' => $columns,
                            'search' => $search,
                            'models' => 'media-files',
                            'selectedIds' => $selectedIds ?? [],
                        ])
                        @endcomponent
                    </div>
                </div>
            @endif

            @if (isset($data) && !empty($data) && $data->count() > 0)
                @include('includes.pagination', ['data' => $data])
            @endif
        </div>
    </div>
</div>
