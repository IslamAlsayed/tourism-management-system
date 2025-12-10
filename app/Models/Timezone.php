<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\HasUuid;
use App\Traits\FiltersByUserRole;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Timezone extends Model
{
    use HasSearch, HasUuid, HasRichText, HasFactory, FiltersByUserRole, BroadcastsRecordEvents;

    protected $richTextAttributes = [
        'description',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'abbreviation',
        'abbreviation_dst',
        'offset',
        'offset_dst',
        'country_code',
        'gmt_offset_name',
        'gmt_offset_name_dst',
        'supports_dst',
        'region',
        'city',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'supports_dst' => 'boolean',
        'is_active' => 'boolean',
        'offset' => 'integer',
        'offset_dst' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return ['description', 'sort_order'];
    }

    /**
     * Get formatted offset as +/-HH:MM
     */
    public function getFormattedOffsetAttribute(): string
    {
        $hours = floor(abs($this->offset) / 3600);
        $minutes = floor((abs($this->offset) % 3600) / 60);
        $sign = $this->offset >= 0 ? '+' : '-';
        return sprintf('%s%02d:%02d', $sign, $hours, $minutes);
    }

    /**
     * Get current time in this timezone
     */
    public function getCurrentTimeAttribute(): string
    {
        try {
            $timezone = new \DateTimeZone($this->name);
            $datetime = new \DateTime('now', $timezone);
            return $datetime->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return 'Invalid timezone';
        }
    }
}