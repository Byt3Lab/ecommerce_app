# ECOMMERCE_APP — Developer Documentation

**Project Type:** PHP MVC (Custom Framework)
**Stack:** PHP 8+, Composer, XAMPP, MySQL
**Architectural Pattern:** MVC (Model-View-Controller)
**Layouts:** Front Office & Admin Dashboard
**Routing:** Custom Router with dynamic error handling
**Environment Variables:** `.env` via `vlucas/phpdotenv`
**Views:** PHP templates with layout system

---

## Table of Contents

1. [Project Structure](#project-structure)
2. [Environment Setup](#environment-setup)
3. [Routing System](#routing-system)
4. [Controller Structure](#controller-structure)
5. [Views & Layouts](#views--layouts)
6. [Error Handling](#error-handling)
7. [Helpers](#helpers)
8. [Development Workflow](#development-workflow)
9. [Testing](#testing)

---

## 1. Project Structure

```
ecommerce_app/
│
├── app/
│   ├── Controllers/          # All controllers (HomeController, AdminController, ErrorController, etc.)
│   ├── Core/                 # Core system (Router, Env, View)
│   ├── Models/               # Data models (optional)
│   └── Helpers.php           # Global helper functions
│
├── public/                   # Public folder for web access
│   ├── index.php             # Main entry point
│   └── assets/               # CSS, JS, images, vendor assets
│
├── Views/                    # All views
│   ├── front/                # Front office layout views
│   │   ├── home/accueil.php
│   │   └── layouts/front.php
│   ├── admin/                # Admin dashboard layout views
│   │   └── layouts/admin.php
│   └── errors/               # Error pages (404.php, 403.php, 500.php)
│
├── vendor/                   # Composer dependencies
├── .env                      # Environment variables
├── composer.json
└── README.md
```

---

## 2. Environment Setup

**.env Example:**

```
APP_NAME=ECOMMERCE_APP
DB_HOST=localhost
DB_PORT=3306
DB_NAME=ecommerce_db
DB_USER=root
DB_PASS=
```

**Env Class (app/Core/Env.php):**

- Automatically loads `.env` file from project root.
- Access variables via `$_ENV['VAR_NAME']`.

```php
use Dotenv\Dotenv;

class Env {
    public static function load(): void {
        $basePath = dirname(__DIR__, 2);
        if (!file_exists($basePath . '/.env')) {
            throw new \Exception(".env file not found at $basePath");
        }
        $dotenv = Dotenv::createImmutable($basePath);
        $dotenv->load();
    }
}
```

**Usage:**

```php
Env::load();
echo $_ENV['APP_NAME']; // Output: ECOMMERCE_APP
```

---

## 3. Routing System

**File:** `app/Core/Router.php`

- Supports `GET` and `POST` methods.
- Dynamic normalization of URIs (`/path/` → `/path`).
- Handles custom error pages (404, 403, 500).

**Define Routes:**

```php
$router->get('/', 'HomeController@index');
$router->get('/contact', 'ContactController@index');
$router->get('/dashboard', 'AdminController@index');

// Error Pages
$router->setErrorPage(404, 'ErrorController@notFound');
$router->setErrorPage(403, 'ErrorController@forbidden');
$router->setErrorPage(500, 'ErrorController@internal');
```

**Dispatching Routes:**

```php
$router->dispatch();
```

**Features:**

- Automatically serves `index.php` as `/`.
- Handles missing controller/method gracefully.
- Can easily extend to dynamic parameters (e.g., `/products/{id}`).

---

## 4. Controller Structure

- All controllers are in `app/Controllers`.
- Must have methods corresponding to actions defined in the router.

**Example: HomeController.php**

```php
namespace App\Controllers;
use App\Core\Env;
use App\Core\View;

class HomeController {
    public function index() {
        Env::load();
        View::render('front/home/accueil', [
            'title' => 'Bienvenue sur la page d\'accueil'
        ], 'front');
    }
}
```

**AdminController Example:**

```php
namespace App\Controllers;
use App\Core\View;

class AdminController {
    public function index() {
        View::render('admin/dashboard', ['title' => 'Tableau de bord'], 'admin');
    }
}
```

---

## 5. Views & Layouts

**View Class (app/Core/View.php):**

```php
class View {
    public static function render(string $view, array $data = [], string $layout = 'front'): void {
        $viewPath = dirname(__DIR__) . "/Views/{$view}.php";
        if (!file_exists($viewPath)) throw new \Exception("View $viewPath not found");
        extract($data);
        ob_start();
        require $viewPath;
        $content = ob_get_clean();
        require dirname(__DIR__) . "/Views/{$layout}/layouts/{$layout}.php";
    }
}
```

**Layouts:**

- `Views/front/layouts/front.php` → front office layout
- `Views/admin/layouts/admin.php` → dashboard layout

`$content` variable is automatically injected.

**Example: accueil.php**

```php
<h1><?php echo $title; ?></h1>
<p>Contenu de la page d'accueil.</p>
```

---

## 6. Error Handling

- Custom error pages located in `Views/errors/`.
- `ErrorController` handles all HTTP errors.
- Can pass dynamic messages to error views.

```php
class ErrorController {
    public function notFound() {
        View::render('errors/404', ['title' => 'Page non trouvée'], 'front');
    }
    public function forbidden() { ... }
    public function internal($message = '') { ... }
}
```

---

## 7. Helpers

**app/helpers.php** — global helper functions:

```php
<?php
function url(string $path = ''): string {
    $base = rtrim(str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['PHP_SELF']), '/');
    return $base . '/' . ltrim($path, '/');
}
```

---

## 8. Development Workflow

1. Clone the repository into `htdocs/` in XAMPP.
2. Run `composer install`.
3. Copy `.env.example` → `.env` and update your DB credentials.
4. Start XAMPP Apache & MySQL.
5. Access app via `http://localhost/ecommerce_app/public/`.
6. Define routes in `index.php`.
7. Create controllers in `app/Controllers`.
8. Create views in `Views/front` or `Views/admin`.

---

## 9. Testing

### Manual Testing

- Open each route in the browser (`/`, `/products`, `/dashboard`).
- Test missing pages → should render `Views/errors/404.php`.
- Test forbidden access (if implemented) → 403 page.
- Test internal errors → 500 page.

### Unit Testing (Optional)

- Install **PHPUnit** via Composer.
- Test controllers and View rendering independently.
- Example:

```php
use PHPUnit\Framework\TestCase;
use App\Controllers\HomeController;

class HomeControllerTest extends TestCase {
    public function testIndex() {
        $controller = new HomeController();
        ob_start();
        $controller->index();
        $output = ob_get_clean();
        $this->assertStringContainsString('Bienvenue', $output);
    }
}
```

---

## ✅ Summary

- Fully dynamic **MVC structure**.
- **Layouts** for front and admin.
- **Centralized router** with error handling.
- `.env` configuration for environment variables.
- Easy to extend for **dynamic routes** and **parameterized URLs**.
- Supports **modular development** and testing.
