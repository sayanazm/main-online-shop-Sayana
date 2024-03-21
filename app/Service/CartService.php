<?php

namespace Service;

use Repository\UserProductRepository;

class CartService
{
    private UserProductRepository $userProductRepository;

    public function __construct()
    {
        $this->userProductRepository = new UserProductRepository();
    }

    public function addProduct(int $userId, int $productId): void
    {
        $quantity = '1';
        $product = $this->userProductRepository->getOneByProductId($userId, $productId);
        if ($product) {
            $this->userProductRepository->plusQuantity($userId, $productId);
        } else {
            $this->userProductRepository->addProduct($userId, $productId, $quantity);
        }

    }

    public function deleteProduct(int $userId, int $productId): void
    {
        $this->userProductRepository->minusQuantity($userId, $productId);

        $product = $this->userProductRepository->getOneByProductId($userId, $productId);
        if ($product) {
            if ($product->getQuantity() === 0) {
                $this->userProductRepository->deleteProduct($userId, $productId);
            }
        }
    }

    public function getTotalPrice(int $userId) :float
    {
        $cartProducts = $this->userProductRepository->getAllUserProducts($userId);
        $totalPrice = '0';
        if ($cartProducts) {
            foreach ($cartProducts as $cartProduct) {
                $totalPrice += ($cartProduct->getProduct()->getPrice() * $cartProduct->getQuantity());
            }
        }
        return $totalPrice;
    }
}