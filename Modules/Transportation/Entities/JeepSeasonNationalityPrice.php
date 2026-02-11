<?php

namespace Modules\Transportation\Entities;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Modules\Geography\Entities\Nationality;
use Modules\Transportation\Entities\JeepSeason;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JeepSeasonNationalityPrice extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'uuid',
        'jeep_season_id',
        'nationality_id',
        'price',
        'price_type'
    ];

    protected $casts = [
        'price' => 'float',
    ];

    public function season()
    {
        return $this->belongsTo(JeepSeason::class, 'jeep_season_id');
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }
}
