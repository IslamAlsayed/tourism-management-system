@extends('layouts.master')

@section('content')
    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    @yield('table-content')
                </div>
            </div>
        </div>
    </div>
    <!-- End of Container -->
@endsection
