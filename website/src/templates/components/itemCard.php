<div class="card-wrapper">
    <div class="card h-100">
        <!-- rotate(0) prevents the stretched link from affecting other elements -->
        <div class="card-top" style="transform: rotate(0);"
            onmouseenter="underlineProductName.call(this, true)"
            onmouseleave="underlineProductName.call(this, false)">
            <a href="article?id=<?php echo $prod['articleId']; ?>" class="stretched-link text-decoration-none mb-0">
                <div class="image-fluid overflow-hidden d-flex justify-content-center align-items-center" style="height: 200px;">
                    <img src="<?php echo Settings::UPLOAD_DIR . $prod['image']; ?>"
                        class="card-img-top"
                        alt="Product Image">
                </div>
            </a>
            <div class="card-body">
                <h6 class="card-text mb-0 product-name"><?php echo $prod["name"] ?></h6>
                <p class="card-text mb-0 text-truncate"><small class="text-muted"><?php echo $prod["details"] ?></small></p>
                <p class="card-text mb-1 text-truncate"><small class="text-muted"><?php echo $prod["size"] ?></small></p>
                <h5 class="card-text mb-0"><small>€</small><?php echo $prod["basePrice"] ?></h5>
            </div>
        </div>

        <?php if (Utils::isUserLoggedIn()): ?>
            <div class="card-body pt-0">
                <button type="button" class="btn btn-outline-danger wishlist-btn" 
                        data-article-id="<?php echo $prod['articleId']; ?>"
                        onclick="toggleWishlist.call(this)">
                    <i class="bi bi-heart<?php 
                        if(isset($_SESSION['userId']) && $dbh->isInWishlist($_SESSION['userId'], $prod['articleId'])) {
                            echo '-fill';
                        }
                    ?>"></i>
                </button>
            </div>
        <?php endif; ?>
    </div>
</div>
