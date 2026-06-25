# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**لنگر موتور (Langar Motor)** — A Laravel 13 e-commerce application for an auto parts/motorcycle parts store. Built with Laravel Breeze (Blade stack + Alpine.js), Tailwind CSS, and Vite.

## Commands

```bash
# Dev server (runs artisan serve, queue listener, pail logs, and Vite concurrently)
composer run dev

# Run all tests
composer run test

# Run a single test file
php artisan test tests/Feature/ProductTest.php

# Run a specific test method
php artisan test --filter="test_method_name"

# Build frontend assets
npm run build

# Frontend dev (Vite HMR only, when not using composer run dev)
npm run dev

# Static analysis / linting
./vendor/bin/pint        # Laravel Pint (PSR-12)
pint --test              # Dry-run / report mode

# Database
php artisan migrate
php artisan migrate:fresh --seed
```

## Architecture

### Tech Stack
- **Backend**: PHP 8.3+, Laravel 13
- **Frontend**: Blade templates, Alpine.js, Tailwind CSS
- **Build**: Vite + laravel-vite-plugin
- **Database**: MySQL (local: `langar_motor`, user: `root`)
- **Auth**: Laravel Breeze (Blade + Alpine stack)

### Directory Structure (app/)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── HomeController.php        — Homepage (latest products, categories)
│   │   ├── ProductController.php     — Product listing + detail by slug
│   │   ├── CartController.php        — Cart (stub, not yet implemented)
│   │   ├── SearchController.php      — Full-text search with category/brand filters
│   │   ├── BrandController.php       — Brand listing + products per brand
│   │   ├── ContactController.php     — Contact form with validation
│   │   ├── ProfileController.php     — User profile CRUD (from Breeze)
│   │   └── Auth/                     — Auth controllers (register, login, passwords)
│   ├── Requests/
│   │   ├── Auth/LoginRequest.php
│   │   └── ProfileUpdateRequest.php
│   └── Controllers/
├── Models/
│   ├── Product.php            — name, slug, description, price, stock, category_id, brand_id, is_active
│   ├── Category.php           — name, slug, icon, is_active. hasMany(Product)
│   ├── Brand.php              — name, slug, logo, is_active. hasMany(Product)
│   └── User.php               — Standard Laravel auth user
├── Providers/
│   └── AppServiceProvider.php
└── View/Components/           — AppLayout and GuestLayout blade components
```

### Key Models & Relationships
- **Product** → belongsTo `Category` and `Brand`. Price stored as unsigned big integer (rials/tomans).
- **Category** → hasMany `Product`
- **Brand** → hasMany `Product`

### Routes (web.php)
| URI | Controller | Named Route |
|-----|-----------|-------------|
| `/` | `HomeController@index` | — |
| `/products` | `ProductController@index` | `products.index` |
| `/products/{slug}` | `ProductController@show` | `products.show` |
| `/cart` | `CartController@index` | `cart.index` |
| `/search` | `SearchController@index` | `search.index` |
| `/contact` | `ContactController@index` | `contact.index` |
| `/brands` | `BrandController@index` | `brands.index` |
| `/brands/{slug}` | `BrandController@show` | `brands.show` |
| `/dashboard` | Inline view | — (auth+verified middleware) |
| `/profile` | `ProfileController` | — (auth middleware group) |

Auth routes are loaded from `routes/auth.php` (Breeze-generated: login, register, password reset, email verification).

### Frontend
- Blade layouts: `layouts/app.blade.php` (authenticated) and `layouts/guest.blade.php`
- Views live in `resources/views/`, organized by feature (products/, brands/, cart/, search/, contact/, home/, auth/, profile/)
- Components in `resources/views/components/` (form inputs, buttons, modals, dropdowns — from Breeze)
- Tailwind CSS configured in `tailwind.config.js`, compiled via `resources/css/app.css`

### Notable Observations
- `CartController` is a stub (`$cartItems = []`) — cart functionality is not yet built.
- `ContactController@store` has validation but the send/save logic is commented out (TODO).
- The `HomeController` exists but is not mapped in `web.php` — the homepage route currently returns the `welcome` view inline.
- Search uses `LIKE` queries (no dedicated search engine).
- Price is stored as `unsignedBigInteger` (likely representing amounts in a minor currency unit).