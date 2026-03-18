<div class="kt-card"
    @if($hasActiveJobs) wire:poll.3s @endif
>
    <div class="kt-card-header min-h-14">
        <h3 class="kt-card-title flex items-center gap-2">
            <i class="ki-filled ki-time text-muted-foreground text-lg"></i>
            {{ __('main.import_history') ?? 'Import History' }}
            
            @if($hasActiveJobs)
                <span class="relative flex h-3 w-3 ms-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-warning opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-warning"></span>
                </span>
                <span class="text-xs text-muted-foreground ms-1 animate-pulse">{{ __('main.processing') ?? 'Processing...' }}</span>
            @endif
        </h3>
        
        @if (auth()->user() && auth()->user()->hasRole('superadmin') && count($history) > 0)
            <div class="flex items-center gap-2">
                 <button type="button" 
                         wire:click="clearHistory" 
                         wire:confirm="{{ __('main.clear_history_confirm_message') ?? 'This will delete all import history records. This action cannot be undone.' }}"
                         class="kt-btn kt-btn-sm kt-btn-destructive-outline">
                     <i class="ki-filled ki-trash me-1.5"></i>
                     {{ __('main.clear_history') ?? 'Clear History' }}
                 </button>
            </div>
        @endif
    </div>
    
    @if($hasActiveJobs && $activeJob)
        <!-- Prominent Unskippable Overlay for Active Imports -->
        <div class="fixed inset-0 z-[9999] flex items-center justify-center m-0 p-0" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 9999; background-color: rgba(0, 0, 0, 0.7); backdrop-filter: blur(5px);">
            <div class="bg-card w-full max-w-lg rounded-xl shadow-2xl border border-border relative">
                <!-- Close Button (Fallback if stuck) -->
                @if($activeJob->status === 'queued')
                <button wire:click="cancelJob({{ $activeJob->id }})" class="absolute top-4 right-4 text-muted-foreground hover:text-destructive">
                    <i class="ki-filled ki-cross text-xl"></i>
                </button>
                @endif
                <div class="p-8 text-center shadow-sm">
                    <div class="w-20 h-20 mx-auto rounded-full bg-primary/10 flex items-center justify-center mb-6">
                        <i class="ki-filled ki-cloud-download text-5xl text-primary animate-bounce"></i>
                    </div>
                    
                    <h2 class="text-2xl font-semibold mb-2">{{ __('main.importing_data') }}</h2>
                    <p class="text-secondary-foreground mb-8 text-base">
                        {{ __('main.please_wait_importing') }}
                    </p>
                    
                    @if($activeJob->status === 'processing')
                        <div class="mb-2 flex justify-between text-sm font-medium">
                            <span>{{ __('main.progress') }}</span>
                            <span>{{ $progressPercentage }}%</span>
                        </div>
                        <div class="w-full bg-secondary rounded-full h-4 mb-4 overflow-hidden border border-border">
                            <div class="bg-primary h-4 rounded-full transition-all duration-1000 ease-out flex items-center justify-center" style="width: {{ $progressPercentage }}%">
                                @if($progressPercentage > 10)
                                    <span class="text-[10px] text-primary-foreground font-bold px-2">{{ $progressPercentage }}%</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 text-sm mt-6">
                            <div class="bg-secondary/50 p-3 rounded-lg border border-border">
                                <span class="block text-muted-foreground text-xs uppercase cursor-default mb-1">{{ __('main.records_processed') }}</span>
                                <span class="font-semibold text-xl">{{ number_format($activeJob->processed_records ?? 0) }} / {{ number_format($activeJob->total_records ?? 0) }}</span>
                            </div>
                            <div class="bg-secondary/50 p-3 rounded-lg border border-border">
                                <span class="block text-muted-foreground text-xs uppercase cursor-default mb-1">{{ __('main.estimated_time') }}</span>
                                <span class="font-semibold text-xl text-primary">{{ $eta }}</span>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center gap-3 text-secondary-foreground bg-secondary/30 p-6 rounded-lg mt-4">
                            <i class="ki-filled ki-loading animate-spin text-3xl text-primary"></i>
                            <span class="font-medium text-lg">{{ __('main.queued_waiting') }}</span>

                        </div>
                    @endif
                </div>
                <div class="bg-warning/10 p-4 text-center border-t border-warning/20 rounded-b-xl">
                    <p class="text-warning-foreground text-sm flex items-center justify-center gap-2 font-medium">
                        <i class="ki-filled ki-information-2 text-xl"></i>
                        {{ __('main.do_not_refresh_warning') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    
    @if(count($history) > 0)
    <div class="kt-card-table">
        <div class="kt-table-wrapper">
            <table class="kt-table kt-table-border">
                <thead>
                    <tr>
                        <th>{{ __('main.date') ?? 'Date' }}</th>
                        <th>{{ __('main.user') ?? 'User' }}</th>
                        <th>{{ __('main.source') ?? 'Source' }}</th>
                        <th>{{ __('main.records') ?? 'Records' }}</th>
                        <th>{{ __('main.status') ?? 'Status' }}</th>
                        <th class="text-end">{{ __('main.details') ?? 'Details' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($history as $item)
                        <tr wire:key="history-{{ $item->id }}">
                            <td class="text-nowrap text-secondary-foreground text-sm">
                                {{ $item->created_at->format('d M Y H:i') }}
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium">{{ $item->user->name ?? 'System' }}</span>
                                </div>
                            </td>
                            <td>
                                @if ($item->source === 'google_drive')
                                    <span class="kt-badge kt-badge-primary gap-1">
                                        <i class="ki-filled ki-cloud text-xs"></i>
                                        Google Drive
                                    </span>
                                @else
                                    <span class="kt-badge kt-badge-secondary gap-1">
                                        <i class="ki-filled ki-file text-xs"></i>
                                        {{ __('main.file_upload') ?? 'File Upload' }}
                                    </span>
                                @endif
                            </td>
                            <td class="font-semibold">
                                {{ $item->record_count ? number_format($item->record_count) : '—' }}
                            </td>
                            <td>
                                @if ($item->status === 'completed')
                                    <span class="kt-badge kt-badge-success">
                                        <i class="ki-filled ki-check-circle me-1 text-xs"></i>
                                        {{ __('main.completed') ?? 'Completed' }}
                                    </span>
                                @elseif ($item->status === 'failed')
                                    <span class="kt-badge kt-badge-destructive"
                                        title="{{ $item->error_message }}">
                                        <i class="ki-filled ki-cross-circle me-1 text-xs"></i>
                                        {{ __('main.failed') ?? 'Failed' }}
                                    </span>
                                @elseif ($item->status === 'processing')
                                    <span class="kt-badge kt-badge-warning animate-pulse">
                                        <i class="ki-filled ki-time me-1 text-xs"></i>
                                        {{ __('main.processing') ?? 'Processing' }}
                                    </span>
                                @elseif ($item->status === 'queued')
                                    <span class="kt-badge kt-badge-info">
                                        <i class="ki-filled ki-information me-1 text-xs"></i>
                                        {{ __('main.queued') ?? 'Queued' }}
                                    </span>
                                @else
                                    <span class="kt-badge kt-badge-secondary">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if ($item->error_message)
                                    <span class="text-xs text-destructive max-w-48 truncate inline-block"
                                        title="{{ $item->error_message }}">
                                        {{ Str::limit($item->error_message, 40) }}
                                    </span>
                                @elseif($item->status === 'completed')
                                    <span class="text-xs text-success"><i class="ki-filled ki-verify"></i></span>
                                @else
                                    <span class="text-xs text-muted-foreground"><span class="animate-ping max-w-1 max-h-1 bg-current rounded-full inline-block"></span></span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="kt-card-body pb-6 flex flex-col items-center justify-center text-center">
        <div class="bg-secondary/30 rounded-full h-16 w-16 flex items-center justify-center mb-3">
            <i class="ki-filled ki-data text-2xl text-muted-foreground"></i>
        </div>
        <p class="text-muted-foreground text-sm">{{ __('main.no_history_records') ?? 'No import history found.' }}</p>
    </div>
    @endif
    
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('import-completed-confetti', (event) => {
                // Trigger global confetti effect (assuming it's available or we can use generic one)
                if (typeof triggerConfetti === 'function') {
                    triggerConfetti();
                } else if (typeof window.confetti === 'function') {
                    window.confetti({
                        particleCount: 150,
                        spread: 80,
                        origin: { y: 0.6 },
                        colors: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6']
                    });
                } else {
                     // Fallback check if script is loaded, if not load it dynamically
                    if (!document.getElementById('confetti-script')) {
                        const script = document.createElement('script');
                        script.id = 'confetti-script';
                        script.src = 'https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js';
                        script.onload = () => {
                            window.confetti({ particleCount: 150, spread: 80, origin: { y: 0.6 } });
                        };
                        document.head.appendChild(script);
                    } else {
                        window.confetti({ particleCount: 150, spread: 80, origin: { y: 0.6 } });
                    }
                }
            });
            
            Livewire.on('alert', (data) => {
                const type = data[0].type || 'success';
                const message = data[0].message || '';
                if (typeof showToast === 'function') {
                    showToast(type, message);
                } else if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: type,
                        title: message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000
                    });
                }
            });

            Livewire.on('import-completed-modal', (data) => {
                // In Livewire 3, event details are often passed either directly as the object or wrapped in an array.
                const details = Array.isArray(data) ? data[0] : data;
                
                if (typeof Swal !== 'undefined' && details) {
                    Swal.fire({
                        icon: details.icon || 'success',
                        title: details.title || 'Success',
                        text: details.text || '',
                        showConfirmButton: true,
                        confirmButtonText: details.confirmButtonText || 'OK',
                        timer: undefined
                    });
                } else if (details) {
                    alert(details.title + '\n' + details.text);
                }
            });
        });
    </script>
</div>
