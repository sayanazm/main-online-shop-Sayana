<?php

namespace Repository;

use Core\Repository;
use Entity\Product;
use Entity\User;
use Entity\UserProduct;

class UserProductRepository extends Repository
{
    public function addProduct(int $userId, int $productId, int $quantity): void
    {
        $stmnt = self::getPdo()->prepare("INSERT INTO user_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
        $stmnt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public function getAllUserProducts(int $userId): array|null
    {
        $stmt = self::getPdo()->prepare("SELECT up.id as id, u.id as user_id, u.name as user_name,
                                           u.email, u.password, p.id as product_id, p.name as product_name,
                                           p.price, p.image, p.description, up.quantity
                                           FROM user_products up
                                           JOIN users u ON up.user_id = u.id
                                           JOIN products p ON up.product_id = p.id
                                           WHERE user_id =:user_id");
        $stmt->execute(['user_id' => $userId]);
        $userProducts = $stmt->fetchAll();

        if (empty($userProducts)) {
            return null;
        }

        $userProductsEntity = [];
        foreach ($userProducts as $userProduct) {
            $userProductsEntity[] = $this->hydrate($userProduct);
        }

        return $userProductsEntity;
    }

    public function getOneByProductId(int $userId, int $productId) : UserProduct|null
    {
        $stmt = self::getPdo()->prepare("SELECT up.id as id, u.id as user_id, u.name as user_name,
                                           u.email, u.password, p.id as product_id, p.name as product_name,
                                           p.price, p.image, p.description, up.quantity
                                           FROM user_products up
                                           JOIN users u ON up.user_id = u.id
                                           JOIN products p ON up.product_id = p.id
                                           WHERE user_id = :user_id
                                           AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $userProduct = $stmt->fetch();

        if (empty($userProduct)) {
            return null;
        }

        return $this->hydrate($userProduct);
    }

    public function plusQuantity(int $userId, int $productId): void
    {
        $stmt = self::getPdo()->prepare("UPDATE user_products SET quantity = (quantity + 1) WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public function minusQuantity(int $userId, int $productId): void
    {
        $stmt = self::getPdo()->prepare("UPDATE user_products SET quantity = (quantity - 1) WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public function deleteProduct(int $userId, $productId): void
    {
        $stmt = self::getPdo()->prepare("DELETE FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public function deleteAllUserProducts(int $userId) :void
    {
        $statement = self::getPdo()->prepare('DELETE FROM user_products WHERE user_id = :user_id');
        $statement->execute(['user_id' => $userId]);
    }

    private function hydrate(array $userProduct): UserProduct
    {
        return new UserProduct(
            $userProduct['id'],
            new User($userProduct['user_id'], $userProduct['user_name'], $userProduct['email'], $userProduct['password']),
            new Product($userProduct['product_id'], $userProduct['product_name'], $userProduct['price'], $userProduct['image'], $userProduct['description']),
            $userProduct['quantity']
        );
    }
}