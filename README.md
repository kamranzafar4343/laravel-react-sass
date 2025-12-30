<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


# 🚀 Laravel + React + SASS Starter App

A simple starter application built using **Laravel (Backend API)**, **React (Frontend SPA)**, **Inertia.js**, and **SASS**.  
This project is perfect for learning CRUD, authentication, middleware, protected routes, and modern full-stack workflows.

---

## 📦 Tech Stack

- **Laravel 12** – Backend API, Auth, Routing  
- **React 18** – Frontend UI  
- **Inertia.js** – Single-Page App (SPA) bridge  
- **MySQL** – Database  
- **SASS** – Custom styling  
- **Vite** – Frontend bundler  

---

## 🔧 Installation & Setup

### Clone the repo
```bash
git clone https://github.com/yourname/yourrepo.git
cd yourrepo

2️⃣ Install PHP dependencies
composer install

3️⃣ Install Node dependencies
npm install

4️⃣ Create & configure .env
cp .env.example .env
php artisan key:generate


Update DB credentials:

DB_DATABASE=your_db
DB_USERNAME=root
DB_PASSWORD=

5️⃣ Run migrations
php artisan migrate

6️⃣ Start the development servers
npm run dev
php artisan serve

📁 Project Structure
app/
resources/
 ├── js/
 │    ├── Pages/      → React pages (Dashboard, Features etc.)
 │    ├── Components/ → Shared UI components
 │    └── Layouts/    → Main layouts
 └── sass/
      └── app.scss    → SASS styles
routes/
 ├── web.php          → Web routes
public/

🔐 Authentication

This project uses Laravel Breeze for login, registration, password reset, and email verification.

To install Breeze (if not installed):

composer require laravel/breeze
php artisan breeze:install react
npm install && npm run dev

✨ Features

✔ React pages using Inertia
✔ Dashboard UI
✔ SASS styling
✔ Basic CRUD (example: users, cars)
✔ Middleware example (role:admin)
✔ Protected routes
✔ Logout system
✔ Components + layout system

🛠 Build for production
npm run build


## For Testing 
Card Number: 4242 4242 4242 4242
Expiry Date: Any future date (e.g., 12/34)
CVC: Any 3 digits (e.g., 123)
ZIP: Any 5 digits (e.g., 12345)

📝 License

This project is open-source and available under the MIT License.


