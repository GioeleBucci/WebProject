<?php Utils::denySellerAccess(); ?>
<?php require "utils/loadOrders.php" ?>

<?php $templateParams["title"] = "Your orders" ?>

<div class="container">
	<div class="text-center">
		<span class="page-title-text">Your Orders</span>
	</div>

	<?php if ($orders !== false): ?>
		<?php foreach ($orders as $order) require "components/order.php" ?>
	<?php else: ?>
		<div class="row g-5">
			<div class="col-md-12">
				<p class="lead mt-4">You have made no orders yet.</p>
			</div>
		</div>
	<?php endif ?>
</div>
