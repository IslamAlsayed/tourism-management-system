<?php

namespace Modules\Geography\Entities;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Subregion extends Model
{
    use HasSearch, HasUuid, HasRichText, FiltersByUserRole, SoftDeletes;
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
        'region_id',
    ];

    public function getRelationshipNames()
    {
        // Only include proper Eloquent relationships (not multi-level through queries)
        return ['region', 'countries', 'states'];
    }

    public function getExcludedColumns()
    {
        return ['region_id', 'description', 'notes'];
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
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
                $q2->where('subregion_id', $this->id);
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
