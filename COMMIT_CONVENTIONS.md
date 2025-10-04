# 📝 Commit Message Conventions - MixJo2025

## 🎯 **قواعد كتابة Commit Messages:**

### **الصيغة الأساسية:**
```
<type>: <description>

[optional body]
[optional footer]
```

---

## 🏷️ **أنواع التغييرات (Types):**

### **الميزات والإضافات:**
- **`feat:`** - إضافة ميزة جديدة
- **`add:`** - إضافة ملفات أو مكونات جديدة
- **`new:`** - إنشاء موديولات أو أنظمة جديدة

### **الإصلاحات والتحسينات:**
- **`fix:`** - إصلاح bug أو مشكلة
- **`enhance:`** - تحسين ميزة موجودة
- **`improve:`** - تحسين الأداء أو التجربة
- **`optimize:`** - تحسين الكود أو الاستعلامات

### **إعادة الهيكلة والتنظيف:**
- **`refactor:`** - إعادة هيكلة الكود بدون تغيير الوظائف
- **`cleanup:`** - تنظيف الكود وحذف الملفات غير المستخدمة
- **`reorganize:`** - إعادة تنظيم الملفات والمجلدات

### **التحديثات والصيانة:**
- **`update:`** - تحديث dependencies أو packages
- **`upgrade:`** - ترقية إصدارات أو technologies
- **`migrate:`** - تحديثات قاعدة البيانات

### **التوثيق والترجمة:**
- **`docs:`** - تحديث التوثيق والـ README
- **`lang:`** - إضافة أو تحديث الترجمات
- **`comment:`** - إضافة تعليقات أو شروحات

### **التصميم والواجهة:**
- **`style:`** - تحسينات CSS أو UI
- **`design:`** - تغييرات في التصميم العام
- **`responsive:`** - تحسينات الاستجابة للشاشات

### **الاختبار والجودة:**
- **`test:`** - إضافة أو تحديث tests
- **`security:`** - تحسينات أمنية
- **`validate:`** - إضافة أو تحسين validation

---

## 📋 **أمثلة عملية:**

### **إضافة ميزة جديدة:**
```
feat: add transportation vehicle management system

- Create VehicleController with full CRUD operations
- Add TransportationVehicle model with relationships
- Implement Excel import/export for vehicles
- Add Livewire component for real-time vehicle table
- Include Arabic/English translations for vehicle module
```

### **إصلاح مشكلة:**
```
fix: resolve tour-guides-types component namespace error

- Fix incorrect namespace in TourGuidesTypes\Table component
- Clear Livewire component cache to refresh registry
- Update component to use correct App\Livewire\TourGuidesTypes namespace
```

### **تحسين نظام موجود:**
```
enhance: improve import system with shared components

- Unify import forms across all modules using shared components
- Add advanced import form with examples and validation
- Enhance user import with better error handling
- Update all import views to use new component structure
```

### **إعادة هيكلة:**
```
refactor: simplify Livewire components and remove duplicate code

- Remove redundant methods from table components
- Standardize pagination implementation across all Livewire tables
- Extract common functionality to CustomPagination trait
- Clean up unused imports and optimize component structure
```

### **تحديث تقني:**
```
update: enhance models with relationships and documentation

- Add comprehensive PHPDoc comments to all models
- Implement missing relationships between models
- Update fillable arrays for better mass assignment
- Standardize model structure across the application
```

---

## 🎨 **قواعد الوصف (Description):**

### **يجب أن يكون:**
- **واضح ومختصر** (أقل من 72 حرف للسطر الأول)
- **بصيغة الأمر** (add, fix, enhance)
- **يبدأ بحرف صغير** 
- **بدون نقطة في النهاية**

### **أمثلة جيدة:**
```
✅ feat: add vehicle booking system with payment integration
✅ fix: resolve pagination rehydration bug in Livewire tables
✅ enhance: improve import validation with real-time feedback
✅ refactor: extract common form components for reusability
```

### **أمثلة سيئة:**
```
❌ Fix bug
❌ Update files
❌ feat: Add new feature.
❌ FEAT: ADD VEHICLE SYSTEM
```

---

## 📊 **Body & Footer (اختياري):**

### **متى نستخدم Body:**
- شرح **لماذا** تم التغيير
- وصف **كيف** تم حل المشكلة
- ذكر **الآثار الجانبية** المحتملة

### **متى نستخدم Footer:**
- ربط الـ commit بـ **GitHub Issue**
- ذكر **Breaking Changes**
- إضافة **معلومات إضافية** مهمة

### **مثال كامل:**
```
feat: implement comprehensive transportation booking system

Add complete booking workflow including:
- Multi-step booking form with validation
- Real-time availability checking
- Payment integration with multiple gateways
- Email notifications for booking confirmations
- Admin dashboard for booking management

This enhancement supports the core business requirement for
online booking functionality and replaces the manual booking process.

Closes #45
Related to #12, #23
```

---

## 🔄 **Commit Workflow:**

### **قبل الـ Commit:**
1. **فحص التغييرات:** `git diff`
2. **اختبار الكود:** تأكد من عدم وجود أخطاء
3. **مراجعة الملفات:** `git status`

### **أثناء الـ Commit:**
1. **اختيار النوع المناسب** من القائمة أعلاه
2. **كتابة وصف واضح** للتغيير
3. **إضافة تفاصيل** إذا لزم الأمر

### **بعد الـ Commit:**
1. **مراجعة الرسالة:** `git log --oneline -1`
2. **تعديل إذا لزم:** `git commit --amend`
3. **Push للـ remotes:** حسب استراتيجية المشروع

---

## 📈 **إحصائيات مفيدة:**

### **لمراجعة آخر الـ commits:**
```bash
git log --oneline -10
git log --pretty=format:"%h %s" --since="1 week ago"
```

### **لمراجعة أنواع التغييرات:**
```bash
git log --pretty=format:"%s" | grep -E "^(feat|fix|enhance):" | wc -l
```

---

*📅 إنشاء: أكتوبر 4, 2025*  
*🎯 الغرض: توحيد رسائل الـ commits في مشروع MixJo2025*  
*👨‍💻 بواسطة: GitHub Copilot مع الفريق*