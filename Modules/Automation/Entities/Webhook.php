<?php

namespace Modules\Automation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Webhook extends Model
{
    use HasFactory;

    protected $table = 'automation_webhooks';

    protected $fillable = [
        'name',
        'url',
        'event_type',
        'is_active',
        'secret_token',
        'headers'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'headers' => 'array',
    ];

    public function logs()
    {
        return $this->hasMany(WebhookLog::class, 'webhook_id');
    }
}
