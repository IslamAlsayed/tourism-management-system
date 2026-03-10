<?php

namespace Modules\Restaurants\Entities;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\HasCustomFields;
use App\Traits\ClearsEmptyRichText;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantType extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, ClearsEmptyRichText, HasCustomFields;

    protected $table = 'restaurant_types';

    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'is_active',
        'description',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getExcludedColumns()
    {
        return ['description', 'notes'];
    }

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class, 'type_id');
    }
}
