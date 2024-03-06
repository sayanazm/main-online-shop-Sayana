<?php

namespace Model;

use Model\Model;

class UserProduct extends Model
{
    public function addProduct(int $userId, int $productId, int $quantity): void
    {
        $stmnt = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
        $stmnt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public function getAllUserProducts(string $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT name, price, image, user_products.quantity FROM products JOIN user_products ON products.id = user_products.product_id WHERE user_id =:user_id");
        $stmt->execute(['user_id' => $userId]);
        $userProducts = $stmt->fetchAll();

        return $userProducts;
    }

}