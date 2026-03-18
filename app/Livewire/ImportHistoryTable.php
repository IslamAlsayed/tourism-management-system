<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ImportHistory;
use App\Models\ImportSetting;
use Illuminate\Support\Facades\Log;

class ImportHistoryTable extends Component
{
    public $modelType;
    public $history = [];
    public $lastCompletedCount = 0;
    public $activeJob = null;
    public $progressPercentage = 0;
    public $eta = '';

    protected $listeners = [
        'importHistoryUpdated' => '$refresh',
    ];

    public function mount($modelType)
    {
        $this->modelType = $modelType;
        $this->loadHistory();
        $this->lastCompletedCount = $this->getCompletedCount();
    }

    public function loadHistory()
    {
        $this->history = ImportHistory::where('model_type', $this->modelType)
            ->with('user')
            ->latest()
            ->take(10)
            ->get();
    }

    public function getCompletedCount()
    {
        return ImportHistory::where('model_type', $this->modelType)
            ->where('status', 'completed')
            ->count();
    }

    public function checkCompletion()
    {
        $currentCompletedCount = $this->getCompletedCount();

        if ($currentCompletedCount > $this->lastCompletedCount) {
             // A new import has completed since the last check!
            $this->dispatch('import-completed-confetti');
            $this->lastCompletedCount = $currentCompletedCount;
            
            $latestJob = \App\Models\ImportHistory::where('model_type', $this->modelType)
                ->where('status', 'completed')
                ->latest()
                ->first();

            $processed = $latestJob ? number_format($latestJob->processed_records) : 0;
            
            // Extract basename and convert to plural translation key (e.g., "Modules\Geography\Entities\Region" -> "regions")
            $modelClassBasename = class_basename($this->modelType);
            $translationKey = \Illuminate\Support\Str::plural(strtolower($modelClassBasename));
            $modelTranslated = __('main.' . $translationKey, [], app()->getLocale());
            if ($modelTranslated === 'main.' . $translationKey) {
                 $modelTranslated = $modelClassBasename; // Fallback if translation missing
            }
            
            // Dispatch a sweetalert modal event instead of a toast alert
            $this->dispatch('import-completed-modal', [
                 'title' => __('main.import_completed_successfully', ['count' => $processed, 'model' => $modelTranslated], app()->getLocale()) ?? 'Import completed successfully!',
                 'text' => __('main.records_processed_msg', ['count' => $processed], app()->getLocale()) ?? "Successfully processed $processed records.",
                 'icon' => 'success',
                 'confirmButtonText' => __('main.ok', [], app()->getLocale()) ?? 'OK'
            ]);
        }
    }

    public function cancelJob($id)
    {
        $job = \App\Models\ImportHistory::find($id);
        if ($job && $job->status === 'queued') {
            $job->update(['status' => 'failed', 'error_message' => __('main.canceled_by_user') ?? 'Canceled by user.']);
            
            // Also attempt to remove from the jobs table if it's there
            // Note: Since we don't store the jobs table ID directly, we might not easily delete it, 
            // but the status change in ImportHistory will skip it if the job checks the status.
            
            $this->dispatch('alert', [
                'type' => 'info',
                'message' => __('main.job_canceled') ?? 'Import job canceled.'
            ]);
            $this->loadHistory();
        }
    }

    public function processQueue()
    {
        // For environments without a running queue worker, allow manual triggering
        try {
            \Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => __('main.queue_processed') ?? 'Queue processed successfully.'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        $this->loadHistory();
    }

    public function clearHistory()
    {
        if (!auth()->user() || !auth()->user()->hasRole('superadmin')) {
            return;
        }

        $deleted = ImportHistory::where('model_type', $this->modelType)->delete();
        Log::info("Import history cleared for {$this->modelType}: {$deleted} records deleted by user " . (function_exists('getActiveUserId') ? getActiveUserId() : 'unknown'));
        
        $this->loadHistory();
        $this->lastCompletedCount = 0; // Reset
        
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => __('main.import_history_cleared', [], app()->getLocale()) ?? "Import history cleared ({$deleted} records)"
        ]);
    }

    public function render()
    {
        $this->loadHistory();
        $this->checkCompletion(); // Check for newly completed jobs on every render (poll)

        // Find the most recent active job for the overlay
        $this->activeJob = $this->history->whereIn('status', ['queued', 'processing'])->first();
        $hasActiveJobs = $this->activeJob !== null;
        
        if ($this->activeJob && $this->activeJob->status === 'processing') {
            $total = $this->activeJob->total_records ?? 0;
            $processed = $this->activeJob->processed_records ?? 0;
            
            if ($total > 0) {
                $this->progressPercentage = round(($processed / $total) * 100);
                
                // Calculate ETA
                if ($processed > 0) {
                    // A simple approximation: assuming start time was when it became 'processing'
                    // For simplicity, we just use created_at to current time to measure rate
                    $elapsedSeconds = now()->timestamp - $this->activeJob->created_at->timestamp;
                    $ratePerSecond = $processed / max($elapsedSeconds, 1);
                    $remainingRecords = $total - $processed;
                    $remainingSeconds = $ratePerSecond > 0 ? $remainingRecords / $ratePerSecond : 0;
                    
                    if ($remainingSeconds > 60) {
                        $this->eta = round($remainingSeconds / 60) . ' ' . __('main.minutes', [], app()->getLocale());
                    } else {
                        $this->eta = round($remainingSeconds) . ' ' . __('main.seconds', [], app()->getLocale());
                    }
                } else {
                    $this->eta = __('main.calculating', [], app()->getLocale()) ?? 'Calculating...';
                }
            } else {
                $this->progressPercentage = 0;
                $this->eta = __('main.calculating', [], app()->getLocale()) ?? 'Calculating...';
            }
        }

        return view('livewire.import-history-table', [
            'hasActiveJobs' => $hasActiveJobs
        ]);
    }
}
