# Laravel + React + SASS Starter Kit

A minimal starter using **Laravel (API Backend)**, **React + Inertia.js (SPA Frontend)**, and **SASS**.

---

## 🧩 Tech Stack
| Layer     | Tech                          |
|-----------|-------------------------------|
| Backend   | Laravel 12, Sanctum           |
| Frontend  | React 18, Inertia.js          |
| Styling   | SASS / Tailwind via Vite      |
| Build     | Vite                          |
| Database  | MySQL / SQLite                |
| Testing   | PestPHP / PHPUnit             |

---

## 📁 Structure
app/ ← Backend (routes, controllers, models)
resources/js/ ← React + Inertia SPA
├─ Pages/ ← Screens
├─ Components/ ← Shared UI
└─ Layouts/ ← UI Shell
resources/sass/ ← Styles
routes/web.php ← Routes


---

## 🔐 Auth
- Login / Register
- Logout

---

## ✨ Features
- Laravel + React SPA with Inertia
- SASS styling
- Protected routes & middleware
- CRUD-ready structure

---

## 🧪 Stripe Test (if enabled)
| Field  | Value |
|--------|-------|
| Card   | **4242 4242 4242 4242** |
| Expiry | 12/34 |
| CVC    | 123 |
| ZIP    | 12345 |

---

## 🧾 Run Tests (Pest)
```bash
php artisan test
