<?php
namespace App\Controllers;

use App\Core\Env;
use App\Core\View;

class HomeController {
    public function index() {
        $view = new View();
        Env::load();
        $view->render('home/index', [
            'app_name' => $_ENV['APP_NAME'] ?? 'Mon site',
            'title' => 'Bienvenue sur la page d\'accueil'
        ]);
    }
}
