<?php

namespace Modules\Transportation\Entities;

use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class VehicleType extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, ClearsEmptyRichText;

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
        return $this->belongsTo(Company::class, 'company_id');
    }
}
