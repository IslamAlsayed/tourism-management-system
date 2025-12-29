<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class City extends Model
{
    use HasSearch, HasRichText, HasUuid, BroadcastsRecordEvents;

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

    public function getRelationshipNames()
    {
        return ['timezone', 'region', 'subregion', 'country', 'state'];
    }

    public function getExcludedColumns()
    {
        return ['timezone_id', 'region_id', 'subregion_id', 'country_id', 'state_id'];
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

    public function states()
    {
        return $this->belongsToMany(State::class, 'city_state');
    }
}