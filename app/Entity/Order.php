<?php

namespace Entity;

class Order
{
    private int $id;

    private int $userId;

    private string $email;

    private string $phone;

    private string $name;

    private string $country;

    private string $city;

    private string $address;

    private int $postal;

    public function __construct(int $id, int $userId, string $email, string $phone, string $name, string $country, string $city, string $address, int $postal)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->email = $email;
        $this->phone = $phone;
        $this->name = $name;
        $this->country = $country;
        $this->city = $city;
        $this->address = $address;
        $this->postal = $postal;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPostal(): int
    {
        return $this->postal;
    }

}