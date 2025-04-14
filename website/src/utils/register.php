<?php

if (isset($_SESSION["userId"])) {
    Utils::redirect(Links::ACCOUNT);
}
if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
    if (strcmp($_POST["password"], $_POST["confirm_password"]) == 0) {
        $register = $dbh->addUser($_POST["email"], $_POST["password"], $_POST["name"]);
        if ($register["result"] == true) {
            Utils::login($_POST["email"]);
            //EXTRA: print actual login date and time
            $dbh->addNotification($_SESSION["userId"], date("Y-m-d H:i:s"), "Registrazione effettuata");
            unset($templateParams["registrationError"]);
            Utils::redirect(Links::ACCOUNT);
        } else {
            switch ($register["errCode"]) {
                case "ALR_EXIST":
                    $templateParams["registrationError"] = "Registration failed - the given email address is already in use";
                break;
                case "FATAL":
                default:
                    $templateParams["registrationError"] = "Registration failed - Unknown database error";
                break;
            }
        }
    } else {
        $templateParams["registrationError"] = "The inserted passwords don't match";
    }
}