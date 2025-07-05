<?php Utils::denySellerAccess(); ?>
<?php require "utils/checkout.php" ?>

<?php $templateParams["title"] = "Checkout" ?>

<div class="container mt-md-2">
    <div class="text-center">
        <span class="page-title-text">Checkout</span>
    </div>

    <div class="row g-5">
        <div class="col-md-4 order-md-2 order-1">
            <div class="d-flex justify-content-between align-items-center my-3">
                <span class="text-primary fs-4">Your cart</span>
                <span class="badge bg-primary rounded-pill"><?php echo $totalItems ?></span>
            </div>

            <ul class="list-group">
                <?php $total = 0 ?>
                <?php foreach ($cartItems as $article): ?>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0"><?php echo ($article["name"] . ($article["amount"] > 1 ? " (" . $article["amount"] . ")" : "")) ?></h6>
                            <small class="text-muted"><?php echo $article["details"] ?></small>
                        </div>
                        <?php $price = $article["amount"] * $article["price"];
                        $total += $price;
                        ?>
                        <span class="text-muted">€<?php echo $price ?></span>
                    </li>
                <?php endforeach; ?>
                <li class="list-group-item d-flex justify-content-between bg-light">
                    <strong class="text-primary">Total</strong>
                    <strong class="text-primary">€<?php echo $total ?></strong>
                </li>
            </ul>
        </div>

        <div class="col-md-8 order-md-1 order-2">
            <h4 class="mb-3">Shipping details</h4>
            <form method="post">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="firstName" class="form-label">First name</label>
                        <input type="text" class="form-control" id="firstName" required>
                    </div>

                    <div class="col-sm-6">
                        <label for="lastName" class="form-label">Last name</label>
                        <input type="text" class="form-control" id="lastName" required>
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
                    </div>

                    <div class="col-12">
                        <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
                        <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
                    </div>

                    <div class="col-md-5">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" required>
                    </div>

                    <div class="col-md-4">
                        <label for="province" class="form-label">Province</label>
                        <input type="text" class="form-control" id="province" required>
                    </div>

                    <div class="col-md-3">
                        <label for="zip" class="form-label">Zip code</label>
                        <input type="text" class="form-control" id="zip" pattern="\d*" maxlength="10" required>
                    </div>
                </div>

                <hr class="my-4">

                <h4 class="mb-3">Payment</h4>

                <fieldset class="my-3">
                    <legend class="visually-hidden">Payment Method</legend>
                    <?php $paymentMethods = $dbh->getPaymentMethodsNames() ?>

                    <?php foreach ($paymentMethods as $index => $method) : ?>
                        <div class="form-check">
                            <input id="payment-<?php echo $index ?>" name="paymentMethod" type="radio" class="form-check-input" <?php echo $index === 0 ? "checked" : "" ?> required>
                            <label class="form-check-label" for="payment-<?php echo $index ?>"><?php echo $method ?></label>
                        </div>
                    <?php endforeach; ?>
                </fieldset>

                <hr class="my-4">

                <input type="hidden" name="totalPrice" id="totalPrice" value=<?php echo $total ?>>
                <button class="w-100 btn btn-primary btn-md" type="submit" name="checkout" id="checkout">Pay</button>
            </form>
        </div>
    </div>
</div>
