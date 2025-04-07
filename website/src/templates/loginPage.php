<?php $templateParams["title"] = "Login" ?>

<?php

if (Utils::isUserLoggedIn()) {
    Utils::redirect(Links::ACCOUNT);
}

if (isset($_POST["email"]) && isset($_POST["password"])) {
    if ($dbh->isLoginValid($_POST["email"], $_POST["password"])) {
        Utils::login($_POST["email"]);
        //EXTRA: print actual login date and time
        $dbh->addNotification($_SESSION["sessionId"], "01-01-2001 12:00:00", "Login effettuato");
        unset($templateParams["loginError"]);
        Utils::redirect(Links::ACCOUNT);
    } else {
        $templateParams["loginError"] = "Wrong email or password!";
    }
}

?>


<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Login</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <?php if (isset($templateParams["loginError"])): ?>
                            <div class="alert alert-warning show mb-1 mt-0" role="alert">
                                <?php echo $templateParams["loginError"]; ?>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <small>Don't have an account? <a href=<?php echo Links::REGISTER ?>>Register here</a></small>
                </div>
            </div>
        </div>
    </div>
</div>