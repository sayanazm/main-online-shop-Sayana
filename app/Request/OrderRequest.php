<?php

namespace Request;

use Core\Request;
use Repository\UserProductRepository;
use Repository\UserRepository;

class OrderRequest extends Request
{
    private UserProductRepository $userProductRepository;

    public function __construct(string $method, string $uri, array $headers, array $body)
    {
        parent::__construct($method, $uri, $headers, $body);

        $this->userProductRepository = new UserProductRepository();
    }

    public function getName()
    {
        return $this->body['name'];
    }

    public function getEmail()
    {
        return $this->body['email'];
    }

    public function getPhone()
    {
        return $this->body['phone'];
    }

    public function getCountry()
    {
        return $this->body['country'];
    }

    public function getCity()
    {
        return $this->body['city'];
    }

    public function getAddress()
    {
        return $this->body['address'];
    }

    public function getPostal()
    {
        return $this->body['postal'];
    }


    public function validateOrder(int $userId) :array
    {
        $errors = [];

        $cartProducts = $this->userProductRepository->getAllUserProducts($userId);
        if (empty($cartProducts)) {
            $errors['cart'] = "Выберите товар для заказа";
        }

        $name = $this->getName();
        if (!empty($name)) {
            if (strlen($name) < 2) {
                $errors['name'] = "Имя должно быть больше 2 символов";
            }
        } else {
            $errors['name'] = 'Значение не может быть пустым';
        }

        $email = $this->getEmail();
        if (!empty($email)) {
            if (strlen($email) < 2) {
                $errors['email'] = 'Email должен быть больше 2 символов';
            } else {
                $str = '@';
                $strpos = strpos($email, $str);

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