<?php

Utils::denySellerAccess();
$orders = $dbh->getAllOrders($_SESSION["userId"]);
