<?php

namespace Model;

use Entity\UserProductEntity;
use Model\Model;

class UserProduct extends Model
{
    public function addProduct(int $userId, int $productId, int $quantity): void
    {
        $stmnt = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
        $stmnt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public function getAllUserProducts(int $userId): array|null
    {
        $stmt = $this->pdo->prepare("SELECT user_products.id, 
        user_products.user_id, name, price, image, id, 
        user_products.quantity FROM products JOIN user_products 
        ON products.id = user_products.product_id WHERE user_id =:user_id");
        $stmt->execute(['user_id' => $userId]);
        $userProducts = $stmt->fetchAll();

        if (empty($userProducts)) {
            return null;
        }

        $userProductsEntity = [];
        foreach ($userProducts as $userProduct) {
            $userProduct = new UserProductEntity($userProduct['id'], $userProduct['user_id'], $userProduct['name'], $userProduct['price'], $userProduct['image'], $userProduct['product_id'], $userProduct['quantity']);
            $userProductsEntity[] = $userProduct;
        }

        return $userProductsEntity;
    }

    public function getOneByProductId(int $userId, int $productId) : UserProductEntity|null
    {
        $stmt = $this->pdo->prepare("SELECT id, user_id, products.name, products.price, products.image, products.id, quantity FROM user_products WHERE user_id=:user_id AND product_id=:product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $userProduct = $stmt->fetch();

        if (empty($userProduct)) {
            return null;
        }

        return new UserProductEntity($userProduct['id'], $userProduct['user_id'], $userProduct['name'], $userProduct['price'], $userProduct['quantity'], $userProduct['image']);
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