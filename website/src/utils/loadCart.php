<?php

Utils::requireLoggedUser();

if (isset($_POST["removeItem"])) {
    $removed = $dbh->removeFromCart($_SESSION["userId"], $_POST["articleId"], $_POST["versionId"]);
    unset($_POST["removeItem"]);
    unset($_POST["articleId"]);
    unset($_POST["versionId"]);
}
$cartItems = $dbh->getCartItems($_SESSION["userId"]);
$subtotal = 0;
foreach ($cartItems as $article) {
    $subtotal += $article["price"] * $article["amount"];
}
$isCartEmpty = empty($cartItems);
