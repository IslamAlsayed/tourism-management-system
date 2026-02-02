<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ClearsEmptyRichText;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpecialHour extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, ClearsEmptyRichText;
    protected $richTextAttributes = [
        'description',
    ];

    protected $table = 'special_hours';

    protected $fillable = [
        'tourist_service_id',
        'date',
        'opening_time',
        'closing_time',
        'type',
        'description',
        'is_closed',
    ];

    protected $casts = [
        'date' => 'date',
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
