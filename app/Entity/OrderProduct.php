<?php

namespace Entity;

class OrderProduct
{
    private int $id;

    private Order $order;

    private UserProduct $userProduct;

    public function __construct(int $id, Order $order, UserProduct $userProduct)
    {
        $this->id = $id;
        $this->order = $order;
        $this->userProduct = $userProduct;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getUserProduct(): UserProduct
    {
        return $this->userProduct;
    }

}