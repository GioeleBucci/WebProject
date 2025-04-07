<?php $templateParams["title"] = "Register" ?>

<?php
    if(isset($_SESSION["sessionId"])){
        Utils::redirect(Links::ACCOUNT);
    }
    if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])){
        if(strcmp($_POST["password"], $_POST["confirm_password"]) != 0){
            $templateParams["registrationError"] = "The inserted passwords don't match";
        } else{
            $result = $dbh->addUser($_POST["email"], $_POST["password"], $_POST["name"]);
            if($result){
                Utils::login($_POST["email"]);
                //EXTRA: print actual login date and time
                $dbh->addNotification($_SESSION["sessionId"], "01-01-2001 12:00:00", "Registrazione effettuata");
                unset($templateParams["registrationError"]);
                Utils::redirect(Links::ACCOUNT);
            } else{
                $templateParams["registrationError"] = "Registration failed! Make sure the email hasn't already been used for another account";
            }
        }
    }
?>

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Register</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <?php if (isset($templateParams["registrationError"])): ?>
                            <div class="alert alert-warning show mb-1 mt-0" role="alert">
                                <?php echo $templateParams["registrationError"]; ?>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <small>Already have an account? <a href="<?php echo Links::LOGIN ?>">Login here</a></small>
                </div>
            </div>
        </div>
    </div>
</div>