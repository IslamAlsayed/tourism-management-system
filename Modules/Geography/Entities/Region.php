<?php

namespace Modules\Geography\Entities;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\ClearsEmptyRichText;
use App\Traits\FiltersByUserRole;
use App\Traits\HasUuid;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Region extends Model
{
    use HasSearch, HasUuid, HasRichText, FiltersByUserRole, BroadcastsRecordEvents, ClearsEmptyRichText, SoftDeletes;

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

    public function cities()
    {
        return $this->hasManyThrough(City::class, Country::class);
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

