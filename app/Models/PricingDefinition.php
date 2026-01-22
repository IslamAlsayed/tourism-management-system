<?php

namespace App\Models;

use App\Traits\FiltersByUserRole;
use App\Traits\HandlesRichTextAttributes;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class PricingDefinition extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, HandlesRichTextAttributes;
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'key',
        'name',
        'name_ar',
        'category',
        'is_active',
        'description',
        'notes',
    ];

    public function getExcludedColumns()
    {
        return ['key', 'category', 'description', 'notes'];
    }

    public function isPerPerson()
    {
        return $this->key === 'per_person';
    }

    public function isPerDay()
    {
        return $this->key === 'per_day';
    }
}
