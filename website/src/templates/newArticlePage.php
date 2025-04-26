<?php $templateParams["title"] = "New product" ?>

<?php require 'utils/addArticle.php' ?>

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Add a new product</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">Details</label>
                            <input type="text" class="form-control" id="details" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control" id="price" name="confirm_password" required>
                        </div>
						<div>
							<div class="form-group">
								<label for="categorySelect" class="form-label">Category</label>
								<select class="form-select" id="categorySelect" name="category" >
									<?php foreach ($dbh->getAllCategories as $category): ?>
										<option value="<?php echo $category["categoryId"]; ?>" ></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
                        <button type="submit" class="btn btn-primary w-100">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>