<?php

declare(strict_types=1);

namespace Mini\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    public static function getPDO(): PDO
    {
        if (self::$pdo === null) {
            // Configuration
            $host = '127.0.0.1';
            $port = '8889'; // MAMP: 8889, XAMPP: 3306, Default: 3306
            $dbname = 'ecommerce_project';
            $username = 'root';
            $password = 'root';

            try {
                self::$pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
