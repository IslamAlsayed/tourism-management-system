@props([
    'title',
    'description',
    'models',
    'route' => null,
    'cancelRoute' => null,
    'requirements' => [],
    'options' => [],
    'hasOptions' => false,
    'optionName' => 'importOptions',
    'disabledOptions' => [],
])

@php
    $formRoute = $route ?? route('import.data.post', ['models' => $models]);
    $backRoute = $cancelRoute ?? route("$models.index");
@endphp

<div class="container mx-auto px-6 py-8">
    <div class="flex flex-col">
        <div class="-mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8 p-4">
            <div class="align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 pt-0">
                    <h1 class="text-xl font-semibold">{{ $title }}</h1>
                    <p class="mb-3">{{ $description }}</p>

                    @if ($hasOptions)
                        <div id="import-section">
                            <div class="grid grid-cols-1">
                                @if (count($options) > 0)
                                    @php
                                        $optionChunks = array_chunk($options, ceil(count($options) / 2));
                                    @endphp

                                    @foreach ($optionChunks as $chunk)
                                        <div class="custom-input">
                                            <input type="radio" name="{{ $optionName }}" class="mb-0 toggle-trigger"
                                                id="{{ $item }}" data-toggle-target="{{ $item }}"
                                                data-toggle-id="{{ $item }}" value="{{ $item }}"
                                                {{ in_array($item, $disabledOptions) ? 'disabled' : '' }}>
                                            <label for="{{ $item }}">
                                                @if (in_array($item, $disabledOptions))
                                                    <i class="fas fa-xmark text-red-600"></i>
                                                @endif
                                                {{ __('main.' . $item) }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                                <p class="text-red-600" id="importError" style="display: none">
                                    Please select an option to enable the import functionality.
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Requirements Alerts -->
                    @if (count($requirements) > 0)
                        @php $hasUnmetRequirements = false; @endphp
                        @foreach ($requirements as $requirement)
                            @if (!$requirement['condition'])
                                @php $hasUnmetRequirements = true; @endphp
                            @endif
                        @endforeach

                        @if ($hasUnmetRequirements)
                            <div class="kt-alert text-white flex items-center mb-4" style="background: #ff6166">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ __('main.you_must_add') }}

                                @php $unmetCount = 0; @endphp
                                @foreach ($requirements as $requirement)
                                    @if (!$requirement['condition'])
                                        @php $unmetCount++; @endphp

                                        @if ($unmetCount > 1 && $unmetCount === count(array_filter($requirements, fn($r) => !$r['condition'])))
                                            {{ __('main.and') }}
                                        @elseif($unmetCount > 1)
                                            ,
                                        @endif

                                        <a href="{{ $requirement['route'] }}" class="text-primary underline">
                                            {{ $requirement['label'] }}
                                        </a>
                                    @endif
                                @endforeach
                                {{ __('main.first') }}.
                            </div>
                        @endif
                    @endif

                    <!-- Import Form -->
                    <form action="{{ $formRoute }}" method="POST" enctype="multipart/form-data"
                        class="w-half disabled p-2 rounded-sm"
                        style="background: var(--color-yellow-100); user-select: none;">
                        @csrf

                        <div class="mb-4">
                            <label for="file" class="inline-block text-gray-700 text-sm font-bold mb-2">
                                {{ __('main.import_file') }}
                                <strong>only .csv | .xlsx</strong>
                                <span
                                    class="inline-block bg-primary/10 text-red-600 text-xs font-medium px-2 py-0.5 rounded-full ms-2">
                                    {{ __('sidebar.under_maintenance') }}
                                </span>
                            </label>

                            <input type="file" name="file" id="file" accept=".csv,.xlsx"
                                class="border rounded p-2 block w-full" onchange="handleFileChange()" />

                            @error('file')
                                <p class="text-red-600 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File preview -->
                        <div id="file-preview" class="mb-4 w-full" style="display:none">
                            <h3 class="text-sm font-semibold mb-2">{{ __('main.preview') }}</h3>
                            <div
                                style="max-height:300px; overflow:auto; border:1px solid #e5e7eb; padding:8px; border-radius:6px; background:#fafafa">
                                <table id="preview-table" class="min-w-full text-sm"
                                    style="border-collapse:collapse;width:100%"></table>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="kt-btn kt-btn-primary" id="submit-button" disabled>
                                {{ __('main.upload_and_import') }}
                            </button>
                            <a href="{{ $backRoute }}" class="kt-btn kt-btn-outline ml-4">
                                {{ __('main.cancel') }}
                            </a>
                        </div>
                    </form>

                    <!-- Custom Content Slot -->
                    {{ $slot ?? '' }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <!-- SheetJS for .xlsx parsing -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <script>
        function renderPreview(rows) {
            const preview = document.getElementById('file-preview');
            const table = document.getElementById('preview-table');
            table.innerHTML = '';
            if (!rows || rows.length === 0) {
                preview.style.display = 'none';
                return;
            }
            preview.style.display = 'block';

            const maxCols = Math.max(...rows.map(r => r.length));
            // header (first row)
            const thead = document.createElement('thead');
            const headerRow = document.createElement('tr');
            const headers = rows[0];
            for (let c = 0; c < maxCols; c++) {
                const th = document.createElement('th');
                th.style.border = '1px solid #e5e7eb';
                th.style.padding = '6px';
                th.style.textAlign = 'left';
                th.style.background = '#f3f4f6';
                th.textContent = headers[c] !== undefined ? headers[c] : '';
                headerRow.appendChild(th);
            }
            thead.appendChild(headerRow);
            table.appendChild(thead);

            const tbody = document.createElement('tbody');
            for (let r = 1; r < rows.length; r++) {
                const tr = document.createElement('tr');
                for (let c = 0; c < maxCols; c++) {
                    const td = document.createElement('td');
                    td.style.border = '1px solid #e5e7eb';
                    td.style.padding = '6px';
                    td.textContent = rows[r][c] !== undefined ? rows[r][c] : '';
                    tr.appendChild(td);
                }
                tbody.appendChild(tr);
            }
            table.appendChild(tbody);
        }

        function parseCSV(text) {
            // Simple CSV parser that handles quoted fields
            const rows = [];
            const lines = text.split(/\r?\n/).filter(l => l.trim() !== '');
            for (const line of lines) {
                const row = [];
                let cur = '';
                let inQuotes = false;
                for (let i = 0; i < line.length; i++) {
                    const ch = line[i];
                    if (ch === '"') {
                        if (inQuotes && line[i + 1] === '"') {
                            cur += '"';
                            i++;
                        } else inQuotes = !inQuotes;
                    } else if (ch === ',' && !inQuotes) {
                        row.push(cur);
                        cur = '';
                    } else {
                        cur += ch;
                    }
                }
                row.push(cur);
                rows.push(row);
                if (rows.length >= 11) break; // limit preview to header + 10 rows
            }
            return rows;
        }

        function handleFileChange() {
            const fileInput = document.getElementById('file');
            const submitButton = document.getElementById('submit-button');
            const hasOptions = {{ $hasOptions ? 'true' : 'false' }};

            // manage submit enabling
            if (hasOptions) {
                const selectedOption = document.querySelector('input[name="{{ $optionName }}"]:checked');
                submitButton.disabled = !fileInput.files.length || !selectedOption;
            } else {
                submitButton.disabled = !fileInput.files.length;
            }

            const preview = document.getElementById('file-preview');
            const table = document.getElementById('preview-table');
            table.innerHTML = '';
            if (!fileInput.files || !fileInput.files.length) {
                preview.style.display = 'none';
                return;
            }

            const file = fileInput.files[0];
            const name = file.name.toLowerCase();
            if (name.endsWith('.csv')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const text = e.target.result;
                    const rows = parseCSV(text);
                    // ensure at most header + 10 rows
                    const slice = rows.slice(0, 11);
                    renderPreview(slice);
                };
                reader.readAsText(file);
            } else if (name.endsWith('.xlsx') || name.endsWith('.xls')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, {
                        type: 'array'
                    });
                    const firstSheetName = workbook.SheetNames[0];
                    const worksheet = workbook.Sheets[firstSheetName];
                    const rows = XLSX.utils.sheet_to_json(worksheet, {
                        header: 1
                    });
                    const slice = rows.slice(0, 11);
                    renderPreview(slice);
                };
                reader.readAsArrayBuffer(file);
            } else {
                preview.style.display = 'none';
            }
        }

        @if ($hasOptions)
            // Handle option selection for complex import pages
            document.addEventListener('DOMContentLoaded', function() {
                const optionInputs = document.querySelectorAll('input[name="{{ $optionName }}"]');
                const importError = document.getElementById('importError');
                const fileInput = document.getElementById('file');
                const submitButton = document.getElementById('submit-button');

                optionInputs.forEach(input => {
                    input.addEventListener('change', function() {
                        if (importError) {
                            importError.style.display = 'none';
                        }
                        handleFileChange();
                    });
                });

                // Show error if trying to submit without selection
                if (submitButton) {
                    submitButton.addEventListener('click', function(e) {
                        const selectedOption = document.querySelector(
                            'input[name="{{ $optionName }}"]:checked');
                        if (!selectedOption) {
                            e.preventDefault();
                            if (importError) {
                                importError.style.display = 'block';
                            }
                        }
                    });
                }
            });
        @endif
    </script>
@endpush
