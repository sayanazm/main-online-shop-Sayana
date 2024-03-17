<div id='cart-wrapper' >
    <div id='cart'>
        <div id="cart-products-wrapper">
            <table id="cart-table">
                <thead id="cart-table-header">
                <th class="name-col">Product Name</th>
                <th class="quantity-col">Quantity</th>
                <th class="price-col">Price</th>
                <th class="updated-price-col">Updated Price</th>
                <th class="update-col">Update</th>
                <th class="remove-col">Remove</th>
                </thead>
                <tbody id="cart-table-body"></tbody>
            </table>
        </div>
        <?php
        echo $massage ?? '';
        if (empty ($massage)) {
            foreach ($cartProducts as $cartProduct): ?>
                <tr class="productitm">
                    <td><?php echo $cartProduct->getName(); ?></td>
                    <td><input type="number" value="<?php echo $cartProduct->getQuantity(); ?>" min="0" max="99" class="qtyinput"></td>
                    <td><?php echo '$' . $cartProduct->getPrice(); ?></td>
                </tr>
            <?php endforeach;  } ?>
    </div>

    <div id='amount-controls'>
        <div id="cart-amount-wrapper">
            <table>
                <tbody>

                <tr id='total-wrapper'>
                    <td id="total-label">Total:</td>
                    <td id="total"><?php echo $totalPrice; ?></td>
                </tr>

                <tr id="promo-checkout">
                    <td>
                        <button id="checkout"><a href="/order">Checkout now</a></button>
                    </td>

                    <td>
                        <button id="ks" class="keep-shopping"><a href="/main">Keep shopping</a></button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

    * {
        font-family: 'Poppins', sans-serif;
        outline: 0;
        transition: .3s;
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