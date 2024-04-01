<?php

use Controller\CartController;
use Controller\MainController;
use Controller\OrderController;
use Controller\UserController;
use Core\Container;
use Core\Logger;
use Core\LoggerInterface;
use Repository\OrderProductRepository;
use Repository\OrderRepository;
use Repository\ProductRepository;
use Repository\UserProductRepository;
use Repository\UserRepository;
use Service\AuthenticationService\AuthenticationServiceInterface;
use Service\AuthenticationService\SessionAuthenticationService;
use Service\CartService;
use Service\OrderService;

return [
    AuthenticationServiceInterface::class => function (Container $container) {
        $userRepository = $container->get(UserRepository::class);

        return new SessionAuthenticationService($userRepository);
    },

    LoggerInterface::class => function () {

        return new Logger();
    },

    OrderService::class => function (Container $container) {
        $orderProductRepository = $container->get(OrderProductRepository::class);
        $orderRepository = $container->get(OrderRepository::class);
        $userProductRepository = $container->get(UserProductRepository::class);

        return new OrderService($orderRepository, $orderProductRepository, $userProductRepository);
    },

    CartService::class => function (Container $container) {
        $authService = $container->get(AuthenticationServiceInterface::class);
        $userProductRepository = $container->get(UserProductRepository::class);

        return new CartService($authService, $userProductRepository);
    },

    CartController::class => function (Container $container) {
        $authService = $container->get(AuthenticationServiceInterface::class);
        $cartService = $container->get(CartService::class);

        return new CartController($authService, $cartService);
    },

    MainController::class => function (Container $container) {
        $authService = $container->get(AuthenticationServiceInterface::class);
        $cartService = $container->get(CartService::class);
        $productRepository = $container->get(ProductRepository::class);

        return new MainController($authService, $cartService, $productRepository);
    },

    OrderController::class => function (Container $container) {
        $authService = $container->get(AuthenticationServiceInterface::class);
        $cartService = $container->get(CartService::class);
        $orderService = $container->get(OrderService::class);
        $userProductRepository = $container->get(UserProductRepository::class);

        return new OrderController($authService, $cartService, $orderService, $userProductRepository);
    },

    UserController::class => function (Container $container) {
        $authService = $container->get(AuthenticationServiceInterface::class);
        $userRepository = $container->get(UserRepository::class);

        return new UserController($authService, $userRepository);
    }
];
