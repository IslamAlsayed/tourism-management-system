<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\HandlesRichTextAttributes;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class TouristSite extends Model
{
    use HasSearch, HasUuid, HasRichText, HasFactory, BroadcastsRecordEvents, HandlesRichTextAttributes;
    protected $table = 'tourist_sites';
    protected $richTextAttributes = [
        'nearby_attractions',
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'main_image',
        'gallery_images',
        'name',
        'name_ar',
        'site_type',
        'unesco_site',
        'supplier_type',
        'sites_theme',
        'supplier_name',
        'latitude',
        'longitude',
        'nearby_attractions',
        'sort_order',
        'is_active',
        'description',
        'notes',

        'city_id',
    ];

    protected $casts = [
        'unesco_site' => 'boolean',
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'sort_order' => 'integer',
        'gallery_images' => 'json',
    ];

    public function getRelationshipNames()
    {
        return ['city'];
    }

    public function getExcludedColumns()
    {
        return ['city_id', 'sort_order', 'description', 'notes', 'nearby_attractions'];
    }

    /**
     * Relationships
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function services()
    {
        return $this->hasMany(TouristService::class, 'site_id');
    }

    public function media()
    {
        return $this->morphMany(MediaFile::class, 'model');
    }

    public function photos()
    {
        return $this->hasManyThrough(
            MediaFile::class,
            null,
            'id',
            'id',
            'id',
            'photo_id_01'
        );
    }
}
