<div class="notification-card">
    <div class="card h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1 me-3">
                    <p class="card-text mb-1"><?php echo $notification["content"] ?></p>
                    <small class="text-muted"><?php echo date('d-m-Y H:i', strtotime($notification["receptionTime"])) ?></small>
                </div>
                <div class="flex-shrink-0">
                    <form method="POST" class="d-inline">
                        <button type="submit" name="remnot" value="<?php echo $notification["notificationId"] ?>"
                            class="btn btn-outline-danger btn-sm"
                            aria-label="Delete notification">
                            <span class="bi bi-trash" aria-hidden="true"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
