@php
    $btnId = 'del-' . ($id ?? 'x') . '-' . Str::random(4);
@endphp

<button
    id="{{ $btnId }}"
    type="button"
    style="{{ $styles ?? '' }}"
    class="kt-btn kt-btn-sm text-white bg-red-500 hover:bg-red-600 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-150 px-3 py-1.5 gap-2 rounded-full font-semibold"
    title="{{ __('main.delete') }}"
    data-id="{{ $id ?? '' }}"
    wire:ignore>
    <i class="fa-duotone fa-solid fa-trash text-base"></i>
    <span>{{ __('main.delete') }}</span>
</button>

<script>
    (function() {
        const btn = document.getElementById('{{ $btnId }}');
        if (!btn) return;
        btn.addEventListener('click', function () {
            const recordId = this.getAttribute('data-id');
            Swal.fire({
                title: '{{ addslashes(__('messages.are_you_sure')) }}',
                text: '{{ addslashes(__('messages.are_you_sure_delete')) }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fa-duotone fa-solid fa-trash me-1"></i> {{ addslashes(__('main.delete')) }}',
                cancelButtonText: '{{ addslashes(__('main.cancel')) }}',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed && recordId) {
                    const comp = btn.closest('[wire\\:id]');
                    if (comp) {
                        window.Livewire.find(comp.getAttribute('wire:id')).call('destroy', recordId);
                    }
                }
            });
        });
    })();
</script>
