<?php

namespace Modules\Automation\Livewire;

use Livewire\Component;
use Modules\Automation\Entities\Webhook;
use Modules\Automation\Entities\WebhookLog;

class WebhookSettings extends Component
{
    public $webhooks;
    public $logs;
    
    public $name, $url, $event_type = '*', $secret_token;
    public $editingWebhookId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'url' => 'required|url',
        'event_type' => 'required|string',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->webhooks = Webhook::latest()->get();
        $this->logs = WebhookLog::with('webhook')->latest()->take(20)->get();
    }

    public function save()
    {
        $this->validate();

        if ($this->editingWebhookId) {
            $webhook = Webhook::find($this->editingWebhookId);
            $webhook->update([
                'name' => $this->name,
                'url' => $this->url,
                'event_type' => $this->event_type,
                'secret_token' => $this->secret_token,
            ]);
        } else {
            Webhook::create([
                'name' => $this->name,
                'url' => $this->url,
                'event_type' => $this->event_type,
                'secret_token' => $this->secret_token,
            ]);
        }

        $this->resetForm();
        $this->loadData();
        session()->flash('success', 'Webhook saved successfully.');
    }

    public function edit($id)
    {
        $webhook = Webhook::find($id);
        $this->editingWebhookId = $id;
        $this->name = $webhook->name;
        $this->url = $webhook->url;
        $this->event_type = $webhook->event_type;
        $this->secret_token = $webhook->secret_token;
    }

    public function toggleStatus($id)
    {
        $webhook = Webhook::find($id);
        $webhook->update(['is_active' => !$webhook->is_active]);
        $this->loadData();
    }

    public function delete($id)
    {
        Webhook::find($id)->delete();
        $this->loadData();
    }

    public function resetForm()
    {
        $this->editingWebhookId = null;
        $this->name = '';
        $this->url = '';
        $this->event_type = '*';
        $this->secret_token = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('automation::livewire.webhook-settings');
    }
}
