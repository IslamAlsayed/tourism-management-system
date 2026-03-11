<?php

namespace Modules\Automation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebhookLog extends Model
{
    use HasFactory;

    protected $table = 'automation_webhook_logs';

    protected $fillable = [
        'webhook_id',
        'payload',
        'response_status',
        'response_body',
        'error'
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function webhook()
    {
        return $this->belongsTo(Webhook::class, 'webhook_id');
    }
}
