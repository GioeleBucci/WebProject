<?php Utils::allowOnlySellerWithId(DatabaseHelper::getInstance()->getArticleSeller($_GET['articleId'])["sellerId"]); ?>
<?php require "utils/editArticle.php" ?>

<?php $templateParams["title"] = "Edit " . implode(" ", [$article["name"], $article["details"]]) ?>

<?php include "components/articleForm.php"; ?>
