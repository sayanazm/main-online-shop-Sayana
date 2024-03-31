<?php

namespace Entity;

class Product
{
    private int $id;
    private string $name;
    private float $price;
    private string $image;
    private string $description;

    public function __construct(int $id, string $name, float $price, string $image, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
        $this->description = $description;
    }


    public function getId(): int
    {
        return $this->id;
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

    public function getDescription(): string
    {
        return $this->description;
    }


}