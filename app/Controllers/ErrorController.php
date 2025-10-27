<?php
namespace App\Controllers;

use App\Core\View;

class ErrorController {
    public function notFound() {
        View::render('errors/404', ['title' => 'Page non trouvée'], null, 'front');
    }

    public function forbidden() {
        View::render('errors/403', ['title' => 'Accès refusé'], null, 'front');
    }

    public function internal($message = '') {
        View::render('errors/500', ['title' => 'Erreur interne', 'message' => $message], null, 'front');
    }
}
