# 🌍 MixJo Tourism Management System (TMS)

[![Laravel](https://img.shields.io/badge/Laravel-v12.36.1-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-v8.2.29-777BB4?logo=php&logoColor=white)](https://php.net)
[![Livewire](https://img.shields.io/badge/Livewire-v3.x-FB70A9?logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![Metronic](https://img.shields.io/badge/UI-Metronic%20Demo1-009EF7)](https://keenthemes.com/metronic)

A comprehensive, enterprise-grade Tourism Management System designed for travel agencies, tour operators, and destination management companies (DMCs). Built with **Laravel 12**, **Livewire 3**, and the **Metronic** design system.

---

## 🚀 Key Modules & Features

### 🏢 Operations & Services
- **Jeep Safari**: Full management with seasonal pricing, nationality-based exceptions, and detailed itineraries.
- **Tourist Services**: Dynamic pricing engine with commission logic and local citizen support.
- **Accommodations**: Hotel/Resort management with advanced supplement handling and seasons.
- **Restaurants**: Multi-season meal planning (FIT/Group) with status toggles.
- **Transportation**: Fleet management and regional transfer pricing.
- **Automation (n8n)**: Event-driven architecture with Webhooks for seamless integration with external tools.

### 🗺️ Core Infrastructure
- **Geography Engine**: Global data import (Regions, Subregions, Countries, States/Cities).
- **Import/Export Pro**: High-performance Excel handling for all major entities.
- **Cloud Integration**: Direct "Google Drive Link" import feature for seamless data updates.

### 🤖 AI & Development Tools
- **Gemini CLI (Speckit)**: Intelligent agent orchestration for feature planning and analysis.
- **Genkit Integration**: AI-powered content generation and text correction.
- **Diagnostics**: Built-in `checklist.py` for automated health, security, and UI audits.

---

## 🛠️ Tech Stack

- **Backend**: Laravel 12.36.1 (PHP 8.2.29)
- **Frontend**: Livewire 3 (SPA Mode), Alpine.js, Vanilla CSS / Tailwind
- **UI System**: Metronic Demo 1 Core & Components
- **Database**: SQLite (Local Dev) / MySQL (Production Ready)
- **Ecosystem**:
  - `maatwebsite/excel` for Data Ports
  - `spatie/laravel-activitylog` for Audit Trails
  - `ably/ably-php` for Real-time Notifications

---

## 📥 Installation

```bash
# 1. Clone & Install Dependencies
git clone https://github.com/IslamAlsayed/tourist-site.git
composer install
npm install

# 2. Setup Environment
cp .env.example .env
php artisan key:generate

# 3. Database Initialization
php artisan migrate --seed
php artisan core:import-geography # Import global locations

# 4. Launch
php artisan serve
npm run dev
```

---

## 📌 Development Workflow

This project uses **Speckit (Gemini CLI)** for structured development:

1. **Plan**: Define new features in `.gemini/commands`.
2. **Specify**: Run `npx speckit.specify <feature_name>` to create structures.
3. **Verify**: Run `python .agent/scripts/checklist.py .` before every push.

---

## ⚡ Troubleshooting

- **405 Method Not Allowed**: Ensure you aren't pressing `Enter` on vanilla inputs inside Livewire components; global protection is implemented in `main.js`.
- **Route Not Found**: Run `php artisan optimize:clear` to refresh route caches.
- **Session Expired**: Check `APP_URL` in `.env` matches your local server.

---

## 🤝 Contribution & Maintenance

- Track tasks in `TASKS.md`.
- Follow the Socratic Gate protocol for architectural changes.
- Always use `notify_user` with an implementation plan for approval.

---
© 2025 MixJo. All Rights Reserved.
