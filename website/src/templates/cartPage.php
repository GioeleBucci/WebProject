<?php $templateParams["title"] = "Your shopping cart" ?>

<?php

Utils::requireLoggedUser();

$cartItems = $dbh->getCartItems($_SESSION["userId"]);

?>

<?php $templateParams["title"] = "Cart" ?>

<div class="container mt-md-2">
    <div class="text-center">
        <h2>Your Cart</h2>
    </div>

    <div class="row g-5">
        <div class="col-md-8">
            <?php if (isset($cartItems)): ?>
                <?php foreach ($cartItems as $cartItem): ?>
                    <?php require("components/cartItemCard.php") ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nothing here!</p>
            <?php endif; ?>
        </div>

        <div class="col-md-4 mt-2 mt-md-5">
            <div class="p-3">
                <h4 class="mb-4">Order Summary</h4>

                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>€149.97</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping</span>
                    <span>€10</span>
                </div>

                <hr />

                <div class="d-flex justify-content-between mb-3">
                    <strong>Total</strong>
                    <strong>€159.97</strong>
                </div>

                <a href=<?php echo Links::CHECKOUT ?> class="btn btn-success w-100">Proceed to Checkout</a>
            </div>
        </div>
    </div>
</div>