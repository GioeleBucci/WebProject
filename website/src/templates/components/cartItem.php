<div class="row align-items-center border-bottom py-3">
    <div class="col-3 col-md-2">
        <img
            src="<?php echo Settings::UPLOAD_DIR . "articles/" . $article['image']; ?>"
            alt="<?php echo $article['name'] ?>"
            class="img-fluid">
    </div>
    <div class="col-9 col-md-5">
        <h5 class="mb-1"><?php echo $article['name'] ?></h5>
        <small class="text-muted"><?php echo "(" . $article['versionType'] . ")" ?></small>
        <small class="text-muted"><?php echo $article['details'] ?></small>
    </div>
    <div class="col-6 col-md-2 text-end mt-2 mt-md-0">
        <strong class="item-price" data-unit-price="<?php echo $article['price'] ?>">€<?php echo $article['price'] * $article['amount'] ?></strong>
    </div>
    <div class="col-3 col-md-2 text-end mt-2 mt-md-0">
        <label for="quantity-<?php echo $article['articleId'] ?>-<?php echo $article['versionId'] ?>" class="visually-hidden">Quantity for <?php echo htmlspecialchars($article['name']); ?></label>
        <input
            id="quantity-<?php echo $article['articleId'] ?>-<?php echo $article['versionId'] ?>"
            type="number"
            class="form-control quantity-input"
            value="<?php echo $article['amount'] ?>"
            min="1"
            data-article-id="<?php echo $article['articleId'] ?>"
            data-version-id="<?php echo $article['versionId'] ?>"
            style="max-width: 80px; margin: 0 auto;">
    </div>
    <form method="post" class="col-3 col-md-1 text-end mt-2 mt-md-0">
        <input type="hidden" id="removeItem" name="removeItem" >
        <input type="hidden" id="articleId" name="articleId" value=<?php echo $article["articleId"] ?>>
        <input type="hidden" id="versionId" name="versionId" value=<?php echo $article["versionId"] ?>>
        <button type="submit" class="btn btn-link text-danger p-0" title="Remove item" aria-label="Remove <?php echo htmlspecialchars($article['name']); ?> from cart" style="margin-right: -10px;">
            <span class="bi bi-x fs-4 mx-2" aria-hidden="true"></span>
        </button>
    </form>
</div>
