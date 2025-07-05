<?php

if (!isset($_GET["id"])) {
    Utils::redirect(Links::HOME);
}

$articleId = $_GET["id"];
$article = $dbh->getArticle($articleId);
$_SESSION["currentArticle"] = $article;

if (!$article) {
    die("Product not found");
}

// Check for success message after article update
if (isset($_GET["updated"]) && $_GET["updated"] === "success") {
    $templateParams["successMessage"] = "Article updated successfully!";
}

if (isset($_POST["addArticle"])) {
    $added = $dbh->addToCart($_SESSION["userId"], $articleId, $_POST["selectedVersion"]);
    unset($_POST["addArticle"]);
}

$articleVersions = $dbh->getAllVersions($articleId);
