# MixJo2025 - Tourism Management System

A simple tourism management system built with Laravel. It helps manage hotels, restaurants, cities, countries, money types, and users. It supports English and Arabic languages.

## About This Project

This system is for managing travel and tourism business. You can:
- Add and manage users
- Manage hotels and accommodations
- Manage restaurants
- Manage countries and cities
- Manage currencies
- Manage transportation

The system makes it easy to import and export data using Excel files.

## Technical Requirements

- **Laravel**: 11.x
- **PHP**: 8.2+
- **MySQL**: 8.0+
- **Livewire**: 3.x
- **Tailwind CSS**: 3.x
- **Metronic**: UI Design System
- **Laravel Excel**: For import/export
- **Vite**: 5.x
- **Node.js**: LTS

## Project Structure

```
app/
├── Excels/                         # Import and Export Files
├── Http/Controllers/Dashboard/     # Dashboard Controllers
├── Livewire/                      # Dynamic Components
├── Models/                        # Database Models
└── Traits/                        # Reusable Traits

resources/views/
├── layouts/                       # Page Layouts
├── pages/dashboard/              # Dashboard Pages
└── livewire/                     # Livewire Components

lang/                             # Languages
├── en/                           # English
└── ar/                           # Arabic

config/                           # Settings
```

## Features

### Tourism Management
- **User Management**: Add, edit, and delete users
- **Accommodation Management**: Manage hotels and resorts
- **Restaurant Management**: Manage restaurants
- **Countries and Cities**: Manage locations
- **Currency Management**: Support different currencies
- **Transportation**: Manage transportation services

### Import and Export
- **Excel Import**: Upload data from Excel files
- **Excel Export**: Download data as Excel files
- **Validation**: Check data before importing
- **Examples**: Download example files

### Dashboard
- **Livewire Components**: Fast and interactive tables
- **Multi-Language**: English and Arabic support
- **Responsive Design**: Works on phones and computers
- **Easy Navigation**: Simple menu to find everything

## Quick Start

### Installation Steps

1. **Clone the project**
```bash
git clone <repository-url>
cd MixJo2025
```

2. **Install packages**
```bash
composer install
npm install
```

3. **Setup database**
```bash
cp .env.example .env
php artisan key:generate

# Update .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mixjo2025
DB_USERNAME=root
DB_PASSWORD=your_password
```

4. **Create database tables**
```bash
php artisan migrate
php artisan db:seed
```

5. **Start the application**
```bash
# First terminal
php artisan serve

# Second terminal
npm run dev
```

The application will run at: **http://localhost:8000**

## Main Pages

| URL | Description |
|-----|-------------|
| `/dashboard` | Main page |
| `/dashboard/users` | Manage users |
| `/dashboard/countries` | Manage countries |
| `/dashboard/accommodations` | Manage hotels |
| `/dashboard/restaurants` | Manage restaurants |
| `/dashboard/currencies` | Manage money |
| `/dashboard/transportation` | Manage transportation |

## How to Use

### Import Data
1. Go to the management page
2. Click "Import"
3. Upload Excel file
4. Check for errors
5. Save

### Export Data
1. Go to the management page
2. Click "Export"
3. Download Excel file

### Add New Item
1. Click "Add New"
2. Fill in the form
3. Click "Save"

## Important Notes

- **PHP Version**: Need PHP 8.2 or higher
- **Database**: Use MySQL 8.0+
- **Backup**: Always backup your data before importing
- **File Format**: Use .xlsx or .xls format for import

## Need Help?

- Check the documentation files
- Look at the code examples
- Read Laravel documentation: https://laravel.com/docs
