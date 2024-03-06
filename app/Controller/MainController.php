<?php
namespace Controller;

use Model\Product;
use Model\UserProduct;

class MainController
{
    private Product $modelProduct;
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->modelProduct = new Product;
        $this->userProductModel = new UserProduct;
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

    public function addProduct($array) :void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        $userId = $_SESSION['user_id'];

        $productId = $array['product_id'];
        $quantity = $array['quantity'];

        $errors = $this->validate($productId, $quantity);

        if (empty($errors)) {


            $this->userProductModel->addProduct($userId, $productId, $quantity);

            header("Location: /main");

        } else {
            
            $products = $this->modelProduct->getAll();
            require_once './../View/main.php';
        }
    }

    private function validate(string $productId, string $quantity): array
    {
        $errors = [];

        if ($quantity <= '0') {

            $errors['quantity'] = 'Вы ввели неверное значение, попробуйте снова';

        }
        return $errors;
    }

}