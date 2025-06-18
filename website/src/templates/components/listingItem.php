<div class="card-wrapper">
    <div class="card h-100">
        <!-- rotate(0) prevents the stretched link from affecting other elements -->
        <div class="card-top" style="transform: rotate(0);">
            <a href="article?id=<?php echo $article['articleId']; ?>" class="stretched-link text-decoration-none mb-0" aria-label="View <?php echo htmlspecialchars($article['name']); ?> details">
                <div class="image-fluid overflow-hidden d-flex justify-content-center align-items-center" style="height: 200px;">
                    <img src="<?php echo Settings::UPLOAD_DIR . "articles/" . $article['image']; ?>"
                        class="card-img-top"
                        alt="Product Image">
                </div>
            </a>
            <div class="card-body">
                <h6 class="card-text mb-0 product-name"><?php echo $article["name"] ?></h6>
                <p class="card-text mb-0 text-truncate"><small class="text-muted"><?php echo $article["details"] ?></small></p>
                <p class="card-text mb-1 text-truncate"><small class="text-muted"><?php echo $article["size"] ?></small></p>
                <h5 class="card-text mb-0"><small>€</small><?php echo $article["basePrice"] ?></h5>
            </div>
        </div>
    </div>
</div>
