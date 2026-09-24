# 🏠 Your-PG — Paying Guest & Hostel Accommodation Management System

A full-stack, modern web application built with **Laravel 13**, **Tailwind CSS**, and **Alpine.js** designed to streamline PG (Paying Guest) / Hostel discovery, room bookings, and administrative operations.

---

## ✨ Features

### 👤 User / Student Portal
- **Browse & Search PGs**: Explore available PGs with location, amenities, pricing, and room sharing options.
- **Detailed PG Profiles**: High-resolution gallery, verified amenities, room availability, and rules.
- **Online Booking System**: Seamless booking requests with room type selection, check-in dates, and identity document uploads.
- **User Dashboard**: Track real-time booking statuses (*Pending*, *Approved*, *Rejected*, *Cancelled*), view invoices, and manage profile settings.

### 🛡️ Admin Management Portal
- **PG Management**: Add, update, and manage PG properties with multi-image upload & primary image selection.
- **Room & Amenity Control**: Configure room categories (Single, Double, Triple Sharing), pricing, and attached amenities (Wi-Fi, AC, Food, Laundry, etc.).
- **Booking Workflow**: Review booking applications, verify submitted user documents, and approve or reject requests with one click.
- **User Management**: View registered users, contact details, and their booking histories.

---

## 🛠️ Tech Stack

- **Backend**: [Laravel 13.x](https://laravel.com/) (PHP 8.3+)
- **Frontend**: Blade Templates, [Tailwind CSS](https://tailwindcss.com/), [Alpine.js](https://alpinejs.dev/)
- **Alerts & UI**: [SweetAlert2](https://sweetalert2.github.io/)
- **Database**: SQLite / MySQL
- **Tooling & Build**: [Vite](https://vitejs.dev/), Pest PHP

---

## 🚀 Getting Started

Follow these steps to run the project locally on your system:

### 1. Clone the Repository
```bash
git clone https://github.com/Ambartiwari2001/your-pg.git
cd your-pg
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Frontend dependencies
npm install
```

### 3. Environment Configuration
Copy the example `.env` file and generate the application key:
```bash
cp .env.example .env
php artisan key:generate
```

Configure your database settings in `.env` (SQLite or MySQL).

### 4. Run Migrations & Seeders
Populate the database with sample PGs, amenities, rooms, and test users:
```bash
php artisan migrate:fresh --seed
```

### 5. Create Storage Symlink
```bash
php artisan storage:link
```

### 6. Start Development Server
Run Vite and Laravel development server:
```bash
# Run backend server
php artisan serve

# In a separate terminal, compile frontend assets
npm run dev
```

Visit the app at `http://localhost:8000` in your browser.

---

## 🔑 Default Test Credentials

After running `php artisan db:seed`, you can log in with:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@gmail.com` | `123456` |
| **User** | `user@gmail.com` | `123456` |

---

## 📂 Project Structure

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/         # Admin PG, Room, Booking & User controllers
│   │   ├── BookingController.php
│   │   ├── HomeController.php
│   │   └── PGController.php
├── Models/
│   ├── Amenity.php
│   ├── Booking.php
│   ├── BookingDocument.php
│   ├── PG.php
│   ├── PGImage.php
│   ├── Room.php
│   └── User.php
database/
├── migrations/            # Database schema definitions
└── seeders/               # Dummy data & test accounts
resources/
├── views/                 # Blade templates & UI layouts
└── js/ / css/             # Frontend assets
routes/
└── web.php                # Application route definitions
```

---

## 📄 License

This project is open-source software licensed under the [MIT License](LICENSE).
