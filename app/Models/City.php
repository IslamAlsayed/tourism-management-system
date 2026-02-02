<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\ClearsEmptyRichText;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class City extends Model
{
    use HasSearch, HasRichText, HasUuid, BroadcastsRecordEvents, ClearsEmptyRichText;
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
        'country_id',
        'state_id',
    ];

    public function getRelationshipNames()
    {
        return ['timezone', 'country', 'state', 'states'];
    }

    public function getExcludedColumns()
    {
        return ['timezone_id', 'country_id', 'state_id', 'description', 'notes'];
    }

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
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
