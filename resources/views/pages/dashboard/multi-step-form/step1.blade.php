@extends('pages.dashboard.multi-step-form.layout', ['step' => 1])

@section('form-content')
    <form action="{{ route('dashboard.multi-step-form.step2') }}" method="POST" class="form" id="kt_form_1">
        @csrf

        <div class="mb-6">
            <h4 class="text-dark text-xl font-semibold mb-2">{{ __('step :number', ['number' => 1]) }}:
                {{ __('select currency') }}</h4>
            <p class="text-gray-600">{{ __('Please select the currency for this booking') }}</p>
        </div>

        <div>
            <div class="grid lg:grid-cols-3 gap-6">
                <div class="mb-10">
                    <!-- Currency -->
                    <label for="currency_id" class="kt-label mb-2">{{ __('main.currency') }}</label>
                    <select name="currency_id" id="currency_id" class="kt-select">
                        <option value="">{{ __('main.select_currency') }}</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ old('currency_id') == $currency->id ? 'selected' : '' }}>
                                {{ $currency->name }} ({{ $currency->code }})
                            </option>
                        @endforeach
                    </select>
                    <div class="fv-plugins-message-container invalid-feedback">
                        Please select a currency.
                    </div>
                    @error('currency')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <button type="submit" class="btn btn-primary next-step">
                    Next Step <i class="ki-duotone ki-arrow-right ms-2"><span class="path1"></span><span
                            class="path2"></span></i>
                </button>
            </div>
        </div>
    </form>
@endsection
