{{-- 
    ملف الأمثلة - استخدامات مختلفة للمكونات المشتركة
    Examples File - Different Usage Patterns for Shared Components
--}}

{{-- ===== مثال 1: صفحة استيراد بسيطة (بدون متطلبات) ===== --}}
{{-- Example 1: Simple Import Page (No Requirements) --}}

@extends('layouts.master')
@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view">

        <div class="mt-4">
            <a href="{{ route('export.data', ['models' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        {{-- جدول الحقول المطلوبة --}}
        <strong class="block mt-6 mb-2">Required Fields</strong>
        <table class="border min-w-half divide-y text-center divide-gray-200">
            <thead>
                <tr>
                    <th class="border px-2">name</th>
                    <th class="border px-2">code</th>
                </tr>
            </thead>
            <tbody class="background divide-y divide-gray-200">
                <tr>
                    <td class="border px-2">Sample Name</td>
                    <td class="border px-2">SMP</td>
                </tr>
            </tbody>
        </table>
    </x-import-form>
@endsection

{{-- ===== مثال 2: صفحة استيراد مع متطلب واحد ===== --}}
{{-- Example 2: Import Page with Single Requirement --}}

@extends('layouts.master')
@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view" :requirements="[
        [
            'condition' => \Modules\Geography\Entities\Country::count() > 0,
            'route' => route('dashboard.geography.countries.create'),
            'label' => __('main.countries_'),
        ],
    ]">

        <div class="mt-4">
            <a href="{{ route('export.data', ['models' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>
    </x-import-form>
@endsection

{{-- ===== مثال 3: صفحة استيراد مع متطلبات متعددة ===== --}}
{{-- Example 3: Import Page with Multiple Requirements --}}

@extends('layouts.master')
@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view" :requirements="[
        [
            'condition' => \Modules\Localization\Entities\Currency::count() > 0,
            'route' => route('currencies.create'),
            'label' => __('main.currencies_'),
        ],
        [
            'condition' => \Modules\Geography\Entities\Region::count() > 0,
            'route' => route('dashboard.geography.regions.create'),
            'label' => __('main.regions_'),
        ],
        [
            'condition' => \Modules\Geography\Entities\Country::count() > 0,
            'route' => route('dashboard.geography.countries.create'),
            'label' => __('main.countries_'),
        ],
    ]">

        {{-- محتوى إضافي --}}
    </x-import-form>
@endsection

{{-- ===== مثال 4: صفحة استيراد مع مسارات مخصصة ===== --}}
{{-- Example 4: Import Page with Custom Routes --}}

@extends('layouts.master')
@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view" :route="route('custom.import.route')" :cancelRoute="route('custom.cancel.route')">

        {{-- محتوى مخصص --}}
    </x-import-form>
@endsection

{{-- ===== مثال 5: صفحة استيراد متقدمة مع خيارات ===== --}}
{{-- Example 5: Advanced Import Page with Options --}}

@extends('layouts.master')
@section('content')
    <x-advanced-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view" :hasOptions="true"
        optionName="accommodationOptions" :options="['types', 'accommodations', 'seasons', 'supplements', 'rates', 'rate_details', 'hotels']" :disabledOptions="['rate_nationalities', 'room_types']" :additionalInputs="[['name' => 'importType', 'id' => 'importType', 'value' => '']]" customExportId="exportData">

        {{-- جداول ديناميكية حسب الخيار المختار --}}
        <div>
            <div data-types-target="types" class="target-trigger mt-4" style="display: none">
                <strong class="block mt-6 mb-2">Types Fields</strong>
                <table class="border min-w-half divide-y text-center divide-gray-200">
                    <thead>
                        <tr>
                            <th class="border px-2">name</th>
                            <th class="border px-2">name_ar</th>
                        </tr>
                    </thead>
                    <tbody class="background divide-y divide-gray-200">
                        <tr>
                            <td class="border px-2">Hotel</td>
                            <td class="border px-2">فندق</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div data-accommodations-target="accommodations" class="target-trigger mt-4" style="display: none">
                <strong class="block mt-6 mb-2">Accommodations Fields</strong>
                {{-- جدول الإقامة --}}
            </div>
        </div>
    </x-advanced-import-form>
@endsection

{{-- JavaScript إضافي للصفحات المتقدمة --}}
@push('scripts')
    <script>
        // كود JavaScript مخصص للتحكم في الخيارات والجداول الديناميكية
        document.addEventListener('DOMContentLoaded', function() {
            const importForm = document.getElementById('importForm');
            const importType = document.getElementById('importType');
            const exportType = document.getElementById('exportData');

            // معالجة تغيير الخيارات
            document.querySelectorAll(".toggle-trigger").forEach((trigger) => {
                trigger.addEventListener("change", (event) => {
                    const targetId = event.target.dataset.toggleTarget;
                    const model = exportType.dataset.model;

                    // تحديث القيم المخفية
                    importType.value = targetId;

                    // تحديث مسارات التصدير والاستيراد
                    exportType.href = `export/${model}/data/${targetId}`;
                    importForm.action = `import/${model}/data/${targetId}`;
                });
            });
        });
    </script>
@endpush

{{-- ===== مثال 6: استخدام المكون مع محتوى مخصص فقط ===== --}}
{{-- Example 6: Using Component with Custom Content Only --}}

@extends('layouts.master')
@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view" :showExport="false">

        {{-- محتوى مخصص بدون زر التصدير --}}
        <div class="custom-content">
            <p class="text-gray-600">هذه صفحة استيراد مخصصة بالكامل</p>

            {{-- أي محتوى HTML مخصص --}}
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="border p-4 rounded">
                    <h3 class="font-bold">نصائح الاستيراد</h3>
                    <ul class="list-disc list-inside mt-2">
                        <li>تأكد من تنسيق الملف</li>
                        <li>راجع الأعمدة المطلوبة</li>
                        <li>احفظ نسخة احتياطية</li>
                    </ul>
                </div>

                <div class="border p-4 rounded">
                    <h3 class="font-bold">الملفات المدعومة</h3>
                    <ul class="list-disc list-inside mt-2">
                        <li>.csv</li>
                        <li>.xlsx</li>
                        <li>.xls</li>
                    </ul>
                </div>
            </div>
        </div>
    </x-import-form>
@endsection

{{-- ===== الخصائص المتاحة ===== --}}
{{-- Available Properties:
    
    للمكون الأساسي (x-import-form):
    - title: عنوان الصفحة
    - description: وصف الصفحة  
    - models: اسم النموذج
    - route: مسار مخصص للاستيراد (اختياري)
    - cancelRoute: مسار مخصص للإلغاء (اختياري)
    - requirements: متطلبات مسبقة (مصفوفة)
    - showExport: إظهار زر التصدير (افتراضي: true)
    
    للمكون المتقدم (x-advanced-import-form):
    - كل خصائص المكون الأساسي +
    - hasOptions: وجود خيارات متعددة
    - optionName: اسم مجموعة الخيارات
    - options: مصفوفة الخيارات
    - disabledOptions: الخيارات المعطلة
    - additionalInputs: حقول إدخال إضافية مخفية
    - customExportId: معرف مخصص لزر التصدير
--}}
