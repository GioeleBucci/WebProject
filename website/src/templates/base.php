<?php require_once 'bootstrap.php'; ?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?php echo Settings::BASE_PATH; ?>" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo Settings::STYLESHEET_DIR ?>" rel="stylesheet">
</head>

<header>
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between py-3">
            <!-- Logo -->
            <div>
                <img src="<?php echo Settings::UPLOAD_DIR . 'logo.png'; ?>" alt="Logo" class="img-fluid">
            </div>
            <!-- Search bar -->
            <div class="flex-grow-1 mx-3">
                <form class="d-flex" action="#" method="get">
                    <input class="form-control me-2 rounded-pill" type="search" placeholder="What are you looking for?" aria-label="Search" name="q">
                    <button class="btn btn-outline-primary rounded-circle d-flex align-items-center justify-content-center" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
            <!-- Icons -->
            <div>
                <i class="bi bi-cart fs-4 mx-2"></i>
                <i class="bi bi-person fs-4 mx-2"></i>
            </div>
        </div>
    </div>
</header>

<main>
    <?php
    if (isset($templateParams["page"])) {
        require($templateParams["page"]);
    }
    ?>
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

<body>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" defer integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>