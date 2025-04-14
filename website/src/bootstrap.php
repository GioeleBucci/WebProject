<?php
session_start();

require_once '../config/settings.php';
require_once '../config/siteConfigs.php';
require_once 'model/pages.php';
require_once '../src/model/DatabaseHelper.php';
require_once '../src/utils/utils.php';

$dbh = DatabaseHelper::getInstance();

