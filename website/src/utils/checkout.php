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

$cartItems = $dbh->getCartItems($_SESSION["userId"]);

// Redirect to another page if the cart is empty
if (!isset($cartItems) || sizeof($cartItems) === 0) {
    Utils::redirect(Links::ORDERS);
}

$totalItems = 0;
foreach ($cartItems as $cartItem) {
    $totalItems += $cartItem["amount"];
}

if (isset($_POST["checkout"])) {
    // Process checkout...
    $dbh->addOrder($_SESSION["userId"], $_POST["totalPrice"], date("Y-m-d H:i"), $cartItems);
    Utils::addNotification("Your order of €" . number_format($_POST["totalPrice"], 2) . " has been issued");
    $dbh->emptyCart($_SESSION["userId"]);
    Utils::redirect(Links::ORDERS);
}
