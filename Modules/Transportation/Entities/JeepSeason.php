<?php

namespace Modules\Transportation\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class JeepSeason extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'uuid',
        'jeep_id',
        'name',
        'start_date',
        'end_date',
        'price_local',
        'price_arab',
        'price_foreigner'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price_local' => 'float',
        'price_arab' => 'float',
        'price_foreigner' => 'float',
    ];

    public function jeep()
    {
        return $this->belongsTo(Jeep::class);
    }

    public function nationalityPrices()
    {
        return $this->hasMany(JeepSeasonNationalityPrice::class, 'jeep_season_id');
    }
}
