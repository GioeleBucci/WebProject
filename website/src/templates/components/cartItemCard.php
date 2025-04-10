<?php 
$article = $dbh->getArticle($cartItem['articleId']);
$version = $dbh->getArticleVersion($cartItem['articleId'], $cartItem['versionId']);
?>

<div class="row align-items-center border-bottom py-3">
    <div class="col-3 col-md-2">
        <img
            src="<?php echo Settings::UPLOAD_DIR . $article['image']; ?>"
            alt="<?php echo $article['name']?>"
            class="img-fluid" />
    </div>
    <div class="col-9 col-md-5">
        <h5 class="mb-1"><?php echo $article['name']?></h5>
        <small class="text-muted"><?php echo $article['details']?></small>
    </div>
    <div class="col-6 col-md-2 text-end mt-2 mt-md-0">
        <strong>€<?php echo ($article['basePrice'] + $version['priceVariation']) ?></strong>
    </div>
    <div class="col-3 col-md-2 text-end mt-2 mt-md-0">
        <input
            type="number"
            class="form-control"
            value="<?php echo $cartItem['amount'] ?>"
            min="1"
            style="max-width: 80px; margin: 0 auto;" />
    </div>
    <form method="post">
        <div class="col-3 col-md-1 text-end mt-2 mt-md-0">
            <input type="hidden">
            <button type="submit" class="btn btn-link text-danger p-0" title="Remove item">
                <i class="bi bi-x fs-5 mx-2"></i>
            </button>
        </div>
    </form>
</div>