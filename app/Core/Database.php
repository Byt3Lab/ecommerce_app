<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static $connection = null;

    public static function connect() {
        if (self::$connection === null) {
            $host = $_ENV['DB_HOST'];
            $db = $_ENV['DB_DATABASE'];
            $user = $_ENV['DB_USERNAME'];
            $pass = $_ENV['DB_PASSWORD'];
            try {
                self::$connection = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
