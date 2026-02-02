<?php

namespace App\Models;

use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class TransportationVehicleType extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, ClearsEmptyRichText;
    protected $table = 'transportations_vehicle_types';
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'min_capacity',
        'max_capacity',
        'has_luggage',
        'is_air_conditioning',
        'is_active',
        'description',
        'notes',

        'company_id',
    ];

    public function getRelationshipNames()
    {
        return ['company'];
    }

    public function getExcludedColumns()
    {
        return ['company_id', 'description', 'notes'];
    }

    public function company()
    {
        return $this->belongsTo(TransportationCompany::class, 'company_id');
    }
}
