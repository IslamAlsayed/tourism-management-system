<?php

namespace Modules\Geography\Entities;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\ClearsEmptyRichText;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Modules\Geography\Entities\State;
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
        'photo',
        'is_active',
        'is_independent',
        'is_developed',
        'is_landlocked',
        'description',
        'notes',
        'state_id',
    ];

    public function getRelationshipNames()
    {
        return ['state', 'states'];
    }

    public function getExcludedColumns()
    {
        return ['state_id', 'description', 'notes'];
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
