@props([
    'title',
    'description',
    'models',
    'model',
    'view',
    'route' => null,
    'cancelRoute' => null,
    'requirements' => [],
    'options' => [],
    'hasOptions' => false,
    'optionName' => 'importOptions',
    'disabledOptions' => [],
    'googleDriveUrl' => null,
    'lastImport' => null,
    'history' => null,
    'modelClass' => null,
])

@php
    $formRoute = $route ?? route('import.data.post', ['models' => $models]);
    $routePrefix = $view ?? $models;
    $backRoute = $cancelRoute ?? (Route::has("$routePrefix.index") ? route("$routePrefix.index") : url()->previous());
@endphp

<div class="flex flex-col gap-5 lg:gap-7.5">
{{-- ===== PAGE HEADER ===== --}}
<div class="flex flex-wrap items-center justify-between gap-4">
    <div class="flex items-center gap-3">
        <div>
            <h1 class="text-xl font-semibold text-mono">{{ $title }}</h1>
            <p class="text-sm text-secondary-foreground mt-1">{{ $description }}</p>
        </div>
        
        <a href="{{ route('import.template', ['models' => $models]) }}" class="kt-btn kt-btn-dark kt-btn-sm ms-auto group shadow-sm hover:shadow-md transition-all">
            <i class="fa-duotone fa-solid fa-file-arrow-down text-lg"></i>
            {{ __('main.export_template') ?? 'Export Template' }}
        </a>
    </div>

    @if (isset($lastImport) && $lastImport['date'])
        <div class="kt-badge kt-badge-success gap-1.5 px-3 py-2 text-sm">
            <i class="fa-duotone fa-solid fa-check-circle text-base"></i>
            {{ __('main.last_import') ?? 'Last Import' }}:
            <strong>{{ number_format($lastImport['count']) }}</strong>
            {{ __('main.records') ?? 'records' }}
            <span class="opacity-70 text-xs">({{ $lastImport['date'] }})</span>
        </div>
    @endif
</div>

{{-- ===== UNMET REQUIREMENTS ALERT ===== --}}
@if (count($requirements) > 0)
    @php $hasUnmetRequirements = collect($requirements)->contains(fn($r) => !$r['condition']); @endphp
    @if ($hasUnmetRequirements)
        <div class="kt-alert kt-alert-icon kt-alert-destructive">
            <i class="fa-duotone fa-solid fa-circle-info-2 kt-alert-icon-item text-lg"></i>
            <div class="kt-alert-content">
                <div class="kt-alert-title">{{ __('main.requirements_not_met') ?? 'Requirements Not Met' }}</div>
                <div class="kt-alert-description">
                    {{ __('main.you_must_add') }}
                    @php $unmetCount = 0; @endphp
                    @foreach ($requirements as $requirement)
                        @if (!$requirement['condition'])
                            @php $unmetCount++; @endphp
                            @if ($unmetCount > 1)
                                ,
                            @endif
                            <a href="{{ $requirement['route'] }}" class="kt-link font-medium">
                                {{ $requirement['label'] }}
                            </a>
                        @endif
                    @endforeach
                    {{ __('main.first') }}.
                </div>
            </div>
        </div>
    @endif
@endif

{{-- ===== MAIN GRID: Import from URL + Manual Upload ===== --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-7.5">

    {{-- Import from URL Card --}}
    <div class="kt-card">
        <div class="kt-card-header">
            <h3 class="kt-card-title">
                <i class="fa-duotone fa-solid fa-cloud-arrow-down text-primary text-xl me-2"></i>
                {{ __('main.import_from_url') ?? 'Import from URL' }}
            </h3>
        </div>
        <div class="kt-card-content pt-4">
            <form action="{{ route('import.data.drive', ['models' => $models]) }}" method="POST"
                id="drive-import-form">
                @csrf
                {{ $customLogic ?? '' }}
                <input type="hidden" name="model" value="{{ $model }}" />
                <input type="hidden" name="action" id="drive_action" value="save_only">

                <div class="mb-4">
                    <label for="google_drive_url" class="kt-form-label mb-1.5">
                        {{ __('main.import_url') ?? 'Import URL (e.g. Google Drive, Ical)' }}
                    </label>
                    <input type="url" name="google_drive_url" id="google_drive_url" class="kt-input"
                        placeholder="https://..." value="{{ $googleDriveUrl ?? '' }}" required />
                    @error('google_drive_url')
                        <p class="text-destructive text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-secondary-foreground mt-1.5">
                        <i class="fa-duotone fa-solid fa-circle-info-2 me-1"></i>
                        {{ __('main.make_sure_url_is_public') ?? 'Make sure the URL is publicly accessible.' }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <button type="button" class="kt-btn kt-btn-sm kt-btn-outline" onclick="confirmDriveSave()">
                        <i class="fa-duotone fa-solid fa-bookmark me-1.5"></i>
                        {{ __('main.save_link_only') ?? 'Save Link Only' }}
                    </button>
                    <button type="button" class="kt-btn kt-btn-sm kt-btn-primary" onclick="confirmDriveUpdate()">
                        <i class="fa-duotone fa-solid fa-arrows-rotate me-1.5"></i>
                        {{ __('main.update_from_url') ?? 'Update Data' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Manual Upload Card --}}
    <div class="kt-card">
        <div class="kt-card-header">
            <h3 class="kt-card-title">
                <i class="fa-duotone fa-solid fa-file-arrow-up text-success text-xl me-2"></i>
                {{ __('main.manual_file_upload') ?? 'Manual File Upload' }}
            </h3>
        </div>
        <div class="kt-card-content pt-4">
            <form action="{{ $formRoute }}" method="POST" enctype="multipart/form-data" id="manual-import-form">
                @csrf
                {{ $customLogic ?? '' }}
                <input type="hidden" name="model" value="{{ $model }}" />

                @if ($hasOptions && count($options) > 0)
                    <div class="mb-4">
                        <label class="kt-form-label mb-1.5">{{ __('main.import_type') ?? 'Import Type' }}</label>
                        <div class="flex flex-col gap-2">
                            @foreach ($options as $item)
                                <label
                                    class="flex items-center gap-2 cursor-pointer {{ in_array($item, $disabledOptions) ? 'opacity-50 cursor-not-allowed' : '' }}">
                                    <input type="radio" name="{{ $optionName }}" value="{{ $item }}"
                                        id="opt_{{ $item }}" class="kt-radio"
                                        {{ in_array($item, $disabledOptions) ? 'disabled' : '' }}
                                        onchange="handleFileChange()">
                                    <span class="text-sm">
                                        @if (in_array($item, $disabledOptions))
                                            <i class="fa-duotone fa-solid fa-xmark text-destructive me-1"></i>
                                        @endif
                                        {{ __('main.' . $item) }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        <p class="text-destructive text-xs mt-1" id="importError" style="display:none;">
                            {{ __('main.please_select_option') ?? 'Please select an import type.' }}
                        </p>
                    </div>
                @endif

                <div class="mb-4">
                    <label for="file" class="kt-form-label mb-1.5">
                        {{ __('main.import_file') }}
                        <span class="text-secondary-foreground font-normal text-xs ms-1">(.csv, .xlsx)</span>
                    </label>
                    <input type="file" name="file" id="file" accept=".csv,.xlsx" class="kt-input py-2"
                        onchange="handleFileChange()" />
                    @error('file')
                        <p class="text-destructive text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- File Preview --}}
                <div id="file-preview" class="mb-4" style="display:none">
                    <label class="kt-form-label mb-1.5">{{ __('main.preview') ?? 'Preview' }}</label>
                    <div class="kt-scrollable border border-border rounded-md" style="max-height:220px; overflow:auto;">
                        <table id="preview-table" class="kt-table kt-table-border text-xs"></table>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="kt-btn kt-btn-sm kt-btn-primary" id="submit-button" toggle-button>
                        <i class="fa-duotone fa-solid fa-file-arrow-up me-1.5"></i>
                        {{ __('main.upload_and_import') }}
                    </button>
                    <a href="{{ $backRoute }}" class="kt-btn kt-btn-sm kt-btn-outline">
                        {{ __('main.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== CUSTOM SLOT ===== --}}
{{ $slot ?? '' }}

{{-- ===== IMPORT HISTORY TABLE ===== --}}
@livewire('import-history-table', ['modelType' => $modelClass ?? $model])
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            const thead = document.createElement('thead');
            const headerRow = document.createElement('tr');
            rows[0].forEach((h, i) => {
                const th = document.createElement('th');
                th.textContent = h !== undefined ? h : '';
                headerRow.appendChild(th);
            });
            thead.appendChild(headerRow);
            table.appendChild(thead);
            const tbody = document.createElement('tbody');
            for (let r = 1; r < rows.length; r++) {
                const tr = document.createElement('tr');
                for (let c = 0; c < maxCols; c++) {
                    const td = document.createElement('td');
                    td.textContent = rows[r][c] !== undefined ? rows[r][c] : '';
                    tr.appendChild(td);
                }
                tbody.appendChild(tr);
            }
            table.appendChild(tbody);
        }

        function parseCSV(text) {
            const rows = [];
            const lines = text.split(/\r?\n/).filter(l => l.trim() !== '');
            for (const line of lines) {
                const row = [];
                let cur = '',
                    inQuotes = false;
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
                    } else cur += ch;
                }
                row.push(cur);
                rows.push(row);
                if (rows.length >= 11) break;
            }
            return rows;
        }

        function handleFileChange() {
            const fileInput = document.getElementById('file');
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
                reader.onload = e => renderPreview(parseCSV(e.target.result).slice(0, 11));
                reader.readAsText(file);
            } else if (name.endsWith('.xlsx') || name.endsWith('.xls')) {
                const reader = new FileReader();
                reader.onload = e => {
                    const wb = XLSX.read(new Uint8Array(e.target.result), {
                        type: 'array'
                    });
                    const ws = wb.Sheets[wb.SheetNames[0]];
                    renderPreview(XLSX.utils.sheet_to_json(ws, {
                        header: 1
                    }).slice(0, 11));
                };
                reader.readAsArrayBuffer(file);
            } else {
                preview.style.display = 'none';
            }
        }

        @if ($hasOptions)
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('input[name="{{ $optionName }}"]').forEach(input => {
                    input.addEventListener('change', function() {
                        const err = document.getElementById('importError');
                        if (err) err.style.display = 'none';
                        handleFileChange();
                    });
                });
            });
        @endif

        function confirmDriveSave() {
            const url = document.getElementById('google_drive_url').value;
            if (!url) {
                Swal.fire({
                    title: '{{ __('main.error') ?? 'Error' }}',
                    text: '{{ __('main.please_enter_valid_url') ?? 'Please enter a valid URL' }}',
                    icon: 'error'
                });
                return;
            }
            Swal.fire({
                title: '{{ __('main.drive_save_confirm_title') ?? 'Save Link?' }}',
                text: '{{ __('main.drive_save_confirm_message') ?? 'Save this link without importing data now?' }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '{{ __('main.save') ?? 'Save' }}',
                cancelButtonText: '{{ __('main.cancel') ?? 'Cancel' }}'
            }).then(r => {
                if (r.isConfirmed) {
                    document.getElementById('drive_action').value = 'save_only';
                    document.getElementById('drive-import-form').submit();
                }
            });
        }

        function confirmDriveUpdate() {
            const url = document.getElementById('google_drive_url').value;
            if (!url) {
                Swal.fire({
                    title: '{{ __('main.error') ?? 'Error' }}',
                    text: '{{ __('main.please_enter_valid_url') ?? 'Please enter a valid URL' }}',
                    icon: 'error'
                });
                return;
            }
            Swal.fire({
                title: '{{ __('main.drive_update_confirm_title') ?? 'Confirm Import from URL' }}',
                html: '<b>{{ __('main.drive_update_confirm_line1') ?? 'Are you sure you want to fetch and import data from this URL?' }}</b><br><br>' +
                    '<div style="text-align:start">' +
                    '• {{ __('main.drive_update_confirm_line2') ?? 'New records will be added.' }}<br>' +
                    '• {{ __('main.drive_update_confirm_line3') ?? 'Existing records will be updated by name.' }}<br>' +
                    '• {{ __('main.drive_update_confirm_line4') ?? 'Records not in the file will NOT be deleted.' }}' +
                    '</div>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: '{{ __('main.yes_update_it') ?? 'Yes, import!' }}',
                cancelButtonText: '{{ __('main.cancel') ?? 'Cancel' }}'
            }).then(r => {
                if (r.isConfirmed) {
                    Swal.fire({
                        title: '{{ __('main.fetching') ?? 'Importing...' }}',
                        html: '<p style="font-size:14px;color:#6b7280;margin-top:8px">{{ __('main.please_wait_downloading') ?? 'Downloading file from URL... Please wait.' }}</p>',
                        allowOutsideClick: false,
                        width: '400px',
                        didOpen: () => Swal.showLoading()
                    });
                    document.getElementById('drive_action').value = 'update';
                    document.getElementById('drive-import-form').submit();
                }
            });
        }

        function confirmClearHistory() {
            Swal.fire({
                title: '{{ __('main.clear_history_confirm_title') ?? 'Clear Import History?' }}',
                text: '{{ __('main.clear_history_confirm_message') ?? 'This will delete all import history records. This action cannot be undone.' }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: '{{ __('main.yes_clear') ?? 'Yes, clear it!' }}',
                cancelButtonText: '{{ __('main.cancel') ?? 'Cancel' }}'
            }).then(r => {
                if (r.isConfirmed) document.getElementById('clear-history-form').submit();
            });
        }
    </script>
@endpush
