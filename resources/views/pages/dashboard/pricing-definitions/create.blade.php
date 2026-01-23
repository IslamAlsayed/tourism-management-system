@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.pricing-definition')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.pricing-definition')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.pricing-definition')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('pricing-definitions.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.pricing-definitions')]) }}
                </a>
            </div>
        </div>

        @include('components.must-add-first', [
            'requirements' => [
                [
                    'condition' => \App\Models\TransportationCompany::count() > 0,
                    'route' => route('transportation-companies.index'),
                    'label' => __('main.transportations_companies'),
                ],
            ],
        ])
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('pricing-definitions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">
                <!-- Transportation pricings Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.pricing')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            {{-- Name (English) --}}
                            <div class="align-self-end">
                                <label for="name" class="kt-label required">
                                    {{ __('main.name') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="text" class="kt-input h-[45px]" id="name" name="name"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name (Arabic) --}}
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" class="kt-input h-[45px]" id="name_ar" name="name_ar"
                                    value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Key --}}
                            <div>
                                <label for="key" class="kt-label required mb-2">{{ __('main.key') }}</label>
                                <div class="relative">
                                    <input type="text" name="key" id="key" class="kt-input h-[45px] pr-10"
                                        value="{{ old('key', fake()->numerify('PD-#####')) }}" required readonly>

                                    <button type="button" onclick="generateNewKey()" toggle-button
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-primary cursor-pointer hover:text-gray-700">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                @error('key')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="align-self-end">
                                <label for="category" class="kt-label">{{ __('main.category') }}</label>
                                <input type="text" name="category" id="category" class="kt-input h-[45px]"
                                    value="{{ old('category') }}">
                                @error('category')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'description',
                    'value' => old('description'),
                ])

                {{-- Notes --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'notes',
                    'value' => old('notes'),
                ])

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => 1,
                            'label' => __('main.active'),
                        ])
                    </div>
                </div>

                {{-- Save Buttons --}}
                @include('components.elements.save-submit', [
                    'models' => 'pricing-definitions',
                    'model' => 'pricing-definition',
                ])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function generateNewKey() {
            function getRandomCode() {
                const randomNum = Math.floor(Math.random() * 99999) + 1;
                const paddedNum = String(randomNum).padStart(5, '0');
                return 'PD-' + paddedNum;
            }
            document.getElementById('key').value = getRandomCode();
        }
    </script>
@endpush
