<?php

Utils::denySellerAccess();

if (!Utils::isUserLoggedIn()) {
    // Store the current page URL in session before redirecting
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $requestPath = str_replace(Settings::BASE_PATH, '', $requestUri);
    $_SESSION['redirect_after_login'] = $requestPath;
    Utils::redirect(Links::LOGIN);
    die();
}

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
