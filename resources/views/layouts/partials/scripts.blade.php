<script src="{{ asset('metronic/js/core.bundle.js') }}"></script>
{{-- KTUI loaded via Vite in app.js to avoid double initialization --}}
<script src="{{ asset('metronic/vendors/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('metronic/js/layouts/demo1.js') }}"></script>
{{-- jquery-3.7.1 --}}
<script src="{{ asset('assets/plugins/jquery@3.7.1/jquery-3.7.1.min.js') }}"></script>
{{-- Multiple select plugin --}}
<script src="{{ asset('assets/plugins/select2@4.1.0-rc.0/js/select2.min.js') }}"></script>
{{-- Bootstrap --}}
<script src="{{ asset('assets/plugins/bootstrap@5.3.0/bootstrap.bundle.min.js') }}"></script>
{{-- Text editor --}}
<script src="{{ asset('assets/plugins/trix@2.0.0/trix@2.0.0.js') }}"></script>
{{-- Fontawesome icons pro --}}
<script src="{{ asset('assets/plugins/fontawesome-icons/js/all.min.js') }}"></script>{{-- Multiples JS --}}
<script src="{{ asset('assets/js/multiSelectUtils.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/multiples/specialSelect.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/multiples/specialCheckbox.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/multiples/specialSearch.js') }}?v={{ time() }}"></script>
{{-- <script src="{{ asset('assets/js/multiples/specialDelete.js') }}"></script> --}}
{{-- Helpers --}}
<script src="{{ asset('assets/js/helpers.js') }}?v={{ time() }}"></script>
{{-- Main --}}
<script src="{{ asset('assets/js/main.js') }}?v={{ time() }}"></script>

{{-- @include('components.elements.track-user-status') --}}
<!-- Compiled App Scripts -->
{{-- <script src="{{ asset('assets/plugins/local-ably-cdn/ably.min-1.js') }}"></script>
<script>
    /*
    const ably = new Ably.Realtime({
        key: "{{ config('app.ably_key') }}",
        logLevel: 1
    });
    window.settings = @json(Modules\Core\Entities\Setting::first());

    document.addEventListener("visibilitychange", () => {
        if (document.hidden) {
            ably.close();
        } else {
            ably.connect();
        }
    });
    */
</script>
<script src="{{ asset('assets/plugins/local-ably-cdn/setup.js') }}"></script> --}}

@vite(['resources/js/app.js'])
@yield('scripts')
@stack('scripts')
