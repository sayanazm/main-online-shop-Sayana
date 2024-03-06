<?php

use Controller\MainController;
use Controller\UserController;
use Controller\UserProductController;

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

require_once './../Autoloader.php';

Autoloader::registrate(dirname(__DIR__));

if ($requestUri === '/registrate') {
    $obj = new UserController();
    if ($requestMethod === "GET") {
        $obj->getRegistrationForm();
    } elseif ($requestMethod === "POST") {
        $obj->registrate($_POST);
    } else {
        echo "Метод $requestMethod не поддерживается для $requestUri";
    }
} elseif ($requestUri === '/login') {
    $obj = new UserController();
    if ($requestMethod === "GET") {
        $obj->getLoginForm();
    } elseif ($requestMethod === "POST") {
        $obj->login($_POST);
    } else {
        echo "Метод $requestMethod не поддерживается для $requestUri";
    }
} elseif ($requestUri === '/main') {
    $obj = new MainController();
    if ($requestMethod === "GET") {
        $obj->getProductsForm();
    } elseif ($requestMethod === "POST") {
        $obj->addProduct($_POST);
    } else {
        echo "Метод $requestMethod не поддерживается для $requestUri";
    }
} else {
    require_once './../View/not_found.html';
}