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
}

/* Actual filenames the relative links will be resolved to */
class Pages
{
    public const HOME = 'homePage.php';
    public const LOGIN = 'loginPage.php';
    public const REGISTER = 'registerPage.php';
    public const ACCOUNT = 'accountPage.php';
    public const CART = 'cartPage.php';
    public const CHECKOUT = 'checkoutPage.php';
    public const SEARCH = 'searchPage.php';
    public const NOT_FOUND_404 = 'notFound404.php';
}
