<?php
namespace App\Core;

use Dotenv\Dotenv;
use Exception;

class Env
{
    public static function load(string $basePath = null): void
    {
        // Déterminer dynamiquement la racine du projet
        if ($basePath === null) {
            // 2 niveaux au-dessus du fichier Env.php → racine du projet
            $basePath = dirname(__DIR__, 2);
            
        }

        $envPath = $basePath . DIRECTORY_SEPARATOR . '.env';

        if (!file_exists($envPath)) {
            throw new Exception(".env file not found at {$envPath}");
        }

        // Charger le fichier .env
        $dotenv = Dotenv::createImmutable($basePath);
        $dotenv->load();
    }
}
