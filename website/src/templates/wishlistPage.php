<?php $templateParams["title"] = "Your Wishlist" ?>

<?php
// Check if user is logged in
if (!Utils::isUserLoggedIn()) {
    // Store the current page URL in session before redirecting
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $requestPath = str_replace(Settings::BASE_PATH, '', $requestUri);
    $_SESSION['redirect_after_login'] = $requestPath;
    Utils::redirect(Links::LOGIN);
    die();
}

// Get wishlist items for the current user
$wishlistItems = $dbh->getWishlistItems($_SESSION["userId"]);
$isWishlistEmpty = empty($wishlistItems);
?>

<div class="container">
    <div class="text-center">
        <span class="page-title-text">Your Wishlist</span>
    </div>

    <div class="row">
        <?php if (!$isWishlistEmpty): ?>
            <div class="row g-3 mt-2">
                <?php foreach ($wishlistItems as $article): ?>
                    <div class="col-6 col-md-3">
                        <?php require("components/itemCard.php") ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="col-12 text-center mt-4">
                <p class="lead">Your wishlist is empty! Browse our products and add items to your wishlist.</p>
                <a href="<?php echo Links::HOME ?>" class="btn btn-primary mt-2">Browse Products</a>
            </div>
        <?php endif; ?>
    </div>
</div>
