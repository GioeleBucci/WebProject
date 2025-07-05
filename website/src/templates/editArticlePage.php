<?php Utils::denyClientAccess(); ?>
<?php require "utils/editArticle.php" ?>

<?php $templateParams["title"] = "Edit " . implode(" ", [$article["name"], $article["details"]]) ?>

<?php include "components/articleForm.php"; ?>
