<?php

namespace App\Models;

use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class TaxConfiguration extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, ClearsEmptyRichText;
    protected $richTextAttributes = [
        'description',
    ];

    protected $table = 'tax_configurations';
    protected $fillable = [
        'tourist_service_id',
        'name',
        'type',
        'value',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: Belongs to TouristService
     */
    public function touristService()
    {
        return $this->belongsTo(TouristService::class);
    }
}
