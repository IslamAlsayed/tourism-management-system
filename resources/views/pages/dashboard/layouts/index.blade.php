@extends('layouts.master')

@section('content')
    <!-- Container -->
    <div class="kt-container-fixed">
        @yield('table-content')
    </div>
    <!-- End of Container -->
@endsection

@push('scripts')
    {{-- <script>
        let toggleScroll = false;
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
                // dataTargetModel?.classList.add('hidden');
            }
        });

        if (window.innerWidth > 768) {
            toggleScroll = true;
        }

        window.addEventListener('resize', function() {
            toggleScroll = window.innerWidth > 768 ? true : false;
        });

        document.addEventListener('scroll', function(event) {
            // Check if scroll is happening inside the modal
            if (dataTargetModel?.contains(event.target)) {
                return; // Don't close modal if scrolling inside it
            }

            if (toggleScroll && !dataTargetModel?.classList.contains('hidden')) {
                // dataTargetModel?.classList.add('hidden');
            }
        });

        // Prevent scroll propagation from modal to page
        dataTargetModel?.addEventListener('scroll', function(event) {
            event.stopPropagation();
        });

        // Also prevent wheel event propagation when scrolling inside modal
        dataTargetModel?.addEventListener('wheel', function(event) {
            event.stopPropagation();
        });
    </script> --}}


    <script>
        let toggleScroll = window.innerWidth > 768;

        const dataTargetButton = document.querySelector('[data-target-button="#columnsModal"]');
        const dataTargetModel = document.getElementById('columnsModal');
        const parentWrapper = document.getElementById('parentColumnsModal');

        // فتح وإغلاق المودال بزر معين
        dataTargetButton?.addEventListener('click', function(event) {
            event.stopPropagation();
            dataTargetModel.classList.toggle('hidden');
        });

        // إغلاق المودال لما تضغط برّه
        document.addEventListener('click', function(event) {
            if (dataTargetModel?.classList.contains('hidden')) return;

            if (!parentWrapper?.contains(event.target)) {
                // dataTargetModel?.classList.add('hidden');
            }
        });

        // تحديث قيمة toggleScroll حسب عرض الشاشة
        window.addEventListener('resize', function() {
            toggleScroll = window.innerWidth > 768;
        });

        // لو المستخدم بيعمل scroll في الصفحة
        window.addEventListener('scroll', function(event) {
            // لو المودال مش ظاهر، نخرج
            if (dataTargetModel?.classList.contains('hidden')) return;

            // لو الماوس حالياً داخل المودال، متقفلش
            if (isMouseInsideModal) return;

            if (toggleScroll) {
                dataTargetModel?.classList.add('hidden');
            }
        });

        // ----- التعامل مع scroll داخل المودال -----
        let isMouseInsideModal = false;

        // لما الماوس يدخل المودال → نعرف إن المستخدم بيتفاعل معاه
        dataTargetModel?.addEventListener('mouseenter', function() {
            isMouseInsideModal = true;
        });

        // لما الماوس يخرج من المودال → نرجع نسمح بقفل المودال لما يعمل scroll في الصفحة
        dataTargetModel?.addEventListener('mouseleave', function() {
            isMouseInsideModal = false;
        });

        // منع تمرير scroll من المودال للصفحة
        dataTargetModel?.addEventListener('wheel', function(event) {
            const atTop = dataTargetModel.scrollTop === 0;
            const atBottom = dataTargetModel.scrollTop + dataTargetModel.clientHeight >= dataTargetModel
                .scrollHeight;

            // لو المستخدم داخل المحتوى، امنع انتقال scroll للصفحة
            if (!(atTop && event.deltaY < 0) && !(atBottom && event.deltaY > 0)) {
                event.stopPropagation();
                event.preventDefault();
            }
        });
    </script>
@endpush
