<?php

namespace Modules\TouristSites\Entities;

use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class CustomNationality extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, ClearsEmptyRichText;
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $table = 'custom_nationalities';
    protected $fillable = [
        'seasonal_price_id',
        'nationality_id',
        'custom_name',
        'pricing_matrix',
        'notes',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'pricing_matrix' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: Belongs to SeasonalPrice
     */
    public function seasonalPrice()
    {
        return $this->belongsTo(SeasonalPrice::class);
    }

    /**
     * Relationship: Belongs to Nationality (if exists)
     */
    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }
}
