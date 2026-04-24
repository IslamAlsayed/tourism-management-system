{{-- Filter Dropdowns: File + Language selectors --}}
<div class="kt-card w-full min-w-0 shadow-sm mb-5">
    <div class="kt-card-body py-5 px-6">
        <div class="rounded-lg p-5 flex flex-col md:flex-row flex-wrap gap-4 items-end w-full bg-muted border border-border">
            {{-- File Selector --}}
            <div class="w-full md:flex-1 min-w-0 md:min-w-[250px] relative" data-kt-dropdown="true" data-kt-dropdown-trigger="click" data-kt-dropdown-placement="bottom-start">
                <span class="font-bold text-xs uppercase mb-2 block text-muted-foreground">{{ __('File') }}</span>
                <button type="button" data-kt-dropdown-toggle="true"
                    class="w-full flex items-center justify-between text-start px-3 py-2 rounded-lg font-medium shadow-sm border border-border bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-primary">
                    @php
                        $selectedFileLabel = $selectedFile . '.php';
                        if (str_starts_with($selectedFile, 'global::')) {
                            $selectedFileLabel = 'global / ' . str_replace('global::', '', $selectedFile) . '.php';
                        } elseif (str_contains($selectedFile, '::')) {
                            $parts = explode('::', $selectedFile);
                            if (count($parts) === 2) $selectedFileLabel = 'Module: ' . $parts[0] . ' / ' . $parts[1] . '.php';
                        }
                    @endphp
                    <span class="truncate font-bold"><i class="fas fa-file-code me-2 text-primary opacity-50"></i> {{ $selectedFileLabel }}</span>
                    <i class="fa-solid fa-chevron-down text-xs text-muted-foreground transition-transform duration-200 kt-dropdown-open:rotate-180"></i>
                </button>
                <div class="kt-dropdown w-full max-h-60 overflow-y-auto custom-scrollbar py-2 bg-popover text-popover-foreground border border-border shadow-lg rounded-lg" data-kt-dropdown-menu="true">
                    @foreach ($availableFiles as $file)
                        @php
                            $displayLabel = $file . '.php';
                            if (str_starts_with($file, 'global::')) { $displayLabel = 'global / ' . str_replace('global::', '', $file) . '.php'; }
                            elseif (str_contains($file, '::')) { $parts = explode('::', $file); if (count($parts) === 2) $displayLabel = 'Module: ' . $parts[0] . ' / ' . $parts[1] . '.php'; }
                        @endphp
                        <button type="button" wire:click="$set('selectedFile', '{{ $file }}')" data-kt-dropdown-dismiss="true"
                            class="kt-dropdown-menu-link w-full text-start px-3 py-2 flex items-center gap-3 {{ $selectedFile === $file ? 'bg-primary/10 text-primary' : '' }}">
                            <span class="truncate font-bold {{ $selectedFile === $file ? 'text-primary' : '' }}">{{ $displayLabel }}</span>
                            @if ($selectedFile === $file) <i class="fas fa-check ms-auto text-primary text-sm"></i> @endif
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Language Selector --}}
            <div class="w-full md:flex-1 min-w-0 md:min-w-[200px] relative" data-kt-dropdown="true" data-kt-dropdown-trigger="click" data-kt-dropdown-placement="bottom-start">
                <span class="font-bold text-xs uppercase mb-2 block text-muted-foreground">{{ __('Language') }}</span>
                <button type="button" data-kt-dropdown-toggle="true"
                    class="w-full flex items-center justify-between text-start px-3 py-2 rounded-lg font-medium shadow-sm border border-border bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-primary">
                    <div class="flex items-center gap-2 truncate">
                        @if (isset($localePhotos[$selectedLocale]))
                            <img src="{{ !empty($localePhotos[$selectedLocale]) ? (str_contains($localePhotos[$selectedLocale], '/') ? asset('storage/' . $localePhotos[$selectedLocale]) : asset('assets/media/flags/' . $localePhotos[$selectedLocale])) : asset('assets/media/flags/' . ($flagMap[$selectedLocale] ?? $selectedLocale) . '.svg') }}"
                                alt="" class="w-5 h-5 rounded-sm object-cover shadow-sm border border-border">
                        @else
                            <span class="w-5 h-5 flex items-center justify-center rounded-sm text-[10px] font-bold bg-muted text-muted-foreground">{{ strtoupper($selectedLocale) }}</span>
                        @endif
                        <span class="truncate">{{ $availableLocales[$selectedLocale] ?? strtoupper($selectedLocale) }} ({{ strtoupper($selectedLocale) }})</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs text-muted-foreground transition-transform duration-200 kt-dropdown-open:rotate-180"></i>
                </button>
                <div class="kt-dropdown w-full py-1 max-h-60 overflow-y-auto custom-scrollbar bg-popover text-popover-foreground border border-border shadow-lg rounded-lg" data-kt-dropdown-menu="true">
                    @foreach ($availableLocales as $code => $name)
                        <button type="button" wire:click="$set('selectedLocale', '{{ $code }}')" data-kt-dropdown-dismiss="true"
                            class="kt-dropdown-menu-link w-full text-start px-3 py-2 flex items-center gap-3 {{ $selectedLocale === $code ? 'bg-primary/10 text-primary' : '' }}">
                            @if (isset($localePhotos[$code]))
                                <img src="{{ !empty($localePhotos[$code]) ? (str_contains($localePhotos[$code], '/') ? asset('storage/' . $localePhotos[$code]) : asset('assets/media/flags/' . $localePhotos[$code])) : asset('assets/media/flags/' . ($flagMap[$code] ?? $code) . '.svg') }}"
                                    alt="" class="w-5 h-5 rounded-sm object-cover shadow-sm border border-border">
                            @else
                                <span class="w-5 h-5 flex items-center justify-center rounded-sm text-[10px] font-bold bg-muted text-muted-foreground">{{ strtoupper($code) }}</span>
                            @endif
                            <span class="truncate font-medium {{ $selectedLocale === $code ? 'text-primary' : '' }}">{{ $name }} ({{ strtoupper($code) }})</span>
                            @if ($selectedLocale === $code) <i class="fas fa-check ms-auto text-primary text-sm"></i> @endif
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
