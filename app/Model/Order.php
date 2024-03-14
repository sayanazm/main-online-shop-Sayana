<?php

namespace Model;

use Model\Model;

class Order extends Model
{
    public function create(int $userId, string $email, string $phone, string $name, string $address, string $city, string $country, int $postal) :void
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, email, phone, name, address, city, country, postal) VALUES (:user_id, :email, :phone, :name, :address, :city, :country, :postal)");
        $stmt->execute(['user_id' => $userId,'email' => $email, 'phone' => $phone, 'name' => $name, 'address' => $address, 'city' => $city, 'country' => $country, 'postal' => $postal]);
    }

    public function getOrderId(): false|string
    {
        return $this->pdo->lastInsertId();
    }

}