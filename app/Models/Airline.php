<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\ClearsEmptyRichText;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Modules\Geography\Entities\Country;
use Modules\Geography\Entities\State;
use Modules\Geography\Entities\City;
use Modules\Localization\Entities\Timezone;

class Airline extends Model
{
    use HasFactory, HasSearch, HasRichText, HasUuid, BroadcastsRecordEvents, ClearsEmptyRichText;
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'iata_code',
        'icao_code',
        'parent_airline_icao_code',
        'marketing_name',
        'official_full_name',
        'alliance',
        'frequent_flyer_program_name',
        'airline_type',
        'airline_type_code',
        'is_lowcost',
        'airline_home_country',
        'airline_home_country_alpha_2_code',
        'airline_home_country_alpha_3_code',
        'airline_home_city_iata_code',
        'year_of_foundation',
        'email',
        'official_website',
        'baggage_policy_url',
        'web_check_in_url',
        'local_phone_number',
        'international_phone_number',
        'is_active',
        'description',
        'notes',

        'timezone_id',
        'country_id',
        'state_id',
        'city_id',
    ];

    protected $casts = [
        'is_lowcost' => 'boolean',
        'is_active' => 'boolean',
        'year_of_foundation' => 'integer',
    ];

    public function getRelationshipNames()
    {
        return ['timezone', 'country', 'state', 'city'];
    }

    public function getExcludedColumns()
    {
        return [
            'timezone_id',
            'country_id',
            'state_id',
            'city_id',
            'description',
            'notes',
            'official_website',
            'baggage_policy_url',
            'web_check_in_url',
            'parent_airline_icao_code'
        ];
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
    }

    /**
     * Get display name (localized)
     */
    public function getDisplayNameAttribute()
    {
        return app()->getLocale() === 'ar' && $this->name_ar ? $this->name_ar : $this->name;
    }

    /**
     * Get full location string
     */
    public function getFullLocationAttribute()
    {
        $location = [];

        if ($this->city)
            $location[] = $this->city?->display_name;
        if ($this->state)
            $location[] = $this->state?->display_name;
        if ($this->country)
            $location[] = $this->country?->display_name;

        return implode(', ', $location);
    }

    /**
     * Get coordinates as string
     */
    public function getCoordinatesAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return $this->latitude . ', ' . $this->longitude;
        }
        return null;
    }
}
