<?php

namespace Model;

use Model\Model;

class Product extends Model
{
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        $products = $stmt->fetchALL();

        return $products;
    }

    public function getOneById(int $id): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
        $data = $statement->fetch();

        return $data;
    }

}