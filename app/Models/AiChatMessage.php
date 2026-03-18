<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiChatMessage extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'role',
        'content',
    ];

    /**
     * Get the user that owns the chat message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
