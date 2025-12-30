# Laravel + React + SASS Starter Kit

A lightweight starter project using **Laravel (API Backend)**, **React + Inertia.js (SPA Frontend)**, and **SASS Styling**.  

---

## 🧩 Tech Stack

| Layer | Tech |
|-------|------|
| Backend | Laravel 12, Sanctum Auth |
| Frontend | React 18, Inertia.js |
| Styling | SASS / Tailwind (via Vite) |
| Build Tool | Vite |
| DB | MySQL / SQLite |
| Testing | PestPHP / PHPUnit |

---

## ⚙️ Installation

```bash
# 1️⃣ Clone
git clone https://github.com/kamranzafar4343/laravel-react-sass.git
cd yourrepo

# 2️⃣ Install backend
composer install

# 3️⃣ Install frontend
npm install

# 4️⃣ Create env + key
cp .env.example .env
php artisan key:generate

# 5️⃣ Configure Database (.env)
DB_DATABASE=your_db
DB_USERNAME=root
DB_PASSWORD=

# 6️⃣ Migrate
php artisan migrate

# 7️⃣ Run Dev Servers
npm run dev
php artisan serve


📁 Project Structure
app/                  ← Laravel backend (routes, controllers, models)
resources/js/         ← React + Inertia SPA
 ├─ Pages/            ← Page components
 ├─ Components/       ← Shared UI
 └─ Layouts/          ← App layouts
resources/sass/       ← SASS styles
routes/web.php        ← App routes

---

🔐 Authentication

Login / Register
Logout

---

✨ Features

✔ Laravel + React SPA with Inertia
✔ Authentication scaffolding
✔ Pages, Layouts, Components structure
✔ SASS styling support
✔ Protected routes & middleware example
✔ Ready for CRUD modules

---

🧪 Stripe Test Payments(use this Test card)

Card Number:	4242 4242 4242 4242
Expiry:	Any future date (12/34)
CVC	Any: (123)
ZIP	Any: (12345)


Run test(pest):

php artisan test