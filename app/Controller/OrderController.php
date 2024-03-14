<?php

namespace Controller;

use Model\Order;
use Model\OrderProducts;

class OrderController
{
    private Order $orderModel;
    private OrderProducts $orderProductsModel;

    public function __construct()
    {
        $this->orderModel = new Order;
        $this->orderProductsModel = new OrderProducts;

    }
    public function getOrderForm(): void
    {
        require_once './../View/order.php';
    }

    public function order(array $array) :void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        $errors = $this->validateOrder($array);

        if (empty($errors)) {
            $userId = $_SESSION['user_id'];
            $email = $array['email'];
            $phone = $array['phone'];
            $name = $array['name'];
            $country = $array['country'];
            $city = $array['city'];
            $address = $array['address'];
            $postal = $array['postal'];

            $this->orderModel->create($userId, $email, $phone, $name, $address, $city, $country, $postal);
            $orderId = $this->orderModel->getOrderId();
            $this->orderProductsModel->add($userId, $orderId);

        } else {
            require_once './../View/order.php';
        }

    }

    private function validateOrder(array $data) :array
    {
        $errors = [];
        
        if (!empty($data['name'])) {
            if (strlen($data['name']) < 2) {
                $errors['name'] = "Имя должно быть больше 2 символов";
            }
        } else {
            $errors['name'] = 'Значение не может быть пустым';
        }
        
        if (!empty($data['email'])) {
            if (strlen($data['email']) < 2) {
                $errors['email'] = 'Email должен быть больше 2 символов';
            } else {
                $str = '@';
                $strpos = strpos($data['email'], $str);

                if ($strpos === false) {
                    $errors['email'] = 'Email должен содержать @';
                }

            }
        } else {
            $errors['email'] = 'Значение не может быть пустым';
        }

        return $errors;
    }

}