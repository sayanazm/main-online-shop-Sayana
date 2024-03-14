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

    public function getAllUserProducts(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT name, price, image, user_products.quantity FROM products JOIN user_products ON products.id = user_products.product_id WHERE user_id =:user_id");
        $stmt->execute(['user_id' => $userId]);
        $userProducts = $stmt->fetchAll();

        return $userProducts;
    }

    public function getOneByProductId(int $userId, int $productId) :array|bool
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id=:user_id AND product_id=:product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        return $stmt->fetch();
    }

    public function plusQuantity(int $userId, int $productId): void
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET quantity = (quantity + 1) WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public function minusQuantity(int $userId, int $productId): void
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET quantity = (quantity - 1) WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public function deleteProduct(int $userId, $productId): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public function deleteAllUserProducts(int $userId) :void
    {
        $statement = $this->pdo->prepare('DELETE FROM user_products WHERE user_id = :user_id');
        $statement->execute(['user_id' => $userId]);
    }
}