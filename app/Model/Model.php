<?php

namespace Model;

use PDO;

class Model
{
    protected PDO $pdo;
    public function __construct()
    {
        $host = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $username = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');

        $this->pdo = new PDO("pgsql:host=$host; port=5432; dbname=$dbname", $username, $password);

    }
}