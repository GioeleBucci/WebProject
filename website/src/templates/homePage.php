<?php $templateParams["title"] = "Home" ?>

<!-- Carousel -->
<div class="container-fluid px-0">
    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000" data-bs-touch="true" data-bs-pause="none">

        <?php
        $categories = $dbh->getCategoryNames();
        shuffle($categories);
        $images = array_map(function ($category) {
            return strtolower(str_replace(" ", "", $category));
        }, $categories);
        $carouselTexts = [
            "Create the space you love.",
            "Design your dream home.",
            "Affordable style for every room.",
            "Innovate your living space.",
            "Comfort meets functionality.",
            "Transform your home today.",
            "Inspiration for every corner.",
            "Style that fits your life.",
            "Make your house a home.",
            "Where ideas come to life."
        ];
        shuffle($carouselTexts);
        ?>

        <div class="carousel-indicators">
            <?php foreach ($images as $index => $image): ?>
                <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>" aria-label="Slide <?php echo $index + 1; ?>"></button>
            <?php endforeach; ?>
        </div>

        <div class="carousel-inner">
            <?php foreach ($images as $index => $image): ?>

                <?php $path = Settings::UPLOAD_DIR . "categories/" . $image . ".png"; ?>

                <div class="carousel-item <?php echo ($index === 0) ? "active" : "" ?>">
                    <?php
                    $searchUrl = "search?" . http_build_query([
                        'q' => '',
                        'filters' => [$categories[$index]]
                    ]);
                    ?>
                    <a class="e" href="<?php echo $searchUrl; ?>" aria-label="Browse <?php echo htmlspecialchars($categories[$index]); ?> products">
                        <img src="<?php echo $path ?>" class="d-block w-100 img-fluid carousel-image" alt="<?php echo htmlspecialchars($image); ?>">
                        <div class="carousel-caption">
                            <span class="page-title-text"><?php echo htmlspecialchars($categories[$index]); ?></span>
                            <p><?php echo htmlspecialchars($carouselTexts[$index % sizeof($carouselTexts)]); ?></p>
                        </div>
                    </a>
                </div>

            <?php endforeach; ?>
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
        <?php foreach ($dbh->getAllArticles(50) as $article): ?>
            <div class="col-6 col-md-3">
                <?php require("components/itemCard.php") ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
