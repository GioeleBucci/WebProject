<?php

if (!Utils::isUserLoggedIn()) {
    // Store the current page URL in session before redirecting
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $requestPath = str_replace(Settings::BASE_PATH, '', $requestUri);
    $_SESSION['redirect_after_login'] = $requestPath;
    Utils::redirect(Links::LOGIN);
    die();
}

if (isset($_POST["logout"])) {
    Utils::logout();
    exit();
}

unset($_SESSION["account_success"]);
unset($_SESSION["account_error"]);

// Handle user information updates
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $redirect = false;
    
    // Update Email
    if (isset($_POST["update_email"]) && !empty($_POST["new_email"])) {
        $newEmail = $_POST["new_email"];
        if ($dbh->updateUserEmail($_SESSION["userId"], $newEmail)) {
            $_SESSION["account_success"] = "Email updated successfully!";
        } else {
            $_SESSION["account_error"] = "Email couldn't be updated.";
        }
        $redirect = true;
    }
    
    // Update Password
    if (isset($_POST["update_password"]) && !empty($_POST["new_password"]) && !empty($_POST["confirm_password"])) {
        if ($dbh->updateUserPassword($_SESSION["userId"], $_POST["new_password"])) {
            $_SESSION["account_success"] = "Password updated successfully!";
        } else {
            $_SESSION["account_error"] = "Password couldn't be updated.";
        }
        $redirect = true;
    }
    
    // Update Phone Number
    if (isset($_POST["update_phone"]) && !empty($_POST["new_phone"])) {
        if ($dbh->updateUserPhoneNumber($_SESSION["userId"], $_POST["new_phone"])) {
            $_SESSION["account_success"] = "Phone number updated successfully!";
        } else {
            $_SESSION["account_error"] = "Phone number couldn't be updated.";
        }
        $redirect = true;
    }
    
    // Update Address
    if (isset($_POST["update_address"]) && !empty($_POST["new_address"])) {
        if ($dbh->updateUserAddress($_SESSION["userId"], $_POST["new_address"])) {
            $_SESSION["account_success"] = "Address updated successfully!";
        } else {
            $_SESSION["account_error"] = "Address couldn't be updated.";
        }
        $redirect = true;
    }
}

// Fetch user info to display
$userInfo = $dbh->getUserInfo($_SESSION["userId"]);
