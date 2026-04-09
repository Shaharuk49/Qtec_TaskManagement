# TaskFlow — Task Management System

A simple and clean task management system built with **Laravel 11** + **Bootstrap 5**.

---

## ✨ Features

- ✅ Create, view, edit, and delete tasks
- 🔄 Track task status — **Pending**, **In Progress**, **Completed**
- 🚦 Set task priority — **Low**, **Medium**, **High**
- 📅 Optional due date with **overdue detection**
- 🔍 Filter by status, priority, and keyword search
- 📊 Dashboard stats cards (total, pending, in progress, completed)
- ⚡ Quick status update from the task detail page
- 📄 Paginated task list (10 per page)

---

## 🛠 Tech Stack

- **Backend:** Laravel 11, PHP 8.2+
- **Frontend:** Bootstrap 5.3, Bootstrap Icons
- **Database:** MySQL
- **Testing:** PHPUnit

---

## ⚙️ Setup

### 1. Clone & Install
```bash
git clone https://github.com/your-username/task-manager.git
cd task-manager
composer install
```

### 2. Environment
```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database credentials:
```env
DB_DATABASE=taskflow
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. Migrate & Seed
```bash
php artisan migrate:fresh --seed
```

> Default demo account: `demo@taskflow.test` / `password`

### 4. Run
```bash
php artisan serve
```
Visit **http://localhost:8000**

---

## 🧪 Tests

```bash
php artisan test
```

- `tests/Unit/TaskTest.php` — Model scopes, accessors, casts
- `tests/Feature/TaskControllerTest.php` — CRUD, filters, validation

---

## 📁 Key Structure

```
app/Http/Controllers/TaskController.php
app/Http/Requests/StoreTaskRequest.php
app/Http/Requests/UpdateTaskRequest.php
app/Models/Task.php
resources/views/layouts/app.blade.php
resources/views/tasks/         ← index, create, edit, show
resources/views/partials/      ← stats, status-badge, priority-badge
database/migrations/
database/seeders/TaskSeeder.php
```
