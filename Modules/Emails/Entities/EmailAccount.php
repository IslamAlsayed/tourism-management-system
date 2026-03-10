<?php

namespace Modules\Emails\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'provider',
        'smtp_host',
        'smtp_port',
        'smtp_user',
        'smtp_pass',
        'smtp_encryption',
        'incoming_host',
        'incoming_port',
        'incoming_user',
        'incoming_pass',
        'incoming_encryption',
        'incoming_protocol',
        'is_active',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Emails\Database\factories\EmailAccountFactory::new();
    }
}
