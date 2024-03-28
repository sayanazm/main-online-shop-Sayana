<?php

namespace Core;

use Controller\CartController;
use Controller\MainController;
use Controller\OrderController;
use Controller\UserController;
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
        $requestUri = $_SERVER['REQUEST_URI'];

        if (isset($this->routes[$requestUri])) {
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            $routeMethod = $this->routes[$requestUri];

            if (isset($routeMethod[$requestMethod])) {
                $handler = $routeMethod[$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];
                $requestClass = $handler['requestClass'];

                $container = new Container();

                $container->set(CartController::class, function () {
                    $authService = new SessionAuthenticationService();
                    $cartService = new CartService($authService);

                    return new CartController($authService, $cartService);
                });

                $container->set(MainController::class, function () {
                    $authService = new SessionAuthenticationService();
                    $cartService = new CartService($authService);
                    $productRepository = new ProductRepository();

                    return new MainController($authService, $cartService, $productRepository);
                });

                $container->set(OrderController::class, function () {
                    $authService = new SessionAuthenticationService();
                    $cartService = new CartService($authService);
                    $orderService = new OrderService();
                    $userProductRepository = new UserProductRepository();

                    return new OrderController($authService, $cartService, $orderService, $userProductRepository);
                });

                $container->set(UserController::class, function () {
                    $authService = new SessionAuthenticationService();
                    $userRepository = new UserRepository();

                    return new UserController($authService, $userRepository);
                });

                $obj = $container->get($class);

                $request = new $requestClass($method, $requestUri, headers_list(), $_POST);
                $obj->$method($request);

            } else {
                echo "Метод $requestMethod не поддерживается для $requestUri";
            }
        } else {
            require_once './../View/not_found.html';
        }
    }

}