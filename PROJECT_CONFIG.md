# 🏗️ MixJo2025 Project Configuration

## 📋 **معلومات المشروع الأساسية:**

### **Git Remotes:**
```
origin: https://github.com/Tawfiqmakhamreh/MixJo2025.git
islam:  https://github.com/IslamAlsayed/tourist-site.git
```

### **Current Branch:** `v-4-1`
### **Project Type:** Tourism Management System
### **Laravel Version:** 11.x
### **Database:** MySQL 8.0+

---

## 🚀 **الموديولات المطورة:**

### ✅ **مكتملة:**
- **User Management** - إدارة المستخدمين
- **Countries & Cities** - البلدان والمدن  
- **Regions & Subregions** - المناطق والمناطق الفرعية
- **Transportation System** - نظام النقل
  - Companies (الشركات)
  - Departments (الأقسام)
  - Bus Types (أنواع الحافلات)
  - Vehicles (المركبات) - في التطوير
- **Tour Guides** - المرشدين السياحيين
- **Accommodations** - أماكن الإقامة
- **Restaurants** - المطاعم
- **Currencies** - العملات
- **Languages** - اللغات
- **Nationalities** - الجنسيات

### 🔄 **في التطوير:**
- **Vehicle Management** - إدارة المركبات
- **Car Routes & Pricing** - خطوط الرحلات والأسعار

### 📋 **قائمة الانتظار:**
- **Booking System** - نظام الحجوزات
- **Payment Integration** - دمج أنظمة الدفع
- **Advanced Reporting** - التقارير المتقدمة
- **API Development** - تطوير API
- **Mobile Support** - دعم الهواتف المحمولة

---

## 🏗️ **البنية التقنية:**

### **Backend:**
- **Framework:** Laravel 11.x
- **Database:** MySQL 8.0+
- **Real-time:** Livewire 3.x
- **Excel:** Laravel Excel (Maatwebsite)
- **Authentication:** Laravel Sanctum

### **Frontend:**
- **CSS Framework:** Tailwind CSS
- **UI Theme:** Metronic
- **JavaScript:** Alpine.js
- **Build Tool:** Vite

### **Features:**
- **Multilingual:** Arabic/English
- **Import/Export:** Excel integration
- **Pagination:** Custom pagination with session persistence
- **Responsive:** Mobile-first design
- **Real-time:** Dynamic tables with Livewire

---

## 📁 **هيكل الملفات الرئيسي:**

```
app/
├── Excels/              # Import/Export Classes
├── Http/Controllers/    # Controllers
├── Livewire/           # Dynamic Components  
├── Models/             # Eloquent Models
├── Traits/             # Reusable Traits
└── helpers.php         # Helper Functions

resources/views/
├── components/         # Shared Components
├── livewire/          # Livewire Views
├── pages/dashboard/   # Dashboard Pages
└── layouts/           # Layout Files

config/
├── excel_models.php   # Excel Configuration
└── sidebar.php        # Sidebar Configuration

lang/
├── ar/                # Arabic Translations
└── en/                # English Translations
```

---

## 🔧 **إعدادات مهمة:**

### **Environment Variables:**
```
APP_NAME=MixJo2025
APP_URL=http://localhost:8000
DB_DATABASE=mixjo2025
LOCALE=en
FALLBACK_LOCALE=ar
```

### **Pagination Settings:**
- Default per page: 10
- Options: 10, 25, 50, 100
- Session persistence: enabled

### **Import/Export:**
- Max file size: 10MB
- Supported formats: XLSX, CSV
- Batch processing: enabled

---

## 👥 **الفريق:**

### **الأدوار:**
- **Project Owner:** Tawfiq Makhamreh
- **Developer:** Islam Alsayed
- **AI Assistant:** GitHub Copilot

### **التواصل:**
- **GitHub Issues:** لتتبع المهام
- **Git Branches:** للميزات الجديدة
- **Documentation:** في README.md و docs/

---

## 📊 **إحصائيات التطوير:**

### **آخر إحصائية (أكتوبر 4, 2025):**
- **Total Files:** 500+ files
- **Models:** 25+ models  
- **Controllers:** 30+ controllers
- **Livewire Components:** 20+ components
- **Database Tables:** 25+ tables
- **Translation Keys:** 200+ keys

### **Git Statistics:**
- **Total Commits:** 100+
- **Active Branches:** v-4-1 (main development)
- **Last Major Release:** v-4-1
- **Remotes Synced:** 2 (origin, islam)

---

*📅 إنشاء: أكتوبر 4, 2025*  
*🔄 آخر تحديث: أكتوبر 4, 2025*  
*📝 بواسطة: GitHub Copilot*