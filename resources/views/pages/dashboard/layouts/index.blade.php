@extends('layouts.master')

@section('content')
    <!-- Container -->
    <div class="kt-container-fixed">
        @yield('table-content')
    </div>
    <!-- End of Container -->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            MultiDelete({
                selectAllId: 'selectAllItems',
                rowCheckboxSelector: 'input[name="selectedItems[]"]',
            });
        });
    </script>
@endpush

@push('scripts')
    <script>
        const dataTargetButton = document.querySelector('[data-target-button="#columnsModal"]');
        const dataTargetModel = document.getElementById('columnsModal');
        const parentWrapper = document.getElementById('parentColumnsModal');

        dataTargetButton?.addEventListener('click', function(event) {
            event.stopPropagation();
            dataTargetModel.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            if (dataTargetModel?.classList.contains('hidden')) return;

            if (!parentWrapper?.contains(event.target)) {
                dataTargetModel?.classList.add('hidden');
            }
        });

        document.addEventListener('scroll', function() {
            if (!dataTargetModel?.classList.contains('hidden')) {
                dataTargetModel?.classList.add('hidden');
            }
        });
    </script>
@endpush
