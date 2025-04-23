<?php

if (!isset($_GET["id"])) {
    Utils::redirect(Links::HOME);
}

$articleId = $_GET["id"];
$article = $dbh->getArticle($articleId);

if (!$article) {
    die("Product not found"); // TODO handle this more gracefully
}

if (isset($_POST["addArticle"])) {
    $added = $dbh->addToCart($_SESSION["userId"], $articleId, intval($_POST["selectedVersion"]));
    if (!$added) {
        $templateParams["dberror"] = "Database transaction error";
    }
    unset($_POST["addArticle"]);
}


$articleVersions = $dbh->getArticleVersions($articleId);
