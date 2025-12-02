<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ImportDataJob;

class ImportManager extends Component
{
    use WithFileUploads;

    public $file;
    public $status = '';
    public $lastMessage = null;

    protected $listeners = [
        'importNotification' => 'handleImportNotification'
    ];

    public function render()
    {
        return view('livewire.import-manager');
    }

    public function startImport()
    {
        $this->validate([
            'file' => 'required|file|max:10240', // 10MB
        ]);

        // store file to storage/app/public/excels on the `public` disk
        $filename = Str::random(12) . '_' . $this->file->getClientOriginalName();
        $relative = $this->file->storeAs('excels', $filename, 'public');

        $this->status = __('main.import_queued', [], 'ar');

        // dispatch job (async) with current user id
        $userId = auth()->id() ?? null;
        // full path the worker can read
        $fullPath = storage_path('app/public/' . $relative);
        ImportDataJob::dispatch('\App\\Models\\User', $fullPath, 1000, $userId);

        // emit immediate local notification so UI updates quickly
        $this->lastMessage = __('main.import_queued', [], 'ar');
        $this->dispatchBrowserEvent('import-started', ['message' => $this->lastMessage]);
    }

    public function handleImportNotification($payload)
    {
        // payload expected to be array with ['message' => ..., 'type' => 'success']
        $this->lastMessage = $payload['message'] ?? json_encode($payload);
        $this->status = $this->lastMessage;
        // optionally emit a browser event for JS to show a toast
        $this->dispatchBrowserEvent('import-completed-js', ['message' => $this->lastMessage, 'type' => $payload['type'] ?? 'success']);
    }
}