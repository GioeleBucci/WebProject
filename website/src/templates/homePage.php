<?php $templateParams["title"] = "Home" ?>

<!-- Carousel -->
<div class="container-fluid px-0">
    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000" data-bs-touch="true" data-bs-pause="none">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?php echo Settings::UPLOAD_DIR . "1.png" ?>" class="d-block w-100 img-fluid carousel-image" alt="Product 1">
                <div class="carousel-caption">
                    <h1>Product 1</h1>
                    <p>High-quality and affordable.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?php echo Settings::UPLOAD_DIR . "2.png" ?>" class="d-block w-100 img-fluid carousel-image" alt="Product 2">
                <div class="carousel-caption">
                    <h1>Product 2</h1>
                    <p>Perfect for your needs.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?php echo Settings::UPLOAD_DIR . "3.png" ?>" class="d-block w-100 img-fluid carousel-image" alt="Product 3">
                <div class="carousel-caption">
                    <h1>Product 3</h1>
                    <p>Top-rated by our customers.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev d-none d-md-block" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next d-none d-md-block" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<div class="container mt-2 mt-md-4">
    <!-- Featured products -->
    <div class="row mt-3 g-3">
        <?php foreach ($dbh->getArticles(50) as $prod): ?>
            <div class="col-6 col-md-3">
                <?php require("components/itemCard.php") ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>