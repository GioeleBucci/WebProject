<?php
require_once 'bootstrap.php';
//TODO: print something if the user is already logged in

$home_redirect = 'Location: http://localhost/WebProject/website/src/home';
$login_redirect = 'Location: http://localhost/WebProject/website/src/login';

if(isset($_SESSION["sessionID"])){
    //User is already logged in
    header($home_redirect);
    $templateParams["page"] = $routes[$requestPath];
    require_once 'base.php';
    exit();
} else if(isset($_POST["email"]) && isset($_POST["password"])){
    $login_result = $dbh->checkLogin($_POST["email"], $_POST["password"]);
    if($login_result==0){
        //Login failed
        header($login_redirect);
    }
    else{
        $_SESSION["sessionID"] = $_POST["email"];
        $templateParams["page"] = $routes[$requestPath];
        header($login_redirect);
    }
}

//header($home_redirect);
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
                    <form method="post" action=>
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