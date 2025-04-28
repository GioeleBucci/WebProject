<?php

if (isset($_POST["submit"])) {
	if (!isset($_POST["name"]) || !isset($_POST["details"]) || !isset($_POST["description"]) || !isset($_POST["price"]) || !isset($_POST["categoryId"])) {
		$templateParams["insertionError"] = "All fields must be filled in order to proceed";
	} else {
		unset($_SESSION["add-product"]);

		// Image processing
		$target_dir = "assets/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		$imageOk = 1;
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

		// Check if image file is a actual image or fake image
		if (isset($_POST["submit"])) {
			$check = getimagesize($_FILES["image"]["tmp_name"]);
			if ($check !== false) {
				$imageOk = 1;
			} else {
				$imageOk = 0;
			}
		}

		// Check if file already exists
		if (file_exists($target_file)) {
			$imageOk = 0;
		}

		// Allow certain file formats
		if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif") {
			$imageOk = 0;
		}

		if ($imageOk == 0) {
		} else {
			move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
		}

		$dbh->addArticle($_POST["name"], $_POST["details"], $_POST["description"], $_POST["price"], $_POST["categoryId"], $_POST["image"]);
	}
}
