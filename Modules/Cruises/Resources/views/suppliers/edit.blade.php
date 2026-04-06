@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.cruise-supplier')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.cruise-supplier')]) }}:
                    <span class="text-primary">{{ $supplier->name }}</span>
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.cruises.suppliers.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back') }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <form class="space-y-6" method="POST"
            action="{{ route('dashboard.cruises.suppliers.update', $supplier) }}">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">

                {{-- Basic Information --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.general_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Name EN --}}
                            <div>
                                <label for="name" class="kt-label required mb-2">{{ __('main.name_en') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ old('name', $supplier->name) }}" required>
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name AR --}}
                            <div>
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ old('name_ar', $supplier->name_ar) }}" dir="rtl">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Supplier Type --}}
                            <div>
                                <label for="type" class="kt-label required mb-2">{{ __('main.type') }}</label>
                                <select name="type" id="type" class="kt-input h-[45px]" required>
                                    <option value="">{{ __('main.select_type') }}</option>
                                    @foreach(['ship_owner', 'broker', 'agency', 'operator'] as $typeOption)
                                        <option value="{{ $typeOption }}"
                                            {{ old('type', $supplier->type) === $typeOption ? 'selected' : '' }}>
                                            {{ __('main.' . $typeOption) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Contact Person --}}
                            <div>
                                <label for="contact_person" class="kt-label mb-2">{{ __('main.contact_person') }}</label>
                                <input type="text" name="contact_person" id="contact_person" class="kt-input h-[45px]"
                                    value="{{ old('contact_person', $supplier->contact_person) }}">
                                @error('contact_person')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="phone" class="kt-label mb-2">{{ __('main.phone') }}</label>
                                <input type="text" name="phone" id="phone" class="kt-input h-[45px]"
                                    value="{{ old('phone', $supplier->phone) }}">
                                @error('phone')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="kt-label mb-2">{{ __('main.email') }}</label>
                                <input type="email" name="email" id="email" class="kt-input h-[45px]"
                                    value="{{ old('email', $supplier->email) }}">
                                @error('email')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Website --}}
                            <div>
                                <label for="website" class="kt-label mb-2">{{ __('main.website') }}</label>
                                <input type="url" name="website" id="website" class="kt-input h-[45px]"
                                    value="{{ old('website', $supplier->website) }}" placeholder="https://...">
                                @error('website')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Commission Rate --}}
                            <div>
                                <label for="default_commission_rate" class="kt-label mb-2">
                                    {{ __('main.commission_rate') }} (%)
                                </label>
                                <input type="number" name="default_commission_rate" id="default_commission_rate"
                                    class="kt-input h-[45px]"
                                    value="{{ old('default_commission_rate', $supplier->default_commission_rate) }}"
                                    step="0.01" min="0" max="100">
                                @error('default_commission_rate')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Address --}}
                            <div class="md:col-span-2">
                                <label for="address" class="kt-label mb-2">{{ __('main.address') }}</label>
                                <textarea name="address" id="address" class="kt-input h-24 py-3"
                                    rows="3">{{ old('address', $supplier->address) }}</textarea>
                                @error('address')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contract Information --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.contract_details') }}</h3>
                    </div>
                    <div class="kt-card-body p-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label for="contract_start_date" class="kt-label mb-2">
                                    {{ __('main.contract_start_date') }}
                                </label>
                                <input type="date" name="contract_start_date" id="contract_start_date"
                                    class="kt-input h-[45px]"
                                    value="{{ old('contract_start_date', optional($supplier->contract_start_date)->format('Y-m-d')) }}">
                                @error('contract_start_date')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="contract_end_date" class="kt-label mb-2">
                                    {{ __('main.contract_end_date') }}
                                </label>
                                <input type="date" name="contract_end_date" id="contract_end_date"
                                    class="kt-input h-[45px]"
                                    value="{{ old('contract_end_date', optional($supplier->contract_end_date)->format('Y-m-d')) }}">
                                @error('contract_end_date')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="payment_terms" class="kt-label mb-2">{{ __('main.payment_terms') }}</label>
                                <textarea name="payment_terms" id="payment_terms" class="kt-input h-24 py-3"
                                    rows="3">{{ old('payment_terms', $supplier->payment_terms) }}</textarea>
                                @error('payment_terms')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="notes" class="kt-label mb-2">{{ __('main.notes') }}</label>
                                <textarea name="notes" id="notes" class="kt-input h-24 py-3"
                                    rows="3">{{ old('notes', $supplier->notes) }}</textarea>
                                @error('notes')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="kt-card">
                    <div class="kt-card-body p-6 flex gap-6">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('components.elements.checkbox-button', [
                                'name'    => 'is_active',
                                'id'      => 'is_active',
                                'value'   => '1',
                                'checked' => old('is_active', $supplier->is_active),
                                'label'   => __('main.is_active'),
                            ])
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 mt-4">
                    <a href="{{ route('dashboard.cruises.suppliers.index') }}" class="kt-btn kt-btn-outline">
                        {{ __('main.cancel') }}
                    </a>
                    <button type="submit" class="kt-btn kt-btn-primary">
                        {{ __('main.save_changes') }}
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection
