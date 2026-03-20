# OFPPT Training Management System - Backend API

## 📝 Description
This is the backend REST API for the **OFPPT Training Management System**. It provides a robust and secure foundation for managing training formations, themes, sessions, participants, and absences. Built with Laravel 12, it follows modern best practices for API development, including Role-Based Access Control (RBAC) and Sanctum-based authentication.

---

## 🚀 Tech Stack
- **Framework**: [Laravel 12](https://laravel.com)
- **PHP**: ^8.2
- **Authentication**: [Laravel Sanctum](https://laravel.com/docs/sanctum)
- **Database**: SQLite (default) / MySQL / PostgreSQL
- **Tools**: Laravel Tinker, Artisan, Composer

---

## ✨ Key Features
- **Authentication System**: Secure registration, login, and profile management using Sanctum.
- **Role-Based Access Control (RBAC)**: Fine-grained permissions for different user roles (Admin, CDC, Formateur).
- **Resource Management**: Complete CRUD operations for:
  - 📚 **Themes & Formations**: Manage the educational catalog.
  - 🗓️ **Sessions**: Schedule and track training sessions.
  - 👥 **Participants & Inscrits**: Manage student enrollment and profiles.
  - 📝 **Absences**: Log and monitor attendance.
  - 📂 **Documents**: Manage related training materials.
- **Form Validation**: Robust input validation using Laravel FormRequests.
- **API Resources**: Consistent JSON responses for all endpoints.

---

## 🛠️ Installation & Setup

### 1. Prerequisites
Ensure you have the following installed:
- PHP ^8.2
- Composer
- Node.js & NPM (for frontend assets if applicable)

### 2. Quick Setup
The project includes a convenient setup script:
```bash
composer setup
```
This command will:
- Install dependencies
- Copy `.env.example` to `.env`
- Generate the Application Key
- Run migrations and seeds
- Build assets

### 3. Manual Steps (Alternative)
If you prefer manual setup:
```bash
# Install PHP dependencies
composer install

# Configure Environment
cp .env.example .env
php artisan key:generate

# Run Migrations & Seeders
php artisan migrate --seed

# Start the Server
php artisan serve
```

---

## 🔌 API Reference

### Public Endpoints
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `POST` | `/api/register` | Register a new user |
| `POST` | `/api/login` | Login and receive a token |

### Protected Endpoints (Requires Bearer Token)
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/me` | Get current user profile |
| `POST` | `/api/logout` | Revoke the current token |
| `GET/POST/PUT/DELETE` | `/api/themes` | Manage training themes |
| `GET/POST/PUT/DELETE` | `/api/formations` | Manage formations |
| `GET/POST/DELETE` | `/api/sessions` | Manage sessions |
| `GET/POST/DELETE` | `/api/participants` | Manage participants |
| `GET/POST/DELETE` | `/api/absences` | Manage attendance |

---

## 🤝 Contributing
1. Clone the repository.
2. Create a new branch (`git checkout -b feature/amazing-feature`).
3. Commit your changes (`git commit -m 'Add some amazing feature'`).
4. Push to the branch (`git push origin feature/amazing-feature`).
5. Open a Pull Request.

---

## 📄 License
This project is open-sourced software licensed under the [MIT license](LICENSE).
