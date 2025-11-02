<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait HandlesCrudSafely
{
    /**
     * Run a callback safely and handle exceptions gracefully.
     */
    public function safeRun(callable $callback)
    {
        try {
            return $callback();
        } catch (\Throwable $e) {
            Log::error('Livewire SafeRun Error: ' . $e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine()]);
            // session()->flash('danger', __('main.messages.general_error') . ' | ' . $e->getMessage() ?? 'Something went wrong, please try again later.');
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Something went wrong, please try again later.', 'title' => 'Error', 'emoji' => '❌']);
        }
    }

    /**
     * Generic delete method — delete any model dynamically and handle all errors.
     */
    public function safeDestroy($id, $type, $showToast = true)
    {
        return $this->safeRun(function () use ($id, $type, $showToast) {
            $modelName = ucfirst($type);
            $modelClass = "App\\Models\\$modelName";
            if (!class_exists($modelClass)) {
                throw new \Exception("Model class $modelClass does not exist");
            }
            $model = $modelClass::find($id);
            $parts = preg_split('/(?=[A-Z])/', $type, -1, PREG_SPLIT_NO_EMPTY);
            $type = strtolower(implode('-', $parts));

            if (!$model) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Tour guide not found.', 'title' => 'Error', 'emoji' => '❌']);
            } elseif ($model->delete()) {
                if ($showToast) {
                    $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Tour guide deleted successfully!', 'title' => 'Deleted', 'emoji' => '🎯']);
                }
            } else {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Tour guide not found.', 'title' => 'Error', 'emoji' => '❌']);
            }
        });
    }
}