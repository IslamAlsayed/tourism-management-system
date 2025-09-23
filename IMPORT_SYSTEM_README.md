# نظام صفحات الاستيراد المشترك (Shared Import System)

## نظرة عامة

تم إنشاء نظام صفحات استيراد مشترك لتبسيط وتوحيد جميع صفحات الاستيراد في التطبيق. يوفر هذا النظام:

- **واجهة موحدة** لجميع صفحات الاستيراد
- **صيانة أسهل** من خلال مركزة الكود
- **تصميم متجاوب** وحديث
- **معالجة أخطاء محسنة**
- **تقليل تكرار الكود** بشكل كبير

## المكونات (Components)

### 1. `x-import-form` - المكون الأساسي

مخصص للصفحات البسيطة التي تحتوي على:
- حقل رفع الملف
- متطلبات اختيارية (مثل وجود بلدان أولاً)
- زر الاستيراد والإلغاء
- رابط التصدير

**الاستخدام:**
```blade
<x-import-form 
    :title="$title"
    :description="$description"
    :models="$models"
    :requirements="[
        [
            'condition' => \App\Models\Country::count() > 0,
            'route' => route('countries.index'),
            'label' => __('main.countries_')
        ]
    ]">
    
    <!-- محتوى إضافي مثل الجداول -->
    <div class="mt-4">
        <a href="{{ route('export.data', ['model' => $models]) }}" class="kt-btn kt-btn-outline">
            {{ __('main.export') }}
        </a>
    </div>
</x-import-form>
```

### 2. `x-advanced-import-form` - المكون المتقدم

مخصص للصفحات المعقدة مثل صفحة الإقامة (accommodations) التي تحتوي على:
- خيارات متعددة للاستيراد (راديو بأتونز)
- حقول إدخال مخفية إضافية
- جداول ديناميكية تظهر حسب الخيار المختار

**الاستخدام:**
```blade
<x-advanced-import-form 
    :title="$title"
    :description="$description"
    :models="$models"
    :hasOptions="true"
    optionName="accommodationOptions"
    :options="['types', 'accommodations', 'seasons']"
    :disabledOptions="['rate_nationalities']"
    :additionalInputs="[
        ['name' => 'importType', 'id' => 'importType', 'value' => '']
    ]">
    
    <!-- الجداول والمحتوى الديناميكي -->
</x-advanced-import-form>
```

## المعاملات (Parameters)

### المعاملات الأساسية
- `title` - عنوان الصفحة
- `description` - وصف الصفحة
- `models` - اسم النموذج للمسارات

### معاملات التحكم في المسارات
- `route` - مسار مخصص للاستيراد (اختياري)
- `cancelRoute` - مسار مخصص للإلغاء (اختياري)

### معاملات المتطلبات
- `requirements` - مصفوفة من المتطلبات المسبقة
  - `condition` - الشرط المطلوب
  - `route` - مسار الصفحة المطلوبة
  - `label` - نص الرابط

### معاملات الخيارات (للمكون المتقدم)
- `hasOptions` - هل توجد خيارات متعددة
- `optionName` - اسم مجموعة الخيارات
- `options` - مصفوفة الخيارات المتاحة
- `disabledOptions` - الخيارات المعطلة

### معاملات إضافية
- `additionalInputs` - حقول إدخال مخفية إضافية
- `showExport` - إظهار زر التصدير
- `customExportId` - معرف مخصص لزر التصدير

## الملفات المُحدثة

### ✅ تم التحديث
1. **المستخدمين** - `users/import.blade.php`
2. **البلدان** - `countries/import.blade.php`  
3. **المدن** - `cities/import.blade.php`
4. **العملات** - `currencies/import.blade.php`
5. **المناطق** - `regions/import.blade.php`
6. **الإقامة** - `accommodations/import.blade.php` (مع المكون المتقدم)

### 📋 يحتاج تحديث
- `states/import.blade.php`
- `subregions/import.blade.php`
- `nationalities/import.blade.php`
- `restaurants/import.blade.php`
- وملفات أخرى في `resources/views/dashboard/imports/`

## كيفية تحديث ملف موجود

### 1. للصفحات البسيطة:
```blade
<!-- القديم -->
@extends('layouts.master')
@section('content')
<div class="container">
    <form action="..." method="POST">
        <!-- كود الفورم -->
    </form>
</div>
@endsection

<!-- الجديد -->
@extends('layouts.master')
@section('content')
    <x-import-form 
        :title="$title"
        :description="$description" 
        :models="$models">
        
        <!-- المحتوى الإضافي -->
    </x-import-form>
@endsection
```

### 2. للصفحات المعقدة:
استخدم `x-advanced-import-form` مع المعاملات المناسبة.

## المميزات الجديدة

### 🎨 تصميم محسن
- واجهة موحدة عبر جميع الصفحات
- تصميم متجاوب
- رسائل خطأ محسنة

### ⚡ أداء أفضل
- كود أقل تكراراً
- تحميل أسرع
- صيانة أسهل

### 🔧 مرونة في التخصيص
- إمكانية إضافة محتوى مخصص
- تحكم في المتطلبات
- دعم للخيارات المعقدة

### 🛡️ معالجة أخطاء محسنة
- فحص تلقائي للمتطلبات
- رسائل خطأ واضحة
- تفعيل/تعطيل تلقائي للأزرار

## الصيانة والتطوير

### إضافة ميزة جديدة
1. عدّل المكون المناسب في `resources/views/components/`
2. أضف المعامل الجديد
3. اختبر التغييرات على جميع الصفحات

### حل المشاكل
- تأكد من وجود المتغيرات المطلوبة (`$title`, `$description`, `$models`)
- تحقق من مسارات المتطلبات
- راجع console المتصفح للأخطاء JavaScript

## الخطوات التالية

1. **إكمال التحديث** لجميع ملفات الاستيراد المتبقية
2. **اختبار شامل** لجميع الصفحات
3. **إضافة اختبارات آلية** للمكونات
4. **توثيق إضافي** للمطورين الجدد

## دعم ومساعدة

للحصول على المساعدة أو الإبلاغ عن مشاكل:
- راجع الكود في `resources/views/components/`
- تحقق من الأمثلة في الملفات المُحدثة
- اتبع نفس النمط للملفات الجديدة