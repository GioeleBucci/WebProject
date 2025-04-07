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
    Links::SEARCH => Pages::SEARCH,
];

if (array_key_exists($requestPath, $routes)) {
    $templateParams["page"] = $routes[$requestPath];
} else {
    http_response_code(404);
    $templateParams["page"] = Pages::NOT_FOUND_404; 
}

require_once 'templates/base.php';
