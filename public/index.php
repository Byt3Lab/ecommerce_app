<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/helpers.php';

use App\Core\Env;
use App\Core\Router;

// Charge automatiquement depuis la racine du projet
Env::load();

// Charger le routeur
$router = new Router();

// front routes
$router->get('/', 'HomeController@index');
$router->get('/contact', 'ContactController@index');
$router->get('/products', 'ProductController@index');

// dashboard routes
$router->get('/dashboard', 'AdminController@index');

// Pages d’erreur personnalisées
$router->setErrorPage(404, 'ErrorController@notFound');
$router->setErrorPage(403, 'ErrorController@forbidden');
$router->setErrorPage(500, 'ErrorController@internal');

// Lancer le routeur
$router->dispatch();
