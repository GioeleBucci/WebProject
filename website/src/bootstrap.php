<?php
session_start();

require_once '../config/settings.php';
require_once 'model/pages.php';
require_once '../src/model/DatabaseHelper.php';

$dbh = DatabaseHelper::getInstance();

require_once 'model/login.php';
