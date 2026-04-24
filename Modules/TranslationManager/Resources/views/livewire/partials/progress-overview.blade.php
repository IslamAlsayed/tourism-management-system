{{-- Translation Progress Overview (Collapsible) --}}
<div class="kt-card shadow-sm mb-5 w-full min-w-0 overflow-hidden" x-data="{ progressOpen: false }">
    <div class="kt-card-header py-5 px-6 cursor-pointer flex justify-between items-center" @click="progressOpen = !progressOpen">
        <h3 class="kt-card-title font-bold text-lg m-0 flex items-center">
            <i class="fas fa-chart-pie text-primary me-2"></i> {{ __('Translation Progress') }}
            <span class="kt-badge kt-badge-light kt-badge-sm ms-3 text-xs font-bold">{{ count($localeStats) }} {{ __('main.languages') }}</span>
        </h3>
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold" style="color: var(--muted-foreground);" x-text="progressOpen ? '{{ __('Click to collapse') }}' : '{{ __('Click to expand') }}'"></span>
            <i class="fas fa-chevron-down transition-transform duration-300" style="color: var(--muted-foreground);" :class="progressOpen ? 'rotate-180' : ''"></i>
        </div>
    </div>
    <div class="kt-card-body p-6 w-full min-w-0" x-show="progressOpen" x-collapse x-cloak>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-6">
            {{-- 16 unique color themes for file progress bars --}}
            @php $fileColors = [
                ['bg' => 'bg-blue-500',    'text' => 'text-blue-600 dark:text-blue-400'],
                ['bg' => 'bg-emerald-500', 'text' => 'text-emerald-600 dark:text-emerald-400'],
                ['bg' => 'bg-amber-500',   'text' => 'text-amber-600 dark:text-amber-400'],
                ['bg' => 'bg-rose-500',    'text' => 'text-rose-600 dark:text-rose-400'],
                ['bg' => 'bg-violet-500',  'text' => 'text-violet-600 dark:text-violet-400'],
                ['bg' => 'bg-cyan-500',    'text' => 'text-cyan-600 dark:text-cyan-400'],
                ['bg' => 'bg-orange-500',  'text' => 'text-orange-600 dark:text-orange-400'],
                ['bg' => 'bg-teal-500',    'text' => 'text-teal-600 dark:text-teal-400'],
                ['bg' => 'bg-pink-500',    'text' => 'text-pink-600 dark:text-pink-400'],
                ['bg' => 'bg-indigo-500',  'text' => 'text-indigo-600 dark:text-indigo-400'],
                ['bg' => 'bg-lime-500',    'text' => 'text-lime-600 dark:text-lime-400'],
                ['bg' => 'bg-fuchsia-500', 'text' => 'text-fuchsia-600 dark:text-fuchsia-400'],
                ['bg' => 'bg-sky-500',     'text' => 'text-sky-600 dark:text-sky-400'],
                ['bg' => 'bg-red-500',     'text' => 'text-red-600 dark:text-red-400'],
                ['bg' => 'bg-green-500',   'text' => 'text-green-600 dark:text-green-400'],
                ['bg' => 'bg-yellow-500',  'text' => 'text-yellow-600 dark:text-yellow-400'],
            ]; @endphp
            @foreach ($localeStats as $code => $stat)
                <div class="w-full min-w-0">
                    <div wire:click="$set('selectedLocale', '{{ $code }}')"
                        class="kt-card cursor-pointer w-full min-w-0 hover:shadow-lg transition-all h-full {{ $selectedLocale === $code ? 'shadow-sm' : '' }}"
                        style="border: 1px solid {{ $selectedLocale === $code ? 'var(--primary)' : 'var(--border)' }}; {{ $selectedLocale === $code ? 'background-color: hsl(var(--primary) / 0.05);' : '' }}">
                        <div class="kt-card-body p-4 lg:p-5 h-full w-full min-w-0 flex flex-col">
                            <div class="flex justify-between items-center mb-4 min-w-0 w-full shrink-0">
                                <div class="flex items-center min-w-0">
                                    <span class="w-8 h-8 rounded-full overflow-hidden me-3 flex items-center justify-center shadow-sm shrink-0" style="border: 1px solid var(--border);">
                                        <img src="{{ !empty($stat['photo']) ? (str_contains($stat['photo'], '/') ? asset('storage/' . $stat['photo']) : asset('assets/media/flags/' . $stat['photo'])) : asset('assets/media/flags/' . ($flagMap[$code] ?? $code) . '.svg') }}"
                                            alt="" class="w-full h-full object-cover">
                                    </span>
                                    <div class="text-lg font-bold truncate {{ $selectedLocale === $code ? 'text-primary' : '' }}" style="{{ $selectedLocale !== $code ? 'color: var(--foreground);' : '' }}">{{ $stat['name'] }}</div>
                                </div>
                                <div class="kt-badge {{ $selectedLocale === $code ? 'kt-badge-primary' : 'kt-badge-outline' }} rounded-full text-xs font-bold shrink-0">{{ strtoupper($code) }}</div>
                            </div>
                            {{-- Overall progress --}}
                            <div class="flex items-center gap-2 mb-3 shrink-0">
                                <div class="h-2 flex-1 rounded overflow-hidden" style="background-color: var(--muted);">
                                    <div class="h-full bg-primary rounded transition-all" style="width: {{ $stat['percentage'] }}%"></div>
                                </div>
                                <span class="text-sm font-bold {{ $stat['percentage'] >= 80 ? 'text-success' : ($stat['percentage'] >= 50 ? 'text-warning' : 'text-danger') }}">{{ $stat['percentage'] }}%</span>
                            </div>
                            {{-- Per-file progress bars --}}
                            <div class="flex flex-col w-full min-w-0 gap-2.5 flex-grow mb-4">
                                @foreach ($stat['files'] as $index => $fileStat)
                                    @php $colorTheme = $fileColors[$index % count($fileColors)]; @endphp
                                    <div class="flex flex-col w-full min-w-0" title="{{ $fileStat['name'] }}: {{ $fileStat['translated'] }}/{{ $fileStat['total'] }}">
                                        <div class="flex justify-between font-bold text-[10px] mb-0.5 min-w-0 w-full" style="color: var(--muted-foreground);">
                                            <span class="truncate pr-2">{{ $fileStat['name'] }} ({{ $fileStat['translated'] }}/{{ $fileStat['total'] }})</span>
                                            <span class="font-bold shrink-0 {{ $colorTheme['text'] }}">{{ $fileStat['percentage'] }}%</span>
                                        </div>
                                        <div class="h-1.5 w-full rounded overflow-hidden" style="background-color: var(--muted);">
                                            <div class="h-full {{ $colorTheme['bg'] }} rounded transition-all" style="width: {{ $fileStat['percentage'] }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{-- Stats footer --}}
                            <div class="shrink-0 mt-auto flex items-center gap-2">
                                @if ($stat['missing'] > 0)
                                    <div class="flex items-center bg-red-50 dark:bg-red-900/20 rounded p-2 px-3 justify-center w-full min-w-0 truncate">
                                        <i class="fas fa-exclamation-triangle text-danger text-sm me-2 shrink-0"></i>
                                        <span class="font-bold text-danger text-xs truncate">{{ $stat['missing'] }} {{ __('missing') }}</span>
                                    </div>
                                @else
                                    <div class="flex items-center bg-green-50 dark:bg-green-900/20 rounded p-2 px-3 justify-center w-full min-w-0 truncate">
                                        <i class="fas fa-check-circle text-success text-sm me-2 shrink-0"></i>
                                        <span class="font-bold text-success text-xs truncate">{{ __('Complete!') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
