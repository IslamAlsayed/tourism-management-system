<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Type extends Model
{
    use HasFactory, HasSearch, HasRichText, BroadcastsRecordEvents;

    protected $richTextAttributes = [
        'description',
    ];

    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class);
    }
}