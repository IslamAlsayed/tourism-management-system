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
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Something went wrong, please try again later.', 'title' => 'Error', 'emoji' => '❌']);
        }
    }

    /**
     * Generic delete method — delete any model dynamically and handle all errors.
     */
    public function safeDestroy($id, $modelClass, $type, $showToast = true)
    {
        return $this->safeRun(function () use ($id, $modelClass, $type, $showToast) {
            // $modelClass = "App\\Models\\" . studlyCaseName($type);
            if (!class_exists($modelClass)) {
                throw new \Exception("Model class $modelClass does not exist");
            }
            $model = $modelClass::find($id);
            // $parts = preg_split('/(?=[A-Z])/', $type, -1, PREG_SPLIT_NO_EMPTY);
            // $type = strtolower(implode('-', $parts));

            if (!$model) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => __('messages.type_not_found', ['type' => __('main.' . singularLowerCaseName($type, '-'))]), 'title' => __('main.error'), 'emoji' => '❌']);
            } elseif ($model->delete()) {
                if ($showToast) {
                    $this->dispatch('show-toast', ['type' => 'success', 'message' => __('messages.type_deleted', ['type' => __('main.' . singularLowerCaseName($type, '-'))])]);
                }
            } else {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => __('messages.type_not_found', ['type' => __('main.' . singularLowerCaseName($type, '-'))]), 'title' => __('main.error'), 'emoji' => '❌']);
            }
        });
    }
}