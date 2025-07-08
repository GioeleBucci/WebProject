<?php

if (isset($_POST["add"])) {
	unset($templateParams["insertionError"]);
	// Image processing
	$fileName = $_FILES["image"]["name"];
	$absoluteFilePath = "/opt/lampp/htdocs" . Settings::UPLOAD_DIR . "articles/" . $fileName;
	$imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
	$imageOk = true;

	// Check if file already exists
	if (file_exists($absoluteFilePath)) {
		$imageOk = false;
	}

	// Only allow certain file formats
	if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
		$imageOk = false;
	}

	if (!$imageOk) {
		$templateParams["insertionError"] = "Error during image elaboration";
		die();
	}

	if (!move_uploaded_file($_FILES["image"]["tmp_name"], $absoluteFilePath)) {
		$templateParams["insertionError"] = "Error during image upload";
		die();
	}

	if (!$dbh->addArticle($_SESSION["userId"], $_POST["name"], $_POST["details"], $_POST["description"], $_POST["material"], $_POST["weight"], $_POST["price"], $_POST["size"], $_POST["categoryId"], $fileName) || !$dbh->addVersion(-1, $_POST["type"], 0, $_POST["amount"])) {
		$templateParams["insertionError"] = "Error during article insertion";
	} else {
		Utils::redirect(Links::LISTING . "?articleAdded=success");
	}
}
