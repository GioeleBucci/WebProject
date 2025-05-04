<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?php echo Settings::BASE_PATH; ?>" />
    <link rel="icon" href="<?php echo Settings::UPLOAD_DIR . 'logo.png'; ?>" type="image/png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo Settings::STYLESHEET_DIR ?>" rel="stylesheet">
</head>

<body>
    <div class="page-wrapper">
        <header>
            <div class="container mt-4 mb-1 mb-md-4">
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
                            <?php if (isset($_SESSION["isSeller"])): ?>
                                <a href="<?php echo Links::LISTING ?>" class="icon">
                                    <i class="bi bi-tag fs-5 mx-2"></i>
                                </a>
                            <?php endif; ?>
                            <a href="<?php echo Links::CART ?>" class="icon">
                                <i class="bi bi-cart fs-5 mx-2"></i>
                            </a>
                            <a href="<?php echo Links::ACCOUNT ?>" class="icon">
                                <i class="bi bi-person fs-5 mx-2"></i>
                            </a>
                            <a href="<?php echo Links::NOTIFICATIONS ?>" class="icon">
                                <i class="bi bi-bell fs-5 mx-2"></i>
                            </a>
                            <a href="<?php echo Links::WISHLIST ?>" class="icon">
                                <i class="bi bi-heart fs-5 mx-2"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Search bar -->
                    <div class="flex-grow-1 mt-3 mb-3 mb-md-0 mx-md-3">
                        <form class="d-flex" action="search" method="get">
                            <input class="form-control me-2 rounded-pill" type="search" placeholder="What are you looking for?" aria-label="Search" name="q" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                            <button class="btn btn-outline-primary rounded-circle d-flex align-items-center justify-content-center" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                    <!-- Icons (desktop) -->
                    <div class="d-none d-md-block mt-3">
                        <?php if (isset($_SESSION["isSeller"])): ?>
                            <a href="<?php echo Links::LISTING ?>" class="icon">
                                <i class="bi bi-tag fs-4 mx-2"></i>
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo Links::CART ?>" class="icon">
                            <i class="bi bi-cart fs-4 mx-2"></i>
                        </a>
                        <a href="<?php echo Links::ACCOUNT ?>" class="icon">
                            <i class="bi bi-person fs-4 mx-2"></i>
                        </a>
                        <a href="<?php echo Links::NOTIFICATIONS ?>" class="icon">
                            <i class="bi bi-bell fs-4 mx-2"></i>
                        </a>
                        <a href="<?php echo Links::WISHLIST ?>" class="icon">
                            <i class="bi bi-heart fs-4 mx-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main style="flex-grow: 1;">
            <?php
            if (isset($templateParams["page"])) {
                require($templateParams["page"]);
            }
            ?>
            <!-- Title can be set only after page's specific templateParams are loaded in -->
            <title> <?php echo "Kiwi" . (isset($templateParams["title"]) ? " - " . $templateParams["title"] : "") ?> </title>
        </main>

        <footer>
            <div class="container mt-5">
                <!-- Footer -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center py-3 border-top">
                    <div>
                        <p class="mb-0">&copy; <?php echo date("Y"); ?> Company Name</p>
                    </div>
                    <div class="d-flex flex-column flex-md-row text-center text-md-start">
                        <a href="#" class="text-decoration-underline text-dark my-1 mx-md-2">Privacy Policy</a>
                        <a href="#" class="text-decoration-underline text-dark my-1 mx-md-2">Terms of Service</a>
                        <a href="#" class="text-decoration-underline text-dark my-1 mx-md-2">Cookies</a>
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
