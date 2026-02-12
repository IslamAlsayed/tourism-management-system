<?php

namespace Modules\Transportation\Entities;

use App\Traits\ClearsEmptyRichText;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Localization\Entities\Currency;
use Modules\Transportation\Entities\Company;
use Modules\Transportation\Entities\Route;
use Modules\Transportation\Entities\VehicleType;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class RouteAssignment extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, ClearsEmptyRichText;

    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'base_price',
        'price_per_km',
        'price_per_person',
        'available_days',
        'departure_time',
        'arrival_time',
        'frequency_per_day',
        'is_active',
        'valid_from',
        'valid_to',
        'description',
        'notes',

        'route_id',
        'company_id',
        'vehicle_type_id',
        'currency_id',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'price_per_km' => 'decimal:2',
        'price_per_person' => 'decimal:2',
        'is_active' => 'boolean',
        'available_days' => 'array',
        'valid_from' => 'date',
        'valid_to' => 'date',
    ];

    public function getRelationshipNames()
    {
        return ['route', 'company', 'vehicleType', 'currency'];
    }

    public function getExcludedColumns()
    {
        return ['route_id', 'company_id', 'vehicle_type_id', 'currency_id', 'description', 'notes'];
    }

    // Route
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    // Company
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Vehicle Type
    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    // Currency
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function getAvailableDaysAttribute()
    {
        return $this->attributes['available_days'] ? json_decode($this->attributes['available_days'], true) : [];
    }

    public function getAvailableDaysNamesAttribute()
    {
        if (!$this->available_days || !is_array($this->available_days)) {
            return [];
        }
        return array_map(function ($day) {
            return config('helpers.daysMap.' . $day) ?? '--';
        }, $this->available_days);
    }

    // Active assignments scope
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Valid assignments (within date range)
    public function scopeValid($query)
    {
        $today = now()->toDateString();
        return $query->where(function ($q) use ($today) {
            $q->whereNull('valid_from')
                ->orWhere('valid_from', '<=', $today);
        })->where(function ($q) use ($today) {
            $q->whereNull('valid_to')
                ->orWhere('valid_to', '>=', $today);
        });
    }

    // Available on specific day
    public function scopeAvailableOnDay($query, $dayOfWeek)
    {
        return $query->whereRaw("JSON_CONTAINS(available_days, '$dayOfWeek')");
    }

    // Check if available on a specific day
    public function isAvailableOnDay($dayOfWeek)
    {
        if (!$this->available_days) {
            return false;
        }
        return in_array($dayOfWeek, $this->available_days);
    }

    // Check if currently valid
    public function isCurrentlyValid()
    {
        $today = now();

        $validFrom = $this->valid_from ? $today->greaterThanOrEqualTo($this->valid_from) : true;
        $validTo = $this->valid_to ? $today->lessThanOrEqualTo($this->valid_to) : true;

        return $validFrom && $validTo;
    }

    // Get total price based on distance
    public function getTotalPriceByDistance($distance = null)
    {
        if (!$distance && $this->route) {
            $distance = $this->route->distance;
        }

        if ($this->base_price) {
            return $this->base_price;
        }

        if ($this->price_per_km && $distance) {
            return $this->price_per_km * $distance;
        }

        return 0;
    }

    public function getFormattedValidFromAttribute()
    {
        return $this->valid_from ? $this->valid_from->format('Y-m-d') : null;
    }

    public function getFormattedValidToAttribute()
    {
        return $this->valid_to ? $this->valid_to->format('Y-m-d') : null;
    }

    // Get formatted price
    public function getFormattedPriceAttribute()
    {
        $currencySymbol = $this->currency ? $this->currency->symbol : '';

        if ($this->base_price) {
            return $currencySymbol . number_format($this->base_price, 2);
        }

        if ($this->price_per_km) {
            return $currencySymbol . number_format($this->price_per_km, 2) . '/km';
        }

        if ($this->price_per_person) {
            return $currencySymbol . number_format($this->price_per_person, 2) . '/person';
        }

        return 'N/A';
    }
}
