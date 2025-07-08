<div class="text-center">
    <h1 class="display-1 fw-bold text-danger">404</h1>
    <p class="fs-3"> <span class="text-danger">Oops!</span> Page not found.</p>
    <p class="lead">
        The page you're looking for doesn't exist.
    </p>
    <a href="<?php echo Links::HOME ?>" class="btn btn-primary">Back to Homepage</a>
</div>

<?php
http_response_code(404);
die();
?>
