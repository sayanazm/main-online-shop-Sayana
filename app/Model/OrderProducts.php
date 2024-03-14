<?php

namespace Model;

class OrderProducts
{
    public function add($userId, $orderId): void
    {
        $statement = $this->pdo->prepare("INSERT INTO order_products (order_id, product_id, quantity)
            SELECT :order_id, product_id, quantity
            FROM user_products
            WHERE user_id = :user_id");

        $statement->execute(['user_id' => $userId, 'order_id' => $orderId]);
    }
}