<div class="notification-card">
    <div class="card h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1 me-3">
                    <p class="card-text mb-1"><?php echo $order["notes"] ?></p>
                    <p class="card-text mb-1"><?php echo $order["totalExpense"] ?></p>
                    <small class="text-muted"><?php echo date('d-m-Y H:i', strtotime($notification["receptionTime"])) ?></small>
                </div>
            </div>
        </div>
    </div>
</div>
