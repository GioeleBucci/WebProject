<?php require 'utils/loadNotifications.php' ?>

<?php $templateParams["title"] = "Notifications" ?>

<?php if ($notificationsAmount != 0): ?>
    <div class="container mt-2 mt-md-4">
        <div class="text-center mb-4">
            <h2>Notifications</h2>
        </div>

        <div class="row g-3">
            <?php foreach ($sections[$_GET["sectionNumber"]] as $notification): ?>
                <div class="col-12">
                    <?php require "components/notificationCard.php" ?>
                </div>
            <?php endforeach ?>
        </div>

        <?php if (count($sections) > 1): ?>
            <nav aria-label="Notifications pagination" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php foreach (array_keys($sections) as $sectionNumber): ?>
                        <li class="page-item <?php echo ($_GET["sectionNumber"] == $sectionNumber) ? 'active' : ''; ?>">
                            <a class="page-link" href="?sectionNumber=<?php echo $sectionNumber; ?>"><?php echo $sectionNumber; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        <?php endif; ?>

        <?php $dbh->markNotificationsAsRead($_SESSION["userId"]) ?>
    </div>
<?php else: ?>
    <div class="container mt-2 mt-md-4">
        <div class="text-center">
            <h2>Notifications</h2>
            <p class="lead mt-4">You have no notifications at the moment.</p>
        </div>
    </div>
<?php endif; ?>
