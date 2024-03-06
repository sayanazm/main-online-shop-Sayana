<?php

use Controller\CartController;
use \Controller\MainController;
use Controller\OrderController;
use \Controller\UserController;
class App
{
    private array $routes = [
        '/registrate' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getRegistrationForm',
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'registrate',
            ],
        ],
        '/login' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getLoginForm',
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'login',
            ]
        ],
        '/main' => [
            'GET' => [
                'class' => MainController::class,
                'method' => 'getProductsForm',
            ]
        ],
        '/logout' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'logout'
            ]
        ],
        '/add-product' => [
            'GET' => [
                'class' => MainController::class,
                'method' => 'getAddProductForm',
            ],
            'POST' => [
                'class' => CartController::class,
                'method' => 'addProduct',
            ]
        ],
        '/cart' => [
            'GET' => [
                'class' => CartController::class,
                'method' => 'getShoppingCartForm',
            ],
            'POST' => [
                'class' => CartController::class,
                'method' => 'deleteProductFromCart',
            ]
        ],
        '/order' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'getOrderForm',
            ]
        ]

    ];
    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];

        if (isset($this->routes[$requestUri])) {
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            $routeMethod = $this->routes[$requestUri];

            if (isset($routeMethod[$requestMethod])) {
                $handler = $routeMethod[$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];

                $obj = new $class;
                $obj->$method($_POST);
            } else {
                echo "Метод $requestMethod не поддерживается для $requestUri";
            }
        } else {
            require_once './../View/not_found.html';
        }
    }

}