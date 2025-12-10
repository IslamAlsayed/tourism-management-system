<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasSearch, HasUuid, BroadcastsRecordEvents;

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'code',
    ];
}