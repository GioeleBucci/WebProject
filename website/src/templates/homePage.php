<div class="container mt-5">
    <!-- Header -->
    <div class="text-center">
        <h1>Welcome to Our Online Shop</h1>
        <p class="lead">Find the best products at unbeatable prices!</p>
    </div>

    <!-- Carousel -->
    <div id="productCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?php echo Settings::UPLOAD_DIR . "1.png" ?>" class="d-block w-100 img-fluid carousel-image" alt="Product 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Product 1</h5>
                    <p>High-quality and affordable.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?php echo Settings::UPLOAD_DIR . "2.png" ?>" class="d-block w-100 img-fluid carousel-image" alt="Product 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Product 2</h5>
                    <p>Perfect for your needs.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?php echo Settings::UPLOAD_DIR . "3.png" ?>" class="d-block w-100 img-fluid carousel-image" alt="Product 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Product 3</h5>
                    <p>Top-rated by our customers.</p>
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