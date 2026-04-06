@extends('layouts.master')

@section('title', __('main.edit_profile'))

@section('content')
    <!-- Tooling: Select2 for Searchable Country -->
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-container--default .select2-selection--single {
                height: 45px;
                border-radius: 0.75rem;
                display: flex;
                align-items: center;
                border: 1px solid rgb(var(--tw-color-border) / 0.6);
                background-color: transparent;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: rgb(var(--tw-color-foreground));
                font-weight: 500;
                padding-left: 1rem;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 44px;
                right: 0.5rem;
            }

            .select2-dropdown {
                border-radius: 1rem;
                border: 1px solid rgb(var(--tw-color-border));
                box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
                overflow: hidden;
                z-index: 9999;
            }
        </style>
    @endpush

    <!-- Header -->
    <div class="container-fixed mb-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex flex-col gap-2">
                <h1 class="text-2xl font-bold text-foreground">
                    <i class="fa-duotone fa-solid fa-user-edit text-primary fs-2 me-2"></i>
                    {{ __('main.edit_profile') }}
                </h1>
                <p class="text-secondary-foreground text-sm font-medium">
                    Update your personal details, company info and profile settings.
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('dashboard.core.profile.index') }}"
                    class="kt-btn kt-btn-light rounded-xl">{{ __('main.cancel') }}</a>
                <button type="submit" form="profile-edit-form"
                    class="kt-btn kt-btn-primary rounded-xl px-10 shadow-lg shadow-primary/20">
                    {{ __('main.save_changes') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fixed">
        <form action="{{ route('dashboard.core.profile.update') }}" method="POST" id="profile-edit-form"
            class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            <!-- Left: Photos & Meta -->
            <div class="space-y-8">
                <!-- Profile Photo Card -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.profile_photo') }}</h3>
                    </div>
                    <div class="kt-card-body p-8 flex flex-col items-center gap-6">
                        <div class="relative group">
                            <div class="size-40 rounded-3xl border-4 border-background overflow-hidden shadow-xl bg-muted">
                                <img id="avatar-preview"
                                    src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('metronic/media/avatars/blank.png') }}"
                                    alt="{{ $user->name }}" class="size-full object-cover">
                            </div>
                            <label for="photo-input"
                                class="absolute -bottom-2 -right-2 size-10 bg-primary text-white rounded-xl shadow-lg flex items-center justify-center cursor-pointer hover:bg-primary-emphasis transition-colors">
                                <i class="fa-duotone fa-solid fa-camera fs-4"></i>
                            </label>
                        </div>
                        <input type="file" id="photo-input" name="photo" class="hidden" accept="image/*">
                        <p class="text-center text-xs text-secondary-foreground leading-relaxed">
                            Recommended: 200x200px (JPG, PNG). Overwriting current photo will happen immediately upon
                            selection.
                        </p>
                    </div>
                </div>

                <!-- Account Status Info -->
                <div class="kt-card bg-muted/10 border-dashed border-2">
                    <div class="kt-card-body p-6 flex items-center gap-4">
                        <div class="size-10 bg-success/20 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-duotone fa-solid fa-badge-check text-success fs-4"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-foreground">Verified User</div>
                            <p class="text-[11px] text-secondary-foreground">Since {{ $user->created_at->format('Y-m-d') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Detailed Information -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Basic Info -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.personal_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-bold text-foreground">{{ __('main.full_name') }}</label>
                                <div class="kt-input rounded-xl h-[45px]">
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        placeholder="John Doe" required>
                                </div>
                                @error('name')
                                    <span class="text-danger text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-bold text-foreground">{{ __('main.email_address') }}</label>
                                <div class="kt-input rounded-xl h-[45px] bg-muted/20">
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        placeholder="email@example.com" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-bold text-foreground">{{ __('main.mobile') }}</label>
                                <div class="kt-input rounded-xl h-[45px]">
                                    <input type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}"
                                        placeholder="+962 7XXXXXXXX">
                                </div>
                                @error('mobile')
                                    <span class="text-danger text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-bold text-foreground">{{ __('main.country') }}</label>
                                <select name="country_id" class="searchable-select w-full">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id', $user->country_id) == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <span class="text-danger text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Info -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.business_details') }}</h3>
                    </div>
                    <div class="kt-card-body p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-bold text-foreground">{{ __('main.company_name') }}</label>
                                <div class="kt-input rounded-xl h-[45px]">
                                    <input type="text" name="company_name"
                                        value="{{ old('company_name', $user->company_name) }}"
                                        placeholder="Travel Agency Name">
                                </div>
                                @error('company_name')
                                    <span class="text-danger text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-bold text-foreground">{{ __('main.company_website') }}</label>
                                <div class="kt-input rounded-xl h-[45px]">
                                    <input type="text" name="company_website"
                                        value="{{ old('company_website', $user->company_website) }}"
                                        placeholder="example.com">
                                </div>
                                @error('company_website')
                                    <span class="text-danger text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-bold text-foreground">{{ __('main.bio_or_description') }}</label>
                            @include('components.elements.input-text-editor', [
                                'column' => 'bio',
                                'value' => $user->bio,
                            ])
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('dashboard.core.profile.index') }}"
                        class="kt-btn kt-btn-light rounded-xl px-10">{{ __('main.discard') }}</a>
                    <button type="submit"
                        class="kt-btn kt-btn-primary rounded-xl px-12 shadow-lg shadow-primary/20 transition-all hover:scale-105">
                        {{ __('main.save_changes') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.searchable-select').select2({
                    placeholder: "Select an option",
                    allowClear: true,
                    width: '100%'
                });

                // Photo Preview Logic
                $('#photo-input').change(function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#avatar-preview').attr('src', e.target.result);

                            // Proactively upload if you wish, or user clicks save.
                            // The user requested to see changes.
                        }
                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>
    @endpush
@endsection
