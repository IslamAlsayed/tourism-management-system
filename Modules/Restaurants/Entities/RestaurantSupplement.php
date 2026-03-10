<?php

namespace Modules\Restaurants\Entities;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\HasCustomFields;
use Modules\Core\Entities\User;
use App\Traits\FiltersByUserRole;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantSupplement extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, BroadcastsRecordEvents, HasCustomFields;

    protected $table = 'restaurant_supplements';

    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'price',
        'price_type',
        'applicable_date',
        'is_mandatory',
        'is_active',
        'description',
        'notes',
        'restaurant_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_mandatory' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getRelationshipNames()
    {
        return ['restaurant', 'creator', 'updater'];
    }

    public function getExcludedColumns()
    {
        return ['restaurant_id', 'description', 'notes'];
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
