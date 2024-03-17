<?php

namespace Controller;

use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;

class OrderController
{
    private Order $orderModel;
    private OrderProduct $orderProductModel;
    private UserProduct $userProductModel;


    public function __construct()
    {
        $this->orderModel = new Order;
        $this->orderProductModel = new OrderProduct;
        $this->userProductModel = new UserProduct;

    }
    public function getOrderForm(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }
        $userId = $_SESSION['user_id'];
        $cartProducts = $this->userProductModel->getAllUserProducts($userId);
        $totalPrice = $this->getTotalPrice($cartProducts);

        require_once './../View/order.php';
    }

    public function order(array $array) :void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }
        $userId = $_SESSION['user_id'];
        $cartProducts = $this->userProductModel->getAllUserProducts($userId);
        $totalPrice = $this->getTotalPrice($cartProducts);

        $errors = $this->validateOrder($array, $userId);

        if (empty($errors)) {
            $email = $array['email'];
            $phone = $array['phone'];
            $name = $array['name'];
            $country = $array['country'];
            $city = $array['city'];
            $address = $array['address'];
            $postal = $array['postal'];

            $this->orderModel->create($userId, $email, $phone, $name, $address, $city, $country, $postal);
            $orderId = $this->orderModel->getOrderId();
            $this->orderProductModel->addFromUserProducts($userId, $orderId);
            $this->userProductModel->deleteAllUserProducts($userId);


            require_once './../View/massage.php';
        } else {
            require_once './../View/order.php';
        }

    }

    private function validateOrder(array $data, int $userId) :array
    {
        $errors = [];

        $cartProducts = $this->userProductModel->getAllUserProducts($userId);
        if (empty($cartProducts)) {
            $errors['cart'] = "Выберите товар для заказа";
        }
        
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

    public function getTotalPrice(array $cartProducts) :float
    {
        $totalPrice = '0';
        foreach ($cartProducts as $cartProduct) {
            $totalPrice += ($cartProduct->getPrice() * $cartProduct->getQuantity());
        }
        return $totalPrice;
    }

}