<?php Utils::denyClientAccess(); ?>
<?php require "utils/addArticle.php" ?>

<?php $templateParams["title"] = "New product" ?>

<?php include "components/articleForm.php"; ?>
