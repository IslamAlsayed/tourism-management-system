

<div>
    @if (session()->has('message'))
        <div class="alert alert-success mb-2">
            {{ session('message') }}
        </div>
    @endif


    <!-- Advanced Toolbar (Metronic RTL style, all in one row, no duplicates) -->
    <div class="flex flex-row-reverse flex-wrap items-center gap-2 p-4 w-full">
        <input type="text" wire:model.debounce.500ms="search" placeholder="{{ __('بحث عن بلد') }}" class="kt-input min-w-[180px]" />
        <select wire:model="status" class="kt-select min-w-[150px]">
            <option value="">{{ __('اختر الحالة') }}</option>
            <option value="active">{{ __('نشط') }}</option>
            <option value="inactive">{{ __('غير نشط') }}</option>
        </select>
        <select wire:model="sort" class="kt-select min-w-[150px]">
            <option value="">{{ __('ترتيب حسب') }}</option>
            <option value="name_asc">{{ __('الاسم (أ-ي)') }}</option>
            <option value="name_desc">{{ __('الاسم (ي-أ)') }}</option>
            <option value="created_desc">{{ __('الأحدث') }}</option>
            <option value="created_asc">{{ __('الأقدم') }}</option>
        </select>
        <!-- Show/Hide Columns -->
        <div class="relative">
            <button type="button" class="kt-btn kt-btn-outline flex items-center gap-1" onclick="document.getElementById('columnsDropdown').classList.toggle('hidden')">
                <i class="ki-filled ki-setting-4"></i> {{ __('إظهار/إخفاء الأعمدة') }}
            </button>
            <div id="columnsDropdown" class="absolute z-10 bg-white border rounded shadow p-3 mt-2 hidden min-w-[200px]">
                <label class="flex items-center gap-2 mb-1"><input type="checkbox" checked disabled> #</label>
                <label class="flex items-center gap-2 mb-1"><input type="checkbox" checked disabled> {{ __('العلم') }}</label>
                <label class="flex items-center gap-2 mb-1"><input type="checkbox" checked> {{ __('الاسم') }}</label>
                <label class="flex items-center gap-2 mb-1"><input type="checkbox" checked> {{ __('الكود') }}</label>
                <label class="flex items-center gap-2 mb-1"><input type="checkbox" checked> {{ __('العملة') }}</label>
                <label class="flex items-center gap-2 mb-1"><input type="checkbox" checked> {{ __('العاصمة') }}</label>
                <label class="flex items-center gap-2 mb-1"><input type="checkbox" checked> {{ __('كود الهاتف') }}</label>
                <label class="flex items-center gap-2 mb-1"><input type="checkbox" checked> {{ __('القارة') }}</label>
                <label class="flex items-center gap-2 mb-1"><input type="checkbox" checked> {{ __('عدد السكان') }}</label>
                <label class="flex items-center gap-2 mb-1"><input type="checkbox" checked> {{ __('المساحة') }}</label>
                <label class="flex items-center gap-2 mb-1"><input type="checkbox" checked> {{ __('الحالة') }}</label>
                <label class="flex items-center gap-2 mb-1"><input type="checkbox" checked> {{ __('تاريخ الإنشاء') }}</label>
            </div>
        </div>
        <button class="kt-btn kt-btn-sm kt-btn-primary" wire:click="bulkEdit" @if(empty($selected)) disabled @endif>
            <i class="ki-filled ki-pencil"></i> {{ __('تعديل جماعي') }}
        </button>
        <div class="text-sm text-gray-600 whitespace-nowrap ms-auto">
            {{ __('عرض') }} {{ $data->count() }} {{ __('من') }} {{ $data->total() }} {{ __('بلد') }}
        </div>
    </div>

    <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="country_table">
        <div class="kt-scrollable-x-auto">
            <table class="kt-table table-auto kt-table-border" data-kt-datatable-table="true">
            <thead>
                <tr>
                    <th class="w-[40px] text-center">#</th>
                    <th class="w-[60px] text-center">{{ __('العلم') }}</th>
                    <th class="min-w-[180px]">{{ __('الاسم') }}</th>
                    <th class="min-w-[80px]">{{ __('الكود') }}</th>
                    <th class="min-w-[100px]">{{ __('العملة') }}</th>
                    <th class="min-w-[120px]">{{ __('العاصمة') }}</th>
                    <th class="min-w-[100px]">{{ __('كود الهاتف') }}</th>
                    <th class="min-w-[100px]">{{ __('القارة') }}</th>
                    <th class="min-w-[120px]">{{ __('عدد السكان') }}</th>
                    <th class="min-w-[100px]">{{ __('المساحة') }}</th>
                    <th class="min-w-[80px]">{{ __('الحالة') }}</th>
                    <th class="min-w-[120px]">{{ __('تاريخ الإنشاء') }}</th>
                    <th class="w-[60px]"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $country)
                    <tr>
                        <td class="text-center">
                            <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true" type="checkbox" value="{{ $country->id }}" wire:model="selected">
                            <div class="text-xs text-gray-400">{{ $country->id }}</div>
                        </td>
                        <td class="text-center">
                            @if($country->flag_url)
                                <img alt="" class="rounded-full size-7 mx-auto" src="{{ $country->flag_url }}">
                            @elseif($country->flag_emoji)
                                <span class="text-2xl">{{ $country->flag_emoji }}</span>
                            @else
                                <span class="text-2xl">🏳️</span>
                            @endif
                        </td>
                        <td class="font-medium text-mono">{{ $country->name }}</td>
                        <td>{{ $country->code }}</td>
                        <td>{{ $country->currency_code }}</td>
                        <td>{{ $country->capital }}</td>
                        <td>{{ $country->phone_code }}</td>
                        <td>{{ $country->continent }}</td>
                        <td>{{ number_format($country->population) }}</td>
                        <td>{{ $country->area }}</td>
                        <td>
                            <button wire:click="toggleActive({{ $country->id }})" class="px-2 py-1 rounded text-xs font-semibold {{ $country->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $country->is_active ? __('نشط') : __('غير نشط') }}
                            </button>
                        </td>
                        <td>{{ $country->created_at ? $country->created_at->format('Y-m-d') : '-' }}</td>
                        <td>
                            <div class="kt-menu" data-kt-menu="true">
                                <div class="kt-menu-item" data-kt-menu-item-offset="0, 10px" data-kt-menu-item-placement="bottom-end" data-kt-menu-item-toggle="dropdown" data-kt-menu-item-trigger="click">
                                    <button class="kt-menu-toggle kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost">
                                        <i class="ki-filled ki-dots-vertical text-lg"></i>
                                    </button>
                                    <div class="kt-menu-dropdown kt-menu-default w-full max-w-[200px]" data-kt-menu-dismiss="true">
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="{{ route('countries.show', $country->id) }}">
                                                <span class="kt-menu-icon"><i class="ki-filled ki-eye"></i></span>
                                                <span class="kt-menu-title">{{ __('عرض') }}</span>
                                            </a>
                                        </div>
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="{{ route('countries.edit', $country->id) }}">
                                                <span class="kt-menu-icon"><i class="ki-filled ki-pencil"></i></span>
                                                <span class="kt-menu-title">{{ __('تعديل') }}</span>
                                            </a>
                                        </div>
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="#" onclick="event.preventDefault(); @this.call('makeCopy', {{ $country->id }})">
                                                <span class="kt-menu-icon"><i class="ki-filled ki-copy"></i></span>
                                                <span class="kt-menu-title">{{ __('نسخ') }}</span>
                                            </a>
                                        </div>
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="#" onclick="event.preventDefault(); if(confirm('{{ __('هل أنت متأكد من الحذف؟') }}')) { @this.call('delete', {{ $country->id }}) }">
                                                <span class="kt-menu-icon"><i class="ki-filled ki-trash"></i></span>
                                                <span class="kt-menu-title">{{ __('حذف') }}</span>
                                            </a>
                                        </div>
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="#" onclick="event.preventDefault(); @this.call('toggleActive', {{ $country->id }})">
                                                <span class="kt-menu-icon"><i class="ki-filled {{ $country->is_active ? 'ki-cross' : 'ki-check' }}"></i></span>
                                                <span class="kt-menu-title">{{ $country->is_active ? __('تعطيل') : __('تفعيل') }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination & Per Page -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 p-4">
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <span>{{ __('Show') }}</span>
            <select wire:model.live="perPage" class="kt-select w-20 px-2 py-1 border rounded">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span>{{ __('per page') }}</span>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-sm text-gray-600">
                {{ $data->firstItem() }} - {{ $data->lastItem() }} {{ __('of') }} {{ $data->total() }}
            </div>
            @if($data->hasPages())
            <div class="flex items-center gap-1">
                @if ($data->onFirstPage())
                    <span class="px-3 py-1 text-gray-400 bg-gray-200 rounded cursor-not-allowed">{{ __('Previous') }}</span>
                @else
                    <button wire:click="previousPage" class="px-3 py-1 text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50">
                        {{ __('Previous') }}
                    </button>
                @endif
                @for ($i = max(1, $data->currentPage() - 2); $i <= min($data->lastPage(), $data->currentPage() + 2); $i++)
                    @if ($i == $data->currentPage())
                        <span class="px-3 py-1 text-white bg-blue-600 rounded">{{ $i }}</span>
                    @else
                        <button wire:click="gotoPage({{ $i }})" class="px-3 py-1 text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50">
                            {{ $i }}
                        </button>
                    @endif
                @endfor
                @if ($data->hasMorePages())
                    <button wire:click="nextPage" class="px-3 py-1 text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50">
                        {{ __('Next') }}
                    </button>
                @else
                    <span class="px-3 py-1 text-gray-400 bg-gray-200 rounded cursor-not-allowed">{{ __('Next') }}</span>
                @endif
            </div>
            @endif
        </div>
    </div>
    <!-- FAQ Section -->
    <div class="mt-8">
        <div class="kt-card">
            <div class="kt-card-header">
                <h3 class="kt-card-title">{{ __('FAQ') }}</h3>
            </div>
            <div class="kt-card-body">
                <ul class="list-disc pl-6">
                    <li>{{ __('How to add a new country?') }}</li>
                    <li>{{ __('How to edit or delete a country?') }}</li>
                    <li>{{ __('How to use bulk edit?') }}</li>
                    <li>{{ __('All content and questions appear in the selected language automatically.') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
