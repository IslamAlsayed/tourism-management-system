<div class="kt-card-body p-0 d-flex flex-column" id="kt_chat_messenger_body">
    <!--begin::Messages-->
    <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" style="min-height: 500px; padding: 2rem;" id="kt_chat_messenger_scroll">
        @foreach($messages as $message)
            @if($message['role'] == 'user')
                <!--begin::Message(out)-->
                <div class="d-flex justify-content-end mb-10">
                    <div class="d-flex flex-column align-items-end">
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-3">
                                <span class="text-muted fs-7 mb-1">{{ now()->format('H:i') }}</span>
                                <span class="fs-5 fw-bold text-gray-900 ms-1">You</span>
                            </div>
                            <div class="symbol symbol-35px symbol-circle">
                                <span class="symbol-label bg-light-primary text-primary fw-bold">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-400px text-end" data-kt-element="message-text">
                            {{ $message['content'] }}
                        </div>
                    </div>
                </div>
                <!--end::Message(out)-->
            @else
                <!--begin::Message(in)-->
                <div class="d-flex justify-content-start mb-10">
                    <div class="d-flex flex-column align-items-start">
                        <div class="d-flex align-items-center mb-2">
                            <div class="symbol symbol-35px symbol-circle">
                                <span class="symbol-label bg-light-success text-success fw-bold"><i class="fas fa-robot"></i></span>
                            </div>
                            <div class="ms-3">
                                <span class="fs-5 fw-bold text-gray-900 me-1">MixJo AI</span>
                                <span class="text-muted fs-7 mb-1">{{ now()->format('H:i') }}</span>
                            </div>
                        </div>
                        <div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start" data-kt-element="message-text">
                            {!! Str::markdown($message['content']) !!}
                        </div>
                    </div>
                </div>
                <!--end::Message(in)-->
            @endif
        @endforeach

        @if($isLoading)
        <div class="d-flex justify-content-start mb-10">
            <div class="d-flex flex-column align-items-start">
                <div class="d-flex align-items-center mb-2">
                    <div class="symbol symbol-35px symbol-circle">
                        <span class="symbol-label bg-light-success text-success fw-bold"><i class="fas fa-robot"></i></span>
                    </div>
                    <div class="ms-3">
                        <span class="fs-5 fw-bold text-gray-900 me-1">MixJo AI</span>
                    </div>
                </div>
                <div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start">
                    <div class="typing-indicator">
                        <span></span><span></span><span></span>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .typing-indicator span {
                display: inline-block;
                width: 8px;
                height: 8px;
                background-color: #009ef7;
                border-radius: 50%;
                margin-right: 5px;
                animation: typing 1s infinite;
            }
            .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
            .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
            @keyframes typing {
                0%, 100% { transform: translateY(0); opacity: 0.5; }
                50% { transform: translateY(-5px); opacity: 1; }
            }
        </style>
        @endif
    </div>
    <!--end::Messages-->

    <!--begin::Card footer-->
    <div class="card-footer pt-4" id="kt_chat_messenger_footer">
        <!--begin::Input-->
        <form wire:submit.prevent="sendMessage">
            <textarea wire:model="newMessage" class="form-control form-control-flush mb-3" rows="1" data-kt-element="input" placeholder="Type a message (Enter to push, Shift+Enter for new line)" wire:keydown.enter.prevent="sendMessage"></textarea>
            <!--begin::Toolbar-->
            <div class="d-flex flex-stack">
                <!--begin::Actions-->
                <div class="d-flex align-items-center me-2">
                    <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-light text-gray-500 hover:text-primary me-1" type="button" title="Upload File (Coming Soon)">
                        <i class="fa-duotone fa-solid fa-paperclip fs-3"></i>
                    </button>
                </div>
                <!--end::Actions-->

                <!--begin::Send-->
                <button class="kt-btn kt-btn-primary" type="submit" data-kt-element="send" wire:loading.attr="disabled">
                    <span wire:loading.remove>Send</span>
                    <span wire:loading><i class="fas fa-spinner fa-spin"></i></span>
                </button>
                <!--end::Send-->
            </div>
            <!--end::Toolbar-->
        </form>
    </div>
    <!--end::Card footer-->
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('messageAdded', () => {
                setTimeout(() => {
                    const scrollEl = document.getElementById('kt_chat_messenger_scroll');
                    if(scrollEl) {
                        scrollEl.scrollTop = scrollEl.scrollHeight;
                    }
                }, 100);
            });
        });
    </script>
</div>
