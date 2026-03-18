<div x-data="{
    lat: null,
    lng: null,
    title: '{{ __('main.location') }}',
    mapUrl: ''
}"
@open-map-modal.window="
    lat = $event.detail.lat;
    lng = $event.detail.lng;
    title = $event.detail.title || '{{ __('main.location') }}';
    mapUrl = `https://maps.google.com/maps?q=${lat},${lng}&z=15&output=embed`;
    $dispatch('open-modal', 'generic-map-modal');
">
    <x-modal name="generic-map-modal" maxWidth="2xl">
        <div class="bg-background flex flex-col w-full h-full text-current">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-800">
                <h5 class="font-medium text-lg leading-none" x-text="title"></h5>
                <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-light kt-btn-primary text-gray-500 hover:text-primary transition-colors" @click="$dispatch('close-modal', 'generic-map-modal')">
                    <i class="ki-filled ki-cross text-xl"></i>
                </button>
            </div>
            <div class="p-0">
                <template x-if="mapUrl">
                    <iframe :src="mapUrl" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </template>
                <template x-if="!mapUrl">
                    <div class="flex items-center justify-center p-8 text-gray-400">
                        {{ __('main.no_data') }}
                    </div>
                </template>
            </div>
        </div>
    </x-modal>
</div>
