<?php
namespace App\Config;

/**
 * Classe qui gére la connexion a la db (on a utilisé mysql).
 * Pour configurer la base de donnée tout est dans le readme.
 */

use PDO;
use PDOException;

class ConfigBD {
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO("mysql:host=localhost;dbname=projet_inscription", "root", "root");
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die(" Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
