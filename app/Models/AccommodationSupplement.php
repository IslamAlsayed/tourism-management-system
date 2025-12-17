<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccommodationSupplement extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, BroadcastsRecordEvents;

    protected $richTextAttributes = [
        'notes',
    ];

    protected $fillable = [
        'uuid',
        'accommodation_id',
        'supplement_id',
        'name',
        'name_ar',
        'price',
        'price_type',
        'currency_id',
        'applicable_date',
        'is_mandatory',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_mandatory' => 'boolean',
        'price_type' => 'boolean',
        'is_active' => 'boolean',
        'applicable_date' => 'date',
    ];

    /**
     * Get relationship names for eager loading
     */
    public function getRelationshipNames()
    {
        return ['accommodation_id', 'supplement_id', 'currency_id'];
    }

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return ['accommodation_id', 'supplement_id', 'currency_id'];
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function supplement()
    {
        return $this->belongsTo(Supplement::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}