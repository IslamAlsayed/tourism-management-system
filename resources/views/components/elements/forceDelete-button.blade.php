@php
    $btnId = 'fdel-' . ($id ?? 'x') . '-' . Str::random(4);
@endphp

<button
    id="{{ $btnId }}"
    type="button"
    style="{{ $styles ?? '' }}"
    class="kt-btn kt-btn-sm bg-red-800 text-white shadow-sm hover:shadow-md hover:bg-red-900 hover:-translate-y-0.5 transition-all duration-150 px-3 py-1.5 gap-2 rounded-full font-semibold"
    style="{{ $styles ?? '' }}"
    title="{{ __('main.force_delete') }}"
    data-id="{{ $id ?? '' }}"
    wire:ignore>
    <i class="fa-duotone fa-solid fa-trash-can text-base"></i>
    <span>{{ __('main.force_delete') }}</span>
</button>

<script>
    (function() {
        const btn = document.getElementById('{{ $btnId }}');
        if (!btn) return;
        btn.style.backgroundColor = '#7f1d1d';
        btn.style.color = '#ffffff';
        btn.style.border = 'none';
        btn.addEventListener('click', function () {
            const recordId = this.getAttribute('data-id');
            Swal.fire({
                title: '⚠️ {{ addslashes(__('messages.are_you_sure')) }}',
                html: `<p style="color:#dc2626;font-weight:600;">{{ addslashes(__('messages.are_you_sure_force_delete')) }}</p>
                       <p style="color:#6b7280;font-size:0.85rem;margin-top:6px;">{{ addslashes(__('messages.force_delete_warning')) }}</p>`,
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#7f1d1d',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fa-duotone fa-solid fa-trash-can me-1"></i> {{ addslashes(__('main.force_delete')) }}',
                cancelButtonText: '{{ addslashes(__('main.cancel')) }}',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed && recordId) {
                    const comp = btn.closest('[wire\\:id]');
                    if (comp) {
                        window.Livewire.find(comp.getAttribute('wire:id')).call('forceDelete', recordId);
                    }
                }
            });
        });
    })();
</script>
