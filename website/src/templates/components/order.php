<div class="order-card">
    <div class="card h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1 me-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="card-title mb-0">Order #<?php echo $order["orderId"] ?></h6>
                        <span class="badge bg-primary">Processing</span>
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <strong>Total: €<?php echo number_format($order["totalExpense"], 2) ?></strong>
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-muted">
                                <?php echo date('d M Y, H:i', strtotime($order["orderTime"])) ?>
                            </small>
                        </div>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted">
                            <i class="fas fa-box"></i>
                            <?php echo $order["itemCount"] ?> item<?php echo $order["itemCount"] != 1 ? 's' : '' ?>
                        </small>
                    </div>

                    <?php if (!empty($order["notes"])): ?>
                        <div class="mb-2">
                            <small class="text-muted">
                                <strong>Notes:</strong> <?php echo htmlspecialchars($order["notes"]) ?>
                            </small>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-clock"></i> Ordered <?php echo date('j M Y', strtotime($order["orderTime"])) ?>
                        </small>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal<?php echo $order["orderId"] ?>">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderModal<?php echo $order["orderId"] ?>" tabindex="-1" aria-labelledby="orderModalLabel<?php echo $order["orderId"] ?>" aria-hidden="true" data-bs-backdrop="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel<?php echo $order["orderId"] ?>">Order #<?php echo $order["orderId"] ?> Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <strong>Order ID:</strong> #<?php echo $order["orderId"] ?>
                    </div>
                    <div class="col-6">
                        <strong>Status:</strong> <span class="badge bg-primary">Processing</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong>Total Amount:</strong> €<?php echo number_format($order["totalExpense"], 2) ?>
                    </div>
                    <div class="col-6">
                        <strong>Items:</strong> <?php echo $order["itemCount"] ?> item<?php echo $order["itemCount"] != 1 ? 's' : '' ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <strong>Order Date:</strong> <?php echo date('d M Y, H:i', strtotime($order["orderTime"])) ?>
                    </div>
                </div>

                <?php if (!empty($order["notes"])): ?>
                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>Notes:</strong><br>
                            <?php echo htmlspecialchars($order["notes"]) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <hr>
                <p class="text-muted">Detailed item information and tracking will be available soon.</p>
            </div>
        </div>
    </div>
</div>
