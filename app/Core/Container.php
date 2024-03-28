<?php

namespace Core;

class Container
{
    private array $services = [];

    public function set(string $className, callable $callback): void
    {
        $this->services[$className] = $callback;

    }

    public function get(string $className): object
    {

        $callback = $this->services[$className];

        return $callback();

    }

}