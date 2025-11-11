<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'is_read',
        'read_at',
        'data',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'data' => 'array',
    ];

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-set user_id if user is authenticated
        static::creating(function ($notification) {
            if (Auth::check() && !$notification->user_id) {
                $notification->user_id = Auth::id();
            }
        });
    }

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scopes
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true, 'read_at' => now()]);
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * Create notification for authenticated user
     */
    public static function createForUser($type, $message, $title = null, $data = null, $userId = null)
    {
        return static::create([
            'user_id' => $userId ?? Auth::id(),
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * Create notification for all users
     */
    public static function createForAllUsers($type, $message, $title = null, $data = null)
    {
        $users = \App\Models\User::pluck('id');

        foreach ($users as $userId) {
            static::create([
                'user_id' => $userId,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'data' => $data,
            ]);
        }
    }

    /**
     * Get icon based on type
     */
    public function getIconAttribute()
    {
        return match ($this->type) {
            'success' => 'fas fa-check-circle',
            'error' => 'fas fa-times-circle',
            'warning' => 'fas fa-exclamation-triangle',
            'info' => 'fas fa-info-circle',
            default => 'fas fa-bell',
        };
    }

    /**
     * Get color class based on type
     */
    public function getColorClassAttribute()
    {
        return match ($this->type) {
            'success' => 'text-green-500',
            'error' => 'text-red-500',
            'warning' => 'text-yellow-500',
            'info' => 'text-blue-500',
            default => 'text-gray-500',
        };
    }
}