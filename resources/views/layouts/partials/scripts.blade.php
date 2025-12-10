<script src="{{ asset('metronic/js/core.bundle.js') }}" data-navigate-once></script>
<script src="{{ asset('metronic/vendors/ktui/ktui.min.js') }}" data-navigate-once></script>
{{-- <script>
    // Safe initializers for KT components used with Livewire
    (function() {
        // Initialize datatables only when a real <table> exists
        function safeInitDataTables() {
            try {
                var containers = document.querySelectorAll('[data-kt-datatable="true"]');
                if (!containers || containers.length == 0) return;

                var valid = Array.prototype.filter.call(containers, function(el) {
                    return !!el.querySelector('table[data-kt-datatable-table="true"]');
                });
                if (!valid || valid.length == 0) return;

                if (typeof window.initAllDataTables == 'function') {
                    window.initAllDataTables();
                    return;
                }

                if (window.KTDataTable && typeof window.KTDataTable.createInstances == 'function') {
                    valid.forEach(function(el) {
                        try {
                            if (typeof window.KTDataTable.getOrCreateInstance == 'function') {
                                window.KTDataTable.getOrCreateInstance(el);
                            } else if (typeof window.KTDataTable.createInstances == 'function') {
                                window.KTDataTable.createInstances();
                            }
                        } catch (e) {
                            console.warn('KTDataTable instance creation failed', e);
                        }
                    });
                    return;
                }
            } catch (e) {
                console.warn('KT DataTable safe init error', e);
            }
        }

        // Initialize KTSelect instances safely (used by kt-select custom dropdown)
        function disposeSelectInstances() {
            try {
                var selects = document.querySelectorAll('select[data-kt-select="true"]');
                if (!selects || selects.length == 0) return;

                selects.forEach(function(el) {
                    try {
                        if (window.KTSelect && typeof window.KTSelect.getInstance == 'function') {
                            var inst = window.KTSelect.getInstance(el);
                            if (inst && typeof inst.dispose == 'function') {
                                inst.dispose();
                            }
                        }
                    } catch (e) {
                        // ignore
                    }
                });
            } catch (e) {
                // ignore
            }
        }

        function safeInitSelects() {
            try {
                var selects = document.querySelectorAll('select[data-kt-select="true"]');
                if (!selects || selects.length == 0) return;

                // Dispose existing instances first to avoid duplicate wrappers
                disposeSelectInstances();

                // Prefer per-element getOrCreateInstance if available
                if (window.KTSelect && typeof window.KTSelect.getOrCreateInstance == 'function') {
                    selects.forEach(function(el) {
                        try {
                            window.KTSelect.getOrCreateInstance(el);
                        } catch (e) {
                            console.warn('KTSelect getOrCreateInstance failed', e);
                        }
                    });
                    return;
                }

                // Otherwise, call global createInstances if provided
                if (window.KTSelect && typeof window.KTSelect.createInstances == 'function') {
                    try {
                        window.KTSelect.createInstances();
                    } catch (e) {
                        console.warn('KTSelect createInstances failed', e);
                    }
                }
            } catch (e) {
                console.warn('KT Select safe init error', e);
            }
        }

        function runSafeInits() {
            safeInitDataTables();
            safeInitSelects();
        }

        if (document.readyState == 'loading') {
            document.addEventListener('DOMContentLoaded', runSafeInits);
        } else {
            runSafeInits();
        }

        // Livewire hooks: re-run safe initializers after Livewire updates
        try {
            if (window.Livewire && typeof Livewire.hook == 'function') {
                // After Livewire processes a message, re-init components
                Livewire.hook('message.processed', function() {
                    runSafeInits();
                });

                // Before DOM update, dispose existing instances to avoid leaks / stale wrappers
                Livewire.hook('beforeDomUpdate', function() {
                    try {
                        disposeSelectInstances();
                    } catch (e) {
                        // ignore
                    }
                });
            }

            // Fallback to DOM events emitted by Livewire
            document.addEventListener('livewire:message.processed', function() {
                runSafeInits();
            });
            document.addEventListener('livewire:update', function() {
                runSafeInits();
            });
        } catch (e) {
            // Non-fatal
            console.warn('Livewire hooks for KT init failed', e);
        }
        // Re-init shortly after a change on a select to handle cases where the select
        // triggers a Livewire update immediately (select change -> rerender).
        document.addEventListener('change', function(ev) {
            try {
                var t = ev.target;
                if (!t) return;
                if (t.matches && t.matches('select[data-kt-select="true"]')) {
                    // schedule a re-init after a short delay to let Livewire finish
                    setTimeout(function() {
                        runSafeInits();
                    }, 60);
                }
            } catch (e) {
                // ignore
            }
        }, true);
    })();
</script> --}}
<script src="{{ asset('metronic/vendors/apexcharts/apexcharts.min.js') }}" data-navigate-once></script>
<script src="{{ asset('metronic/js/layouts/demo1.js') }}" data-navigate-once></script>
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
<script src="{{ asset('assets/js/multiSelectUtils.js') }}"></script>
<script src="{{ asset('assets/js/multiples/specialSelect.js') }}"></script>
<script src="{{ asset('assets/js/multiples/specialCheckbox.js') }}"></script>
<script src="{{ asset('assets/js/multiples/specialSearch.js') }}"></script>
{{-- <script src="{{ asset('assets/js/multiples/specialDelete.js') }}"></script> --}}
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
