<?php
class Settings
{
    private const ROOT_PATH = "/WebProject/website/";
    public const BASE_PATH = Settings::ROOT_PATH . "src/";
    public const UPLOAD_DIR = Settings::ROOT_PATH . "assets/";
    public const STYLESHEET_DIR = Settings::ROOT_PATH . "css/style.css";
    public const BASE_URL = "http://localhost" . Settings::BASE_PATH;
    public const DB_SERVERNAME = "localhost";
    public const DB_USERNAME = "root";
    public const DB_PASSWORD = "";
    public const DB_DBNAME = "Kiwi";
    public const DB_PORT = 3306;
}
