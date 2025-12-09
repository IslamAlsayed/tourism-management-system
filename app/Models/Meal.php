<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Meal extends Model
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
        'is_included',
        'is_active',
    ];

    protected $casts = [
        'is_included' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function mealRates()
    {
        return $this->hasMany(AccommodationMealRate::class);
    }
}