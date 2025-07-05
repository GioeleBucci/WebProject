<?php

require_once '../src/model/DatabaseHelper.php';

class Utils
{
    private function __construct() {}

    public const CLIENT = "client";
    public const SELLER = "seller";

    /**
     * Redirects the user to a specified page.
     *
     * @param string $to The page's link to redirect to. See {@see Links}
     */
    public static function redirect(string $dest, int $statusCode = 303)
    {
        if ($dest === "Refresh:0") {
            $to = $dest;
        } else {
            $to = "Location: " . Settings::BASE_PATH . $dest;
        }
        header($to, true, $statusCode);
    }

    /** 
     * Logs in a user by setting the correspondent user ID in the session.
     * 
     * @param string $email The email of the user to log in.
     */
    public static function login(string $email): void
    {
        $userId = DatabaseHelper::getInstance()->getUserId($email);
        $_SESSION['userId'] = $userId;
        DatabaseHelper::getInstance()->getUserType($userId) === self::SELLER ? $_SESSION["isSeller"] = true : $_SESSION["isSeller"] = false;
    }

    /**
     * Logs out the current user by destroying the session and redirecting to the home page.
     */
    public static function logout(): void
    {
        self::redirect(Links::HOME);
        session_unset();
        session_destroy();
    }

    /**
     * Checks if a user is currently logged in.
     *
     * @return bool Returns true if a user is logged in, false otherwise.
     */
    public static function isUserLoggedIn(): bool
    {
        return isset($_SESSION['userId']);
    }

    /**
     * Checks if a user is logged in. If not, redirects to the login page.
     */
    public static function requireLoggedUser(): void
    {
        if (!self::isUserLoggedIn()) {
            // Store the current page URL in session before redirecting
            $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $requestPath = str_replace(Settings::BASE_PATH, '', $requestUri);
            $_SESSION['redirect_after_login'] = $requestPath;
            self::redirect(Links::LOGIN);
        }
    }

    public static function addNotification(string $message): void
    {
        if (self::isUserLoggedIn()) {
            $dbh = DatabaseHelper::getInstance();
            $dbh->addNotification($_SESSION["userId"], date("Y-m-d H:i"), $message);
        }
    }
}
