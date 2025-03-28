<?php
require_once 'bootstrap.php';

if(isset($_POST["email"]) && isset($_POST["password"])){
    $login_result = $dbh->checkLogin($_POST["email"], $_POST["password"]);
    if(count($login_result)==0){
        //Login fallito
        $templateParams["errorelogin"] = "Login fallito - Controlla email e password inserite";
    }
    else{
        $_SESSION["email"] = $login_result["email"];
        $_SESSION["isSeller"] = $login_result["isSeller"];
    }
}

if($_SESSION["isSeller"] == 'True'){
    //Send user to correct landing page
}

$templateParams["categorie"] = $dbh->getCategories();

require 'template/base.php';
?>