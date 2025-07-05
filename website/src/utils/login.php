<?php

$templateParams["loginError"] = "Please log-in to access this page.";

if (isset($_POST["email"]) && isset($_POST["password"])) {
    if ($dbh->checkCredentials($_POST["email"], $_POST["password"])) {
        Utils::login($_POST["email"]);
        Utils::addNotification("Logged in");
        unset($templateParams["loginError"]);
        
        // Redirect to the saved URL if it exists, otherwise go to account page
        if (isset($_SESSION['redirect_after_login'])) {
            $redirectURL = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            Utils::redirect($redirectURL);
        } else {
            Utils::redirect(Links::ACCOUNT);
        }
    } else {
        $templateParams["loginError"] = "Wrong email or password!";
    }
}
