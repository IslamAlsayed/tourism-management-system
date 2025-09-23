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
