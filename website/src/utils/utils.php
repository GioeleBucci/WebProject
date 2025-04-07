<?php

// require_once '../config/settings.php';
require_once 'model/pages.php';
// require_once '../src/model/DatabaseHelper.php';
// require_once '../src/utils/utils.php';

class Utils
{
    private function __construct() {}

    /**
     * Redirects the user to a specified page.
     *
     * @param string $to The page's link to redirect to. See {@see Links}
     */
    public static function redirect(string $to)
    {
        header("Location: " . Settings::BASE_URL . $to);
    }

    /** 
     * Logs in a user by setting the session ID to the user's email.
     * 
     * @param string $email The email of the user to log in.
     */
    public static function login(string $email): void
    {
        $userId = DatabaseHelper::getInstance()->getUserId($email);
        $_SESSION['sessionId'] = $userId;
    }

    /**
     * Logs out the current user by destroying the session and redirecting to the home page.
     */
    public static function logout(): void
    {
        session_destroy();
        self::redirect(Links::HOME);
    }

    /**
     * Checks if a user is currently logged in.
     *
     * @return bool Returns true if a user is logged in, false otherwise.
     */
    public static function isUserLoggedIn(): bool
    {
        return !empty($_SESSION['sessionId']);
    }

    /**
     * Checks if a user is logged in. If not, redirects to the login page.
     */
    public static function requireLoggedUser(): void
    {
        if (!self::isUserLoggedIn()) {
            self::redirect(Links::LOGIN);
        }
    }
}
