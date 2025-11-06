<script src="{{ asset('metronic/js/core.bundle.js') }}" data-navigate-once></script>
<script src="{{ asset('metronic/vendors/ktui/ktui.min.js') }}" data-navigate-once></script>
<script src="{{ asset('metronic/vendors/apexcharts/apexcharts.min.js') }}" data-navigate-once></script>
<script src="{{ asset('metronic/js/layouts/demo1.js') }}" data-navigate-once></script>
<script src="{{ asset('assets/js/all.min.js') }}"></script>
{{-- Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- Text editor --}}
<script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
{{-- Multiples JS --}}
<script src="{{ asset('assets/js/multiSelectUtils.js') }}"></script>
<script src="{{ asset('assets/js/multiples/specialSelect.js') }}"></script>
<script src="{{ asset('assets/js/multiples/specialCheckbox.js') }}"></script>
<script src="{{ asset('assets/js/multiples/specialSearch.js') }}"></script>
<script src="{{ asset('assets/js/multiples/specialDelete.js') }}"></script>
<script src="{{ asset('assets/js/filterByForeignId.js') }}"></script>
{{-- Helpers --}}
<script src="{{ asset('assets/js/helpers.js') }}"></script>
{{-- Main --}}
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- Compiled App Scripts -->
@vite(['resources/js/app.js'])
@yield('scripts')
@stack('scripts')
