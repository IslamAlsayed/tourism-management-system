<?php

namespace Modules\Transportation\Entities;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use Modules\Geography\Entities\City;
use Illuminate\Database\Eloquent\Model;
use Modules\Transportation\Entities\RouteAssignment;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, ClearsEmptyRichText;
    protected $table = 'transportations_routes';
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'code',
        'origin_address',
        'origin_latitude',
        'origin_longitude',
        'destination_address',
        'destination_latitude',
        'destination_longitude',
        'distance',
        'estimated_duration',
        'route_type',
        'waypoints',
        'is_active',
        'is_toll_road',
        'toll_fee',
        'road_condition',
        'description',
        'notes',

        'origin_city_id',
        'destination_city_id',
    ];

    protected $casts = [
        'origin_latitude' => 'decimal:7',
        'origin_longitude' => 'decimal:7',
        'destination_latitude' => 'decimal:7',
        'destination_longitude' => 'decimal:7',
        'distance' => 'decimal:2',
        'toll_fee' => 'decimal:2',
        'is_active' => 'boolean',
        'is_toll_road' => 'boolean',
        'waypoints' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($item) {
            // Auto-fill code
            if (empty($item->code)) {
                $item->code = generateCode('TR-', 5);
            }
        });
    }

    public function getRelationshipNames()
    {
        return ['originCity', 'destinationCity', 'assignments'];
    }

    public function getExcludedColumns()
    {
        return ['origin_city_id', 'destination_city_id', 'description', 'notes', 'waypoints'];
    }

    // Origin City
    public function originCity()
    {
        return $this->belongsTo(City::class, 'origin_city_id');
    }

    // Destination City
    public function destinationCity()
    {
        return $this->belongsTo(City::class, 'destination_city_id');
    }

    // Route Assignments (many routes can be assigned to many companies)
    public function assignments()
    {
        return $this->hasMany(RouteAssignment::class, 'route_id');
    }

    // Active routes scope
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Route type scopes
    public function scopeOneWay($query)
    {
        return $query->where('route_type', 'one_way');
    }

    public function scopeRoundTrip($query)
    {
        return $query->where('route_type', 'round_trip');
    }

    public function scopeMultiStop($query)
    {
        return $query->where('route_type', 'multi_stop');
    }

    // Toll roads
    public function scopeTollRoads($query)
    {
        return $query->where('is_toll_road', true);
    }

    // Get formatted distance
    public function getFormattedDistanceAttribute()
    {
        return $this->distance ? $this->distance . ' km' : 'N/A';
    }

    // Get formatted duration
    public function getFormattedDurationAttribute()
    {
        if (!$this->estimated_duration) {
            return 'N/A';
        }

        $hours = floor($this->estimated_duration / 60);
        $minutes = $this->estimated_duration % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours}h {$minutes}m";
        } elseif ($hours > 0) {
            return "{$hours}h";
        } else {
            return "{$minutes}m";
        }
    }

    // Get number of companies operating on this route
    public function getCompaniesCountAttribute()
    {
        return $this->assignments()->distinct('company_id')->count('company_id');
    }

    // Get companies operating on this route
    public function getAvailableCompaniesAttribute()
    {
        return $this->assignments()
            ->with('company')
            ->where('is_active', true)
            ->get()
            ->pluck('company')
            ->unique('id');
    }

    // Get price range for this route
    public function getPriceRangeAttribute()
    {
        $prices = $this->assignments()
            ->where('is_active', true)
            ->whereNotNull('base_price')
            ->pluck('base_price');

        if ($prices->isEmpty()) {
            return 'N/A';
        }

        $min = $prices->min();
        $max = $prices->max();

        if ($min == $max) {
            return number_format($min, 2);
        }

        return number_format($min, 2) . ' - ' . number_format($max, 2);
    }

    // Get active assignments count
    public function getActiveAssignmentsCountAttribute()
    {
        return $this->assignments()->where('is_active', true)->count();
    }
}
