📌 Laravel + React + SASS Starter Kit

A minimal starter using Laravel (API Backend), React + Inertia.js (SPA Frontend), and SASS.

🧩 Tech Stack
Layer	Tech
Backend	Laravel 12, Sanctum
Frontend	React 18, Inertia.js
Styling	SASS / Tailwind via Vite
Build	Vite
Database	MySQL / SQLite
Testing	PestPHP / PHPUnit
📁 Project Structure
app/                     ← Backend (controllers, models, logic)
resources/
 ├─ js/                  ← React + Inertia
 │   ├─ Pages/           ← Screens & views
 │   ├─ Components/      ← Shared UI
 │   └─ Layouts/         ← App shell layout
 ├─ sass/                ← SASS styles
routes/
 └─ web.php              ← Routes

🔐 Authentication

Login / Register

Logout

✨ Features

Laravel + React SPA (Inertia)

SASS styling

Protected routes & middleware

CRUD-ready structure

💳 Stripe Test Card (if enabled)
Field	Value
Card	4242 4242 4242 4242
Expiry	12/34
CVC	123
ZIP	12345

🧪 Run Tests (Pest)
php artisan test
