<?php

$article = $dbh->getArticle($_GET["articleId"]);
if ($article == false) {
	die("Product not found"); // TODO handle this more gracefully
}
unset($templateParams["insertionError"]);

if (isset($_POST["confirm"])) {
	if ($dbh->addVersion($article["articleId"], $_POST["type"], $_POST["priceVariation"], $_POST["amount"]) == false) {
		$templateParams["insertionError"] = "Error during database insertion";
	}
}
