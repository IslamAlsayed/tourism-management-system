<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class TransportationCompanyBusType extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'min_seats',
        'max_seats',
        'seats',
        'company_id',
        'bus_type_id',
    ];

    /**
     * Get relationship names for eager loading
     */
    public function getRelationshipNames()
    {
        return ['company', 'bus_type'];
    }

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return ['company_id', 'bus_type_id'];
    }

    public function company()
    {
        return $this->belongsTo(TransportationCompany::class, 'company_id');
    }

    public function bus_type()
    {
        return $this->belongsTo(TransportationBusType::class, 'bus_type_id');
    }
}