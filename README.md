# OFPPT-FormPr Backend (Laravel 12)

This is the backend API for the OFPPT Formation Project. It provides a RESTful API built with Laravel 12 and uses Sanctum for authentication.

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- SQLite (default) or MySQL/PostgreSQL

### Quick Setup
We've included a setup script to get you started quickly:
```bash
composer setup
```
This command will:
1. Copy `.env.example` to `.env` (if not exists)
2. Install PHP dependencies
3. Generate application key
4. Run database migrations
5. Install and build frontend assets (if applicable)

### Manual Installation
1. Install dependencies:
   ```bash
   composer install
   ```
2. Configure environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Initialize database:
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

### Development
Run the development server:
```bash
php artisan serve
```

## 🔐 API Authentication
The project uses **Laravel Sanctum**. To access protected routes, include the `Authorization: Bearer <token>` header in your requests.

## 🛠 Tech Stack
- **Framework:** Laravel 12
- **Authentication:** Sanctum
- **Database:** SQLite (Development)
- **API Documentation:** Scribe (optional/planned)

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
