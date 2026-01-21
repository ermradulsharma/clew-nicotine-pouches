<p align="center">
  <img src="public/images/Clew_logo_dark.svg" width="300" alt="Clew Nicotine Pouches Logo">
</p>

# Clew Nicotine Pouches Platform

[![Laravel Version](https://img.shields.io/badge/laravel-10.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/php-8.1+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-Proprietary-blue.svg)](LICENSE)

Clew Nicotine Pouches is a robust, high-performance e-commerce platform built on **Laravel 10**. Specialized for the distribution and management of nicotine products, the platform integrates stringent age verification, secure payment processing, and comprehensive administrative tools.

---

## ✨ Key Features

### 🛒 Customer-Facing

- **🛡️ Age Verification**: Custom middleware and webhook integration for strictly controlled access.
- **🍇 Product Catalog**: Dynamic product display filtered by **Flavour** (Blueberry, Citrus, Mint, etc.) and **Strength** (3mg - 15mg).
- **💳 Secure Checkout**: Multiple payment options via **Stripe** and **Authorize.Net** with saved payment profiles.
- **📍 Store Locator**: Real-time store search with city-based filtering and custom retail partner attributes.
- **👤 User Management**: Multiple shipping addresses, order tracking (with returns), and persistent wishlists.
- **📰 Brand Engagement**: Integrated blog (Laravel-driven with a co-located WordPress installation), newsletters, and press releases.

### ⚙️ Administrative Infrastructure

- **📊 Advanced Dashboard**: Real-time sales reporting and data visualization for business metrics.
- **🏗️ Inventory Control**: Granular management of products, variants, images, and category hierarchies.
- **🧾 Order Lifecycle**: Full control over orders, invoice generation, and status updates via **GoDirect** webhooks.
- **🎟️ Promotional Tools**: Flexible coupon and discount engine for targeted marketing campaigns.
- **🛰️ Partner Logistics**: Dynamic Store management with Excel-based import, export, and template tools.
- **🛠️ Content Management**: Full control over banners, tickers, FAQs, and static pages.

---

## 🛠 Tech Stack

| Component            | Technology Stack               |
| :------------------- | :----------------------------- |
| **Framework**        | Laravel 10 (PHP 8.1+)          |
| **Database**         | MySQL / MariaDB                |
| **Frontend**         | Bootstrap / Vanilla CSS / Vite |
| **Payments**         | Authorize.Net SDK / Stripe API |
| **Image Processing** | Intervention Image             |
| **Excel Logistics**  | Maatwebsite/Laravel-Excel      |
| **Reporting**        | Custom Analytics Dashboard     |

---

## 🚀 Getting Started

### 1. Requirements

Ensure your environment meets the following baseline:

- **PHP 8.1+**
- **Composer**
- **Node.js & NPM**
- **MySQL 5.7+**

### 2. Installation

```bash
# Clone the repository
git clone https://github.com/ermradulsharma/clew-nicotine-pouches.git
cd clew-pouches

# Install dependencies
composer install
npm install && npm run build
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

> [!IMPORTANT]
> Configure your **Database**, **Stripe**, and **Authorize.Net** credentials in the `.env` file before proceeding.

### 4. Database Initialization

```bash
php artisan migrate --seed
php artisan storage:link
```

### 5. Local Development

```bash
php artisan serve
```

---

## 🔐 Administration

The secure management portal is accessible at `/admin`.

- **RBAC**: Role-Based Access Control is enforced via `AdminAccess` middleware.
- **Dashboard**: Features position-based data management for UI elements like banners and product ordering.

---

## 📄 Documentation & Support

For proprietary documentation or technical support, contact the **Clew Development Team**.

---

## 📄 License

This project is proprietary software. All rights reserved by **Clew**.
