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
        let toggleScroll = window.innerWidth > 768;

        const dataTargetButton = document.querySelector('[data-target-button="#columnsModal"]');
        const dataTargetModel = document.getElementById('columnsModal');
        const parentWrapper = document.getElementById('parentColumnsModal');

        dataTargetButton?.addEventListener('click', function(event) {
            event.stopPropagation();
            dataTargetModel?.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            if (dataTargetModel?.classList.contains('hidden')) return;
            if (!parentWrapper?.contains(event.target)) {}
        });

        window.addEventListener('resize', function() {
            toggleScroll = window.innerWidth > 768;
        });

        window.addEventListener('scroll', function(event) {
            if (dataTargetModel?.classList.contains('hidden')) return;
            if (isMouseInsideModal) return;
            if (toggleScroll) {
                dataTargetModel?.classList.add('hidden');
            }
        });

        let isMouseInsideModal = false;

        dataTargetModel?.addEventListener('mouseenter', function() {
            isMouseInsideModal = true;
        });

        dataTargetModel?.addEventListener('mouseleave', function() {
            isMouseInsideModal = false;
        });

        dataTargetModel?.addEventListener('wheel', function(event) {
            const atTop = dataTargetModel?.scrollTop === 0;
            const atBottom = dataTargetModel?.scrollTop + dataTargetModel?.clientHeight >= dataTargetModel
                .scrollHeight;

            if (!(atTop && event.deltaY < 0) && !(atBottom && event.deltaY > 0)) {
                event.stopPropagation();
                event.preventDefault();
            }
        });

        document.addEventListener('click', (e) => {
            const toggleBtn = e.target.closest('#columns');
            const dropdown = document.getElementById('columnsModal');
            const insideDropdown = e.target.closest('#columnsModal');

            if (toggleBtn) {
                dropdown?.classList.toggle('hidden');
                return;
            }

            if (!insideDropdown) {
                dataTargetModel?.classList.add('hidden');
            }
        });
    </script>
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let selectAll = document.getElementById("selectPage");
            if (!selectAll) return;
            let newSelectAll = selectAll?.cloneNode(true);
            let checkboxes = document.querySelectorAll(".custom-input input[name='selectItem[]']");
            selectAll.addEventListener("change", () => {
                newSelectAll.checked = selectAll.checked;
                checkboxes.forEach((cb) => (cb.checked = newSelectAll.checked));
            });
        });

        window.addEventListener('reset-checkout-boxes', () => {
            let selectAll = document.getElementById("selectPage");
            if (!selectAll) return;
            selectAll.checked = false;
            let newSelectAll = selectAll?.cloneNode(false);
            let checkboxes = document.querySelectorAll(".custom-input input[name='selectItem[]']");
            checkboxes.forEach((cb) => (cb.checked = false));
        });
    </script>
@endpush

@push('scripts')
    <script>
        window.addEventListener('reset-filters', () => {
            let filterTables = document.querySelectorAll('.filterTable');
            filterTables.forEach(table => {
                let selects = table.querySelectorAll('select');
                selects.forEach(select => select.value = '');
            });
        });
    </script>
@endpush
