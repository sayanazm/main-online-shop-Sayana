<?php

use Controller\CartController;
use Controller\MainController;
use Controller\OrderController;
use Controller\UserController;
use Core\App;
use Core\Autoloader;
use Core\Container;
use Request\CartRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrationRequest;

require_once './../Core/Autoloader.php';

Autoloader::registrate(dirname(__DIR__));

$services = include './../Config/services.php';

$container = new Container($services);

$app = new App($container);

$app->get('/registrate',  UserController::class, 'getRegistrationForm');
$app->post('/registrate', UserController::class, 'registrate', RegistrationRequest::class);


$app->get('/login',  UserController::class, 'getLoginForm');
$app->post('/login', UserController::class, 'login', LoginRequest::class);

$app->get('/main',  MainController::class, 'getProducts');

$app->get('/logout',  UserController::class, 'logout');

$app->post('/add-product', CartController::class, 'addProduct', CartRequest::class);
$app->post('/delete-product', CartController::class, 'deleteProduct', CartRequest::class);

$app->get('/cart',  CartController::class, 'getCart');
$app->post('/cart', CartController::class, 'deleteProductFromCart', CartRequest::class);

$app->get('/order',  OrderController::class, 'getOrderForm');
$app->post('/order', OrderController::class, 'order', OrderRequest::class);


$app->run();