<?php

namespace Entity;

class UserProductEntity
{

    private int $id;

    private int $userId;

    private string $name;

    private float $price;

    private string $image;

    private int $productId;

    private int $quantity;

    /**
     * @param int $id
     * @param int $userId
     * @param string $name
     * @param float $price
     * @param string $image
     * @param int $productId
     * @param int $quantity
     */
    public function __construct(int $id, int $userId, string $name, float $price, string $image, int $productId, int $quantity)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }



}