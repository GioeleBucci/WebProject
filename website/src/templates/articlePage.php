<?php require "utils/loadArticle.php" ?>

<?php $templateParams["title"] = implode(" ", [$article["name"], $article["details"]]) ?>

<div class="container mt-0">
    <div class="row">
        <div class="col-md-6">
            <div class="image-fluid">
                <img src="<?php echo Settings::UPLOAD_DIR . "articles/" . $article["image"]; ?>"
                    class="img-fluid"
                    alt="Product Image">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="article-name mt-5 mt-md-0"><?php echo ($article["name"]); ?></h1>
            <p class="text-muted mb-1"><?php echo ($article["details"]); ?></p>
            <p class="text-muted mb-1">Size: <?php echo ($article["size"]); ?></p>
            <p class="text-muted mb-1">Material: <?php echo ($article["material"]); ?></p>
            <p class="text-muted mb-1">Weight: <?php echo ($article["weight"]); ?> kg</p>
            <?php if (isset($article["longDescription"])) : ?>
                <div class="description-box mt-3 p-3 border rounded bg-light">
                    <p class="text-muted my-0"><?php echo nl2br($article["longDescription"]); ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($articleVersions)) : ?>
                <form id="versionForm" class="mt-3">
                    <div class="form-group">
                        <label for="versionSelect" class="form-label">Select Version:</label>
                        <select class="form-select" id="versionSelect" name="version" onload="updateSelection()" onchange="updateSelection()">
                            <?php foreach ($articleVersions as $index => $version) : ?>
                                <option value="<?php echo $version["versionId"]; ?>" data-price-variation="<?php echo $version["priceVariation"]; ?>"><?php echo ($version["versionType"] . ($version["priceVariation"] > 0 ? " (+" . $version["priceVariation"] . "€)" : "")) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            <?php endif; ?>

            <h2 class="text-primary mt-3" id="article-price"><small>€</small><?php echo ($article["basePrice"]); ?></h2>
            <?php if (Utils::isUserLoggedIn()): ?>
                <div class="mt-4 mt-md-3 d-flex flex-column flex-md-row gap-2 align-items-center align-items-md-start">
                    <button type="button" class="btn btn-outline-danger wishlist-btn d-flex w-100 w-md-auto justify-content-center"
                        data-article-id="<?php echo $article['articleId']; ?>"
                        onclick="toggleWishlist.call(this)">
                        <?php
                        $isInWishlist = isset($_SESSION['userId']) && $dbh->isInWishlist($_SESSION['userId'], $article['articleId']);
                        ?>
                        <span class="bi bi-heart<?php echo $isInWishlist ? '-fill' : ''; ?> me-1" aria-hidden="true"></span>
                        <span class="wishlist-text">
                            <?php echo $isInWishlist ? 'Remove from Wishlist' : 'Add to Wishlist'; ?>
                        </span>
                    </button>

                    <form method="post" class="d-inline-block w-100 w-md-auto">
                        <input type="hidden" name="selectedVersion" id="selectedVersion" value="">
                        <input type="hidden" name="addArticle" id="addArticle" value="">
                        <button type="submit" class="btn btn-primary add-to-cart-btn w-100" onclick="changeAddToCartIcon.call(this)">
                            <span class="bi bi-cart-plus-fill" aria-hidden="true"></span> Add to Cart
                        </button>
                    </form>
                </div>
                <?php if (($_SESSION["isSeller"] ?? false) === true): ?>
                    <div class="mt-4 mt-md-3 d-flex flex-column flex-md-row gap-2 align-items-center align-items-md-start">
                        <a href="edit-article?articleId=<?= $articleId ?>" class="d-flex w-100 w-md-auto justify-content-center icon">
                            <span style="font-size:10rem !important;" class="h1 align-content-center bi-pencil" aria-hidden="true"></span>
                        </a>
                        <a href="new-version?articleId=<?= $articleId ?>" class="d-flex w-100 w-md-auto justify-content-center icon">
                            <span style="font-size:10rem !important;" class="h1 align-content-center bi-plus" aria-hidden="true"></span>
                        </a>
                    </div>
                <?php endif ?>
            <?php else: ?>
                <button type="button" class="btn btn-primary add-to-cart-btn mt-3" disabled>
                    <span class="bi bi-cart-plus-fill" aria-hidden="true"></span> Log in to add items to your cart!
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function updateSelection() {
        const select = document.getElementById('versionSelect');
        if (!select) return;

        const selectedOption = select.options[select.selectedIndex];
        document.getElementById('selectedVersion').setAttribute('value', selectedOption.getAttribute("value"));
        const priceVariation = parseFloat(selectedOption.getAttribute('data-price-variation'));
        const totalPrice = <?php echo $article["basePrice"]; ?> + priceVariation;

        document.getElementById('article-price').innerHTML = `<small>€</small>${totalPrice.toFixed(2)}`;
    }

    // Initialize price on page load
    document.addEventListener('DOMContentLoaded', updateSelection);
</script>
