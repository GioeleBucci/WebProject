<div class="text-center">
    <h1 class="display-1 fw-bold text-danger">403</h1>
    <p class="fs-3"> <span class="text-danger">Oops!</span> Access forbidden.</p>
    <p class="lead">
        You don't have permission to access this resource.
    </p>
    <a href="<?php echo Links::HOME ?>" class="btn btn-primary">Back to Homepage</a>
</div>

<?php
http_response_code(403);
die();
?>

