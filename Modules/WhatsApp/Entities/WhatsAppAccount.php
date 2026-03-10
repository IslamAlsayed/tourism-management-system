<?php

namespace Modules\WhatsApp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WhatsAppAccount extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_accounts';

    protected $fillable = [
        'name',
        'instance_id',
        'access_token',
        'status',
        'is_active',
    ];
    
    protected static function newFactory()
    {
        return \Modules\WhatsApp\Database\factories\WhatsAppAccountFactory::new();
    }
}
