<?php

namespace Modules\TourGuides\Entities;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\State;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;
use Modules\Geography\Entities\Country;
use Modules\Localization\Entities\Currency;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class TourGuideType extends Model
{
    use HasSearch, HasUuid, HasRichText, FiltersByUserRole, BroadcastsRecordEvents, ClearsEmptyRichText;
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'type',
        'price',
        'all_states',
        'all_cities',
        'is_active',
        'description',
        'notes',
        'currency_id',
        'country_id',
    ];

    public function getRelationshipNames()
    {
        return ['currency', 'country', 'states', 'cities'];
    }

    public function getExcludedColumns()
    {
        return ['currency_id', 'country_id', 'description', 'notes'];
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function states()
    {
        return $this->belongsToMany(State::class, 'tour_guide_type_state');
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'tour_guide_type_city');
    }
}
