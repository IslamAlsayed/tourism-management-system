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
    'additionalInputs' => [],
    'showExport' => true,
    'customExportId' => null,
])

@php
    $formRoute = $route ?? route('import.data.post', ['models' => $models]);
    $backRoute = $cancelRoute ?? route("$models.index");
@endphp

<div class="container mx-auto px-6 py-8">
    <div class="flex flex-col">
        <div class="-mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8 p-4">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h1 class="text-xl font-semibold mb-6">{{ $title }}</h1>
                    <p class="mb-6">{{ $description }}</p>

                    @if ($hasOptions)
                        <div id="import-section">
                            <div class="grid grid-cols-1">
                                @if (count($options) > 0)
                                    @php
                                        $optionChunks = array_chunk($options, ceil(count($options) / 2));
                                    @endphp

                                    @foreach ($optionChunks as $chunk)
                                        <div class="inline-flex flex-wrap gap-4 mb-4">
                                            @foreach ($chunk as $item)
                                                <div class="custom-input">
                                                    <input type="radio" name="{{ $optionName }}"
                                                        class="mb-0 toggle-trigger" id="{{ $item }}"
                                                        data-toggle-target="{{ $item }}"
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
                            <div class="kt-alert text-block flex items-center mb-4" style="background: #ff7c7f">
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

                    <div>
                        <!-- Import Form -->
                        <form action="{{ $formRoute }}" method="POST" enctype="multipart/form-data" class="w-half"
                            id="importForm">
                            @csrf

                            <!-- Additional Hidden Inputs -->
                            @foreach ($additionalInputs as $input)
                                <input type="hidden" name="{{ $input['name'] }}" id="{{ $input['id'] }}"
                                    value="{{ $input['value'] ?? '' }}" />
                            @endforeach

                            <div class="mb-4">
                                <label for="file" class="inline-block text-gray-700 text-sm font-bold mb-2">
                                    {{ __('main.import_file') }}
                                    <strong>only (.csv,.xlsx,.xls)</strong>
                                </label>

                                <input type="file" name="file" id="file" accept=".csv,.xlsx,.xls"
                                    class="border rounded p-2 block w-full" onchange="handleFileChange()" />

                                @error('file')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
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

                        @if ($showExport)
                            <div class="mt-4">
                                <a href="{{ route('export.data', ['models' => $models]) }}"
                                    @if ($customExportId) id="{{ $customExportId }}" @endif
                                    data-model="{{ $model }}" class="kt-btn kt-btn-outline">
                                    {{ __('main.export') }}
                                </a>
                            </div>
                        @endif

                        <!-- Custom Content Slot for additional tables/content -->
                        {{ $slot ?? '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function handleFileChange() {
            const fileInput = document.getElementById('file');
            const submitButton = document.getElementById('submit-button');
            const hasOptions = {{ $hasOptions ? 'true' : 'false' }};

            if (hasOptions) {
                // For pages with options, check both file and option selection
                const selectedOption = document.querySelector('input[name="{{ $optionName }}"]:checked');
                submitButton.disabled = !fileInput.files.length || !selectedOption;
            } else {
                // For simple pages, just check file
                submitButton.disabled = !fileInput.files.length;
            }
        }

        @if ($hasOptions)
            // Handle option selection for complex import pages
            document.addEventListener('DOMContentLoaded', function() {
                const optionInputs = document.querySelectorAll('input[name="{{ $optionName }}"]');
                const importError = document.getElementById('importError');
                const fileInput = document.getElementById('file');
                const submitButton = document.getElementById('submit-button');

                // Handle option changes
                optionInputs.forEach(input => {
                    input.addEventListener('change', function() {
                        if (importError) {
                            importError.style.display = 'none';
                        }

                        // Update hidden inputs if they exist
                        @foreach ($additionalInputs as $input)
                            @if (str_contains($input['name'], 'Type'))
                                const {{ $input['id'] }} = document.getElementById(
                                    '{{ $input['id'] }}');
                                if ({{ $input['id'] }}) {
                                    {{ $input['id'] }}.value = this.value;
                                }
                            @endif
                        @endforeach

                        // Handle target visibility for accommodations-style pages
                        const targetElements = document.querySelectorAll('.target-trigger');
                        targetElements.forEach(element => {
                            element.style.display = 'none';
                        });

                        const targetElement = document.querySelector(
                            `[data-${this.value}-target="${this.value}"]`);
                        if (targetElement) {
                            targetElement.style.display = 'block';
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
