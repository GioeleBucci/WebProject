<?php

$article = $dbh->getArticle($_GET["articleId"]) ?? false;

if ($article === false) {
	die("Product not found");
}

unset($templateParams["insertionError"]);

if (isset($_POST["confirm"])) {
	if ($dbh->addVersion($article["articleId"], $_POST["type"], $_POST["priceVariation"], $_POST["amount"]) === false) {
		$templateParams["insertionError"] = "Error during database insertion";
	} else {
		Utils::redirect(Links::ARTICLE . "?id=" . $article["articleId"] . "&updated=success");
	}
}
