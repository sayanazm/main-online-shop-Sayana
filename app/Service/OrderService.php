<?php

namespace Service;

use Entity\OrderProduct;
use Repository\OrderProductRepository;
use Repository\OrderRepository;
use Repository\Repository;
use Repository\UserProductRepository;
use Request\OrderRequest;
use Throwable;

class OrderService
{

    private OrderRepository $orderRepository;
    private OrderProductRepository $orderProductRepository;
    private UserProductRepository $userProductRepository;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->orderProductRepository = new OrderProductRepository();
        $this->userProductRepository = new UserProductRepository();
    }


    /**
     * @throws Throwable
     */
    public function create(int $userId, string $email, string $phone, string $name, string $address, string $city, string $country, int $postal): array
    {

        Repository::getPdo()->beginTransaction();

        try {

            $this->orderRepository->create($userId, $email, $phone, $name, $address, $city, $country, $postal);

            $orderId = $this->orderRepository->getOrderId();

            $deletedProducts = $this->orderProductRepository->addFromUserProducts($userId, $orderId);

            $this->userProductRepository->deleteAllUserProducts($userId);

            Repository::getPdo()->commit();

            return $deletedProducts;

        } catch (Throwable $exception ) {
            Repository::getPdo()->rollBack();
            throw $exception;
        }

    }


}