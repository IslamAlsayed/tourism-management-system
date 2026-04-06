<div>
    <!-- Header -->
    <div class="mb-5 flex items-center justify-between">
        <h3 class="text-lg font-medium text-foreground">
            {{ __('main.page_banners') }}
        </h3>
        <button wire:click="$dispatch('open-modal')" class="kt-btn kt-btn-primary" data-modal-toggle="#add_banner_modal">
            <i class="fa-duotone fa-solid fa-plus"></i>
            {{ __('main.add_banner') }}
        </button>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="kt-table table-auto kt-table-border align-middle text-gray-700 font-medium fs-6 gy-5">
                    <thead>
                        <tr class="fw-semibold text-muted bg-light">
                            <th class="ps-4 rounded-s w-150px">{{ __('main.preview') }}</th>
                            <th>{{ __('main.target') }}</th>
                            <th>{{ __('main.title') }}</th>
                            <th>{{ __('main.status') }}</th>
                            <th class="text-end rounded-e pe-4 w-100px">{{ __('main.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @forelse ($banners as $banner)
                            <tr>
                                <td class="ps-4">
                                    @if($banner->banner_type === 'image' && $banner->image_path)
                                        <div class="symbol symbol-100px symbol-2by3 rounded border shadow-sm">
                                            <div class="symbol-label" style="background-image:url('{{ asset('storage/' . $banner->image_path) }}'); background-size: cover; background-position: center;"></div>
                                        </div>
                                    @elseif($banner->banner_type === 'text_color')
                                        <div class="rounded border shadow-sm d-flex align-items-center justify-content-center p-2" 
                                             style="height: 60px; width: 140px; background-color: {{ $banner->bg_color }};">
                                            <span style="color: {{ $banner->text_color }}; font-family: '{{ $banner->font_family }}', sans-serif; font-size: {{ str_replace('px', '', $banner->font_size) / 2 }}px; /* scaled down for preview */ white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">
                                                {{ $banner->text_content ?: 'Aa' }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="symbol symbol-100px symbol-2by3 rounded border border-dashed border-gray-300 bg-light">
                                            <div class="symbol-label text-muted fs-8">{{ __('main.no_preview') }}</div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        @if($banner->apply_to === 'module')
                                            <span class="kt-badge kt-badge-info kt-badge-outline fw-bold w-fit mb-1 px-2 py-1">
                                                <i class="fa-duotone fa-solid fa-grid-2 text-info me-1"></i> Module
                                            </span>
                                            <span class="text-gray-800 fs-6">{{ __('main.' . strtolower($banner->module_name)) !== 'main.' . strtolower($banner->module_name) ? __('main.' . strtolower($banner->module_name)) : $banner->module_name }}</span>
                                        @else
                                            <span class="kt-badge kt-badge-primary kt-badge-outline fw-bold w-fit mb-1 px-2 py-1">
                                                <i class="fa-duotone fa-solid fa-route text-primary me-1"></i> Route
                                            </span>
                                            <span class="text-gray-800 fs-7" title="{{ $banner->route_name }}">
                                                {{ Str::limit($banner->route_name, 35) }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $banner->title ?? '-' }}</td>
                                <td>
                                    @if($banner->is_active)
                                        <span class="kt-badge kt-badge-success kt-badge-outline px-3 py-1">{{ __('main.active') }}</span>
                                    @else
                                        <span class="kt-badge kt-badge-destructive kt-badge-outline px-3 py-1">{{ __('main.inactive') }}</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <button wire:click="edit({{ $banner->id }})" class="kt-btn kt-btn-icon kt-btn-outline kt-btn-sm me-1" title="Edit">
                                        <i class="fa-duotone fa-solid fa-pen fs-3"></i>
                                    </button>
                                    <button wire:click="delete({{ $banner->id }})" onclick="return confirm('<?= __('main.are_you_sure') ?>')" class="kt-btn kt-btn-icon kt-btn-outline kt-btn-sm text-danger" title="Delete">
                                        <i class="fa-duotone fa-solid fa-trash fs-3"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-10 text-muted">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fa-duotone fa-solid fa-image fs-3x text-muted mb-3"></i>
                                        <span class="fw-semibold fs-5">{{ __('main.no_data_found') }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Fragment (Uses Bootstrap Modal logic) -->
    <div class="modal fade" id="add_banner_modal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <div class="modal-content border-0 shadow-lg rounded-xl">
                <form wire:submit.prevent="save">
                    <div class="modal-header bg-light py-4">
                        <h2 class="fw-bold fs-3 mb-0">{{ $isEditMode ? __('main.edit_banner') : __('main.add_banner') }}</h2>
                        <button type="button" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost" data-bs-dismiss="modal" wire:click="resetFields">
                            <i class="fa-duotone fa-solid fa-xmark fs-1"></i>
                        </button>
                    </div>

                    <div class="modal-body scroll-y mx-2 mx-xl-8 my-5">
                        
                        <!-- Target Type Selection -->
                        <div class="mb-8 p-5 bg-gray-50 rounded-xl border border-gray-100">
                            <label class="required fw-bold fs-6 mb-3 d-block">{{ __('main.banner_target') }}</label>
                            
                            <div class="d-flex gap-4 flex-wrap">
                                <label class="kt-btn kt-btn-outline kt-btn-outline-dashed kt-btn-active-light-primary d-flex flex-column flex-shrink-0 align-items-start p-4 cursor-pointer {{ $apply_to === 'module' ? 'active bg-light-primary border-primary' : '' }}" style="width: 250px;">
                                    <span class="d-flex align-items-center mb-2">
                                        <input class="form-check-input me-3" type="radio" wire:model.live="apply_to" value="module">
                                        <span class="fw-bold fs-5">{{ __('main.entire_module') }}</span>
                                    </span>
                                </label>

                                <label class="kt-btn kt-btn-outline kt-btn-outline-dashed kt-btn-active-light-success d-flex flex-column flex-shrink-0 align-items-start p-4 cursor-pointer {{ $apply_to === 'route' ? 'active bg-light-success border-success' : '' }}" style="width: 250px;">
                                    <span class="d-flex align-items-center mb-2">
                                        <input class="form-check-input me-3" type="radio" wire:model.live="apply_to" value="route">
                                        <span class="fw-bold fs-5">{{ __('main.specific_route') }}</span>
                                    </span>
                                </label>
                            </div>
                            
                            <!-- Dynamic Target Dropdowns -->
                            <div class="mt-5 ps-2 border-start border-3 border-primary">
                                @if($apply_to === 'module')
                                    <div class="fv-row">
                                        <label class="required fs-6 fw-semibold mb-2">{{ __('main.select_module') }}</label>
                                        <select wire:model="module_name" class="kt-select border-gray-300">
                                            <option value="">{{ __('main.select_module') }}</option>
                                            @foreach($available_modules as $key => $translation_key)
                                                <option value="{{ $key }}">{{ __($translation_key) !== $translation_key ? __($translation_key) : $key }}</option>
                                            @endforeach
                                        </select>
                                        @error('module_name') <span class="text-danger mt-1 fs-7">{{ $message }}</span> @enderror
                                    </div>
                                @elseif($apply_to === 'route')
                                    <div class="fv-row">
                                        <label class="required fs-6 fw-semibold mb-2">{{ __('main.route') }}</label>
                                        <select wire:model="route_name" class="kt-select border-gray-300">
                                            <option value="">{{ __('main.select_route') ?? 'Select Route...' }}</option>
                                            @foreach($available_routes as $route)
                                                <option value="{{ $route }}">{{ $route }}</option>
                                            @endforeach
                                        </select>
                                        @error('route_name') <span class="text-danger mt-1 fs-7">{{ $message }}</span> @enderror
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Banner Style/Design Selection -->
                        <div class="mb-8">
                            <h4 class="fw-bold fs-5 mb-4 text-gray-800">{{ __('main.banner_design') }}</h4>
                            
                            <ul class="nav nav-pills nav-pills-custom mb-5 border-bottom border-gray-200" role="tablist">
                                <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                    <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden h-85px pt-5 pb-2 cursor-pointer {{ $banner_type === 'image' ? 'active' : '' }}" wire:click="$set('banner_type', 'image')">
                                        <div class="nav-icon mb-3">
                                            <i class="fa-duotone fa-solid fa-image fs-1"></i>
                                        </div>
                                        <span class="nav-text fw-bold fs-6 lh-1">{{ __('main.upload_image') }}</span>
                                        <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                    </a>
                                </li>
                                <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                    <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden h-85px pt-5 pb-2 cursor-pointer {{ $banner_type === 'text_color' ? 'active' : '' }}" wire:click="$set('banner_type', 'text_color')">
                                        <div class="nav-icon mb-3">
                                            <i class="fa-duotone fa-solid fa-align-center fs-1"></i>
                                        </div>
                                        <span class="nav-text fw-bold fs-6 lh-1">{{ __('main.color_and_text') }}</span>
                                        <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Design Panels -->
                            <div class="tab-content">
                                <!-- Image Panel -->
                                @if($banner_type === 'image')
                                <div class="p-5 border border-dashed border-primary rounded-xl bg-light-primary opacity-transition animate-fade-in">
                                    
                                    <!-- SEO & Speed Instructions -->
                                    <div class="alert bg-white border border-info border-dashed p-4 mb-5 flex flex-col sm:flex-row align-items-center gap-4 shadow-sm">
                                        <i class="fa-duotone fa-solid fa-circle-info text-info fs-3x">
                                            
                                        </i>
                                        <div>
                                            <h5 class="fw-bold text-info mb-1">{{ __('main.image_tips_title') }}</h5>
                                            <ul class="text-gray-700 fs-7 m-0 ps-3">
                                                <li>{!! __('main.image_tips_format') !!}</li>
                                                <li>{{ __('main.image_tips_dimensions') }}</li>
                                                <li>{{ __('main.image_tips_system') }}</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="fv-row">
                                        <label class="required fs-6 fw-semibold mb-2 fw-bold">{{ __('main.select_banner_image') }}</label>
                                        <input type="file" class="kt-input" wire:model="image" accept="image/jpeg,image/png,image/webp,image/avif" />
                                        <div wire:loading wire:target="image" class="text-primary mt-2 fs-7 fw-semibold"><i class="fas fa-spinner fa-spin me-2"></i> {{ __('main.uploading') }}</div>
                                        @error('image') <span class="text-danger mt-1 fs-7">{{ $message }}</span> @enderror
                                        
                                        <div class="d-flex gap-4 mt-5">
                                            @if ($image && !$errors->has('image'))
                                                <div class="position-relative w-100">
                                                    <span class="kt-badge kt-badge-success position-absolute top-0 end-0 m-2 shadow-sm">{{ __('main.new_preview') }}</span>
                                                    <img src="{{ $image->temporaryUrl() }}" class="rounded mw-100 w-100 shadow-sm border border-gray-300" style="height: 180px; object-fit: cover;">
                                                </div>
                                            @elseif ($existing_image)
                                                <div class="position-relative w-100">
                                                    <span class="kt-badge kt-badge-primary position-absolute top-0 end-0 m-2 shadow-sm">{{ __('main.current_image') }}</span>
                                                    <img src="{{ asset('storage/' . $existing_image) }}" class="rounded mw-100 w-100 shadow-sm border border-gray-300" style="height: 180px; object-fit: cover;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Text/Color Panel -->
                                @if($banner_type === 'text_color')
                                <div class="p-5 border border-dashed border-success rounded-xl bg-light-success opacity-transition animate-fade-in">
                                    <div class="row g-5">
                                        <div class="col-md-6 fv-row">
                                            <label class="required fs-6 fw-semibold mb-2">{{ __('main.background_color') }}</label>
                                            <div class="kt-input">
                                                <input class="form-control" data-kt-color-picker="true" data-kt-color-picker-default="{{ $bg_color }}" data-kt-color-picker-input-mode="true" type="text" wire:model.live="bg_color" placeholder="#HEX" value="{{ $bg_color }}">
                                            </div>
                                            @error('bg_color') <span class="text-danger mt-1 fs-7">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="col-md-6 fv-row">
                                            <label class="required fs-6 fw-semibold mb-2">{{ __('main.text_color') }}</label>
                                            <div class="kt-input">
                                                <input class="form-control" data-kt-color-picker="true" data-kt-color-picker-default="{{ $text_color }}" data-kt-color-picker-input-mode="true" type="text" wire:model.live="text_color" placeholder="#HEX" value="{{ $text_color }}">
                                            </div>
                                            @error('text_color') <span class="text-danger mt-1 fs-7">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-12 mt-5 fv-row">
                                            <label class="required fs-6 fw-semibold mb-2">{{ __('main.banner_text') }}</label>
                                            <textarea class="kt-textarea" rows="3" wire:model.live="text_content"></textarea>
                                            @error('text_content') <span class="text-danger mt-1 fs-7">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6 fv-row mt-5">
                                            <label class="fs-6 fw-semibold mb-2">{{ __('main.font_family') }}</label>
                                            <select class="kt-select" wire:model.live="font_family">
                                                <option value="Tajawal">Tajawal (Default Arabic)</option>
                                                <option value="Cairo">Cairo</option>
                                                <option value="Almarai">Almarai</option>
                                                <option value="Inter">Inter (English)</option>
                                                <option value="Roboto">Roboto</option>
                                                <option value="sans-serif">System Default</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-6 fv-row mt-5">
                                            <label class="fs-6 fw-semibold mb-2">{{ __('main.font_size') }}</label>
                                            <select class="kt-select" wire:model.live="font_size">
                                                <option value="24px">24px (Medium)</option>
                                                <option value="32px">32px (Large)</option>
                                                <option value="48px">48px (Extra Large)</option>
                                                <option value="1.5rem">1.5rem (Responsive)</option>
                                                <option value="2.5rem">2.5rem (Responsive Large)</option>
                                                <option value="5vw">5vw (Flexible Screen Width)</option>
                                            </select>
                                        </div>

                                        <!-- Live Preview Box -->
                                        <div class="col-12 mt-6">
                                            <label class="fs-7 fw-bold text-muted mb-2 text-uppercase">{{ __('main.live_preview') }}</label>
                                            <div class="w-100 rounded-xl shadow-sm d-flex align-items-center justify-content-center border border-gray-200" 
                                                 style="height: 180px; background-color: {{ $bg_color }}; transition: all 0.3s ease;">
                                                <span style="color: {{ $text_color }}; font-family: '{{ $font_family }}', sans-serif; font-size: {{ $font_size }}; transition: all 0.3s ease; text-align: center; padding: 20px;">
                                                    {!! nl2br(e($text_content ?: __('main.your_text_here'))) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- General Settings -->
                        <div class="row g-5">
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">{{ __('main.internal_title') }}</label>
                                <input type="text" class="kt-input" wire:model="title" />
                                @error('title') <span class="text-danger mt-1 fs-7">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 fv-row d-flex align-items-end mb-2">
                                <div class="bg-gray-50 border border-gray-200 rounded p-3 w-100">
                                    <div class="flex items-center gap-2">
                                        <input class="kt-switch" type="checkbox" id="banner_is_active" wire:model="is_active" />
                                        <label class="kt-label fw-bold text-gray-800" for="banner_is_active">
                                            {{ __('main.active_status') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer bg-light py-4 flex-center">
                        <button type="button" class="kt-btn kt-btn-outline me-3 px-6 fw-bold" data-bs-dismiss="modal" wire:click="resetFields">
                            {{ __('main.cancel') }}
                        </button>
                        <button type="submit" class="kt-btn kt-btn-primary px-8 fw-bold">
                            <span wire:loading.remove wire:target="save">
                                <i class="fa-duotone fa-solid fa-check-circle fs-3 me-2"></i> {{ __('main.save_changes') }}
                            </span>
                            <span wire:loading wire:target="save">
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span> {{ __('main.saving') }}
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script Integrations -->
    <style>
        .animate-fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
        .nav-pills-custom .nav-link.active { background-color: var(--bs-primary-light) !important; border-color: var(--bs-primary) !important; }
        .nav-pills-custom .nav-link:not(.active) .bullet-custom { display: none; }
    </style>
    
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('close-modal', () => {
                let modalEl = document.getElementById('add_banner_modal');
                if(modalEl && window.bootstrap) {
                    let modal = bootstrap.Modal.getInstance(modalEl);
                    if(modal) modal.hide();
                }
            });
            Livewire.on('open-modal', () => {
                let modalEl = document.getElementById('add_banner_modal');
                if(modalEl && window.bootstrap) {
                    let modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            });
            Livewire.on('success', (msg) => {
                if (typeof toastr !== 'undefined') {
                    toastr.success(msg[0]);
                } else if (typeof Swal !== 'undefined') {
                    Swal.fire({ text: msg[0], icon: "success", buttonsStyling: false, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn btn-primary" } });
                }
            });
        });
    </script>
</div>
