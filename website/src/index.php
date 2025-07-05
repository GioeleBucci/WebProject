<?php

require_once 'bootstrap.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestPath = str_replace(Settings::BASE_PATH, '', $requestUri);

// Map routes to pages
$routes = [
    "" => Pages::HOME,
    Links::HOME => Pages::HOME,
    Links::LOGIN => Pages::LOGIN,
    Links::REGISTER => Pages::REGISTER,
    Links::ACCOUNT => Pages::ACCOUNT,
    Links::CART => Pages::CART,
    Links::CHECKOUT => Pages::CHECKOUT,
    Links::ORDERS => Pages::ORDERS,
    Links::SEARCH => Pages::SEARCH,
    Links::ARTICLE => Pages::ARTICLE,
    Links::NOTIFICATIONS => Pages::NOTIFICATIONS,
    Links::WISHLIST => Pages::WISHLIST,
    Links::LISTING => Pages::LISTING,
    Links::NEW_ARTICLE => Pages::NEW_ARTICLE,
    Links::EDIT_ARTICLE => Pages::EDIT_ARTICLE,
    Links::NEW_VERSION => Pages::NEW_VERSION,
    Links::PRIVACY_POLICY => Pages::PRIVACY_POLICY,
    Links::TERMS_OF_SERVICE => Pages::TERMS_OF_SERVICE,
    Links::COOKIE_POLICY => Pages::COOKIE_POLICY
];

if (array_key_exists($requestPath, $routes)) {
    $templateParams["page"] = $routes[$requestPath];
    // Special handling for notifications page - mark notifications as read before rendering
    if ($requestPath === Links::NOTIFICATIONS && Utils::isUserLoggedIn()) {
        $dbh->markNotificationsAsRead($_SESSION["userId"]);
    }
} else {
    http_response_code(404);
    $templateParams["page"] = Pages::NOT_FOUND_404; 
}

ob_start();

require_once 'templates/base.php';

$landingPage = ob_get_clean();
echo $landingPage;
