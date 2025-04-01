<?php
require_once 'bootstrap.php';
$home_redirect = 'Location: '.Settings::BASE_PATH;

if(isset($_SESSION["sessionId"])){
    header($home_redirect);
    exit();
} else if(isset($_POST["email"]) && isset($_POST["password"])){
    $login_result = $dbh->checkLogin($_POST["email"], $_POST["password"]);
    if(count($login_result)==0){
        //Login fallito
        $templateParams["errorelogin"] = "Login fallito - Controlla email e password inserite";
    }
    else{
        $_SESSION["sessionId"] = $login_result["email"];
        header($home_redirect);
    }
}

if(isset($_SESSION["isSeller"])){
    //Send user to correct landing page
}

?>