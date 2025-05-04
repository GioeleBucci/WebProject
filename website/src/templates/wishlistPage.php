<?php $templateParams["title"] = "Your Wishlist" ?>

<?php 
// Check if user is logged in
Utils::requireLoggedUser();

// Get wishlist items for the current user
$wishlistItems = $dbh->getWishlistItems($_SESSION["userId"]);
$isWishlistEmpty = empty($wishlistItems);
?>

<div class="container">
    <div class="text-center">
        <h2>Your Wishlist</h2>
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
