<?php

/* Symbolic names for the pages that will show on the browser's address bar */
class Links
{
    public const HOME = 'home';
    public const LOGIN = 'login';
    public const REGISTER = 'register';
    public const ACCOUNT = 'account';
    public const CART = 'cart';
    public const CHECKOUT = 'checkout';
    public const SEARCH = 'search';
    public const ARTICLE = 'article';
    public const NOTIFICATIONS = 'notifications';
    public const NEW_ARTICLE = 'add-article';
    public const WISHLIST = 'wishlist';
}

/* Actual filenames the relative links will be resolved to */
class Pages
{
    public const HOME = 'homePage.php';
    public const LOGIN = 'loginPage.php';
    public const REGISTER = 'registrationPage.php';
    public const ACCOUNT = 'accountPage.php';
    public const CART = 'cartPage.php';
    public const CHECKOUT = 'checkoutPage.php';
    public const SEARCH = 'searchPage.php';
    public const ARTICLE = 'articlePage.php';
    public const NOTIFICATIONS = 'notificationsPage.php';
    public const WISHLIST = 'wishlistPage.php';
    public const NOT_FOUND_404 = 'notFound404.php';
    public const NEW_ARTICLE = 'newArticlePage.php';
}
