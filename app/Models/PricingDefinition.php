<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PricingDefinition extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole;

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

    public function isPerPerson(): bool
    {
        return $this->key === 'per_person';
    }

    public function isPerDay(): bool
    {
        return $this->key === 'per_day';
    }
}