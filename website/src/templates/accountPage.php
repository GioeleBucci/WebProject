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
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Notifications</h4>
                </div>
                <!--<?php foreach ($dbh->getNotifications($_SESSION["sessionId"]) as $notification): ?>
                    <div class="card-body">
                        <div class="mb-3">
                            <p class="card-text mb-0"><small class="text-muted"><?php echo $notification["content"] ?></small></p>
                        </div>
                    </div>
                <?php endforeach; ?>-->
            </div>
            <form method="post">
                <input type="hidden" id="logout" name="logout" value="logout">
                <button type="submit" class="btn btn-secondary w-100">Logout</button>
            </form>
        </div>
    </div>
</div>