<!-- Carousel -->
<div class="container-fluid px-0 mt-1">
    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?php echo Settings::UPLOAD_DIR . "1.png" ?>" class="d-block w-100 img-fluid carousel-image" alt="Product 1">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Product 1</h1>
                    <p>High-quality and affordable.</p>
                    <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?php echo Settings::UPLOAD_DIR . "2.png" ?>" class="d-block w-100 img-fluid carousel-image" alt="Product 2">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Product 2</h1>
                    <p>Perfect for your needs.</p>
                    <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?php echo Settings::UPLOAD_DIR . "3.png" ?>" class="d-block w-100 img-fluid carousel-image" alt="Product 3">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Product 3</h1>
                    <p>Top-rated by our customers.</p>
                    <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<div class="container mt-5">
    <!-- Featured products -->
    <div class="row mt-4 g-2">
        <?php for ($i = 1; $i <= 9; $i++): ?>
            <div class="col-6 col-md-4">
                <img src="<?php echo Settings::UPLOAD_DIR . $i % 3 + 1 . '.png'; ?>" class="img-thumbnail" alt="Image <?php echo $i; ?>">
            </div>
        <?php endfor; ?>
    </div>
</div>