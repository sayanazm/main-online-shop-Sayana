<?php

namespace Repository;

use Entity\Product;
use Repository\Repository;

class ProductRepository extends Repository
{
    public function getAll() :array|null
    {
        $stmt = self::getPdo()->query("SELECT * FROM products");
        $products = $stmt->fetchALL();

        if (empty($products)) {
            return null;
        }

        $productsEntity = [];
        foreach ($products as $product) {
            $productsEntity[] = $this->hydrate($product);
        }

        return $productsEntity;
    }

    public function getOneById(int $id): array
    {
        $statement = self::getPdo()->prepare("SELECT * FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }

    private function hydrate(array $data): Product
    {
        return new Product($data['id'], $data['name'], $data['price'], $data['image'], $data['description']);

    }

}