# Mini Trip Management System

A Laravel-based trip booking system with role-based access for Admin, Staff, and Customer.

## 📋 Requirements

- PHP 8.2+
- Composer
- MySQL 8.0+ (or MariaDB)
- Node.js 18+ & npm
- Git

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/Nerrysky/trip-management-system.git
cd trip-management-system
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies

```bash
npm install
```

### 4. Configure environment

Copy the example env file:

```bash
copy .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Edit `.env` and set your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trip_management
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Create the database

In MySQL / phpMyAdmin:

```sql
CREATE DATABASE trip_management CHARACTER SET utf8 COLLATE utf8_unicode_ci;
```

### 6. Run migrations and seeders

```bash
php artisan migrate --seed
```

> If you get a "Specified key was too long" error, ensure `Schema::defaultStringLength(191);` is present in `app/Providers/AppServiceProvider.php`.

### 7. Build frontend assets

For development (keeps running):

```bash
npm run dev
```

Or build once for production:

```bash
npm run build
```

### 8. Start the server

```bash
php artisan serve
```

Open: **http://localhost:8000**

---

## 🔑 Test Login Credentials

All accounts use password: **`password`**

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@trip.test` | `password` |
| Staff | `staff@trip.test` | `password` |
| Customer | `customer@trip.test` | `password` |

---

## 🎯 Feature Summary

### ✅ Core Features (Completed)

- [x] Authentication (Laravel Breeze) — login, register, logout
- [x] Role-based access control (Admin / Staff / Customer)
- [x] Trip CRUD (Admin & Staff)
- [x] Participant registration per booking
- [x] Trip → Booking → Participant relationships
- [x] Search & filter (trips, bookings)
- [x] Form validation (server-side)
- [x] Git repository

### ✅ Customer Booking Flow (Completed)

- [x] Customer login
- [x] View available trips (with search + sort)
- [x] View trip details
- [x] Select trip & book
- [x] Register multiple participants
- [x] View own bookings
- [x] View booking status & payment status
- [x] Admin/Staff can view and manage all customer bookings

### ✅ Additional Features (Completed)

- [x] Payment status tracking (pending / paid / failed / refunded)
- [x] Simple dashboard (separate for Admin/Staff vs Customer)
- [x] Trip capacity management
  - [x] Max capacity per trip
  - [x] System blocks booking when trip is full
  - [x] Displays participant count and remaining seats

### ✅ Bonus Features (Partial)

- [x] Activity log model (`ActivityLog`)
- [x] Passport expiry warning (< 6 months before trip departure)
- [ ] Duplicate participant registration prevention (not implemented)
- [ ] Passport file upload (schema ready, UI not implemented)

---

## 🗂️ Database Schema

| Table | Purpose |
|-------|---------|
| `users` | All users with `role` (admin/staff/customer) |
| `trips` | Trips with capacity, dates, price, status |
| `bookings` | Bookings linking users to trips |
| `participants` | Participants per booking |
| `activity_logs` | Simple activity history |

### Relationships

- User (customer) **hasMany** Bookings
- Trip **hasMany** Bookings
- Trip **hasMany** Participants
- Booking **hasMany** Participants
- Booking **belongsTo** User, **belongsTo** Trip

---

## 🧪 Demo Flow (for interview)

1. **Login as Customer** (`customer@trip.test` / `password`)
2. Browse **Trips** → view trip → **Book Now**
3. Register 1+ participants → **Confirm Booking**
4. View **My Bookings** → see booking status + payment
5. **Logout** → **Login as Admin** (`admin@trip.test` / `password`)
6. Go to **Bookings** → view customer booking
7. Update booking status → **confirmed** + **paid**
8. Customer sees the updated status

---

## 🔧 Tech Stack

- **Laravel 13**
- **MySQL 9**
- **Laravel Breeze** (Blade + Tailwind CSS)
- **Vite** (asset bundling)
- **Git** (version control)

---

## 📝 Notes

- Passwords are hashed with bcrypt (Laravel default).
- Role middleware is registered in `bootstrap/app.php` as `role`.
- `.env` is gitignored — use `.env.example` as reference.
- Database engine is **InnoDB** (supports foreign keys).