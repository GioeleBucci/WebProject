<?php require "utils/loadArticle.php" ?>

<?php $templateParams["title"] = implode(" ", [$article["name"], $article["details"]]) ?>

<div class="container mt-0">
    <div class="row">
        <div class="col-md-6">
            <div class="image-fluid">
                <img src="<?php echo Settings::UPLOAD_DIR . $article["image"]; ?>"
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

            <h3 class="text-primary mt-3" id="article-price"><small>€</small><?php echo ($article["basePrice"]); ?></h3>
            <?php if (Utils::isUserLoggedIn()): ?>
                <form method="post">
                    <input type="hidden" name="selectedVersion" id="selectedVersion" value="">
                    <input type="hidden" name="addArticle" id="addArticle" value="">
                    <button type="submit" class="btn btn-primary add-to-cart-btn mt-3" onclick="changeAddToCartIcon.call(this)">
                        <i class="bi bi-cart-plus-fill"></i> Add to Cart
                    </button>
                </form>
            <?php else: ?>
                <button type="button" class="btn btn-primary add-to-cart-btn mt-3" disabled>
                    <i class="bi bi-cart-plus-fill"></i> Log in to add items to your cart!
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    const basePrice = <?php echo $article["basePrice"]; ?>;

    function updateSelection() {
        const select = document.getElementById('versionSelect');
        if (!select) return;

        const selectedOption = select.options[select.selectedIndex];
        document.getElementById('selectedVersion').setAttribute('value', selectedOption.getAttribute("value"));
        const priceVariation = parseFloat(selectedOption.getAttribute('data-price-variation'));
        const totalPrice = basePrice + priceVariation;

        document.getElementById('article-price').innerHTML = `<small>€</small>${totalPrice.toFixed(2)}`;
    }

    // Initialize price on page load
    document.addEventListener('DOMContentLoaded', updateSelection);
</script>
