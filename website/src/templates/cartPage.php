<?php $templateParams["title"] = "Your shopping cart" ?>

<?php require "utils/loadCart.php" ?>

<?php $templateParams["title"] = "Cart" ?>

<div class="container mt-md-2">
    <div class="text-center">
        <h2>Your Cart</h2>
    </div>

    <div class="row g-5">
        <div class="col-md-<?php echo $isCartEmpty ? "12" : "8" ?>">
            <?php if (!$isCartEmpty): ?>
                <?php foreach ($cartItems as $article): ?>
                    <?php require("components/cartItem.php") ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="lead mt-4">Nothing here! Come back once you added something to your cart.</p>
            <?php endif; ?>
        </div>

        <?php if (!$isCartEmpty) : ?>
            <div class="col-md-4 mt-2 mt-md-5">
                <div class="p-3">
                    <h4 class="mb-4">Order Summary</h4>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>€<?php echo $subtotal ?></span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span>€10</span>
                    </div>

                    <hr />

                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total</strong>
                        <strong>€<?php echo ($subtotal + 10) ?></strong>
                    </div>

                    <a href=<?php echo Links::CHECKOUT ?> class="btn btn-success w-100">Proceed to Checkout</a>
                <?php endif ?>
                </div>
            </div>
    </div>
</div>