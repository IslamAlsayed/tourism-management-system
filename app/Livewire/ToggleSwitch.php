<?php

namespace App\Livewire;

use Ably\AblyRest;
use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Str;

class ToggleSwitch extends Component
{
    public $modelId;
    public $modelType;
    public $field;
    public $value;
    public $table;

    public function mount($modelId, $modelType, $field, $value, $table = null)
    {
        $this->modelId = $modelId;
        $this->modelType = $modelType;
        $this->field = $field;
        $this->value = $value;
        $this->table = $table ?? Str::plural(Str::snake(class_basename($modelType)));
    }

    public function toggleHold()
    {
        try {
            $modelClass = $this->modelType;
            if (!class_exists($modelClass)) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => __('messages.model_not_found')]);
                return;
            }

            $model = $modelClass::find($this->modelId);
            if (!$model) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => __('messages.record_not_found')]);
                return;
            }

            $newValue = !$this->value;
            $model->{$this->field} = $newValue;
            $model->save();

            $this->value = $newValue;
            if ($this->table == 'users' && $this->field == 'is_active') {
                $ably = new AblyRest(Setting::first()->app_ably_key);
                $data = ['id' => $this->modelId, 'value' => $newValue];
                $ably->channel('switch.user.active')->publish('switch.user.active', $data);
            }
            $this->dispatch('show-toast', ['type' => 'success', 'message' => __('messages.updated_successfully')]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => __('messages.error_occurred') . ': ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.toggle-switch');
    }
}