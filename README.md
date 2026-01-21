# Clew Nicotine Pouches Platform

Clew Nicotine Pouches is a modern e-commerce platform built with Laravel, designed for the distribution and sale of premium nicotine pouches. The system features a robust age-verification flow, integrated payment gateways, and a comprehensive admin management suite.

## 🚀 Key Features

### Frontend & Customer Experience

- **Age Verification System**: Integrated middleware to ensure compliance with age restrictions for tobacco/nicotine products.
- **Dynamic Product Catalog**: Browse products by category, flavour (Blueberry, Citrus, Cool Mint, Spearmint, Wintergreen), and strength (3mg, 6mg, 9mg, 12mg, 15mg).
- **Advanced Shopping Cart**: Intuitive cart management with coupon code support.
- **Secure Checkout**: Multi-step checkout process integrated with top-tier payment providers.
- **Store Locator**: Geographic search and map-based visualization for finding physical store locations.
- **User Accounts**: Manage profiles, multiple addresses, order history, and product wishlists.

### Admin & Management

- **Dashboard & Reporting**: Real-time sales analytics and position-based data visualization.
- **Catalog Management**: Full control over categories, products, variants, and inventory.
- **Order Processing**: Detailed order tracking and invoice generation.
- **Store Management**: Bulk import/export functionality for store locations via Excel templates.
- **Promotion System**: Dynamic coupon and discount management.
- **Enquiry Handling**: Centralized management for contact-us submissions and newsletter subscriptions.

## 🛠 Tech Stack

- **Framework**: [Laravel 10](https://laravel.com)
- **Language**: PHP 8.1+
- **Database**: MySQL
- **UI Framework**: Bootstrap (via Laravel UI)
- **Integrations**:
    - **Payments**: Stripe, Authorize.Net
    - **Image Processing**: Intervention Image
    - **Excel Handling**: Maatwebsite Excel
    - **Webhooks**: GoDirect integration

## 📦 Installation & Setup

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd clew-pouches
    ```

2. **Install Dependencies**

    ```bash
    composer install
    npm install
    npm run build
    ```

3. **Environment Configuration**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    _Configure your database and payment API keys (Stripe, Authorize.Net) in the `.env` file._

4. **Database Setup**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

5. **Storage Link**

    ```bash
    php artisan storage:link
    ```

6. **Serve the Application**
    ```bash
    php artisan serve
    ```

## 🔐 Admin Access

Default admin routes are accessible at `/admin`. Authentication and role-based access control (Admin/Sub-admin) are managed via custom middleware.

## 📄 License

The project is proprietary software belonging to Clew.
