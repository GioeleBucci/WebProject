<?php $templateParams["title"] = "Home" ?>

<!-- Carousel -->
<div class="container-fluid px-0">
    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000" data-bs-touch="true" data-bs-pause="none">

        <?php
        $categories = $dbh->getCategories();
        shuffle($categories);
        $images = array_map(function ($category) {
            return strtolower(str_replace(" ", "", $category["name"]));
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

                <div class="carousel-item <?php echo ($index == 0) ? "active" : "" ?>">
                    <a class="e" href="search?q=&filters[]=<?php echo urlencode($categories[$index]['name']); ?>">
                        <img src="<?php echo $path ?>" class="d-block w-100 img-fluid carousel-image" alt=<?php echo ($image) ?>>
                        <div class="carousel-caption">
                            <h1><?php echo $categories[$index]["name"] ?></h1>
                            <p><?php echo $carouselTexts[$index % sizeof($carouselTexts)] ?></p>
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
        <?php foreach ($dbh->getArticles(50) as $prod): ?>
            <div class="col-6 col-md-3">
                <?php require("components/carouselItemCard.php") ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>