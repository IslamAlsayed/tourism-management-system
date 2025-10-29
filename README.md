# MixJo2025 - Tourism Management System

A comprehensive tourism and travel management system built with Laravel, featuring advanced import/export capabilities, multilingual support, and modern dashboard interface powered by Metronic design system.

## Project Overview

**MixJo2025** is a full-featured tourism management platform designed to handle complex travel operations including accommodations, restaurants, countries, cities, currencies, and user management. The system provides robust data import/export functionality, multi-language support (English/Arabic), and an intuitive admin dashboard.

## Tech Stack

- **Laravel**: 11.x (Latest)
- **PHP**: 8.2+
- **MySQL**: 8.0+
- **Livewire**: 3.x for dynamic components
- **Tailwind CSS**: 3.x
- **Alpine.js**: 3.x for client-side interactions
- **Metronic**: Design system and UI components
- **Laravel Excel**: For import/export functionality
- **Vite**: 5.x for asset building
- **Node.js**: Latest LTS version

## Project Structure

```
app/
├── Excels/                         # Import/Export Classes
│   ├── Users/
│   ├── Countries/
│   ├── Cities/
│   ├── Currencies/
│   ├── Accommodations/
│   └── Restaurants/
├── Http/Controllers/Dashboard/     # Dashboard Controllers  
│   ├── UserController.php
│   ├── CountryController.php
│   ├── AccommodationController.php
│   └── ...
├── Livewire/                      # Dynamic Components
│   ├── Users/
│   ├── Restaurants/
│   ├── Accommodations/
│   └── ...
├── Models/                        # Eloquent Models
├── Traits/                        # Reusable Traits
│   └── CustomPagination.php
└── Jobs/                          # Background Jobs

resources/views/
├── layouts/
│   ├── master.blade.php
│   ├── sidebar.blade.php
│   └── partials/
├── pages/dashboard/               # Dashboard Pages
│   ├── users/
│   ├── countries/
│   ├── accommodations/
│   └── ...
├── components/                    # Shared Components
│   ├── import-form.blade.php
│   ├── advanced-import-form.blade.php
│   └── import-examples.blade.php
└── livewire/                     # Livewire Components

lang/                             # Multilingual Support
├── en/
│   ├── main.php
│   └── sidebar.php
└── ar/
    ├── main.php
    └── sidebar.php

config/
├── app.php                       # App Configuration
├── excel_models.php              # Excel Models Config
└── sidebar.php                   # Sidebar Configuration
```

## Demo Layouts

This integration includes 10 complete demo layouts, each showcasing different UI patterns:

- **Demo 1**: Sidebar Layout - Traditional admin dashboard with sidebar navigation
- **Demo 2**: Header Layout - Modern dashboard with top navigation
- **Demo 3**: Minimal Layout - Clean, minimalist design approach
- **Demo 4**: Creative Layout - Creative and artistic dashboard design
- **Demo 5**: Modern Layout - Contemporary UI with modern elements
- **Demo 6**: Professional Layout - Business-focused professional design
- **Demo 7**: Corporate Layout - Enterprise-grade corporate dashboard
- **Demo 8**: Executive Layout - Executive-level dashboard interface
- **Demo 9**: Premium Layout - Premium design with advanced components
- **Demo 10**: Ultimate Layout - Most comprehensive layout with all features

## Features

### Core Tourism Management Features
- **User Management**: Complete CRUD operations with role-based permissions
- **Accommodation Management**: Hotels, resorts, and lodging facilities management
- **Restaurant Management**: Food service provider management and categorization
- **Country & City Management**: Geographic location management for destinations
- **Currency Management**: Multi-currency support for international operations
- **Transportation Management**: Vehicle and transport service management

### Advanced Import/Export System
- **Shared Import Components**: Reusable import forms across all modules
- **Excel Integration**: Seamless data import/export with Laravel Excel
- **Advanced Import Form**: Feature-rich import interface with validation
- **Import Examples**: User-friendly sample data templates
- **Real-time Validation**: Instant feedback during import operations

### Dynamic User Interface
- **Livewire Components**: Real-time, interactive table management
- **Custom Pagination**: Advanced pagination with session persistence
- **Multilingual Support**: Full Arabic/English localization
- **Responsive Design**: Mobile-first approach with Metronic theme
- **Dynamic Sidebar**: Configurable navigation with drag-and-drop support

### System Administration
- **Role-based Access Control**: Comprehensive permission management
- **Excel Model Configuration**: Flexible import/export model mapping
- **Language Management**: Easy translation key management
- **Session Management**: Persistent user preferences and pagination states
- **Custom Components** - Metronic-specific UI components
- **Icon System** - Comprehensive icon library integration

## Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js (LTS version)
- A web server (Apache/Nginx) or use Laravel's built-in server

### Installation

1. **Clone the repository**

```bash
git clone <repository-url>
cd MixJo2025
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Install Node.js dependencies**

```bash
npm install
```

4. **Database setup**

```bash
# Create database
mysql -u root -p -e "CREATE DATABASE mixjo2025"

# Run migrations and seeders
php artisan migrate
php artisan db:seed
```

5. **Environment setup**

```bash
cp .env.example .env
php artisan key:generate

# Configure database settings in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mixjo2025
DB_USERNAME=root
DB_PASSWORD=your_password
```

6. **Storage and permissions**

```bash
php artisan storage:link
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

7. **Start development servers**

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server
npm run dev
```

### Available Routes

#### Dashboard Routes
- **Dashboard**: `/dashboard` - Main dashboard overview
- **Users**: `/dashboard/users` - User management (create, edit, list, import/export)
- **Countries**: `/dashboard/countries` - Country management with cities
- **Accommodations**: `/dashboard/accommodations` - Hotel and lodging management
- **Restaurants**: `/dashboard/restaurants` - Restaurant management
- **Currencies**: `/dashboard/currencies` - Currency management
- **Transportation**: `/dashboard/transportation` - Transport service management

#### Import/Export Routes
- **User Import**: `/dashboard/users/import` - Excel user import
- **Country Import**: `/dashboard/countries/import` - Country data import
- **Accommodation Import**: `/dashboard/accommodations/import` - Lodging import
- **Restaurant Import**: `/dashboard/restaurants/import` - Restaurant data import

#### Authentication Routes
- **Login**: `/login` - User authentication
- **Register**: `/register` - User registration
- **Password Reset**: `/password/reset` - Password recovery

## Usage

### Import/Export Operations

1. **Using Shared Import Components**
```php
// Include the shared import form in any view
<x-import-form 
    :route="route('dashboard.users.import')" 
    title="Import Users"
    requirements="Name, Email, Phone required columns" />
```

2. **Advanced Import with Examples**
```php
// Advanced import form with sample downloads
<x-advanced-import-form 
    :route="route('dashboard.users.import')"
    :examples-route="route('dashboard.users.import-examples')"
    model="User" />
```

### Livewire Components

```php
// Using custom pagination trait
class UserTable extends Component
{
    use CustomPagination;
    
    public function mount()
    {
        $this->mountWithCustomPagination();
    }
}
```

### Multilingual Support

```php
// Add new translation keys
// lang/en/main.php
'accommodation_type' => 'Accommodation Type',
'booking_status' => 'Booking Status',

// lang/ar/main.php  
'accommodation_type' => 'نوع الإقامة',
'booking_status' => 'حالة الحجز',
```

## Architecture

### Design Principles

- **Tourism-Focused**: Built specifically for tourism and hospitality management
- **Shared Components**: Reusable import/export system across all modules
- **Multilingual**: Full Arabic/English support for MENA region
- **Real-time Interface**: Livewire components for dynamic user experience
- **Data Integrity**: Comprehensive validation and error handling

### System Architecture

- **Import System**: Centralized Excel import with shared components
- **Pagination System**: Custom trait handling session persistence  
- **Multilingual System**: Dynamic language switching with route prefixes
- **Permission System**: Role-based access control throughout the application
- **Responsive Design**: Mobile-first approach optimized for tablets and phones

### Development Standards

- **PSR Compliance**: Following PHP-FIG standards
- **Laravel Best Practices**: Utilizing Eloquent, Artisan commands, and proper MVC
- **Component Reusability**: Shared Blade components and Livewire traits
- **Database Design**: Normalized structure with proper relationships
- **Security**: CSRF protection, validation, and sanitization throughout

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/new-feature`)
3. Commit your changes (`git commit -m 'Add new feature'`)
4. Push to the branch (`git push origin feature/new-feature`)
5. Create a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support and questions:
- Create an issue in the repository
- Check existing documentation
- Review code examples in the codebase

## Support

For questions and support:

- Review the integration documentation
- Check the demo implementations for examples
- Refer to Laravel documentation for framework-specific questions
