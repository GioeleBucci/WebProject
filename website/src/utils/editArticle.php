<?php

$article = $dbh->getArticle($_GET["articleId"]);
if ($article == false) {
	die("Product not found"); // TODO handle this more gracefully
}
unset($templateParams["insertionError"]);

if (isset($_POST["edit"])) {
	if (isset($_FILES["image"]) && !empty($_FILES["image"]["name"])) {
		// Image processing
		$fileName = $_FILES["image"]["name"];
		$filePath = Settings::UPLOAD_DIR . $fileName;
		$imageFileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
		$imageOk = 1;
	
		// Check if file already exists
		if (file_exists($filePath)) {
			$imageOk = 0;
		}
	
		// Only allow certain file formats
		if (!in_array($imageFileType, ["jpg", "png", "jpeg"])) {
			$imageOk = 0;
		}

		if ($imageOk == 0) {
			$templateParams["insertionError"] = "Error during image elaboration";
		} else {
			if (move_uploaded_file($_FILES["image"]["tmp_name"], "/opt/lampp/htdocs" . $filePath) == false) {
				$templateParams["insertionError"] = "Error during image upload";
			}
			else {
				unlink("/opt/lampp/htdocs" . Settings::UPLOAD_DIR . $article["image"]);
			}
		}
	}
	else {
		$fileName = $article["image"];
	}

	if ($dbh->updateArticle($article["articleId"], $_POST["name"], $_POST["details"], $_POST["description"], $_POST["material"], $_POST["weight"], $_POST["price"], $_POST["size"], $_POST["categoryId"], $fileName) == false) {
		$templateParams["insertionError"] = "Error during article update";
	}
	else {
		$article = $dbh->getArticle($_GET["articleId"]);
	}
}
