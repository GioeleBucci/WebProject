<?php $templateParams["title"] = "New version for ".implode(" ", [$article["name"], $article["details"]]) ?>

<?php require 'utils/addVersion.php' ?>

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Add a new version for <?php echo implode(" ", [$article["name"], $article["details"]]) ?></h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Type</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">Additional price (optional)</label>
                            <input type="text" class="form-control" id="details" name="email" >
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>