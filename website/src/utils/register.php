<?php

if (isset($_SESSION["userId"])) {
    Utils::redirect(Links::ACCOUNT);
}
if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
    if (strcmp($_POST["password"], $_POST["confirm_password"]) == 0) {
        // hash the password
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $hashed_password = hash('sha512', $_POST["password"] . $random_salt);
        // create a new user in the database
        $register = $dbh->addUser($_POST["email"], $hashed_password, $random_salt, $_POST["name"]);
        if ($register["result"] == true) {
            Utils::login($_POST["email"]);
            //EXTRA: print actual login date and time
            $dbh->addNotification($_SESSION["userId"], date("Y-m-d H:i"), "Registrazione effettuata");
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
