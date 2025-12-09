<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccommodationNationalityRate extends Model
{
    use HasRichText;

    protected $richTextAttributes = [
        'notes',
    ];

    protected $fillable = [
        'id',
        'accommodation_id',
        'season_id',
        'nationality_id',
        'price_modifier',
        'percentage_discount',
        'currency',
        'notes',
    ];

    protected $casts = [
        'price_modifier' => 'decimal:2',
        'percentage_discount' => 'decimal:2',
    ];

    public function accommodation(): BelongsTo
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class);
    }
}