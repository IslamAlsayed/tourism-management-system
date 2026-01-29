<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

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
