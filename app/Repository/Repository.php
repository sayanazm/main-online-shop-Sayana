<?php

namespace Repository;

use PDO;

class Repository
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

    public function beginTransaction(): void
    {
        $this->pdo->beginTransaction();
    }

    public function commit(): void
    {
        $this->pdo->commit();
    }

    public function rollBack(): void
    {
        $this->pdo->rollBack();
    }
}