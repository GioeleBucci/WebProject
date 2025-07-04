<?php

$orders = $dbh->getOrdersWithItemCount($_SESSION["userId"]);
