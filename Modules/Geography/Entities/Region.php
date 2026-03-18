<?php

namespace Modules\Geography\Entities;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\ClearsEmptyRichText;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Region extends Model
{
    use BroadcastsRecordEvents, ClearsEmptyRichText, FiltersByUserRole, HasRichText, HasSearch, HasUuid, SoftDeletes;

    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'wiki_data_id',
        'is_active',
        'description',
        'notes',
    ];

    public function getRelationshipNames()
    {
        return ['subregions', 'countries', 'accommodations', 'restaurants', 'transportationCompanies'];
    }

    public function getExcludedColumns()
    {
        return ['description', 'notes'];
    }

    public function subregions()
    {
        return $this->hasMany(Subregion::class);
    }

    public function countries()
    {
        return $this->hasMany(Country::class);
    }

    public function states()
    {
        return $this->hasManyThrough(State::class, Country::class);
    }

    /**
     * Cities accessible via states.country chain.
     * NOTE: Not a standard Eloquent relation - do NOT include in getRelationshipNames()
     */
    public function cities()
    {
        return City::whereHas('state', function ($q) {
            $q->whereHas('country', function ($q2) {
                $q2->where('region_id', $this->id);
            });
        });
    }

    public function accommodations()
    {
        return $this->hasManyThrough(\Modules\Accommodations\Entities\Accommodation::class, Country::class);
    }

    public function restaurants()
    {
        return $this->hasManyThrough(\Modules\Restaurants\Entities\Restaurant::class, Country::class);
    }

    public function transportationCompanies()
    {
        return $this->hasManyThrough(\Modules\Transportation\Entities\Company::class, Country::class);
    }
}
