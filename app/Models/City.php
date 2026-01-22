<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\HandlesRichTextAttributes;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class City extends Model
{
    use HasSearch, HasRichText, HasUuid, BroadcastsRecordEvents, HandlesRichTextAttributes;
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'latitude',
        'longitude',
        'wiki_data_id',
        'population',
        'all_states',
        'is_active',
        'is_independent',
        'is_developed',
        'is_landlocked',
        'description',
        'notes',
        'timezone_id',
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($item) {
            // Auto-fill region_id and subregion_id from country
            if (empty($item->region_id) && !empty($item->country_id)) {
                $item->region_id = $item->country?->region_id;
            }
            if (empty($item->subregion_id) && !empty($item->country_id)) {
                $item->subregion_id = $item->country?->subregion_id;
            }
        });

        static::updating(function ($item) {
            // Auto-fill region_id and subregion_id from country on update too
            if (empty($item->region_id) && !empty($item->country_id)) {
                $item->region_id = $item->country?->region_id;
            }
            if (empty($item->subregion_id) && !empty($item->country_id)) {
                $item->subregion_id = $item->country?->subregion_id;
            }
        });
    }

    public function getRelationshipNames()
    {
        return ['timezone', 'region', 'subregion', 'country', 'state', 'states'];
    }

    public function getExcludedColumns()
    {
        return ['timezone_id', 'region_id', 'subregion_id', 'country_id', 'state_id', 'description', 'notes'];
    }

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function subregion()
    {
        return $this->belongsTo(Subregion::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function states()
    {
        return $this->belongsToMany(State::class, 'city_state');
    }
}
