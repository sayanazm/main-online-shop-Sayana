<?php

namespace Core;

use Controller\CartController;
use Controller\MainController;
use Controller\OrderController;
use Controller\Admin\AdminOrderController;
use Controller\UserController;
use Request\CartRequest;
use Request\OrderRequest;
use Request\Request;
use Request\RegistrationRequest;

class App
{
    private array $routes = [
        '/registrate' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getRegistrationForm',
                'requestClass' => Request::class
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'registrate',
                'requestClass' => RegistrationRequest::class
            ],
        ],
        '/login' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getLoginForm',
                'requestClass' => Request::class
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'login',
                'requestClass' => Request::class
            ]
        ],
        '/main' => [
            'GET' => [
                'class' => MainController::class,
                'method' => 'getProducts',
                'requestClass' => Request::class
            ]
        ],
        '/logout' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'logout',
                'requestClass' => Request::class
            ]
        ],
        '/add-product' => [
            'POST' => [
                'class' => CartController::class,
                'method' => 'addProduct',
                'requestClass' => CartRequest::class
            ]
        ],
        '/delete-product' => [
            'POST' => [
                'class' => CartController::class,
                'method' => 'deleteProduct',
                'requestClass' => CartRequest::class
            ]
        ],
        '/cart' => [
            'GET' => [
                'class' => CartController::class,
                'method' => 'getCart',
                'requestClass' => Request::class
            ],
            'POST' => [
                'class' => CartController::class,
                'method' => 'deleteProductFromCart',
                'requestClass' => Request::class
            ]
        ],
        '/order' => [
            'GET' => [
                'class' => AdminOrderController::class,
                'method' => 'getOrderForm',
                'requestClass' => OrderRequest::class
            ],
            'POST' => [
                'class' => AdminOrderController::class,
                'method' => 'order',
                'requestClass' => OrderRequest::class
            ]
        ],
        '/admin-order' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'getOrderForm',
                'requestClass' => OrderRequest::class
            ],
            'POST' => [
                'class' => OrderController::class,
                'method' => 'order',
                'requestClass' => OrderRequest::class
            ]
        ]

    ];

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

                $obj = new $class;
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