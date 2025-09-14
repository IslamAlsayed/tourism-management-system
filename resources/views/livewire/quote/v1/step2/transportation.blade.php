<div class="kt-card p-4 mb-4">
    <h4 class="text-lg font-semibold mb-3">Transportation</h4>

    <div class="space-y-3">
        <div class="grid lg:grid-cols-5 gap-4 font-semibold text-sm text-gray-500">
            <div>Company</div>
            <div>Bus</div>
            <div>Price Per Day</div>
            <div>Days</div>
            <div>Total</div>
        </div>

        @foreach ($transportCompanies as $company)
            <div class="grid lg:grid-cols-5 gap-4 items-center border-b py-2">
                {{-- الشركة --}}
                <div class="flex items-center gap-2">
                    <label>
                        <input type="checkbox" name="buses[{{ $company->id }}][selected]"
                            wire:model.live="buses.{{ $company->id }}.selected"
                            wire:change="addTransportation({{ $company->id }})" />
                        {{ $company->name }}
                    </label>
                </div>

                {{-- نوع الباص --}}
                <select name="buses[{{ $company->id }}][bus_type_id]"
                    wire:model.live="buses.{{ $company->id }}.bus_type_id" class="kt-select h-[45px]">
                    <option value="">Select Bus</option>
                    @foreach ($company->busTypes as $busType)
                        <option value="{{ $busType->id }}">
                            {{ $busType->name }} ({{ $busType->seats }} seats)
                        </option>
                    @endforeach
                </select>

                {{-- السعر --}}
                <input type="number" name="buses[{{ $company->id }}][price]" readonly
                    value="{{ $buses[$company->id]['price'] ?? 0 }}"
                    class="kt-input h-[45px] bg-gray-100 cursor-not-allowed" />

                {{-- عدد الأيام --}}
                <input type="number" min="0" name="buses[{{ $company->id }}][days]"
                    wire:model.live="buses.{{ $company->id }}.days" class="kt-input h-[45px]" />

                {{-- السعر الإجمالي --}}
                <input type="number" name="buses[{{ $company->id }}][total_price]" readonly
                    value="{{ $buses[$company->id]['total_price'] ?? 0 }}"
                    class="kt-input h-[45px] bg-gray-100 cursor-not-allowed" />
            </div>
        @endforeach
    </div>

    <div class="mt-4 font-semibold">
        Subtotal: {{ $currency_symbol }} {{ number_format($subtotal_transport, 2) }}
    </div>
</div>
