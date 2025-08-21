@extends('admin.base')

@section('content')
    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center justify-between gap-5 pb-7.5 lg:items-end">
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
    <div class="kt-container-fixed">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ $formAction }}" class="form">
                    @csrf
                    @method('PUT')

                    @yield('form-content')

                    <div class="text-end mt-4">
                        <button type="submit" class="kt-btn kt-btn-primary">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End of Container -->
@endsection
