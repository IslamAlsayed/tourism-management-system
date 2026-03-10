<?php

namespace App\Livewire;

use Livewire\Component;
use Modules\Core\Entities\Setting;

class ThemeCustomizer extends Component
{
    public $primary;
    public $secondary;
    public $success;
    public $info;
    public $warning;
    public $danger;
    public $dark;
    public $sidebar_bg;
    public $sidebar_text;
    public $sidebar_active;

    public function mount()
    {
        $settings = Setting::first();
        if ($settings) {
            $this->primary = $settings->app_theme_color_primary ?? '#181C32';
            $this->secondary = $settings->app_theme_color_secondary ?? '#212122';
            $this->success = $settings->app_theme_color_success ?? '#17c653';
            $this->info = $settings->app_theme_color_info ?? '#7239ea';
            $this->warning = $settings->app_theme_color_warning ?? '#f6c000';
            $this->danger = $settings->app_theme_color_danger ?? '#f8285a';
            $this->dark = $settings->app_theme_color_dark ?? '#1E2129';
            $this->sidebar_bg = $settings->app_theme_color_sidebar_bg ?? '#181C32';
            $this->sidebar_text = $settings->app_theme_color_sidebar_text ?? '#A1A5B7';
            $this->sidebar_active = $settings->app_theme_color_sidebar_active ?? '#009EF7';
        } else {
            $this->resetDefaults(false); // don't dispatch toast on mount
        }
    }

    public function resetDefaults($dispatchToast = true)
    {
        $this->primary = '#181C32';
        $this->secondary = '#212122';
        $this->success = '#17c653';
        $this->info = '#7239ea';
        $this->warning = '#f6c000';
        $this->danger = '#f8285a';
        $this->dark = '#1E2129';
        $this->sidebar_bg = '#181C32';
        $this->sidebar_text = '#A1A5B7';
        $this->sidebar_active = '#009EF7';
        
        if ($dispatchToast) {
            $this->dispatch('toast', message: __('main.reset_defaults') . ' ' . __('messages.updated_successfully'), type: 'info');
        }
    }

    public function save()
    {
        $settings = Setting::first();
        if ($settings) {
            $settings->update([
                'app_theme_color_primary' => $this->primary,
                'app_theme_color_secondary' => $this->secondary,
                'app_theme_color_success' => $this->success,
                'app_theme_color_info' => $this->info,
                'app_theme_color_warning' => $this->warning,
                'app_theme_color_danger' => $this->danger,
                'app_theme_color_dark' => $this->dark,
                'app_theme_color_sidebar_bg' => $this->sidebar_bg,
                'app_theme_color_sidebar_text' => $this->sidebar_text,
                'app_theme_color_sidebar_active' => $this->sidebar_active,
            ]);

            \Illuminate\Support\Facades\Artisan::call('view:clear');

            $this->dispatch('theme-colors-updated', [
                'primary' => $this->primary,
                'secondary' => $this->secondary,
                'success' => $this->success,
                'info' => $this->info,
                'warning' => $this->warning,
                'danger' => $this->danger,
                'dark' => $this->dark,
                'sidebar_bg' => $this->sidebar_bg,
                'sidebar_text' => $this->sidebar_text,
                'sidebar_active' => $this->sidebar_active,
            ]);
            
            $this->dispatch('refresh-page');
            $this->dispatch('show-toast', ['message' => __('messages.updated_successfully'), 'type' => 'success']);
            $this->dispatch('toast', message: __('messages.updated_successfully'), type: 'success');
        }
    }

    public function render()
    {
        return view('livewire.theme-customizer')->layout('layouts.master');
    }
}

