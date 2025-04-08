<?php $templateParams["title"] = "Notifications" ?>

<?php

Utils::requireLoggedUser();

?>

<div class="container mt-2 mt-md-4">
    <div class="row">
        <div class="col">
            <?php foreach ($dbh->getNotifications($_SESSION["sessionId"]) as $notification): ?>
                <?php require("components/notificationCard.php") ?>
            <?php endforeach; ?>
            <nav>
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#">Previous</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                    <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">4</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">5</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
	</div>
</div>
