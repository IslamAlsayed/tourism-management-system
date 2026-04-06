@extends('layouts.master')

@section('content')
    <!-- Container -->
    <div class="container-fixed">
        <div class="flex flex-wrap items-center justify-between gap-4 pb-6 lg:items-end">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $title }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $subtitle ?? '' }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a class="kt-btn kt-btn-outline" href="{{ $backUrl }}">
                    Back to List
                </a>
            </div>
        </div>
    </div>
    <!-- End of Container -->

    <!-- Container -->
    <div class="container-fixed">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ $formAction }}" class="form">
                    @csrf
                    @method('PUT')

                    @yield('form-content')
                </form>
            </div>
        </div>
    </div>
    <!-- End of Container -->
@endsection
