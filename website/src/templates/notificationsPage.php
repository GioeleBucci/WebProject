<?php require 'utils/loadNotifications.php' ?>

<?php $templateParams["title"] = "Notifications" ?>

<div class="container">
    <div class="text-center">
        <span class="page-title-text">Notifications</span>
    </div>
    <?php if ($notificationsAmount != 0): ?>


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
                            <a class="page-link" href="notifications?sectionNumber=<?php echo $sectionNumber; ?>"><?php echo $sectionNumber; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        <?php endif; ?>

    <?php else: ?>
        <p class="text-center lead mt-4">You have no notifications at the moment.</p>
    <?php endif; ?>
</div>
