<?php
namespace App\Controllers;

use App\Core\View;

class ContactController {
    public function index() {
        $view = new View();
        $view->render('home/contact', [
            'title' => 'Bienvenue sur la page de contact'
        ]);
    }
}
