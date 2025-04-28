<?php $templateParams["title"] = "Your products" ?>

<div class="container mt-2 mt-md-4">
	<div class="row mt-3 g-3">
		<?php foreach ($dbh->getListing($_SESSION["userId"]) as $prod): ?>
			<div class="col-6 col-md-3">
				<?php require("components/itemCard.php") ?>
			</div>
		<?php endforeach; ?>
		<div class="col-6 col-md-3">
			<div class="card-wrapper h-100">
				<div class="card h-100">
					<!-- rotate(0) prevents the stretched link from affecting other elements -->
					<div style="transform: rotate(0);" class="d-flex flex-column h-100 card-top">
						<a href="new-article" class="d-flex justify-content-around align-content-center flex-1 h-100 icon">
							<i style="font-size:10rem !important;" class="h1 align-content-center bi-plus"></i>
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