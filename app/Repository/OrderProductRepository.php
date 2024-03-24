<?php

namespace Repository;

use Throwable;

class OrderProductRepository extends Repository
{

    /**
     * @throws Throwable
     */
    public function replaceToOrder(int $userId, int $orderId) :array
    {
        try {
            $this->pdo->beginTransaction();

            $statement = $this->pdo->prepare("INSERT INTO order_products (order_id, product_id, quantity)
            SELECT :order_id, product_id, quantity
            FROM user_products
            WHERE user_id = :user_id");

            $statement->execute(['user_id' => $userId, 'order_id' => $orderId]);

            $deletedProducts = $statement->fetchAll();

            $statement = $this->pdo->prepare('DELETE FROM user_products WHERE user_id = :user_id');
            $statement->execute(['user_id' => $userId]);

            $this->pdo->commit();

            return $deletedProducts;

        } catch (Throwable $exception ) {
            $this->pdo->rollBack();
            throw $exception;
        }
    }
}