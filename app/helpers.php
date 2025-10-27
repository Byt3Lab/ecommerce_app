<?php
use App\Core\View;

if (!function_exists('view')) {
    function view(string $view, array $data = []): void
    {
        View::render($view, $data);
    }
}
