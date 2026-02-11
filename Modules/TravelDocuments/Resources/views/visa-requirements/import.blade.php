@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl" x-data="{ uploadMethod: 'local' }">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                    <span class="size-10 rounded-lg bg-white border border-gray-200 text-primary flex items-center justify-center shadow-sm">
                        <i class="ki-filled ki-folder-add text-xl"></i>
                    </span>
                    {{ __('main.visa_data_manager') }}
                </h1>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('export.data', ['models' => 'visa-requirements']) }}"
                    class="px-3 py-2 rounded-lg border border-gray-200 text-xs font-bold hover:bg-gray-50 bg-white transition-colors flex items-center gap-2">
                    <i class="ki-filled ki-file-up"></i> {{ __('main.export') }}
                </a>
                <a href="{{ route('dashboard.traveldocuments.visa-requirements.index') }}"
                    class="px-3 py-2 rounded-lg bg-gray-100 text-gray-700 text-xs font-bold hover:bg-gray-200 transition-colors flex items-center gap-2">
                    <i class="ki-filled ki-arrow-left"></i> {{ __('main.back') }}
                </a>
            </div>
        </div>

        <!-- SECTION 1: QUICK MANUAL ENTRY (Dynamic Data) -->
        <div class="kt-card bg-white border border-gray-200 rounded-xl shadow-sm mb-8 overflow-hidden">
            <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <span class="size-8 rounded-full bg-primary/10 text-primary flex items-center justify-center ring-4 ring-white">
                    <i class="ki-filled ki-pencil text-sm"></i>
                </span>
                <div>
                    <h2 class="text-sm font-bold text-gray-900">Quick Manual Entry</h2>
                    <p class="text-[11px] text-gray-500">Create a single rule instantly.</p>
                </div>
            </div>

            <div class="p-6">
                <form action="#" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

                        <!-- Row 1: Nationality -->
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wide">Nationality <span class="text-red-500">*</span></label>
                            <select class="w-full text-xs font-medium border border-gray-300 rounded-lg focus:border-primary focus:ring-primary h-10 px-3 bg-white">
                                <option value="">Select Nationality...</option>
                                @if (isset($nationalities) && count($nationalities) > 0)
                                    @foreach ($nationalities as $nationality)
                                        <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Destination -->
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wide">Destination <span class="text-red-500">*</span></label>
                            <select class="w-full text-xs font-medium border border-gray-300 rounded-lg focus:border-primary focus:ring-primary h-10 px-3 bg-white">
                                <option value="">Select Country...</option>
                                @if (isset($countries) && count($countries) > 0)
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Visa Type -->
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wide">Visa Type <span class="text-red-500">*</span></label>
                            <select class="w-full text-xs font-medium border border-gray-300 rounded-lg focus:border-primary focus:ring-primary h-10 px-3 bg-white">
                                @if (isset($visaTypes))
                                    @foreach ($visaTypes as $key => $label)
                                        <option value="{{ $key }}">{{ __('main.' . $key) }}</option>
                                    @endforeach
                                @else
                                    <option value="on_arrival">{{ __('main.on_arrival') }}</option>
                                    <option value="e_visa">{{ __('main.e_visa') }}</option>
                                @endif
                            </select>
                        </div>

                        <!-- Category -->
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wide">Category</label>
                            <select class="w-full text-xs font-medium border border-gray-300 rounded-lg focus:border-primary focus:ring-primary h-10 px-3 bg-white">
                                @if (isset($visaCategories))
                                    @foreach ($visaCategories as $key => $label)
                                        <option value="{{ $key }}">{{ __('main.' . $key) }}</option>
                                    @endforeach
                                @else
                                    <option value="tourist">{{ __('main.tourist') }}</option>
                                @endif
                            </select>
                        </div>

                        <!-- Row 2: Cost & Currency -->
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wide">Costs</label>
                            <div class="flex shadow-sm rounded-lg">
                                <input type="number" placeholder="0.00"
                                    class="flex-1 w-full text-xs font-medium border border-gray-300 rounded-s-lg focus:border-primary focus:ring-primary border-e-0 h-10 px-3">
                                <select
                                    class="w-24 text-xs font-medium border border-gray-300 bg-gray-50 text-gray-600 rounded-e-lg focus:border-primary focus:ring-primary border-s h-10 px-2">
                                    <option>USD</option>
                                    @if (isset($currencies) && count($currencies) > 0)
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}">{{ $currency->code ?? $currency->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <!-- Max Stay -->
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wide">Max Stay</label>
                            <div class="relative">
                                <input type="number" placeholder="Days"
                                    class="w-full text-xs font-medium border border-gray-300 rounded-lg focus:border-primary focus:ring-primary h-10 pl-3 pr-10">
                                <span class="absolute end-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 font-bold uppercase">Days</span>
                            </div>
                        </div>

                        <!-- Validity -->
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wide">Validity</label>
                            <div class="relative">
                                <input type="number" placeholder="Days"
                                    class="w-full text-xs font-medium border border-gray-300 rounded-lg focus:border-primary focus:ring-primary h-10 pl-3 pr-10">
                                <span class="absolute end-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 font-bold uppercase">Days</span>
                            </div>
                        </div>

                        <!-- NEW: Notes / Description (Full Width) -->
                        <div class="col-span-1 md:col-span-2 lg:col-span-3 space-y-1.5">
                            <label class="text-[11px] font-bold text-gray-700 uppercase tracking-wide">Notes / Conditions</label>
                            <textarea placeholder="Add any specific conditions, notes, or descriptions here..."
                                class="w-full text-xs font-medium border border-gray-300 rounded-lg focus:border-primary focus:ring-primary h-10 py-2 px-3 resize-none bg-white"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full h-10 bg-gray-900 hover:bg-black text-white rounded-lg text-xs font-bold transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2 border border-black">
                                <i class="ki-filled ki-plus-square text-sm"></i>
                                {{ __('main.save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- SEPARATOR -->
        <div class="relative flex items-center py-4 mb-8">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="flex-shrink-0 mx-4 text-gray-400 text-[10px] font-bold uppercase tracking-widest bg-white px-2">OR Bulk Action</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <!-- SECTION 2: BULK IMPORT -->
        <form action="{{ route('import.data.post', ['models' => 'visa-requirements']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-5">

                <!-- Step 1: Download -->
                <div
                    class="lg:col-span-3 kt-card border border-gray-200 shadow-sm bg-white rounded-lg p-3 flex flex-col justify-between h-full hover:border-blue-400 transition-colors">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="size-5 rounded flex items-center justify-center bg-blue-50 text-blue-600 text-[10px] font-bold">1</span>
                            <h3 class="text-xs font-bold text-gray-900">{{ __('main.download_template') }}</h3>
                        </div>
                        <p class="text-[10px] text-gray-500 leading-snug mb-2">
                            Includes Name columns for easier bulk editing.
                        </p>
                    </div>
                    <button type="button" onclick="downloadTemplate()"
                        class="w-full flex items-center justify-center gap-1.5 px-3 py-1.5 rounded border border-dashed border-blue-300 text-blue-600 text-[10px] font-bold hover:bg-blue-50 transition-all">
                        <i class="ki-filled ki-file-down"></i>
                        <span>Download CSV</span>
                    </button>
                </div>

                <!-- Step 2: Upload -->
                <div
                    class="lg:col-span-6 kt-card border border-gray-200 shadow-sm bg-white rounded-lg p-3 h-full flex flex-col hover:border-blue-400 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <span class="size-5 rounded flex items-center justify-center bg-blue-50 text-blue-600 text-[10px] font-bold">2</span>
                            <h3 class="text-xs font-bold text-gray-900">{{ __('main.upload_file') }}</h3>
                        </div>
                        <div class="flex bg-gray-100 rounded p-0.5 border border-gray-200">
                            <button type="button" @click="uploadMethod = 'local'"
                                :class="uploadMethod === 'local' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-500'"
                                class="px-2 py-0.5 text-[10px] font-bold rounded transition-all">Local</button>
                            <button type="button" @click="uploadMethod = 'url'"
                                :class="uploadMethod === 'url' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-500'"
                                class="px-2 py-0.5 text-[10px] font-bold rounded transition-all">Link</button>
                        </div>
                    </div>

                    <!-- Local -->
                    <div x-show="uploadMethod === 'local'" class="flex-grow flex flex-col justify-center">
                        <label
                            class="flex flex-col items-center justify-center w-full h-16 border border-dashed border-gray-300 rounded cursor-pointer hover:bg-gray-50 hover:border-primary transition-all group bg-gray-50/50">
                            <div class="flex items-center gap-2">
                                <i class="ki-filled ki-cloud-add text-lg text-gray-400 group-hover:text-primary transition-colors"></i>
                                <span
                                    class="text-[10px] text-gray-600 font-medium group-hover:text-primary transition-colors">{{ __('main.drop_files_here') }}</span>
                            </div>
                            <input name="file" type="file" class="hidden" accept=".csv,.xlsx" onchange="handleFileSelect(this)" />
                        </label>
                        <div id="file_name_container"
                            class="mt-1 hidden text-[10px] flex items-center gap-1 text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                            <i class="ki-filled ki-file"></i> <span id="file_name_display" class="truncate"></span>
                        </div>
                    </div>

                    <!-- URL -->
                    <div x-show="uploadMethod === 'url'" style="display: none;" class="flex-grow flex flex-col justify-center">
                        <div class="relative">
                            <svg class="absolute start-2 top-1/2 -translate-y-1/2 size-3.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4" />
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853" />
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.84z"
                                    fill="#FBBC05" />
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335" />
                            </svg>
                            <input type="url" name="file_url" placeholder="Paste Google Drive / Direct Link"
                                class="w-full ps-7 pe-2 py-1.5 text-[11px] border border-gray-300 rounded focus:border-blue-500 outline-none" />
                        </div>
                    </div>
                </div>

                <!-- Step 3: Config -->
                <div
                    class="lg:col-span-3 kt-card border border-gray-200 shadow-sm bg-white rounded-lg p-3 flex flex-col justify-between h-full hover:border-blue-400 transition-colors">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="size-5 rounded flex items-center justify-center bg-blue-50 text-blue-600 text-[10px] font-bold">3</span>
                            <h3 class="text-xs font-bold text-gray-900">{{ __('main.configuration') }}</h3>
                        </div>
                        <div class="space-y-1.5 mb-2">
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <input type="checkbox" name="has_header" value="1" class="size-3 rounded border-gray-300 text-blue-600 focus:ring-0"
                                    checked>
                                <span class="text-[10px] text-gray-700 font-medium">{{ __('main.has_header') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <input type="checkbox" name="update_existing" value="1" class="size-3 rounded border-gray-300 text-blue-600 focus:ring-0">
                                <span class="text-[10px] text-gray-700 font-medium">{{ __('main.update_existing') }}</span>
                            </label>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-1.5 px-3 py-1.5 rounded bg-blue-600 text-white text-[10px] font-bold hover:bg-blue-700 transition-all shadow-sm border border-transparent">
                        {{ __('main.import_now') }}
                        <i class="ki-filled ki-send"></i>
                    </button>
                </div>
            </div>

            <!-- Ultra Compact Data Table -->
            <div class="kt-card shadow-sm border border-gray-200 bg-white rounded-lg overflow-hidden">
                <div class="px-3 py-2 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                    <h3 class="text-xs font-bold text-gray-800 flex items-center gap-1.5">
                        <i class="ki-filled ki-brifecase-timer text-gray-400"></i>
                        Fields & Structure (name fields supported)
                    </h3>
                </div>

                <div class="overflow-x-auto scrollbar-thin">
                    <table class="w-full text-left border-collapse min-w-max">
                        <thead class="bg-gray-50 text-[9px] text-gray-500 uppercase tracking-tight">
                            <tr class="h-8">
                                @foreach ([
            'nationality' => ['label' => 'Nationality', 'req' => true],
            'destination' => ['label' => 'Destination', 'req' => true],
            'visa_type' => ['label' => 'Visa Type', 'req' => true],
            'visa_category' => ['label' => 'Category', 'req' => true],
            'price' => ['label' => 'Price', 'req' => false],
            'max_stay' => ['label' => 'Stay(Days)', 'req' => false],
            'url' => ['label' => 'App URL', 'req' => false],
        ] as $key => $col)
                                    <th class="px-2 py-1.5 border-b border-e border-gray-100 last:border-e-0">
                                        <span class="font-bold text-gray-800 leading-none">{{ $col['label'] }}</span>
                                        @if ($col['req'])
                                            <span class="text-red-500">*</span>
                                        @endif
                                    </th>
                                @endforeach
                                <th class="px-2 py-1.5 border-b border-gray-100 text-[9px] text-gray-400 italic">... +15 more columns</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-2 py-1.5 border-e border-gray-100 text-[9px] font-medium text-blue-600">Jordan</td>
                                <td class="px-2 py-1.5 border-e border-gray-100 text-[9px] font-medium text-blue-600">Turkey</td>
                                <td class="px-2 py-1.5 border-e border-gray-100 text-[9px] text-gray-600">e_visa</td>
                                <td class="px-2 py-1.5 border-e border-gray-100 text-[9px] text-gray-600">tourist</td>
                                <td class="px-2 py-1.5 border-e border-gray-100 text-[9px] text-gray-600">50 USD</td>
                                <td class="px-2 py-1.5 border-e border-gray-100 text-[9px] text-gray-600">90</td>
                                <td class="px-2 py-1.5 border-e border-gray-100 text-[9px] text-gray-400">https://...</td>
                                <td class="px-2 py-1.5 text-[9px] text-gray-400"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function handleFileSelect(input) {
            const display = document.getElementById('file_name_display');
            const container = document.getElementById('file_name_container');
            if (input.files && input.files.length > 0) {
                display.textContent = input.files[0].name;
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }

        function downloadTemplate() {
            // Headers matching DB schema + Names
            const headers = [
                'id',
                'nationality_name', 'nationality_id',
                'destination_country_name', 'destination_country_id',
                'visa_type', 'visa_category',
                'crossing_port_name', 'crossing_port_id',
                'is_restricted', 'can_issue_at_port', 'max_stay_days',
                'visa_validity_days', 'visa_fee', 'processing_time_days',
                'application_url', 'description', 'notes'
            ];

            const csvContent = "data:text/csv;charset=utf-8," + headers.join(",");
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "visa_smart_template.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
@endsection
