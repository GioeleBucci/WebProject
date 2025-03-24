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
    <div class="container mt-1">
        <!-- Header -->
        <!-- TODO change icons depending on wether or not the user is logged -->
        <div class="d-flex justify-content-between align-items-center py-3">
            <div>
                <i class="bi bi-bell fs-4 mx-2"></i>
            </div>
            <div>
                <img src="<?php echo Settings::UPLOAD_DIR . 'logo.png'; ?>" alt="Logo" class="img-fluid" style="height: 50px;">
            </div>
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
    <div class="container mt-4">
        <!-- Footer -->
        <div class="d-flex justify-content-between align-items-center py-3 border-top">
            <div>
                <p class="mb-0">&copy; <?php echo date("Y"); ?> Company Name</p>
            </div>
            <div>
                <a href="#" class="text-decoration-underline text-dark mx-2">Privacy Policy</a>
                <a href="#" class="text-decoration-underline text-dark mx-2">Terms of Service</a>
                <a href="#" class="text-decoration-underline text-dark mx-2">Cookies</a>
            </div>
        </div>
    </div>
</footer>

<body>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" defer integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>