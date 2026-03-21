<?php

namespace Modules\TranslationManager\Entities;

use Modules\Core\Entities\User;
use Illuminate\Database\Eloquent\Model;

class TranslationSuggestion extends Model
{
    protected $fillable = [
        'user_id',
        'locale',
        'file',
        'key',
        'current_value',
        'suggested_value',
        'reason',
        'status',
        'reviewed_by',
        'reviewed_at',
        'review_note',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
