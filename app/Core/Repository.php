<?php

namespace Core;

use PDO;

class Repository
{
    protected static PDO $pdo;

    public static function getPdo(): PDO
    {
        if (isset(self::$pdo)) {
            return self::$pdo;
        }

        $host = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $username = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');

        return self::$pdo = new PDO("pgsql:host=$host; port=5432; dbname=$dbname", $username, $password);
    }

}