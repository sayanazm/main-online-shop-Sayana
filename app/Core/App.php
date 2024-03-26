<?php

namespace Core;

use Request\Request;

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