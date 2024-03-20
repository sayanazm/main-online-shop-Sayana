<?php

namespace Service;

class CartService
{
    public function getTotalPrice(array|null $cartProducts) :float
    {
        $totalPrice = '0';
        if ($cartProducts) {
            foreach ($cartProducts as $cartProduct) {
                $totalPrice += ($cartProduct->getProduct()->getPrice() * $cartProduct->getQuantity());
            }
        }
        return $totalPrice;
    }
}