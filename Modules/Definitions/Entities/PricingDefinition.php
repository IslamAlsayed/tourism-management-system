<?php

namespace Modules\Definitions\Entities;

use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class PricingDefinition extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, ClearsEmptyRichText;
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'code',
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
        return ['key', 'description', 'notes'];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            if (empty($item->code)) {
                $lastId = static::max('id') ?? 0;
                $item->code = 'PD-' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
            }
        });

        static::saved(function ($item) {
            if (empty($item->key)) return;
            $langs = ["ar","en","es","it","fr","ja","tr","de","ru","he"];
            foreach ($langs as $lang) {
                $path = resource_path("lang/{$lang}/pricing_units.php");
                if (!file_exists($path)) {
                    if (!is_dir(dirname($path))) mkdir(dirname($path), 0755, true);
                    file_put_contents($path, "<?php\n\nreturn [];\n");
                }
                $translations = include $path;
                if (!is_array($translations)) $translations = [];
                
                if (!isset($translations[$item->key])) {
                    // Default to name_ar for Arabic, name for others
                    $translations[$item->key] = $lang === 'ar' ? ($item->name_ar ?: $item->name) : $item->name;
                    $export = var_export($translations, true);
                    $export = str_replace(array('array (', ')'), array('[', ']'), $export);
                    file_put_contents($path, "<?php\n\nreturn " . $export . ";\n");
                }
            }
        });
    }

    public function getNameAttribute($value)
    {
        if (empty($this->key)) return $value;
        $translated = __('pricing_units.' . $this->key);
        if ($translated !== 'pricing_units.' . $this->key) {
            return $translated;
        }
        return $value;
    }

    public function isPerPerson()
    {
        return $this->key === 'per_person';
    }

    public function isPerDay()
    {
        return $this->key === 'per_day';
    }

    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!empty($this->key)) {
                    $translated = __('pricing_units.' . $this->key);
                    if ($translated !== 'pricing_units.' . $this->key) {
                        return $translated;
                    }
                }
                return app()->getLocale() === 'ar' && !empty($this->name_ar) ? $this->name_ar : $this->attributes['name'] ?? '';
            }
        );
    }

    /**
     * Define relationship columns for the dynamic DataTable builder.
     */
    public function getRelationshipNames(): array
    {
        return ['moduleAssignments'];
    }

    /**
     * Module assignments — tracks which modules/sections use this definition.
     */
    public function moduleAssignments()
    {
        return $this->hasMany(PricingDefinitionModule::class);
    }

    /**
     * Get list of module names where this definition is used.
     */
    public function getUsedInModulesAttribute()
    {
        return $this->moduleAssignments->pluck('module_name')->unique()->toArray();
    }

    /**
     * Available modules for assignment.
     */
    public static function getAvailableModules(): array
    {
        return [
            'tourists' => 'Tourist Sites',
            'hotels' => 'Hotels & Accommodations',
            'transportation' => 'Transportation',
            'restaurants' => 'Restaurants',
            'tours' => 'Tours & Activities',
        ];
    }

    /**
     * Available categories.
     */
    public static function getCategories(): array
    {
        return [
            'pricing_type' => 'Pricing Type',
            'pricing_unit' => 'Pricing Unit',
            'site_type' => 'Site Type',
            'site_category' => 'Site Category',
            'supplier_type' => 'Supplier Type',
            'site_theme' => 'Site Theme',
        ];
    }
}
