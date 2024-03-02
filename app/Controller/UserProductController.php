<?php
namespace Controller;

use Model\UserProduct;
use Model\Product;
require_once './../Model/UserProduct.php';
require_once './../Model/Product.php';

class UserProductController
{
    private UserProduct $userProductModel;
    private Product $productModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct;
        $this->productModel = new Product;
    }
    public function getAddProductForm() :void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        require_once './../View/add-product.php';
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

            header("Location: /cart");
        } else {
            require_once './../View/add-product.php';
        }
    }

    private function validate(string $productId, string $quantity): array
    {
        $errors = [];

        if (empty($this->productModel->getOneById($productId))) {

            $errors['product_id'] = 'Такого продукта не существует, попробуйте снова';

        } elseif ($quantity <= '0') {

            $errors['quantity'] = 'Вы ввели неверное значение, попробуйте снова';

        }
        return $errors;
    }

}