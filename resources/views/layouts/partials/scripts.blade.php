<script src="{{ asset('metronic/js/core.bundle.js') }}" data-navigate-once></script>
<script src="{{ asset('metronic/vendors/ktui/ktui.min.js') }}" data-navigate-once></script>
<script src="{{ asset('metronic/vendors/apexcharts/apexcharts.min.js') }}" data-navigate-once></script>
<script src="{{ asset('metronic/js/layouts/demo1.js') }}" data-navigate-once></script>
{{-- Bootstrap --}}
<script src="{{ asset('assets/plugins/bootstrap@5.3.0/bootstrap.bundle.min.js') }}"></script>
{{-- Text editor --}}
<script src="{{ asset('assets/plugins/trix@2.0.0/trix@2.0.0.js') }}"></script>
{{-- Fontawesome icons pro --}}
<script src="{{ asset('assets/plugins/fontawesome-icons/js/all.min.js') }}"></script>{{-- Multiples JS --}}
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

{{-- @include('components.elements.track-user-status') --}}
<!-- Compiled App Scripts -->
<script src="{{ asset('assets/plugins/local-ably-cdn/ably.min-1.js') }}"></script>
<script>
    const ably = new Ably.Realtime({
        key: "{{ config('app.ably_key') }}",
    });
    window.settings = @json(App\Models\Setting::first());
</script>
<script src="{{ asset('assets/plugins/local-ably-cdn/setup.js') }}"></script>

@vite(['resources/js/app.js'])
@yield('scripts')
@stack('scripts')
