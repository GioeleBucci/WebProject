<?php
// Default values for new article form
$isEdit = isset($article) && !empty($article);
$formTitle = $isEdit ? "Edit article" : "Add a new product";
$submitText = $isEdit ? "Edit" : "Add";
$submitName = $isEdit ? "edit" : "add";
$imageRequired = $isEdit ? "" : "required";

// Article data (empty for new, populated for edit)
$articleData = $isEdit ? $article : [
  "name" => "",
  "details" => "",
  "longDescription" => "",
  "material" => "",
  "weight" => "",
  "basePrice" => "",
  "size" => "",
  "categoryId" => ""
];
?>

<div class="container mt-3">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header text-center">
          <h4 class="mb-0"><?php echo $formTitle; ?></h4>
        </div>
        <div class="card-body">
          <form enctype="multipart/form-data" method="post">
            <?php if (isset($templateParams["insertionError"])): ?>
              <div class="alert alert-warning show mb-1 mt-0" role="alert">
                <?php echo $templateParams["insertionError"]; ?>
              </div>
            <?php endif; ?>
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($articleData["name"]); ?>" required>
            </div>
            <?php if (!$isEdit): ?>
              <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <input type="text" class="form-control" id="type" name="type" required>
              </div>
            <?php endif; ?>
            <div class="mb-3">
              <label for="details" class="form-label">Details</label>
              <input type="text" class="form-control" id="details" name="details" value="<?php echo htmlspecialchars($articleData["details"]); ?>" required>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($articleData["longDescription"]); ?>" required>
            </div>
            <div class="mb-3">
              <label for="material" class="form-label">Material</label>
              <input type="text" class="form-control" id="material" name="material" value="<?php echo htmlspecialchars($articleData["material"]); ?>" required>
            </div>
            <div class="mb-3">
              <label for="weight" class="form-label">Weight (kg)</label>
              <input type="number" step="0.01" min="0" class="form-control" id="weight" name="weight" value="<?php echo htmlspecialchars($articleData["weight"]); ?>" required>
            </div>
            <div class="mb-3">
              <label for="price" class="form-label">Price (€)</label>
              <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($articleData["basePrice"]); ?>" required>
            </div>
            <div class="mb-3">
              <label for="size" class="form-label">Size</label>
              <input type="text" class="form-control" id="size" name="size" value="<?php echo htmlspecialchars($articleData["size"]); ?>" required>
            </div>
            <?php if (!$isEdit): ?>
              <div class="mb-3">
                <label for="amount" class="form-label">Stock amount</label>
                <input type="number" min="0" class="form-control" id="amount" name="amount" required>
              </div>
            <?php endif; ?>
            <div class="mb-3">
              <label for="image" class="form-label">Image</label>
              <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
              <input type="file" class="form-control" accept="image/png, image/jpg, image/jpeg" id="image" name="image" <?php echo $imageRequired; ?>>
            </div>
            <div class="mb-4">
              <div class="form-group">
                <label for="categoryId" class="form-label">Category</label>
                <select class="form-select" id="categoryId" name="categoryId">
                  <?php foreach ($dbh->getAllCategories() as $category): ?>
                    <?php $isSelected = "";
                    if ($category["categoryId"] == $articleData["categoryId"]) {
                      $isSelected = "selected";
                    } ?>
                    <option value="<?php echo $category["categoryId"]; ?>" <?= $isSelected ?>><?php echo $category["name"] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <button type="submit" id="<?php echo $submitName; ?>" name="<?php echo $submitName; ?>" class="btn btn-primary w-100"><?php echo $submitText; ?></button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
