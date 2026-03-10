<?php

namespace Modules\TouristSites\Entities;

use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Geography\Entities\Nationality;

class TouristSiteEntryFee extends Model
{
    use HasFactory, HasSearch, HasUuid;

    protected $table = 'tourist_site_entry_fees';

    protected $fillable = [
        'tourist_site_id',
        'nationality_id',
        'adult_price',
        'child_price',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'adult_price' => 'decimal:2',
        'child_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: Belongs to TouristSite
     */
    public function touristSite()
    {
        return $this->belongsTo(TouristSite::class);
    }

    /**
     * Relationship: Belongs to Nationality
     */
    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }
}
