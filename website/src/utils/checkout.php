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
