<?php

namespace Modules\Cruises\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Traits\HasUuid;
use App\Traits\FiltersByUserRole;

class CruiseSupplier extends Model
{
    use SoftDeletes, HasUuid, FiltersByUserRole;

    protected $fillable = [
        'uuid',
        'company_id',
        'name',
        'name_ar',
        'contact_person',
        'phone',
        'email',
        'website',
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
        'city_id',
        'main_start_point_id',
        'main_end_point_id',
        'address',
        'type',
        'default_commission_rate',
        'payment_terms',
        'contract_start_date',
        'contract_end_date',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active'           => 'boolean',
        'contract_start_date' => 'date',
        'contract_end_date'   => 'date',
        'default_commission_rate' => 'decimal:2',
    ];

    // ─── Relationships ────────────────────────────────────────

    public function cruises()
    {
        return $this->hasMany(Cruise::class, 'supplier_id');
    }

    public function country()
    {
        return $this->belongsTo(\Modules\Geography\Entities\Country::class, 'country_id');
    }

    public function city()
    {
        return $this->belongsTo(\Modules\Geography\Entities\City::class, 'city_id');
    }

    // ─── Helpers ──────────────────────────────────────────────

    public function getTypeLabel(): string
    {
        return match($this->type) {
            'ship_owner' => __('Ship Owner'),
            'broker'     => __('Broker'),
            'agency'     => __('Agency'),
            'operator'   => __('Operator'),
            default      => ucfirst($this->type),
        };
    }

    public function isContractActive(): bool
    {
        if (!$this->contract_start_date || !$this->contract_end_date) {
            return true; // No contract dates = open-ended
        }
        return now()->between($this->contract_start_date, $this->contract_end_date);
    }
}
