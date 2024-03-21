<?php

namespace Request;

use Repository\UserProductRepository;

class CartRequest extends Request
{
    private UserProductRepository $userProductRepository;

    public function __construct(string $method, string $uri, array $headers, array $body)
    {
        parent::__construct($method, $uri, $headers, $body);

        $this->userProductRepository = new UserProductRepository();
    }

    public function getProductId()
    {
        return $this->body['product_id'];
    }

    public function validate($userId): array
    {
        $errors = [];

        $product = $this->userProductRepository->getOneByProductId($userId, $this->getProductId());

        if ($product === false || $product->getQuantity() <= '0') {

            $errors['quantity'] = 'Этого товара уже нет в корзине';
        }
        return $errors;
    }

}