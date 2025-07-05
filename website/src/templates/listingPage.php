<?php Utils::denyClientAccess(); ?>
<?php $templateParams["title"] = "Your Listings" ?>

<div class="container">
	<div class="text-center mb-4">
		<span class="page-title-text">Your Listings</span>
	</div>
	<div class="row mt-3 g-3">
		<?php foreach ($dbh->getListing($_SESSION["userId"]) as $article): ?>
			<div class="col-6 col-md-3">
				<?php require("components/listingItem.php") ?>
			</div>
		<?php endforeach; ?>
		<div class="col-6 col-md-3">
			<div class="card-wrapper h-100">
				<div class="card h-100">
					<!-- rotate(0) prevents the stretched link from affecting other elements -->
					<div style="transform: rotate(0);" class="d-flex flex-column h-100 card-top">
						<a href="new-article" class="d-flex justify-content-around align-content-center flex-1 h-100 icon" aria-label="Add new product">
							<em style="font-size:10rem !important;" class="h1 align-content-center bi-plus" aria-hidden="true"></em>
						</a>
						<div class="flex-shrink card-body">
							<h6 class="card-text mb-0 text">New product</h6>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
