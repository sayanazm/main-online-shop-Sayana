<head>
    <link rel="stylesheet" href="style.css">
</head>

    <h2>Online Shop Sayana</h2>

    <a id='cart-button' class="trigger cart-button-style" href="/cart"> Cart <?php echo $totalPrice; ?></a>
    <a id='cart-button' class="trigger cart-button-style" href="/logout">Logout</a>

    <?php
    foreach ($products as $product): ?>
        <form name="add-product" action="/add-product" method="post">
        <div class="products">
            <img class="products-img" src="<?php echo $product['image']; ?>">
            <p class="product-name"><?php echo $product['name']; ?> </p>
            <p class="product-description"><?php echo $product['description']; ?></p>
            <p class="product-price"><?php echo $product['price']; ?></p>
            <input type="hidden" name="product_id" value="<?php echo $product['id'];  ?>">
        </div>
            <button class="add-to-cart" id='test'>+</button>
    </form>
    <form name="delete-product" action="/delete-product" method="post">
        <?php echo $errors['quantity'] ?? ''; ?>
        <input type="hidden" name="product_id" value="<?php echo $product['id'];  ?>">
        <button class="add-to-cart" id='test' value="">-</button>
    </form>
    <?php endforeach; ?>
<style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

    * {
        font-family: 'Poppins', sans-serif;
        outline: 0;
        transition: .3s;
    }

    body {
        position: relative;
        display: flex;
    }

    h2 {
        font-weight: bolder;
        text-align: center;
        position: relative;
        font-size: 22px;
        color: #333;
    }

    .cart-button-style {
        border-style: none;
        position: absolute;
        top: 0;
        right: 0;
        width: 10em;
        padding: 1em 1em;
        margin: 0.5em;
        background: #4070f4;
        color: white;
        transition: background .5s;
        border-radius: 4px;
        font-weight: bold;
    }

    .cart-button-style-two {
        border-style: none;
        position: fixed;
        top: 0;
        right: 0;
        width: 10em;
        padding: 1em 1em;
        margin: 0.5em;
        background: white;
        color: #7762ff;
        transition: background .5s;
        border-radius: 4px;
    }

    .cart-button-style:hover, #checkout:hover, #apply-promo:hover, .keep-shopping:hover {
        background: #0e4bf1;
        color: white;
    }

    .cart-button-style:active, #checkout:active, #apply-promo:active, .keep-shopping:active {
        background:  #0e4bf1;
        color: white;
    }

    .products {
        float: left;
        width: 23%;
        margin: 3% 1%;
        text-align: center;
        padding: 0 0 1% 0;
    }

    .products-img {
        width: 100%;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    @media screen and (max-width: 980px) {
        .products {
            width: 30%;
            text-align: center;
            margin: 1.66%;
        }
    }

    @media screen and (max-width: 790px) {
        .products {
            width: 47%;
            margin: 1% 1%;
        }

        #shop {
            margin: 5% 1%;
        }
    }

    @media screen and (max-width: 600px) {
        .products {
            width: 100%;
        }

        #shop {
            margin: 2% 0;
        }
    }

    #shop::after {
        content: '';
        display: block;
        clear: both;
    }

    .add-to-cart {
        border: none;
        cursor: pointer;
        display: block;
        margin: 1% auto;
        width: 10em;
        height: 2em;
        background: #4070f4;
        color: white;
        font-weight: bold;
        border-radius: 20px;
    }

    .add-to-cart:hover {
        background: #0e4bf1;
    }

    .add-to-cart:active {
        background: #0e4bf1;
    }

    .products form .input-box{
        height: 52px;
        margin: 18px 0;
    }

    .input-box input{
        height: 100%;
        width: 100%;
        outline: none;
        padding: 0 15px;
        font-size: 17px;
        font-weight: 400;
        color: #333;
        border: 1.5px solid #C7BEBE;
        border-bottom-width: 2.5px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    .input-box input:focus,
    .input-box input:valid{
        border-color: #4070f4;
    }


    .slider {
        position: fixed;
        width: 100vw;
        height: 100vh;
        top: 0;
        overflow: hidden;
        background: white;
        transition: all 1s;
    }

    .slider.close {
        top: 100vh;
        height: 0;
    }

    #amount-controls {
        background: white;
        top: 90;
        right: 0;
    }

    #cart-amount-wrapper {
        background: white;
        padding: 1.5% 0 .5% 35%;
        border-radius: 10px;
    }

    #cart {
        text-align: left;
        margin: 3.5em 0.5em;
        padding: 0.5% 1.5%;
        overflow-y: scroll;
    }

    #total::before, #subtotal::before, .product-price::before, .cart-product-price::before, .cart-updated-product-price::before, #discountAmt::before {
        content: '$';
    }

    #cart #quantity-value {
        width: 45%;
    }

    .name-col {
        width: 40%;
    }
    .quantity-col {
        width: 5%;
    }
    .price-col {
        width: 15%;
    }

    .updated-price-col {
        width: 25%;
    }

    .update-col {
        width: 10%
    }

    .remove-col {
        width: 5%;
    }

    #update {
        border-style: none;
        text-transform: uppercase;
        padding: 2% 12px;
        width: 100%;
        height: 30px;
        background: #56ff6a;
        color: white;
        border-radius: 10px;
    }

    #update:hover {
        background: #f0ffe6;
        color: #56ff6a;
    }

    #update:active {
        background: #56f46a;
        color: white;
    }

    .remove {
        border-style: none;
        font-weight: bolder;
        padding: 2% 2.5%;
        width: 100%;
        height: 30px;
        background: #ff7b67;
        color: #fff1e7;
        border-radius: 10px;
    }

    .remove:hover {
        background: #fff1e7;
        color: #ff7b67;
    }

    .remove:active {
        background: #ff7b67;
        color: #f5f1e7;
    }

    #cart-products-wrapper {
        overflow-y: auto;
    }

    #cart-amount-wrapper {
        overflow-x: auto;
    }

    #promo {
        width: 10em;
        padding: 1em 1em;
        transition: background .5s;
        border-radius: 4px;
    }

    #apply-promo, #checkout, .keep-shopping {
        border-style: none;
        width: 10em;
        padding: 1em 1em;
        background: #7762ff;
        color: white;
        transition: background .5s;
        border-radius: 4px;
    }
</style>
