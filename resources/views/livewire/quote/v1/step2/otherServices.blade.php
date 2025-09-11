<div class="kt-card p-4 mb-4">
    <h4 class="text-lg font-semibold mb-3">Other Services</h4>

    <div class="space-y-3">
        <div class="grid lg:grid-cols-5 gap-4 font-semibold text-sm text-gray-500">
            <div>Service</div>
            <div>Quantity</div>
            <div>Price per person</div>
            <div>Unit Price</div>
            <div>Total Price</div>
        </div>

        @foreach ($otherServices as $service)
            <div class="grid lg:grid-cols-5 gap-4 items-center">
                {{-- اختيار الخدمة --}}
                <div class="flex items-center gap-2">
                    <label>
                        <input type="checkbox" name="services[{{ $service->id }}][selected]"
                            wire:model.live="services.{{ $service->id }}.selected"
                            wire:change="addService({{ $service->id }})" />
                        {{ $service->name_en ?? $service->name }}
                    </label>
                </div>

                {{-- الكمية --}}
                <input type="number" min="1" wire:model.live="services.{{ $service->id }}.quantity"
                    class="kt-input" placeholder="Quantity" />

                {{-- السعر للفرد --}}
                <input type="number" readonly class="kt-input bg-gray-100 cursor-not-allowed"
                    value="{{ $services[$service->id]['total_price'] / $groups }}" />

                {{-- السعر --}}
                <input type="number" readonly wire:model="services.{{ $service->id }}.price"
                    class="kt-input bg-gray-100 cursor-not-allowed" />

                {{-- السعر الإجمالي --}}
                <input type="number" name="services[{{ $service->id }}][total_price]" readonly
                    value="{{ $services[$service->id]['total_price'] ?? 0 }}"
                    class="kt-input bg-gray-100 cursor-not-allowed" />
            </div>
        @endforeach
    </div>

    Subtotal: {{ $currency_symbol }} {{ number_format($subtotal_services, 2) }}
</div>
</div>


@push('scripts')
    <script>
        // console.log(50 % 6)
        // console.log(8 % 6)

        console.log(18 * 50);
        console.log((9 * 100) / 50)
        console.log('1', 100 / (1 % 6))
        console.log('2', 100 / (2 % 6))
        console.log('3', 100 / (3 % 6))
        console.log('4', 100 / (4 % 6))
        console.log('5', 100 / (5 % 6))
        console.log('6', 100 / 6)
    </script>
@endpush
