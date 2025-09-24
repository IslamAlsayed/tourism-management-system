<!-- Scripts -->
<script src="{{ asset('metronic/js/core.bundle.js') }}" data-navigate-once></script>
<script src="{{ asset('metronic/vendors/ktui/ktui.min.js') }}" data-navigate-once></script>
<script src="{{ asset('metronic/vendors/apexcharts/apexcharts.min.js') }}" data-navigate-once></script>
<script src="{{ asset('metronic/js/layouts/demo1.js') }}" data-navigate-once></script>

<!-- Scripts -->
{{-- <script src="{{ asset('metronic/js/scripts.bundle.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- End of Scripts -->

{{-- Multi Select JS --}}
<script src="{{ asset('assets/js/multiSelect.js') }}"></script>
<script src="{{ asset('assets/js/multiCheckbox.js') }}"></script>
<script src="{{ asset('assets/js/multiDelete.js') }}"></script>
<script src="{{ asset('assets/js/helpers.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>


{{-- <script type="module" src="{{ asset('assets/js/main.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/special-multiple.js') }}"></script> --}}

<!-- Livewire Pagination Fix -->
{{-- <script>
    document.addEventListener('livewire:init', () => {
        // Handle pagination select synchronization
        Livewire.hook('morph.updated', ({
            component,
            cleanup
        }) => {
            // Find pagination select elements
            const paginateSelects = document.querySelectorAll('[wire\\:model*="paginate"]');

            paginateSelects.forEach(select => {
                // Get the current component paginate value
                const componentData = component.snapshot.data;
                if (componentData && componentData.paginate) {
                    select.value = componentData.paginate;
                    // Trigger change event to ensure Livewire is aware
                    select.dispatchEvent(new Event('change'));
                }
            });
        });

        // Handle component hydration (page refresh) - CRITICAL FOR LARGE VALUES
        Livewire.hook('component.init', ({
            component,
            cleanup
        }) => {
            // Multiple attempts to ensure value is set correctly
            const setSelectValue = () => {
                const paginateSelects = document.querySelectorAll('[wire\\:model*="paginate"]');

                paginateSelects.forEach(select => {
                    const componentData = component.snapshot.data;
                    const sessionValue = @json(session('paginate_count'));

                    // Use session value as primary source of truth
                    const correctValue = sessionValue || componentData?.paginate ||
                        @json(config('app.paginate_count'));

                    if (correctValue && select.value !== correctValue.toString()) {
                        select.value = correctValue;
                        // Force Livewire to sync
                        select.dispatchEvent(new Event('input', {
                            bubbles: true
                        }));
                    }
                });
            };

            // Multiple timing attempts for different scenarios
            setTimeout(setSelectValue, 50); // First attempt
            setTimeout(setSelectValue, 150); // Second attempt
            setTimeout(setSelectValue, 300); // Third attempt for slow connections
        });
    });

    // Page load synchronization - ESSENTIAL FOR PAGE REFRESH
    document.addEventListener('DOMContentLoaded', function() {
        const sessionValue = @json(session('paginate_count'));
        const configValue = @json(config('app.paginate_count'));

        // Set correct value immediately on page load
        const setInitialValue = () => {
            const paginateSelects = document.querySelectorAll(
                'select[name="paginate"], [wire\\:model*="paginate"]');

            paginateSelects.forEach(select => {
                const correctValue = sessionValue || configValue;

                if (correctValue && select.value !== correctValue.toString()) {
                    select.value = correctValue;
                    console.log('Pagination: Set select value to', correctValue, 'from session:',
                        sessionValue);
                }
            });
        };

        setInitialValue();

        // Also set after a brief delay for safety
        setTimeout(setInitialValue, 100);
    });

    // Listen for page visibility changes (when user returns to tab)
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            const sessionValue = @json(session('paginate_count'));
            if (sessionValue) {
                const paginateSelects = document.querySelectorAll('select[name="paginate"]');
                paginateSelects.forEach(select => {
                    if (select.value !== sessionValue.toString()) {
                        select.value = sessionValue;
                    }
                });
            }
        }
    });
</script> --}}

<!-- Compiled App Scripts -->
@vite(['resources/js/app.js'])
@yield('scripts')
@stack('scripts')
