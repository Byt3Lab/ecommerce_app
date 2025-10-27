<?php
namespace App\Controllers;

use App\Core\Env;
use App\Core\View;

class AdminController {
    public function index() {
        $view = new View();
        Env::load();
        $view->render('admin/dashboard', [
            'app_name' => $_ENV['APP_NAME'] ?? 'Mon site',
            'title' => 'Bienvenue sur la page d\'administration'
        ], null, 'admin');

    }
}
