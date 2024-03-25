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
    private Repository $repository;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->orderProductRepository = new OrderProductRepository();
        $this->userProductRepository = new UserProductRepository();
        $this->repository = new Repository();
    }


    /**
     * @throws Throwable
     */
    public function create(int $userId, string $email, string $phone, string $name, string $address, string $city, string $country, int $postal): array
    {

        $this->orderRepository->create($userId, $email, $phone, $name, $address, $city, $country, $postal);
        $orderId = $this->orderRepository->getOrderId();
        return $this->replaceToOrder($userId, $orderId);

    }

    /**
     * @throws Throwable
     */
    public function replaceToOrder(int $userId, int $orderId) :array
    {
        try {

            $this->repository->beginTransaction();

            $deletedProducts = $this->orderProductRepository->addFromUserProducts($userId, $orderId);

            $this->userProductRepository->deleteAllUserProducts($userId);

            $this->repository->commit();

            return $deletedProducts;

        } catch (Throwable $exception ) {
            $this->repository->rollBack();
            throw $exception;
        }
    }

}