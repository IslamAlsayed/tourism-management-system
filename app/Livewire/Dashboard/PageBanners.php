<?php

namespace App\Livewire\Dashboard;

use App\Models\PageBanner;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

class PageBanners extends Component
{
    use WithFileUploads;

    public $banners;
    
    // Form fields
    public $banner_id;
    public $title, $is_active = true;
    public $apply_to = 'route'; // 'route' or 'module'
    public $module_name = '';
    public $route_name = '';
    
    public $banner_type = 'image'; // 'image' or 'text_color'
    
    // Image fields
    public $image, $existing_image;
    
    // Text fields
    public $bg_color = '#f8f9fa';
    public $text_content = '';
    public $text_color = '#333333';
    public $font_family = 'Tajawal';
    public $font_size = '24px';

    public $isEditMode = false;
    public $available_routes = [];
    public $available_modules = [
        'Core' => 'main.system',
        'Users' => 'main.users', 
        'Geography' => 'main.geographic',
        'Accommodations' => 'main.accommodations',
        'TouristSites' => 'main.tourist-sites',
        'TouristServices' => 'main.tourist-services',
        'Transportation' => 'main.transport',
        'Restaurants' => 'main.restaurants',
        'TourGuides' => 'main.local_guide'
    ];

    protected function rules()
    {
        return [
            'apply_to' => 'required|in:route,module',
            'route_name' => 'required_if:apply_to,route|nullable|string',
            'module_name' => 'required_if:apply_to,module|nullable|string',
            
            'title' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            
            'banner_type' => 'required|in:image,text_color',
            
            // Image Validation
            'image' => ($this->banner_type == 'image' && !$this->isEditMode && !$this->existing_image) ? 'required|image|max:5120' : 'nullable|image|max:5120',
            
            // Text Validation
            'bg_color' => 'required_if:banner_type,text_color|nullable|string|max:20',
            'text_content' => 'required_if:banner_type,text_color|nullable|string',
            'text_color' => 'required_if:banner_type,text_color|nullable|string|max:20',
            'font_family' => 'required_if:banner_type,text_color|nullable|string|max:50',
            'font_size' => 'required_if:banner_type,text_color|nullable|string|max:20',
        ];
    }

    public function mount()
    {
        $this->loadBanners();
        $this->loadAvailableRoutes();
    }

    public function loadBanners()
    {
        $this->banners = PageBanner::latest()->get();
    }

    public function loadAvailableRoutes()
    {
        $routes = collect(Route::getRoutes())->filter(function ($route) {
            return in_array('GET', $route->methods()) && str_starts_with($route->getName(), 'dashboard.');
        })->map(function ($route) {
            return $route->getName();
        })->filter()->values()->toArray();

        $this->available_routes = array_unique($routes);
    }

    public function resetFields()
    {
        $this->apply_to = 'route';
        $this->module_name = '';
        $this->route_name = '';
        $this->banner_type = 'image';
        
        $this->title = '';
        $this->image = null;
        $this->existing_image = null;
        
        $this->bg_color = '#f8f9fa';
        $this->text_content = '';
        $this->text_color = '#333333';
        $this->font_family = 'Tajawal';
        $this->font_size = '24px';
        
        $this->is_active = true;
        $this->banner_id = null;
        $this->isEditMode = false;
        
        $this->resetValidation();
        $this->dispatch('close-modal');
    }

    public function save()
    {
        $this->validate();

        $data = [
            'apply_to' => $this->apply_to,
            'module_name' => $this->apply_to === 'module' ? $this->module_name : null,
            'route_name' => $this->apply_to === 'route' ? $this->route_name : null,
            
            'banner_type' => $this->banner_type,
            'title' => $this->title,
            'is_active' => $this->is_active,
            
            'bg_color' => $this->banner_type === 'text_color' ? $this->bg_color : null,
            'text_content' => $this->banner_type === 'text_color' ? $this->text_content : null,
            'text_color' => $this->banner_type === 'text_color' ? $this->text_color : null,
            'font_family' => $this->banner_type === 'text_color' ? $this->font_family : null,
            'font_size' => $this->banner_type === 'text_color' ? $this->font_size : null,
        ];

        // Handle Image Deletion if switching to text or uploading new image
        if ($this->banner_type === 'text_color' && $this->existing_image) {
            Storage::disk('public')->delete($this->existing_image);
            $data['image_path'] = null;
        } elseif ($this->banner_type === 'image' && $this->image) {
            if ($this->isEditMode && $this->existing_image) {
                Storage::disk('public')->delete($this->existing_image);
            }
            $data['image_path'] = $this->image->store('banners', 'public');
        }

        PageBanner::updateOrCreate(['id' => $this->banner_id], $data);

        $this->loadBanners();
        $this->resetFields();
        $this->dispatch('success', __('messages.saved_successfully'));
    }

    public function edit($id)
    {
        $banner = PageBanner::findOrFail($id);
        
        $this->banner_id = $banner->id;
        $this->apply_to = $banner->apply_to;
        $this->module_name = $banner->module_name;
        $this->route_name = $banner->route_name;
        $this->banner_type = $banner->banner_type;
        
        $this->title = $banner->title;
        $this->existing_image = $banner->image_path;
        
        $this->bg_color = $banner->bg_color ?? '#f8f9fa';
        $this->text_content = $banner->text_content ?? '';
        $this->text_color = $banner->text_color ?? '#333333';
        $this->font_family = $banner->font_family ?? 'Tajawal';
        $this->font_size = $banner->font_size ?? '24px';
        
        $this->is_active = $banner->is_active;
        $this->isEditMode = true;
        
        // Reset validaton so older hints don't stick around
        $this->resetValidation();
        $this->dispatch('open-modal');
    }

    public function delete($id)
    {
        $banner = PageBanner::findOrFail($id);
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }
        $banner->delete();
        $this->loadBanners();
        $this->dispatch('success', __('messages.deleted_successfully'));
    }

    public function render()
    {
        return view('livewire.dashboard.page-banners')->layout('layouts.master');
    }
}
