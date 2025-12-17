<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\FiltersByUserRole;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplement extends Model
{
    use HasFactory, HasUuid, FiltersByUserRole, BroadcastsRecordEvents;

    protected $fillable = [
        'uuid',
        'name',
        'name_ar',
        'description',
        'description_ar',
        'category',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the user who created this supplement
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this supplement
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}