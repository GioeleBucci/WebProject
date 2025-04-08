<?php $templateParams["title"] = "Notifications" ?>

<?php

Utils::requireLoggedUser();

$maxNotificationAmount = 8;         // could be moved to a more appropriate location, e.g. Settings.php
$notifications = $dbh->getNotifications($_SESSION["sessionId"]);
$notificationsAmount = count($notifications);
if($notificationsAmount <= $maxNotificationAmount){
    $sectionsAmount = 1;
}
else{
    $sectionsAmount = $notificationsAmount / $maxNotificationAmount;
    if($notificationsAmount % $maxNotificationAmount != 0){
        $sectionsAmount = $sectionsAmount + 1;
    }
}
for($i = 1; $i <= $sectionsAmount; $i = $i +1){
    $sections[$i] = array_slice($notifications, ($i - 1) * $maxNotificationAmount, $maxNotificationAmount);
}
if(!isset($_GET["sectionNumber"])){
    $_GET["sectionNumber"] = 1;
}

?>

<div class="container mt-2 mt-md-4">
    <div class="row">
        <div class="col">
            <?php foreach ($sections[$_GET["sectionNumber"]] as $notification): ?>
                <?php require("components/notificationCard.php") ?>
            <?php endforeach; ?>
            <nav>
                <form>
                    <?php foreach (array_keys($sections) as $sectionNumber): ?>
                        <input type="submit" name="sectionNumber" value=<?php echo $sectionNumber ?>></input>
                    <?php endforeach; ?>
                </form>
            </nav>
        </div>
	</div>
</div>
