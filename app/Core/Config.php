<?php
namespace App\Core;

use Dotenv\Dotenv;

class Config
{
    private static bool $loaded = false;

    private static function loadEnv(): void
    {
        if (!self::$loaded) {
            $root = dirname(__DIR__, 2);
            if (file_exists($root . '.env')) {
                $dotenv = Dotenv::createImmutable($root);
                $dotenv->load();
            }
            self::$loaded = true;
        }
    }

    public static function get(string $key, $default = null)
    {
        self::loadEnv();
        return $_ENV[$key] ?? $default;
    }

    public static function dbConfig(): array
    {
        return [
            'host' => self::get('DB_HOST', 'localhost'),
            'port' => self::get('DB_PORT', '3306'),
            'name' => self::get('DB_NAME', 'test'),
            'user' => self::get('DB_USER', 'root'),
            'pass' => self::get('DB_PASS', ''),
        ];
    }
}
