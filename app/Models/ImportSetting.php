<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportSetting extends Model
{
    protected $fillable = [
        'model_type',
        'google_drive_url',
        'last_import_count',
        'last_imported_at',
    ];

    protected $casts = [
        'last_imported_at' => 'datetime',
    ];
}
