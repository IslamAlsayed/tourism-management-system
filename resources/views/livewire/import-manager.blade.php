<div x-data>
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Import File (CSV/XLSX)</label>
        <input type="file" wire:model="file" class="mt-2" />
        @error('file')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex items-center space-x-2">
        <button wire:click.prevent="startImport" class="kt-btn kt-btn-primary">Start Import</button>
        <span class="text-sm text-gray-600">{{ $status }}</span>
    </div>

    <div class="mt-4">
        <strong>Last message:</strong>
        <div id="import-last-message" class="mt-2 text-sm text-green-700">{{ $lastMessage }}</div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // When Ably setup dispatches the DOM event, forward it to Livewire component
            window.addEventListener('import-completed', function(e) {
                // e.detail contains { message, type }
                if (window.Livewire) {
                    Livewire.emit('importNotification', e.detail);
                }
            });

            // When Livewire dispatches browser event, show toast via existing showToast function
            window.addEventListener('import-completed-js', function(e) {
                const data = e.detail || {};
                if (window.showToast) {
                    window.showToast({
                        type: data.type || 'success',
                        title: '',
                        message: data.message || ''
                    });
                }
                // update DOM fallback
                const el = document.getElementById('import-last-message');
                if (el) el.textContent = data.message || '';
            });

            // when import is started locally, show immediate feedback
            window.addEventListener('import-started', function(e) {
                if (window.showToast) {
                    window.showToast({
                        type: 'info',
                        title: '',
                        message: e.detail.message
                    });
                }
            });
        });
    </script>
</div>
