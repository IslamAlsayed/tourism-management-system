<?php

namespace Modules\Restaurants\Entities;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\HasCustomFields;
use App\Traits\ClearsEmptyRichText;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;
use Modules\Localization\Entities\Currency;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantMeal extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, BroadcastsRecordEvents, ClearsEmptyRichText, HasCustomFields;

    protected $table = 'restaurant_meals';

    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'type',
        'price',
        'fit_price_adult',
        'fit_price_child_6_11',
        'fit_price_child_under_6',
        'group_price_adult',
        'group_price_child_6_11',
        'group_price_child_under_6',
        'min_group_size',
        'is_included',
        'is_supplement',
        'is_active',
        'description',
        'notes',
        'restaurant_id',
        'currency_id',
        'season_id',
    ];

    protected $casts = [
        'is_included' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getRelationshipNames()
    {
        return ['restaurant', 'currency'];
    }

    public function getExcludedColumns()
    {
        return ['restaurant_id', 'currency_id', 'description', 'notes'];
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
