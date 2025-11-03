@php
    $toasts = session()->pull('toasts', []);
@endphp

@if (session()->has('success') ||
        session()->has('error') ||
        session()->has('warning') ||
        session()->has('info') ||
        $toasts)
    <div class="toasts">
        {{-- To show normal session messages --}}
        @foreach (['success', 'error', 'warning', 'info'] as $type)
            @if (session()->has($type))
                <div class="toast-inner" @if (isToastArray($type, 'dir')) dir="{{ isToastArray($type, 'dir') }}" @endif>
                    <div class="toast toast-{{ isToastArray($type, 'theme') ?: $type }} {{ isToastArray($type, 'pin') }} {{ isToastArray($type, 'position') ?: config('toasts.default_position') }}{{ config('toasts.move') != 'enable' ? ' no_move' : '' }}"
                        @if (isToastArray($type, 'duration')) data-duration="{{ isToastArray($type, 'duration') }}" @endif>

                        @if (isToastArray($type, 'emoji'))
                            <div class="toast-icon emoji fas" style="font-size: 20px">{!! isToastArray($type, 'emoji') !!}</div>
                        @endif

                        @if (!isToastArray($type, 'emoji'))
                            <i class="toast-icon fas fa-{{ isToastArray($type, 'icon') ?: getIcon($type) }}"></i>
                        @endif

                        @if (config('toasts.move') != 'enable' || isToastArray($type, 'pin') == 'pin')
                            <i class="toast-icon pin fas fa-thumbtack"></i>
                        @endif

                        <div class="toast-text">
                            <div class="text">
                                @if (isToastArray($type, 'title'))
                                    <strong>{{ isToastArray($type, 'title') }}</strong>
                                @endif
                                <p>{{ isToastArray($type, 'message') }}</p>
                            </div>

                            @if ($actions = getToastActions($type))
                                <div class="toast-actions">
                                    @foreach ($actions as $action)
                                        <a href="{{ $action['url'] }}"
                                            class="toast-action {{ isEmoji($action['label']) ? 'emoji' : 'text' }}">
                                            {{ $action['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="toast-closed toast-action">
                            <i class="fas fa-xmark"></i>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        @if ($toasts)
            {{-- To show toasts with more options --}}
            @foreach ($toasts as $toast)
                <div class="toast-inner" @if ($toast->dir) dir="{{ $toast->dir }}" @endif>
                    <div class="toast toast-{{ $toast->getTheme() }} {{ $toast->position }}{{ config('toasts.move') != 'enable' ? ' no_move' : '' }} {{ $toast->pin ?: '' }} {{ $toast->type == 'confirm' ? 'confirm-forever' : '' }}"
                        @if ($toast->duration) data-duration="{{ $toast->duration }}" @endif>

                        @if ($toast->emoji)
                            <div class="toast-icon emoji" style="font-size: 20px">{{ $toast->emoji }}</div>
                        @endif

                        @if (!$toast->emoji)
                            <i class="toast-icon fas fa-{{ $toast->getIcon() }}"></i>
                        @endif

                        @if (config('toasts.move') != 'enable' || $toast->pin == 'pin' || config('toasts.confirm_pin') == true)
                            <i class="toast-icon pin fas fa-thumbtack"></i>
                        @endif

                        <div class="toast-text">
                            <div class="text">
                                @if ($toast->type == 'confirm' || $toast->title)
                                    <strong>{{ $toast->title }}</strong>
                                @endif
                                <p>{{ $toast->message }}</p>
                            </div>

                            @if ($toast->type != 'confirm')
                                <div class="toast-actions">
                                    @foreach ($toast->actions as $action)
                                        <a href="{{ $action['url'] }}"
                                            class="toast-action {{ isEmoji($action['label']) ? 'emoji' : 'text' }}">
                                            {{ $action['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            @elseif ($toast->type == 'confirm')
                                @if ($toast->actions)
                                    <div class="toast-actions">
                                        @foreach ($toast->actions as $action)
                                            <a href="{{ $action['url'] }}"
                                                class="toast-action {{ isEmoji($action['label']) ? 'emoji' : 'text' }}">
                                                {{ $action['label'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="toast-actions">
                                    <a href="{{ $toast->link }}"
                                        @if ($toast->target) target="{{ $toast->target }}" @endif
                                        class="toast-action onconfirm {{ isEmoji($toast->onconfirm) ? 'emoji' : 'text' }}">
                                        {{ $toast->onconfirm }}
                                    </a>
                                    <p
                                        class="toast-action oncancel {{ isEmoji($toast->oncancel) ? 'emoji' : 'text' }}">
                                        {{ $toast->oncancel }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        <div class="toast-closed toast-action">
                            <i class="fas fa-xmark"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endif

@if ($errors->any())
    <div class="toasts">
        <div class="toast toast-error{{ config('toasts.move') != 'enable' ? ' no_move' : '' }}">
            <i class="toast-icon fas fa-circle-xmark"></i>

            <div class="toast-text">
                <div class="text">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="toast-closed toast-action">
                <i class="fas fa-xmark"></i>
            </div>
        </div>
    </div>
@endif


<script>
    configToast = @json(config('toasts'));
</script>

<script type="module" src="{{ asset('vendor/toasts/js/toasts.js') }}"></script>
