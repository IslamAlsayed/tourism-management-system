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
            Log::error('Livewire SafeRun Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            session()->flash('danger', __('main.messages.general_error') ?? 'Something went wrong, please try again later.');
        }
    }

    /**
     * Generic delete method — delete any model dynamically and handle all errors.
     */
    public function safeDestroy($id, $type)
    {
        $this->safeRun(function () use ($id, $type) {
            $modelName = ucfirst($type);
            $modelClass = "App\\Models\\$modelName";

            if (!class_exists($modelClass)) {
                throw new \Exception("Model class $modelClass does not exist");
            }

            $model = $modelClass::find($id);

            if (!$model) {
                session()->flash('danger', __('main.messages.not_found_this_type', ['type' => __('main.' . $type)]));
                return;
            }

            if ($model->delete()) {
                // $this->resetPage();
                session()->flash('success', __('main.messages.type_deleted', ['type' => __('main.' . $type)]));
            } else {
                session()->flash('danger', __('main.messages.type_deletion_failed', ['type' => __('main.' . $type)]));
            }
        });
    }
}