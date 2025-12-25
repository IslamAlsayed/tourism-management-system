<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class DeleteBottom extends Component
{
    public $type;
    public $modelId;
    public $modelType;
    public $table;

    public function mount($type, $modelId, $modelType, $table = null)
    {
        $this->type = $type;
        $this->modelId = $modelId;
        $this->modelType = $modelType;
        $this->table = $table ?? Str::plural(Str::snake(class_basename($modelType)));
    }

    public function deleteBottom()
    {
        // dd($this->type, $this->modelId, $this->modelType, $this->table);
        try {
            $modelClass = $this->modelType;
            if (!class_exists($modelClass)) {
                dd("here");
                $this->dispatch('show-toast', ['type' => 'error', 'message' => __('messages.model_not_found')]);
                return;
            }

            $model = $modelClass::find($this->modelId);
            if (!$model) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => __('messages.record_not_found')]);
                return;
            }

            // $deleted = $model->delete();
            $deleted = true;
            if ($deleted) {
                $this->dispatch('record-deleted', id: $model->id, type: $this->type);
                $this->dispatch('show-toast', ['type' => 'success', 'message' => __('messages.type_deleted', ['type' => __('main.' . $this->type) . ' ' . $model->id])]);
                // return redirect()->route(Str::snake($this->type) . '.index');
            } else {
                $this->dispatch('show-toast', ['type' => 'success', 'message' => __('messages.type_deletion_failed', ['type' => __('main.' . $this->type)])]);
            }
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => __('messages.error_occurred') . ': ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.delete-bottom');
    }
}