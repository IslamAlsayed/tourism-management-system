<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UiIcon extends Model
{
    protected $fillable = [
        'field_key', 
        'icon_class', 
        'type', 
        'primary_color_light', 
        'secondary_color_light', 
        'primary_color_dark', 
        'secondary_color_dark', 
        'weight', 
        'size', 
        'shape',
        'bg_color_light',
        'bg_color_dark',
        'border_color_light',
        'border_color_dark',
        'custom_css',
        'custom_styles',
        'is_active'
    ];

    /**
     * Get the effective secondary color for a theme.
     * If not set, it returns a muted version of the primary color.
     */
    public function getEffectiveSecondaryColor($theme = 'light')
    {
        $primary = $theme === 'light' ? $this->primary_color_light : (!empty($this->primary_color_dark) ? $this->primary_color_dark : $this->primary_color_light);
        $secondary = $theme === 'light' ? $this->secondary_color_light : (!empty($this->secondary_color_dark) ? $this->secondary_color_dark : $this->secondary_color_light);

        if (!empty($secondary)) {
            return $secondary;
        }

        if (!empty($primary)) {
            // If primary is hex, return it with 40% opacity for duotone secondary
            if (str_starts_with($primary, '#')) {
                return $primary . '66'; // 66 is approx 40% opacity in hex
            }
            return $primary; // Fallback
        }

        return 'currentColor';
    }
}
