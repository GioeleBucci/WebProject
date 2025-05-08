<?php

//Utils::requireLoggedUser();
if (!Utils::isUserLoggedIn()) {
    // Store the current page URL in session before redirecting
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $requestPath = str_replace(Settings::BASE_PATH, '', $requestUri);
    $_SESSION['redirect_after_login'] = $requestPath;
    Utils::redirect(Links::LOGIN);
    die();
}

$templateParams["title"] = "Checkout";
$cartItems = $dbh->getCartItems($_SESSION["userId"]);

// Redirect to another page if the cart is empty
if (!isset($cartItems) || sizeof($cartItems) === 0) {
    Utils::redirect(Links::CART);
}

$totalItems = 0;
foreach ($cartItems as $cartItem) {
    $totalItems += $cartItem["amount"];
}
