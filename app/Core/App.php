<?php

namespace Core;

use Controller\CartController;
use Controller\MainController;
use Controller\OrderController;
use Controller\UserController;
use Exception\ExceptionClassNotFound;
use Repository\ProductRepository;
use Repository\UserProductRepository;
use Repository\UserRepository;
use Request\Request;
use Service\AuthenticationService\CookieAuthenticationService;
use Service\AuthenticationService\SessionAuthenticationService;
use Service\CartService;
use Service\OrderService;

class App
{
    private array $routes = [];
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get(string $routeName, string $className, string $method, string $requestClass = Request::class): void
    {
        $this->routes[$routeName]['GET'] = [
            'class' => $className,
            'method' => $method,
            'requestClass' => $requestClass
        ];

    }

    public function post(string $routeName, string $className, string $method, string $requestClass = Request::class): void
    {
        $this->routes[$routeName]['POST'] = [
            'class' => $className,
            'method' => $method,
            'requestClass' => $requestClass
        ];

    }

    public function run(): void
    {


    }

}