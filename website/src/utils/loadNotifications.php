<?php

//Utils::requireLoggedUser();
if (!Utils::isUserLoggedIn()) {
    // Store the current page URL in session before redirecting
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $requestPath = str_replace(Settings::BASE_PATH, '', $requestUri);
    $_SESSION['redirect_after_login'] = $requestPath;
    Utils::redirect(Links::LOGIN);
    die();
}

if (isset($_POST["remnot"])) {
    $dbh->deleteNotification($_POST["remnot"]);
}

$maxAmount = SiteConfigs::MAX_NOTIFICATIONS_PER_PAGE;
$notifications = $dbh->getAllNotifications($_SESSION["userId"]);
$notificationsAmount = count($notifications);
if ($notificationsAmount > $maxAmount) {
    $sectionsAmount = $notificationsAmount / $maxAmount;
    if ($notificationsAmount % $maxAmount != 0) {
        $sectionsAmount = $sectionsAmount + 1;
    }
}
else {
    $sectionsAmount = 1;
}
for ($i = 1; $i <= $sectionsAmount; $i = $i +1) {
    $sections[$i] = array_slice($notifications, ($i - 1) * $maxAmount, $maxAmount);
}
if (!isset($_GET["sectionNumber"])) {
    $_GET["sectionNumber"] = 1;
}
