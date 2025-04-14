<?php

Utils::requireLoggedUser();

$maxAmount = SiteConfigs::MAX_NOTIFICATIONS_PER_PAGE;
$notifications = $dbh->getNotifications($_SESSION["userId"]);
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
