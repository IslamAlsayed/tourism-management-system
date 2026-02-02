<?php

namespace App\Models;

use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatingSchedule extends Model
{
    use HasFactory, HasSearch, HasUuid, FiltersByUserRole, ClearsEmptyRichText;

    protected $table = 'operating_schedules';
    protected $fillable = [
        'tourist_service_id',
        'day_name',
        'opening_time',
        'closing_time',
        'is_closed',
        'special_notes',
    ];

    protected $casts = [
        'is_closed' => 'boolean',
    ];

    /**
     * Relationship: Belongs to TouristService
     */
    public function touristService()
    {
        return $this->belongsTo(TouristService::class);
    }
}
