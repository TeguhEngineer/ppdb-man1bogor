<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel 11 Basecode Template

Template basecode Laravel 11 dengan TailwindCSS, authentication, role-based access control, dan API support.

## Fitur

### Authentication & Authorization
- ✅ Authentication dengan Laravel Breeze
- ✅ Role-based middleware (Administrator & Operator)
- ✅ Activity logging untuk audit trail
- ✅ Protected routes dengan middleware

### CRUD Features
- ✅ User Management (Admin only)
  - Create, Read, Update, Delete users
  - Export to Excel
  - Search & pagination
- ✅ Product Management (Admin & Operator)
  - CRUD dengan image upload
  - Image storage management
  - Search & pagination
  - Clean code dengan Form Requests

### API Support
- ✅ RESTful API dengan versioning (v1)
- ✅ Laravel Sanctum authentication
- ✅ API Resources & Collections
- ✅ Rate limiting
- ✅ Endpoints:
  - Authentication (login, register, logout)
  - User management
  - Product management

### UI/UX
- ✅ TailwindCSS styling
- ✅ Responsive sidebar navigation
- ✅ Modal-based forms
- ✅ Toast notifications
- ✅ Error handling & validation messages

## Installation

### Requirements
- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite/MySQL/PostgreSQL

### Setup

1. Clone repository
```bash
git clone <repository-url>
cd basecode-laravel11-tailwind
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
copy .env.example .env
php artisan key:generate
```

4. Configure database di `.env`
```env
DB_CONNECTION=sqlite
# atau untuk MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=your_database
# DB_USERNAME=your_username
# DB_PASSWORD=your_password
```

5. Run migrations & seeders
```bash
php artisan migrate --seed
```

6. Create storage link
```bash
php artisan storage:link
```

7. Build assets
```bash
npm run dev
```

8. Start development server
```bash
php artisan serve
```

## Default Users

Setelah seeding, gunakan kredensial berikut:

**Administrator:**
- Email: administrator@gmail.com
- Password: password

**Operator:**
- Email: operator@gmail.com
- Password: password

## API Documentation

### Base URL
```
http://localhost:8000/api/v1
```

### Authentication

**Login**
```http
POST /api/v1/login
Content-Type: application/json

{
  "email": "administrator@gmail.com",
  "password": "password"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {...},
    "token": "your-api-token"
  }
}
```

**Logout**
```http
POST /api/v1/logout
Authorization: Bearer {token}
```

### Protected Endpoints

Semua endpoint berikut memerlukan header:
```
Authorization: Bearer {your-api-token}
```

**Get Current User**
```http
GET /api/v1/user
```

**Users (Admin only)**
```http
GET    /api/v1/users
POST   /api/v1/users
GET    /api/v1/users/{id}
PUT    /api/v1/users/{id}
DELETE /api/v1/users/{id}
```

**Products (Admin & Operator)**
```http
GET    /api/v1/produk
POST   /api/v1/produk
GET    /api/v1/produk/{id}
PUT    /api/v1/produk/{id}
DELETE /api/v1/produk/{id}
```

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/V1/          # API Controllers
│   │   ├── ProdukController.php
│   │   └── UserManajemenController.php
│   ├── Middleware/
│   │   ├── AdminMiddleware.php
│   │   └── OperatorMiddleware.php
│   └── Resources/           # API Resources
├── Models/
├── Traits/
│   └── HasActivityLog.php   # Activity logging trait
└── ...

routes/
├── api.php                  # API routes (v1)
├── web.php                  # Web routes
└── ...

resources/
├── views/
│   ├── produk/
│   ├── userManajemen/
│   └── ...
└── ...
```

## Middleware

### Admin Middleware
Hanya user dengan role `administrator` yang dapat mengakses.

```php
Route::middleware('admin')->group(function () {
    // Admin only routes
});
```

### Operator Middleware
User dengan role `administrator` atau `operator` dapat mengakses.

```php
Route::middleware('operator')->group(function () {
    // Admin & Operator routes
});
```

## Activity Logging

Gunakan trait `HasActivityLog` untuk logging aktivitas:

```php
use App\Traits\HasActivityLog;

class YourController extends Controller
{
    use HasActivityLog;

    public function store(Request $request)
    {
        // Your code...
        
        self::logActivity('create', 'Created item: ' . $item->name, [
            'item_id' => $item->id
        ]);
    }
}
```

Log akan tersimpan di `storage/logs/laravel.log`.

## Development

### Build for production
```bash
npm run build
```

### Run tests
```bash
php artisan test
```

### Code formatting
```bash
./vendor/bin/pint
```

## License

MIT License
