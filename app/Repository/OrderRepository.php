<?php

namespace Repository;

use Entity\Order;
use Repository\Repository;

class OrderRepository extends Repository
{
    public function create(int $userId, string $email, string $phone, string $name, string $address, string $city, string $country, int $postal) :void
    {
        $stmt = self::getPdo()->prepare("INSERT INTO orders (user_id, email, phone, name, address, city, country, postal) VALUES (:user_id, :email, :phone, :name, :address, :city, :country, :postal)");
        $stmt->execute(['user_id' => $userId,'email' => $email, 'phone' => $phone, 'name' => $name, 'address' => $address, 'city' => $city, 'country' => $country, 'postal' => $postal]);
    }

    public function getOrderId(): false|string
    {
        return self::getPdo()->lastInsertId();
    }

    public function getOrderByOrderId(int $orderId) : Order | null
    {
        $statement = self::getPdo()->prepare("SELECT * FROM orders WHERE id = :id");
        $statement->execute(['id' => $orderId]);
        $order = $statement->fetch();

        if (empty($order))
        {
            return null;
        }

        return $this->hydrate($order);
    }

    private function hydrate(array $order): Order
    {
        return new Order($order['id'], $order['user_id'], $order['email'], $order['phone'], $order['name'], $order['country'], $order['city'], $order['address'], $order['postal']);
    }

}