<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?php echo Settings::BASE_PATH; ?>">
    <link rel="icon" href="<?php echo Settings::UPLOAD_DIR . 'logo.png'; ?>" type="image/png">
    <title><?php echo "Kiwi" . (isset($templateParams["title"]) ? " - " . $templateParams["title"] : "") ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo Settings::STYLESHEET_DIR ?>" rel="stylesheet">
</head>

<body>
    <div class="page-wrapper">
        <header>
            <div class="container-fluid px-3 px-md-5 mt-4 mb-1 mb-md-4">
                <!-- Header -->
                <div class="d-flex flex-column flex-md-row justify-content-between py-3 gap-2 gap-md-0">
                    <!-- Logo -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="<?php echo Links::HOME ?>">
                            <img src="<?php echo Settings::UPLOAD_DIR . 'logo.png'; ?>" alt="Logo" class="img d-block d-md-none" style="height: 40px;">
                            <img src="<?php echo Settings::UPLOAD_DIR . 'logo.png'; ?>" alt="Logo" class="img d-none d-md-block" style="height: 60px;">
                        </a>
                        <!-- Icons (mobile) -->
                        <div class="d-md-none">
                            <?php if (($_SESSION["isSeller"] ?? false) === true): ?>
                                <a href="<?php echo Links::LISTING ?>" class="icon" aria-label="Your Listings">
                                    <span class="bi bi-tag fs-5 mx-2" aria-hidden="true"></span>
                                </a>
                            <?php endif; ?>
                            <a href="<?php echo Links::NOTIFICATIONS ?>" class="icon" aria-label="Notifications">
                                <span class="bi bi-bell fs-5 mx-2" aria-hidden="true"></span>
                            </a>
                            <a href="<?php echo Links::WISHLIST ?>" class="icon" aria-label="Wishlist">
                                <span class="bi bi-heart fs-5 mx-2" aria-hidden="true"></span>
                            </a>
                            <a href="<?php echo Links::CART ?>" class="icon" aria-label="Shopping Cart">
                                <span class="bi bi-cart fs-5 mx-2" aria-hidden="true"></span>
                            </a>
                            <a href="<?php echo Links::ACCOUNT ?>" class="icon" aria-label="Account">
                                <span class="bi bi-person fs-5 mx-2" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                    <!-- Search bar -->
                    <div class="flex-grow-1 mt-3 mb-3 mb-md-0 mx-md-3">
                        <form class="d-flex" action="search" method="get">
                            <label for="search-input" class="visually-hidden">Search products</label>
                            <input class="form-control me-2 rounded-pill" type="search" placeholder="What are you looking for?" aria-label="Search products" name="q" id="search-input" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                            <button class="btn btn-outline-primary rounded-circle d-flex align-items-center justify-content-center" type="submit" aria-label="Search">
                                <span class="bi bi-search" aria-hidden="true"></span>
                            </button>
                        </form>
                    </div>
                    <!-- Icons (desktop) -->
                    <div class="d-none d-md-block mt-3">
                        <?php if (($_SESSION["isSeller"] ?? false) === true): ?>
                            <a href="<?php echo Links::LISTING ?>" class="icon" aria-label="Your Listings">
                                <span class="bi bi-tag fs-4 mx-2" aria-hidden="true"></span>
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo Links::NOTIFICATIONS ?>" class="icon" aria-label="Notifications">
                            <span class="bi bi-bell fs-4 mx-2" aria-hidden="true"></span>
                        </a>
                        <a href="<?php echo Links::WISHLIST ?>" class="icon" aria-label="Wishlist">
                            <span class="bi bi-heart fs-4 mx-2" aria-hidden="true"></span>
                        </a>
                        <a href="<?php echo Links::CART ?>" class="icon" aria-label="Shopping Cart">
                            <span class="bi bi-cart fs-4 mx-2" aria-hidden="true"></span>
                        </a>
                        <a href="<?php echo Links::ACCOUNT ?>" class="icon" aria-label="Account">
                            <span class="bi bi-person fs-4 mx-2" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <?php
            if (isset($templateParams["page"])) {
                require $templateParams["page"];
            }
            ?>
        </main>

        <footer>
            <div class="container-fluid px-3 px-md-5 mt-5">
                <!-- Footer -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center py-3 border-top">
                    <div>
                        <p class="mb-0">&copy; <?php echo date("Y"); ?> KIWI Corp.</p>
                    </div>
                    <div class="d-flex flex-column flex-md-row text-center text-md-start">
                        <a href="<?php echo Links::PRIVACY_POLICY ?>" class="text-decoration-underline text-dark my-1 mx-md-2">Privacy Policy</a>
                        <a href="<?php echo Links::TERMS_OF_SERVICE ?>" class="text-decoration-underline text-dark my-1 mx-md-2">Terms of Service</a>
                        <a href="<?php echo Links::COOKIE_POLICY ?>" class="text-decoration-underline text-dark my-1 mx-md-2">Cookies</a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" defer integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <!-- Custom JS -->
        <script src="<?php echo Settings::BASE_PATH . "../js/functions.js"; ?>" defer></script>
    </div>
</body>

</html>
