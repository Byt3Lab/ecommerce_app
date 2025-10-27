<?php
    namespace App\Controllers;

    class BaseController {
        protected function render($viewPath, $data = []) {
            extract($data);
            $viewFile = __DIR__ . '/../Views/' . $viewPath . '.php';
            if (!file_exists($viewFile)) {
                die('View not found: ' . $viewFile);
            }
            include __DIR__ . '/../Views/layouts/header.php';
            include $viewFile;
            include __DIR__ . '/../Views/layouts/footer.php';
        }

        protected function json($data, $status = 200) {
            http_response_code($status);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
