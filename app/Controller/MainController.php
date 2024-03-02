<?php
namespace Controller;

use Model\Product;
require_once './../Model/Product.php';

class MainController
{
    private Product $modelProduct;

    public function __construct()
    {
        $this->modelProduct = new Product;
    }
    public function getProductsForm() :void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        $products = $this->modelProduct->getAll();

        require_once "./../View/main.php";

    }

}