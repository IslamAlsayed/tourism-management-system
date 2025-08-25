{{-- Enhanced pagination information component --}}
<div class="kt-card-header flex-wrap gap-2 border-b border-gray-200">
    <div class="w-full flex justify-between items-center">
        <div>
            <h3 class="kt-card-title text-lg font-semibold">
                {{ $title ?? 'Records' }}
            </h3>
            <p class="text-sm text-gray-600 mt-1">
                عرض {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} من أصل {{ $data->total() }} {{ $entityName ?? 'عنصر' }}
                @if($data->hasPages())
                    <span class="text-blue-600">(صفحة {{ $data->currentPage() }} من {{ $data->lastPage() }})</span>
                @endif
            </p>
        </div>
        
        @if(isset($showSearch) && $showSearch)
        <div class="flex flex-wrap gap-2 lg:gap-5">
            <div class="flex">
                <label class="kt-input">
                    <i class="ki-filled ki-magnifier"></i>
                    <input wire:model.live="search" 
                           placeholder="بحث في {{ $entityName ?? 'العناصر' }}..."
                           type="text" 
                           class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </label>
            </div>
        </div>
        @endif
    </div>
    
    {{-- Progress bar showing current page position --}}
    @if($data->hasPages() && $data->lastPage() > 1)
    <div class="w-full mt-3">
        <div class="flex items-center gap-2 text-xs text-gray-500">
            <span>التقدم:</span>
            <div class="flex-1 bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                     style="width: {{ ($data->currentPage() / $data->lastPage()) * 100 }}%"></div>
            </div>
            <span>{{ number_format(($data->currentPage() / $data->lastPage()) * 100, 1) }}%</span>
        </div>
    </div>
    @endif
</div>
