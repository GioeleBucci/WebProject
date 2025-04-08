<?php

$templateParams["title"] = "Account";
Utils::requireLoggedUser();

if (isset($_POST["logout"])) {
    Utils::logout();
}

?>

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="post">
                <input type="hidden" id="logout" name="logout" value="logout">
                <button type="submit" class="btn btn-secondary w-100">Logout</button>
            </form>
        </div>
    </div>
</div>