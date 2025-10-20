<!-- Scripts -->
<script src="{{ asset('metronic/js/core.bundle.js') }}" data-navigate-once></script>
<script src="{{ asset('metronic/vendors/ktui/ktui.min.js') }}" data-navigate-once></script>
<script src="{{ asset('metronic/vendors/apexcharts/apexcharts.min.js') }}" data-navigate-once></script>
<script src="{{ asset('metronic/js/layouts/demo1.js') }}" data-navigate-once></script>
<script src="{{ asset('assets/js/all.min.js') }}"></script>

<!-- Scripts -->
{{-- <script src="{{ asset('metronic/js/scripts.bundle.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- End of Scripts -->

{{-- Multiples JS --}}
<script src="{{ asset('assets/js/multiples/specialSelect3.js') }}"></script>
<script src="{{ asset('assets/js/multiples/specialCheckbox.js') }}"></script>
<script src="{{ asset('assets/js/multiples/specialSearch.js') }}"></script>
<script src="{{ asset('assets/js/multiples/specialDelete.js') }}"></script>
<script src="{{ asset('assets/js/filterByForeignId3.js') }}"></script>
<script src="{{ asset('assets/js/helpers.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- Compiled App Scripts -->
@vite(['resources/js/app.js'])
@yield('scripts')
@stack('scripts')
