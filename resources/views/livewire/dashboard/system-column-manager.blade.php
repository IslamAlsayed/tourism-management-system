<div>
    <div class="container-fluid py-5">
        <div class="card shadow-sm border-0 rounded-xl">
            <div class="card-header border-b border-gray-100 dark:border-gray-800 bg-white dark:bg-dark-light py-4 px-6 rounded-t-xl">
                <h3 class="card-title align-items-start flex-column m-0">
                    <span class="card-label fw-bold text-gray-900 dark:text-gray-100 text-lg flex items-center gap-2">
                        <i class="fa-duotone fa-solid fa-grid-2 text-primary text-2xl">
                            
                            
                            
                            
                        </i>
                        {{ __('main.manage_system_columns') ?? 'Manage System Columns' }}
                    </span>
                    <span class="text-muted mt-1 fw-semibold fs-7 pt-1 d-block">{{ __('main.dashboard_subtitle') ?? 'Customize global tables appearance' }}</span>
                </h3>
            </div>
            
            <div class="card-body p-6 md:p-8">
                <!-- Alert Information -->
                <div class="alert bg-primary/5 border border-primary/20 text-primary-800 dark:text-primary-300 p-5 rounded-xl mb-8 flex items-start gap-4">
                    <i class="fa-duotone fa-solid fa-circle-info text-primary text-3xl mt-0.5">
                        
                        
                        
                    </i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-lg mb-1">تنبيه إداري</h4>
                        <p class="text-sm opacity-80 leading-relaxed">
                            تسمح لك هذه الواجهة بالتحكم في <b>الأعمدة الافتراضية للنظام</b>. التعديلات التي تقوم بحفظها هنا ستطبق تلقائياً على <b>جميع المستخدمين</b> الذين لم يقوموا بتخصيص أعمدة الجداول الخاصة بهم من قبل. 
                        </p>
                    </div>
                </div>

                <!-- Module Selection -->
                <div class="mb-10 max-w-xl bg-gray-50 dark:bg-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800">
                    <label class="form-label mb-3 font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2">
                        <i class="fa-duotone fa-solid fa-layer-group text-gray-500"></i>
                        {{ __('main.select_module') ?? 'Select Module/Section' }}
                    </label>
                    <select wire:model.live="selectedModule" class="kt-select w-full transition-all duration-200 cursor-pointer shadow-sm">
                        <option value="">-- {{ __('main.select_module') ?? 'Select Module' }} --</option>
                        @foreach($modules as $key => $class)
                            <option value="{{ $key }}">{{ __('main.'.$key) !== 'main.'.$key ? __('main.'.$key) : $key }}</option>
                        @endforeach
                    </select>
                </div>

                <div wire:loading wire:target="selectedModule" class="w-full flex justify-center py-10">
                    <div class="flex items-center gap-3 text-muted">
                        <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
                        <span class="font-medium animate-pulse">{{ __('main.please_wait') ?? 'Please wait...' }}</span>
                    </div>
                </div>

                <!-- Columns Checkboxes -->
                @if($selectedModule && count($availableColumns) > 0)
                    <div class="mb-8 animate-fade-in" wire:loading.remove wire:target="selectedModule">
                        <div class="flex items-center justify-between mb-6 border-b border-gray-100 dark:border-gray-800 pb-4">
                            <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                <i class="fa-duotone fa-solid fa-shapes text-primary"></i>
                                {{ __('main.available_columns') ?? 'Available Columns' }} 
                                <span class="kt-badge kt-badge-light kt-badge-primary ms-2">{{ $selectedModule }}</span>
                            </h4>
                            <span class="text-sm text-muted">{{ count($selectedColumns) }} / {{ count($availableColumns) }} {{ __('main.selected') ?? 'Selected' }}</span>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 bg-gray-50/30 dark:bg-dark/20 p-5 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                            @foreach($availableColumns as $column)
                                @php 
                                    $isChecked = in_array($column, $selectedColumns);
                                @endphp
                                <label class="flex items-start gap-3 cursor-pointer p-3 rounded-lg border transition-all duration-200 {{ $isChecked ? 'bg-blue-50 border-blue-500 shadow-md ring-1 ring-blue-500 dark:bg-blue-900/20 dark:border-blue-500' : 'bg-white border-gray-200 hover:border-gray-300 shadow-sm dark:bg-[#1e1e2d] dark:border-gray-700 dark:hover:border-gray-500' }}">
                                    <div class="mt-0.5">
                                        <input 
                                            type="checkbox" 
                                            class="kt-checkbox w-5 h-5 border-gray-300 dark:border-gray-600 {{ $isChecked ? 'bg-blue-500 border-blue-500 text-white' : '' }}" 
                                            value="{{ $column }}" 
                                            wire:click="toggleColumn('{{ $column }}')"
                                            @if($isChecked) checked @endif
                                        >
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold select-none break-all {{ $isChecked ? 'text-blue-700 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300' }}">
                                            {{ __('main.'.$column) !== 'main.'.$column ? __('main.'.$column) : str_replace('_', ' ', Str::title($column)) }}
                                        </span>
                                        <span class="text-xs text-muted font-mono mt-1 opacity-70">{{ $column }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Save Actions -->
                    <div class="flex items-center gap-4 border-t border-gray-100 dark:border-gray-800 pt-6 mt-8" wire:loading.remove wire:target="selectedModule">
                        <button wire:click="saveColumns" class="kt-btn kt-btn-primary d-flex align-items-center gap-2 px-6" wire:loading.attr="disabled">
                            <i class="fa-duotone fa-solid fa-circle-check text-xl"></i>
                            <span class="font-medium">{{ __('main.save_changes') ?? 'Save Changes' }}</span>
                        </button>
                        
                        <div wire:loading wire:target="saveColumns" class="text-primary text-sm font-medium flex items-center gap-2">
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                            {{ __('main.please_wait') ?? 'Please wait...' }}
                        </div>
                    </div>
                @elseif($selectedModule)
                    <div class="alert bg-warning/10 border border-warning/20 text-warning-800 dark:text-warning-200 p-6 rounded-xl mt-6 flex flex-col items-center justify-center text-center gap-3 animate-fade-in" wire:loading.remove>
                        <i class="fa-duotone fa-solid fa-circle-info text-warning text-4xl mb-2"></i>
                        <h4 class="font-bold text-lg mb-0 text-warning">{{ __('main.no_columns_found_title') ?? 'لا توجد بيانات' }}</h4>
                        <p class="opacity-80 max-w-md mx-auto">{{ __('main.no_columns_found_desc') ?? 'عذراً، لم يتم العثور على أعمدة متاحة لهذا القسم أو ربما لا يحتوي الجدول على بيانات حتى الآن.' }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
