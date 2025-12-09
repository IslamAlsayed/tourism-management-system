<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class AccommodationType extends Model
{
    use HasFactory, HasSearch, HasRichText, BroadcastsRecordEvents;

    protected $richTextAttributes = [
        'notes',
    ];

    protected $fillable = [
        'id',
        'accommodation_id',
        'type_id',
        'notes',
    ];

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class);
    }
}