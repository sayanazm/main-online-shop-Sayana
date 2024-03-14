<?php

namespace Model;

use Entity\ProductEntity;
use Model\Model;

class Product extends Model
{
    public function getAll() :array|null
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        $products = $stmt->fetchALL();

        if (empty($products)) {
            return null;
        }

        $productsEntity = [];
        foreach ($products as $product) {
            $product = new ProductEntity($product['id'], $product['name'], $product['price'], $product['image'], $product['description']);
            $productsEntity[] = $product;
        }

        return $productsEntity;
    }

    public function getOneById(int $id): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
        $data = $statement->fetch();

        return $data;
    }

}