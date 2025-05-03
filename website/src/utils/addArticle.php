<?php

if (isset($_POST["add"])) {
	unset($templateParams["insertionError"]);
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
	if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
		$imageOk = 0;
	}

	if ($imageOk == 0) {
		$templateParams["insertionError"] = "Error during image elaboration";
	} else {
		if (move_uploaded_file($_FILES["image"]["tmp_name"], "/opt/lampp/htdocs" . $filePath) == false) {
			$templateParams["insertionError"] = "Error during image upload";
		}
		else {
			if ($dbh->addArticle($_POST["name"], $_POST["details"], $_POST["description"], $_POST["material"], $_POST["weight"], $_POST["price"], $_POST["size"], $_POST["categoryId"], $fileName) == false) {
				$templateParams["insertionError"] = "Error during image elaboration";
			}
		}
	}
}
