<?php Utils::allowOnlySellerWithId(DatabaseHelper::getInstance()->getArticleSeller($_GET['articleId'])["sellerId"]); ?>
<?php require 'utils/addVersion.php' ?>

<?php $templateParams["title"] = "New version for " . $article["name"] ?>

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Add a new version for <?= $article["name"] ?></h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <input type="text" class="form-control" id="type" name="type" required>
                        </div>
                        <div class="mb-3">
                            <label for="priceVariation" class="form-label">Additional price (optional)</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="priceVariation" name="priceVariation">
                        </div>
                        <div class="mb-4">
                            <label for="amount" class="form-label">Number of elements in stock</label>
                            <input type="number" class="form-control" id="amount" name="amount" min="0" required>
                        </div>
                        <button type="submit" id="confirm" name="confirm" class="btn btn-primary w-100">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
