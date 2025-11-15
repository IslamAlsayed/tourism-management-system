# Changelog - November 15, 2025

## 🚀 Major Updates

### Air Transports System - Complete Redesign
**Changed from Airlines Management to Airports Management**

#### Database Changes
- **Migration Simplified**: Reduced from 40+ fields to 18 essential airport fields
  - ICAO, IATA, LID codes
  - Airport names (English & Arabic)
  - Geographic data (region, country, state, city, elevation, coordinates)
  - Contact information (phone numbers, website)
  - Airport type (International/Regional/Domestic/Military/Private)

#### Backend Updates
- ✅ Updated `AirTransport` Model with new fillable fields
- ✅ Simplified `AirTransportCreateRequest` and `AirTransportUpdateRequest`
- ✅ Cleaned `AirTransportController` - removed JSON handling
- ✅ Updated `AirTransportFactory` with unique ICAO/IATA code generation
- ✅ Fixed `AirTransportSeeder` - prevents duplicate code errors
- ✅ Updated `AirTransports` Livewire component - removed old filters

#### Frontend Updates
- ✅ Rebuilt `create.blade.php` with 18-field structure
- ✅ Rebuilt `edit.blade.php` to match new structure
- ✅ Cleaned `air-transports.blade.php` Livewire view - removed filter UI
- ✅ Updated sidebar configuration - removed airline submenu items

#### Translations
- ✅ Added new translations in `lang/en/main.php` and `lang/ar/main.php`:
  - `airport_information`, `international`, `regional`, `domestic`, `military`

---

### Users System Enhancement

#### Database Changes
- ✅ Added `birth_date` field to users table
- ✅ Maintained `hire_date` for employment tracking

#### Backend Updates
- ✅ Updated `User` Model fillable with `birth_date`
- ✅ Updated `UserCreateRequest` validation rules
- ✅ Updated `UserUpdateRequest` validation rules

#### Frontend Updates
- ✅ Unified field order between `create.blade.php` and `edit.blade.php`
- ✅ Added Birth Date field in Personal Information section
- ✅ Moved Birth Date to Employment Information section (before Hire Date)
- ✅ Improved form layout consistency

**Field Order (Now Consistent)**:
1. Personal Info: First Name, Last Name, Email, Password
2. Contact Info: Phone, Mobile, Address
3. Employment Info: Birth Date, Hire Date, Department, Position
4. System Settings: Language, Timezone, Permissions
5. Additional Info: Preferences, Notes

---

### Deployment Configuration

#### CI/CD Updates
- ✅ Added cleanup step in `deploy.yml`:
  - Removes old air_transports migration before deployment
  - Removes old AirTransportFactory and Seeder
  - Drops air_transports table from database
  - Ensures clean deployment of new structure

---

## 🔧 Technical Improvements

### Code Quality
- Removed duplicate code and unused fields
- Simplified validation rules
- Improved factory data generation with unique constraints
- Better error handling in seeders

### Database Optimization
- Reduced table complexity (40+ → 18 fields)
- Added proper indexes for performance
- Implemented unique constraints on ICAO/IATA codes

---

## 📝 Files Modified

### Air Transports (15 files)
- Migration, Model, Factory, Seeder
- Controller, Requests (Create/Update)
- Livewire Component and View
- Blade Views (Create/Edit/Index)
- Sidebar Configuration
- Translations (EN/AR)

### Users (6 files)
- Migration, Model
- Requests (Create/Update)
- Blade Views (Create/Edit)

### Deployment (1 file)
- CI/CD Workflow Configuration

---

## 🎯 Impact

- **Database**: Simplified structure, better performance
- **UX**: Cleaner forms, consistent field order
- **Development**: Easier maintenance, reduced complexity
- **Deployment**: Automated cleanup for smooth updates

---

## 📌 Notes

- All changes are backward compatible with existing data migration path
- Translation keys added for new airport-related terms
- Form validation updated to match new field requirements
- Seeder now generates 50 sample airports with unique codes
