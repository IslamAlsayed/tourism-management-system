<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasSearch, BroadcastsRecordEvents;

    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'code',
    ];
}