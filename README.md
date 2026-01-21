<p align="center">
  <img src="public/images/Clew_logo_dark.svg" width="300" alt="Clew Nicotine Pouches Logo">
</p>

# Clew Nicotine Pouches Platform

[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](https://laravel.com)
[![Laravel Version](https://img.shields.io/badge/laravel-10.x-red.svg)](https://laravel.com)
[![License](https://img.shields.io/badge/license-Proprietary-blue.svg)](LICENSE)

Clew Nicotine Pouches is a premium, high-performance e-commerce platform built with **Laravel 10**. It is specifically engineered for the distribution of nicotine products, featuring integrated age verification, secure payment processing, and a sophisticated admin infrastructure.

---

## ✨ Key Features

### 🛒 Customer Experience

- **🛡️ Age Verification**: Strict compliance middleware to ensure age-restricted access.
- **🍇 Dynamic Catalog**: Advanced filtering by flavor (Blueberry, Citrus, Mint, etc.) and strength (3mg - 15mg).
- **💳 Multi-Gateway Checkout**: Seamless integration with **Stripe** and **Authorize.Net**.
- **📍 Store Locator**: Real-time map search and geographic filtering for retail partners.
- **👤 Personalization**: Detailed user profiles, multiple address management, and persistent wishlists.

### ⚙️ Administrative Control

- **📊 Business Intelligence**: Live sales analytics and product performance reporting.
- **🏗️ Inventory Management**: Granular control over variants, pricing, and stock levels.
- **🧾 Automated Invoicing**: Direct PDF generation and order tracking.
- **🛰️ Partner Logistics**: Bulk import/export tools for retail locations via Excel.
- **🎟️ Promotional Engine**: Flexible coupon creation and discount rule management.

---

## 🛠 Tech Stack

| Technology                 | Purpose                        |
| :------------------------- | :----------------------------- |
| **Laravel 10**             | Core Application Framework     |
| **PHP 8.1+**               | Primary Backend Language       |
| **MySQL**                  | Relational Database Management |
| **Bootstrap**              | Responsive UI Framework        |
| **Stripe / Authorize.Net** | Financial Infrastructure       |
| **Intervention Image**     | Dynamic Asset Optimization     |

---

## 🚀 Quick Start

### 1. Prerequisites

Ensure you have **PHP 8.1+** and **Composer** installed on your system.

### 2. Installation

```bash
git clone https://github.com/ermradulsharma/clew-nicotine-pouches.git
cd clew-pouches
composer install
npm install && npm run build
```

### 3. Configuration

```bash
cp .env.example .env
php artisan key:generate
```

> [!IMPORTANT]
> Update your `.env` file with Database and Payment API credentials.

### 4. Database Setup

```bash
php artisan migrate --seed
php artisan storage:link
```

### 5. Launch

```bash
php artisan serve
```

---

## 🔐 Administrative Access

The secure dashboard is located at `/admin`. Role-based access control (Admin/Sub-admin) is strictly enforced via custom middleware.

## 📄 License

This project is proprietary software belonging to **Clew**. All rights reserved.
