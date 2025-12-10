<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class SidebarMenuOrder extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid',
        'menu_key',
        'order',
        'parent_key',
        'level',
        'is_visible',
        'custom_data',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'custom_data' => 'array',
        'order' => 'integer',
        'level' => 'integer',
    ];
}
