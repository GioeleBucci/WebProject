<?php
    require_once 'bootstrap.php';
    //TODO: explicitly notify the result of the login to the user

    if(isset($_POST["logout"]) == false){
        if(isset($_POST["email"]) && isset($_POST["password"])){
            $login_check = $dbh->isLoginValid($_POST["email"], $_POST["password"]);
            if(isset($_SESSION["sessionId"])){
                //User is already logged in
                header("Location: http://localhost".Settings::BASE_PATH.Links::HOME);
            } else if($login_check == false){
                //Login failed
                header("Location: http://localhost".Settings::BASE_PATH.Links::REGISTER);
            } else {
                $_SESSION["sessionId"] = $_POST["email"];
                header("Location: http://localhost".Settings::BASE_PATH.Links::HOME);
            }
        }
    } else {
        $_SESSION["sessionId"] = null;
        $_POST["logout"] = null;
        header("Location: http://localhost".Settings::BASE_PATH.Links::HOME);
    }

    
    $templateParams["page"] = $routes[$requestPath];
    require_once 'base.php';
?>


<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Login</h4>
                </div>
                <div class="card-body">
                    <form method="post">
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
                    <form method="post">
                        <input type="hidden" id="logout" name="logout" value="logout">
                        <button type="submit" class="btn btn-primary w-100">Logout</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <small>Don't have an account? <a href=<?php echo Links::REGISTER ?>>Register here</a></small>
                </div>
            </div>
        </div>
    </div>
</div>