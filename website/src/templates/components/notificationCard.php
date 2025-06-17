<!-- <div class="card-wrapper">
    <div class="card h-100">
        <div class="card-top" style="transform: rotate(0);">
            <div class="card-body">
                <h6 class="card-text mb-0 product-name"><?php echo $notification["receptionTime"] ?></h6>
                <p class="card-text mb-0 text-truncate"><?php echo $notification["content"] ?></p>
            </div>
        </div>
    </div>
</div> -->
<tr>
    <td style="width:80%"><?php echo $notification["content"] ?></td>
    <td style="text-align:right"><?php echo $notification["receptionTime"] ?></td>
    <td style="text-align:right">
        <form method="POST">
            <button type="submit" name="remnot" value=<?php echo $notification["notificationId"] ?>>Delete</button>
        </form>
    </td>
</tr>