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
        document.addEventListener('DOMContentLoaded', function () {
            MultiDelete({
                selectAllId: 'selectAllItems',
                rowCheckboxSelector: 'input[name="selectedItems[]"]',
            });
        });
    </script>
@endpush

@push('scripts')
    <script>
        let toggleScroll = false;
        const dataTargetButton = document.querySelector('[data-target-button="#columnsModal"]');
        const dataTargetModel = document.getElementById('columnsModal');
        const parentWrapper = document.getElementById('parentColumnsModal');

        dataTargetButton?.addEventListener('click', function (event) {
            event.stopPropagation();
            dataTargetModel.classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            if (dataTargetModel?.classList.contains('hidden')) return;

            if (!parentWrapper?.contains(event.target)) {
                dataTargetModel?.classList.add('hidden');
            }
        });

        if (window.innerWidth > 768) {
            toggleScroll = true;
        }

        window.addEventListener('resize', function () {
            toggleScroll = window.innerWidth > 768 ? true : false;
        });

        document.addEventListener('scroll', function () {
            if (toggleScroll && !dataTargetModel?.classList.contains('hidden')) {
                dataTargetModel?.classList.add('hidden');
            }
        });
    </script>
@endpush