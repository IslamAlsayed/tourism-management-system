<?php

namespace App\Livewire;

use Ably\AblyRest;
use Modules\Core\Entities\Setting;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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

    /**
     * Blacklist of sensitive fields that must NEVER be toggled.
     * Using blacklist instead of whitelist because this component
     * is used with 68+ different boolean fields across the project.
     */
    protected array $blockedFields = [
        'is_admin',
        'is_super_admin',
        'is_superadmin',
        'password',
        'email',
        'email_verified_at',
        'remember_token',
        'role',
        'role_id',
        'permissions',
    ];

    /**
     * Allowed model namespaces — only models from these namespaces can be toggled.
     */
    protected array $allowedNamespaces = [
        'App\\Models\\',
        'Modules\\',
    ];

    public function toggleHold()
    {
        try {
            // Security: Block dangerous fields
            if (in_array($this->field, $this->blockedFields, true)) {
                Log::warning('ToggleSwitch: Blocked attempt to toggle sensitive field', [
                    'field' => $this->field,
                    'model' => $this->modelType,
                    'model_id' => $this->modelId,
                    'user_id' => getActiveUserId(),
                ]);
                $this->dispatch('show-toast', [
                    'type' => 'error',
                    'message' => __('messages.field_not_allowed', ['field' => $this->field]),
                ]);
                return;
            }

            // Security: Only allow models from trusted namespaces
            $modelClass = $this->modelType;
            $isAllowedNamespace = false;
            foreach ($this->allowedNamespaces as $ns) {
                if (str_starts_with($modelClass, $ns)) {
                    $isAllowedNamespace = true;
                    break;
                }
            }
            if (!$isAllowedNamespace || !class_exists($modelClass)) {
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

            // Only push to Ably if configured and user.is_active toggle
            if ($this->table == 'users' && $this->field == 'is_active') {
                try {
                    $ablyKey = optional(\Modules\Core\Entities\Setting::first())->app_ably_key;
                    if (!empty($ablyKey)) {
                        $ably = new AblyRest($ablyKey);
                        $data = ['id' => $this->modelId, 'value' => $newValue];
                        $ably->channel('switch.user.active')->publish('switch.user.active', $data);
                    }
                } catch (\Exception $ablyEx) {
                    // Ably not configured or failed - ignore silently
                }
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
