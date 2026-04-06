<div>
    @section('title', __('main.theme_customizer') ?? 'Theme Customizer')
    
    @section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7 mb-7 border-b border-border">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-foreground flex items-center gap-2">
                    <div class="bg-primary/10 rounded-lg p-2 flex items-center justify-center">
                        <i class="fa-duotone fa-solid fa-palette text-primary fs-2 px-1"></i>
                    </div>
                    {{ __('main.theme_customizer') ?? 'Theme Customizer' }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-muted-foreground">
                    {{ __('main.manage_theme_colors') ?? 'Customize your application\'s global colors dynamically.' }}
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.core.settings.general') }}" class="kt-btn kt-btn-secondary kt-btn-sm flex items-center gap-2 px-4 shadow-sm">
                    <i class="fa-duotone fa-solid fa-arrow-left fs-3"></i>  {{ __('main.back') }}
                </a>
                <button type="button" wire:click="resetDefaults" class="kt-btn kt-btn-light kt-btn-sm flex items-center gap-2 px-4 shadow-sm">
                    <i class="fa-duotone fa-solid fa-arrows-rotate fs-3"></i> {{ __('main.reset_defaults') ?? 'Reset Defaults' }}
                </button>
                <button wire:click="save" wire:loading.attr="disabled" class="kt-btn kt-btn-primary kt-btn-sm flex items-center gap-2 px-6 shadow-md transition-shadow hover:shadow-lg">
                    <span wire:loading.remove wire:target="save"><i class="fa-duotone fa-solid fa-floppy-disk-2 fs-3"></i> {{ __('main.save_changes') ?? 'Save Changes' }}</span>
                    <span wire:loading wire:target="save" class="flex gap-2 items-center"><i class="fas fa-spinner fa-spin"></i> {{ __('main.loading') ?? 'Saving...' }}</span>
                </button>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-5 lg:gap-7.5">
            <div class="card shadow-sm border border-border">
                <div class="card-header border-b border-border py-4">
                    <h3 class="card-title font-semibold flex items-center gap-2">
                        <i class="fa-duotone fa-solid fa-pen text-muted-foreground fs-3 items-center"></i>
                        {{ __('main.brand_colors') ?? 'Brand Colors' }}
                    </h3>
                </div>
                <div class="card-body p-6">
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="form-label text-foreground font-medium">{{ __('main.primary_color') ?? 'Primary Color' }}</label>
                            <div class="flex items-center gap-3">
                                <input type="color" wire:model.live="primary" class="w-12 h-12 rounded cursor-pointer border-0 p-0 shadow-sm" >
                                <input type="text" wire:model.live="primary" class="input input-sm border border-border w-32" dir="ltr">
                                <span class="text-xs text-muted-foreground">Main brand color used for primary buttons and active states.</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="form-label text-foreground font-medium">{{ __('main.secondary_color') ?? 'Secondary Color' }}</label>
                            <div class="flex items-center gap-3">
                                <input type="color" wire:model.live="secondary" class="w-12 h-12 rounded cursor-pointer border-0 p-0 shadow-sm" >
                                <input type="text" wire:model.live="secondary" class="input input-sm border border-border w-32" dir="ltr">
                                <span class="text-xs text-muted-foreground">Used for secondary buttons and subtle accents.</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="form-label text-foreground font-medium">{{ __('main.dark_color') ?? 'Dark Color' }}</label>
                            <div class="flex items-center gap-3">
                                <input type="color" wire:model.live="dark" class="w-12 h-12 rounded cursor-pointer border-0 p-0 shadow-sm" >
                                <input type="text" wire:model.live="dark" class="input input-sm border border-border w-32" dir="ltr">
                                <span class="text-xs text-muted-foreground">Dark accents, typically used for dark text elements.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border border-border">
                <div class="card-header border-b border-border py-4">
                    <h3 class="card-title font-semibold flex items-center gap-2">
                        <i class="fa-duotone fa-solid fa-circle-info-2 text-muted-foreground fs-3 items-center"></i>
                        {{ __('main.state_colors') ?? 'State Colors' }}
                    </h3>
                </div>
                <div class="card-body p-6">
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="form-label text-foreground font-medium" style="color:var(--color-success)">{{ __('main.success_color') ?? 'Success Color' }}</label>
                            <div class="flex items-center gap-3">
                                <input type="color" wire:model.live="success" class="w-12 h-12 rounded cursor-pointer border-0 p-0 shadow-sm" >
                                <input type="text" wire:model.live="success" class="input input-sm border border-border w-32" dir="ltr">
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="form-label text-foreground font-medium" style="color:var(--color-info)">{{ __('main.info_color') ?? 'Info Color' }}</label>
                            <div class="flex items-center gap-3">
                                <input type="color" wire:model.live="info" class="w-12 h-12 rounded cursor-pointer border-0 p-0 shadow-sm" >
                                <input type="text" wire:model.live="info" class="input input-sm border border-border w-32" dir="ltr">
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="form-label text-foreground font-medium" style="color:var(--color-warning)">{{ __('main.warning_color') ?? 'Warning Color' }}</label>
                            <div class="flex items-center gap-3">
                                <input type="color" wire:model.live="warning" class="w-12 h-12 rounded cursor-pointer border-0 p-0 shadow-sm" >
                                <input type="text" wire:model.live="warning" class="input input-sm border border-border w-32" dir="ltr">
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="form-label text-foreground font-medium" style="color:var(--color-danger)">{{ __('main.danger_color') ?? 'Danger Color' }}</label>
                            <div class="flex items-center gap-3">
                                <input type="color" wire:model.live="danger" class="w-12 h-12 rounded cursor-pointer border-0 p-0 shadow-sm" >
                                <input type="text" wire:model.live="danger" class="input input-sm border border-border w-32" dir="ltr">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border border-border mb-7">
                <div class="card-header border-b border-border py-4">
                    <h3 class="card-title font-semibold flex items-center gap-2">
                        <i class="fa-duotone fa-solid fa-gear-4 text-muted-foreground fs-3 items-center"></i>
                        {{ __('main.sidebar_colors') ?? 'Sidebar Colors' }}
                    </h3>
                </div>
                <div class="card-body p-6">
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="form-label text-foreground font-medium">{{ __('main.sidebar_bg_color') ?? 'Sidebar Background' }}</label>
                            <div class="flex items-center gap-3">
                                <input type="color" wire:model.live="sidebar_bg" class="w-12 h-12 rounded cursor-pointer border-0 p-0 shadow-sm" >
                                <input type="text" wire:model.live="sidebar_bg" class="input input-sm border border-border w-32" dir="ltr">
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="form-label text-foreground font-medium">{{ __('main.sidebar_text_color') ?? 'Sidebar Text & Icons' }}</label>
                            <div class="flex items-center gap-3">
                                <input type="color" wire:model.live="sidebar_text" class="w-12 h-12 rounded cursor-pointer border-0 p-0 shadow-sm" >
                                <input type="text" wire:model.live="sidebar_text" class="input input-sm border border-border w-32" dir="ltr">
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="form-label text-foreground font-medium">{{ __('main.sidebar_active_color') ?? 'Sidebar Active Item' }}</label>
                            <div class="flex items-center gap-3">
                                <input type="color" wire:model.live="sidebar_active" class="w-12 h-12 rounded cursor-pointer border-0 p-0 shadow-sm" >
                                <input type="text" wire:model.live="sidebar_active" class="input input-sm border border-border w-32" dir="ltr">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm border border-border mb-7">
                <div class="card-header border-b border-border py-4">
                    <h3 class="card-title font-semibold flex items-center gap-2">
                        <i class="fa-duotone fa-solid fa-eye text-muted-foreground fs-3 items-center"></i>
                        {{ __('main.live_preview') ?? 'Live Preview Panel' }}
                    </h3>
                </div>
                <div class="card-body p-6">
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-wrap gap-4 items-center">
                            <p class="text-sm font-medium text-foreground w-full mb-2">{{ __('main.ui_elements_preview') ?? 'UI Elements Preview' }}:</p>
                            
                            <button type="button" class="kt-btn text-white" style="background-color: {{ $primary }};">Primary Action</button>
                            <button type="button" class="kt-btn text-white" style="background-color: {{ $secondary }};">Secondary Action</button>
                            <button type="button" class="kt-btn text-white" style="background-color: {{ $success }};">Success</button>
                            <button type="button" class="kt-btn text-white" style="background-color: {{ $info }};">Info</button>
                            <button type="button" class="kt-btn" style="background-color: {{ $warning }}; color: #000;">Warning</button>
                            <button type="button" class="kt-btn text-white" style="background-color: {{ $danger }};">Danger</button>
                            <button type="button" class="kt-btn text-white" style="background-color: {{ $dark }};">Dark</button>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-border">
                            <p class="text-sm font-medium text-foreground mb-4">Sidebar Preview:</p>
                            <div class="rounded-xl w-64 p-4 shadow-sm" style="background-color: {{ $sidebar_bg }};">
                                <div class="flex items-center gap-3 mb-4 rounded-lg px-3 py-2 cursor-pointer" style="background-color: transparent">
                                    <i class="fa-duotone fa-solid fa-grid-2 fs-4" style="color: {{ $sidebar_text }};"></i>
                                    <span class="font-medium" style="color: {{ $sidebar_text }};">Dashboard</span>
                                </div>
                                <div class="flex items-center gap-3 rounded-lg px-3 py-2 cursor-pointer shadow-sm" style="background-color: {{ $sidebar_active }}1A;">
                                    <i class="fa-duotone fa-solid fa-gear-2 fs-4" style="color: {{ $sidebar_active }};"></i>
                                    <span class="font-medium" style="color: {{ $sidebar_active }};">Settings</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</div>
