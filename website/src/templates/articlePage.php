<?php

if (!isset($_GET["id"])) {
    Utils::redirect(Links::HOME);
}

$articleId = $_GET["id"];
$product = $dbh->getArticle($articleId);

if (!$product) {
    die("Product not found"); // TODO handle this more gracefully
}

$templateParams["title"] = implode(" ", [$product["name"], $product["details"]]);
?>

<div class="container mt-0">
    <div class="row">
        <div class="col-md-6">
            <div class="image-fluid">
                <img src="<?php echo Settings::UPLOAD_DIR . $product["image"]; ?>"
                    class="img-fluid"
                    alt="Product Image">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="product-name mt-5 mt-md-0"><?php echo ($product["name"]); ?></h1>
            <p class="text-muted mb-1"><?php echo ($product["details"]); ?></p>
            <p class="text-muted mb-1">Size: <?php echo ($product["size"]); ?></p>
            <p class="text-muted mb-1">Material: <?php echo ($product["material"]); ?></p>
            <p class="text-muted mb-1">Weight: <?php echo ($product["weight"]); ?> kg</p>
            <?php if (isset($product["longDescription"])) : ?>
                <div class="description-box mt-3 p-3 border rounded bg-light">
                    <p class="text-muted my-0"><?php echo nl2br($product["longDescription"]); ?></p>
                </div>
            <?php endif; ?>

            <h3 class="text-primary mt-3"><small>€</small><?php echo ($product["basePrice"]); ?></h3>
            <?php if (Utils::isUserLoggedIn()): ?>
                <button type="button" class="btn btn-primary add-to-cart-btn mt-3" onclick="changeAddToCartIcon.call(this)">
                    <i class="bi bi-cart-plus-fill"></i> Add to Cart
                </button>
            <?php else: ?>
                <button type="button" class="btn btn-primary add-to-cart-btn mt-3" disabled>
                    <i class="bi bi-cart-plus-fill"></i> Log in to add items to your cart!
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>