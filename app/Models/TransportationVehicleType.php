<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransportationVehicleType extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole;

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
        return ['company_id'];
    }

    public function company()
    {
        return $this->belongsTo(TransportationCompany::class);
    }
}