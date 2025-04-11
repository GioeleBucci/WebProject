<?php
Utils::requireLoggedUser();
$templateParams["title"] = "Checkout";
$cartItems = $dbh->getCartItems($_SESSION["userId"]);

// Redirect to another page if the cart is empty
if (!isset($cartItems) || sizeof($cartItems) == 0) {
    Utils::redirect(Links::CART);
}

$totalItems = 0;
foreach ($cartItems as $cartItem) {
    $totalItems += $cartItem["amount"];
}
?>


<div class="container mt-md-2">
    <div class="text-center">
        <h2>Checkout</h2>
    </div>

    <div class="row g-5">
        <div class="col-md-4 order-md-2 order-1">
            <h4 class="d-flex justify-content-between align-items-center my-3">
                <span class="text-primary">Your cart</span>
                <span class="badge bg-primary rounded-pill"><?php echo $totalItems ?></span>
            </h4>
            <ul class="list-group">
                <?php $total = 0 ?>
                <?php foreach ($cartItems as $cartItem): ?>
                    <?php $article = $dbh->getArticle($cartItem['articleId']); ?>
                    <?php $version = $dbh->getArticleVersion($cartItem['articleId'], $cartItem['versionId']); ?>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0"><?php echo ($article["name"] . ($cartItem["amount"] > 1 ? " (" . $cartItem["amount"] . ")" : "")) ?></h6>
                            <small class="text-muted"><?php echo $article["details"] ?></small>
                        </div>
                        <?php $price = $cartItem["amount"] * ($article["basePrice"] + $version["priceVariation"]);
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
            <form>
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
                        <label for="state" class="form-label">Province</label>
                        <input type="text" class="form-control" id="province" required>
                    </div>

                    <div class="col-md-3">
                        <label for="zip" class="form-label">Zip code</label>
                        <input type="text" class="form-control" id="zip" pattern="\d*" maxlength="10" required>
                    </div>
                </div>

                <hr class="my-4">

                <h4 class="mb-3">Payment</h4>

                <div class="my-3">
                    <?php $paymentMethods = $dbh->getPaymentMethodsNames() ?>

                    <?php foreach ($paymentMethods as $index => $method) : ?>
                        <div class="form-check">
                            <input id="credit" name="paymentMethod" type="radio" class="form-check-input" <?php echo $index == 0 ? "checked" : "" ?> required>
                            <label class="form-check-label" for="credit"><?php echo $method ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="row gy-3">
                    <div class="col-md-6">
                        <label for="cc-name" class="form-label">Name on card</label>
                        <input type="text" class="form-control" id="cc-name" required>
                        <small class="text-muted">Full name as displayed on card</small>
                        <div class="invalid-feedback">
                            Name on card is required
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="cc-number" class="form-label">Credit card number</label>
                        <input type="text" class="form-control" id="cc-number" required>
                    </div>

                    <div class="col-md-3">
                        <label for="cc-expiration" class="form-label">Expiration</label>
                        <input type="text" class="form-control" id="cc-expiration" required>
                    </div>

                    <div class="col-md-3">
                        <label for="cc-cvv" class="form-label">CVV</label>
                        <input type="text" class="form-control" id="cc-cvv" required>
                    </div>
                </div>

                <hr class="my-4">

                <button class="w-100 btn btn-primary btn-md" type="submit">Pay</button>
            </form>
        </div>
    </div>
</div>
