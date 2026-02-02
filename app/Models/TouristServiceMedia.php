<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Traits\HasUuid;

class TouristServiceMedia extends Model
{
    use App\Traits\FiltersByUserRole;
    use App\Traits\ClearsEmptyRichText;
    use App\Traits\HasSearch;
    use App\Traits\HasUuid;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, ClearsEmptyRichText;
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $table = 'tourist_service_media';
    protected $fillable = [
        'tourist_service_id',
        'file_name',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'alt_text',
        'description',
        'is_primary',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: Belongs to TouristService
     */
    public function touristService(): BelongsTo
    {
        return $this->belongsTo(TouristService::class);
    }

    /**
     * Get the full URL for this media file
     */
    public function getFullUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }
}
