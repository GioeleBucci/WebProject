<div class="card-wrapper mb-4">
    <div class="order-card">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1 me-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="card-title mb-0">Order #<?php echo $order["orderId"] ?></h6>
                            <span class="badge <?php echo $order["delivered"] ? 'bg-success' : 'bg-primary' ?>">
                                <?php echo $order["delivered"] ? 'Delivered' : 'Processing' ?>
                            </span>
                        </div>

                        <div class="row mb-2">
                            <div class="col-6">
                                <strong>Total: €<?php echo number_format($order["totalExpense"], 2) ?></strong>
                            </div>
                            <div class="col-6 text-end">
                                <small class="text-muted">
                                    Ordered <?php echo date('j M Y, H:i', strtotime($order["orderTime"])) ?>
                                </small>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2 w-80" data-bs-toggle="modal" data-bs-target="#orderModal<?php echo $order["orderId"] ?>">
                                View Details
                            </button>
                        </div>
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
                        <strong>Status:</strong> <span class="badge <?php echo $order["delivered"] ? 'bg-success' : 'bg-primary' ?>">
                            <?php echo $order["delivered"] ? 'Delivered' : 'Processing' ?>
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong>Total Amount:</strong> €<?php echo number_format($order["totalExpense"], 2) ?>
                    </div>
                    <div class="col-6">
                        <strong>Total Items:</strong> <?php echo $order["itemCount"] ?>
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

                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th id="article-name">Article Name</th>
                            <th id="quantity" class="text-center">Quantity</th>
                            <th id="total" class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order["items"] as $item): ?>
                            <tr>
                                <td headers="article-name">
                                    <strong><?php echo htmlspecialchars($item["articleName"]) ?></strong><br>
                                    <small class="text-muted"><?php echo htmlspecialchars($item["versionType"]) ?></small>
                                </td>
                                <td headers="quantity" class="text-center">
                                    <?php echo $item["amount"] ?>
                                </td>
                                <td headers="total" class="text-end">
                                    €<?php echo number_format($item["price"] * $item["amount"], 2) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
