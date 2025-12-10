<?php

namespace App\Models;

use App\Models\User;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Support\Facades\Auth;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasSearch, HasUuid, HasFactory, BroadcastsRecordEvents;

    // Notification type constants
    public const TYPE_BOOKING = 'booking';
    public const TYPE_PAYMENT = 'payment';
    public const TYPE_TRIP = 'trip';
    public const TYPE_SYSTEM = 'system';
    public const TYPE_PUSH = 'push';

    protected $fillable = [
        'id',
        'uuid',
        'performer_id',
        'target_user_id',
        'type',
        'title',
        'message',
        'is_read',
        'is_global',
        'read_at',
        'notification_type',
        'user_id',
        'recipient_user_id',
        'data',
    ];

    /**
     * Scope for notification type
     */
    public function scopeOfNotificationType($query, $type)
    {
        return $query->where('notification_type', $type);
    }

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'data' => 'array',
    ];

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return ['type', 'title', 'data'];
    }


    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-set user_id if user is authenticated
        static::creating(function ($notification) {
            if (Auth::check() && !$notification->user_id) {
                $notification->user_id = getActiveUser()?->id;
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

    public function recipientUser()
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performer_id');
    }

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function getHumanReadAtAttribute()
    {
        return $this->read_at ? \Carbon\Carbon::parse($this->read_at)->diffForHumans() : null;
    }

    public function getHumanCreatedAtAttribute()
    {
        return $this->created_at ? \Carbon\Carbon::parse($this->created_at)->diffForHumans() : null;
    }

    /**
     * Scopes
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false)->orWhereNull('read_at');
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true)->whereNotNull('read_at');
    }

    public function scopeTargetMe($query, $userId)
    {
        return $query->where('target_user_id', $userId);
    }

    public function scopeWithMe($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeNotMe($query, $userId)
    {
        return $query->where('user_id', '!=', $userId);
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
        $this->update(['is_read' => 1, 'read_at' => now()]);
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
            'performer_id' => Auth::id(),
            'target_user_id' => $userId ?? Auth::id(),
            'type' => $type,
            'notification_type' => 'system',
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
        $users = User::pluck('id');

        foreach ($users as $userId) {
            static::create([
                'performer_id' => Auth::id(),
                'target_user_id' => $userId,
                'type' => $type,
                'notification_type' => 'system',
                'title' => $title,
                'message' => $message,
                'data' => $data,
            ]);
        }
    }

    /**
     * Create push notification (web push or custom)
     */
    public static function createPushNotification($message, $title = null, $data = null, $userId = null, $recipientUserId = null, $isGlobal = false)
    {
        return static::create([
            'performer_id' => Auth::id(),
            'target_user_id' => $recipientUserId,
            'type' => 'push',
            'notification_type' => 'push',
            'title' => $title,
            'message' => $message,
            'is_global' => $isGlobal,
            'data' => $data,
        ]);
    }
}