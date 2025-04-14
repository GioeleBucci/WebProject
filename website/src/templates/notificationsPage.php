<?php $templateParams["title"] = "Notifications" ?>

<?php require 'utils/loadNotifications.php' ?>

<?php if ($notificationsAmount != 0): ?>
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
<?php else: ?>
    <p>There are no notifications</p>
<?php endif; ?>
