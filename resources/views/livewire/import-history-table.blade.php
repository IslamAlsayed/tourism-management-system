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
                         x-data
                         x-on:click="
                             if (typeof Swal !== 'undefined') {
                                 Swal.fire({
                                     title: '{{ __('main.clear_history_confirm_title') ?? 'Clear Import History?' }}',
                                     text: '{{ __('main.clear_history_confirm_message') ?? 'This will delete all import history records. This action cannot be undone.' }}',
                                     icon: 'warning',
                                     showCancelButton: true,
                                     confirmButtonColor: '#d33',
                                     confirmButtonText: '{{ __('main.yes_clear') ?? 'Yes, clear it!' }}',
                                     cancelButtonText: '{{ __('main.cancel') ?? 'Cancel' }}'
                                 }).then((result) => {
                                     if (result.isConfirmed) {
                                         $wire.clearHistory()
                                     }
                                 })
                             } else {
                                 if(confirm('{{ __('main.clear_history_confirm_message') ?? 'Are you sure?' }}')) { 
                                     $wire.clearHistory() 
                                 }
                             }
                         "
                         class="kt-btn kt-btn-sm kt-btn-destructive-outline group">
                     <i class="ki-filled ki-trash me-1.5 group-hover:animate-pulse"></i>
                     {{ __('main.clear_history') ?? 'Clear History' }}
                 </button>
            </div>
        @endif
    </div>
    
    @if($hasActiveJobs && $activeJob)
        <!-- Prominent Unskippable Overlay for Active Imports -->
        <div class="fixed inset-0 z-[9999] flex items-center justify-center m-0 p-0" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 9999; background-color: rgba(0, 0, 0, 0.7); backdrop-filter: blur(5px);">
            <div class="bg-card w-full max-w-[400px] sm:w-1/3 rounded-xl shadow-2xl border border-border relative flex flex-col max-h-[90vh]">
                <!-- Close Button (Fallback if stuck) -->
                @if(in_array($activeJob->status, ['queued', 'pending_start', 'processing']))
                <button wire:click="cancelJob({{ $activeJob->id }})" class="absolute top-4 right-4 z-10 text-muted-foreground hover:text-destructive transition-colors">
                    <i class="ki-filled ki-cross text-xl"></i>
                </button>
                @endif
                <div class="p-8 text-center shadow-sm flex-1 overflow-auto">
                    <div class="w-20 h-20 mx-auto rounded-full bg-primary/10 flex items-center justify-center mb-6">
                        @if($activeJob->status === 'pending_start')
                            <i class="ki-filled ki-rocket text-5xl text-primary"></i>
                        @elseif($activeJob->status === 'processing')
                            <i class="ki-filled ki-cloud-download text-5xl text-primary animate-bounce"></i>
                        @else
                            <i class="ki-filled ki-cloud-download text-5xl text-primary opacity-50"></i>
                        @endif
                    </div>
                    
                    <h2 class="text-2xl font-semibold mb-2">{{ __('main.importing_data') }}</h2>
                    <p class="text-secondary-foreground mb-4 text-base">
                        @if($activeJob->status === 'pending_start')
                            {{ __('main.ready_to_start_import') ?? 'Ready to start the import process.' }}
                        @else
                            {{ __('main.please_wait_importing') }}
                        @endif
                    </p>
                    
                    @if($activeJob->status === 'pending_start')
                        <div class="flex justify-center gap-4 mt-6">
                            <button wire:click="startJob({{ $activeJob->id }})" class="kt-btn kt-btn-primary px-8">
                                <i class="ki-filled ki-rocket me-2"></i> {{ __('main.start') ?? 'Start' }}
                            </button>
                            <button wire:click="cancelJob({{ $activeJob->id }})" class="kt-btn kt-btn-outline px-8">
                                {{ __('main.cancel') ?? 'Cancel' }}
                            </button>
                        </div>
                    @elseif($activeJob->status === 'processing' || $activeJob->status === 'queued')
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
                            
                            <div class="grid grid-cols-2 gap-4 text-sm mt-4">
                                <div class="bg-secondary/50 p-3 rounded-lg border border-border">
                                    <span class="block text-muted-foreground text-xs uppercase cursor-default mb-1">{{ __('main.records_processed') }}</span>
                                    <span class="font-semibold text-xl">{{ number_format($activeJob->processed_records ?? 0) }} / {{ number_format($activeJob->total_records ?? 0) }}</span>
                                </div>
                                <div class="bg-secondary/50 p-3 rounded-lg border border-border">
                                    <span class="block text-muted-foreground text-xs uppercase cursor-default mb-1">{{ __('main.estimated_time') }}</span>
                                    <span class="font-semibold text-xl text-primary">{{ $eta }}</span>
                                </div>
                            </div>

                            <!-- Log Scrollbar -->
                            <div class="mt-6 text-left border border-border rounded-lg bg-slate-100 dark:bg-black text-slate-800 dark:text-green-400 font-mono text-xs max-h-32 overflow-y-auto p-3 flex flex-col gap-1 smooth-scroll shadow-inner" id="import-log-container">
                                <div>> {{ __('main.import_started') ?? 'Import started...' }}</div>
                                <div>> {{ __('main.found_records') ?? 'Found total records to process:' }} {{ $activeJob->total_records }}</div>
                                @if($activeJob->processed_records > 0)
                                    <div>> {{ __('main.fetching_operations') ?? 'Fetching operations completed:' }} {{ $activeJob->processed_records }}</div>
                                    <div class="opacity-70 animate-pulse">> {{ __('main.processing_next_batch') ?? 'Processing next batch...' }}</div>
                                @endif
                                <script>
                                    // Auto-scroll to bottom
                                    var container = document.getElementById('import-log-container');
                                    if(container) {
                                        container.scrollTop = container.scrollHeight;
                                    }
                                </script>
                            </div>
                            <div class="flex justify-center mt-5 text-sm">
                                <button wire:click="cancelJob({{ $activeJob->id }})" class="kt-btn kt-btn-sm kt-btn-destructive w-full max-w-[200px] shadow-sm hover:shadow-md transition-all">
                                    <i class="ki-filled ki-cross-circle me-1.5 text-base"></i> {{ __('main.cancel_import') ?? 'Cancel Import' }}
                                </button>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center gap-3 text-secondary-foreground bg-secondary/30 p-6 rounded-lg mt-4">
                                <i class="ki-filled ki-loading animate-spin text-3xl text-primary"></i>
                                <span class="font-medium text-lg">{{ __('main.queued_waiting') }}</span>
                            </div>
                            <div class="flex justify-center mt-5 text-sm">
                                <button wire:click="cancelJob({{ $activeJob->id }})" class="kt-btn kt-btn-sm kt-btn-destructive w-full max-w-[200px] shadow-sm hover:shadow-md transition-all">
                                    <i class="ki-filled ki-cross-circle me-1.5 text-base"></i> {{ __('main.cancel_queued') ?? 'Cancel' }}
                                </button>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="bg-destructive p-4 text-center rounded-b-xl shrink-0 shadow-[inset_0_2px_10px_rgba(0,0,0,0.1)]">
                    <p class="text-white text-sm flex items-center justify-center gap-2 font-bold tracking-wide">
                        <i class="ki-filled ki-information-2 text-xl text-white"></i>
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
