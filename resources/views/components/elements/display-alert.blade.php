<div class="custom-alerts" id="custom-alerts">
    @if (Cache::has('import_message'))
        @php $id = 'alert_' . uniqid(); @endphp
        <div id="{{ $id }}" class="kt-alert kt-alert-success mb-5" role="alert">
            {{ Cache::get('import_message') }}
        </div>
        @php Cache::forget('import_message'); @endphp
    @endif

    {{-- @if ($this->message)
        @foreach ($this->message as $key => $message)
            @php $id = 'alert_' . uniqid(); @endphp

            <div id="{{ $id }}" class="kt-alert kt-alert-{{ $key }} mb-5" role="alert">
                {{ $message }}
            </div>
        @endforeach
    @endif --}}

    @if (session('success'))
        @php $id = 'alert_' . uniqid(); @endphp
        <div id="{{ $id }}" class="kt-alert kt-alert-success mb-5" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        @php $id = 'alert_' . uniqid(); @endphp
        <div id="{{ $id }}" class="kt-alert kt-alert-danger mb-5" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        @php $id = 'alert_' . uniqid(); @endphp
        <div id="{{ $id }}" class="kt-alert kt-alert-danger mb-5" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    @php $id = 'alert_' . uniqid(); @endphp
                    <li id="{{ $id }}">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- @isset($slot)
        {{ $slot }}
    @endisset --}}
</div>
