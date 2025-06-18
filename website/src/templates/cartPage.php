<?php require "utils/loadCart.php" ?>

<?php $templateParams["title"] = "Cart" ?>

<div class="container">
    <div class="text-center">
        <span class="page-title-text">Your Cart</span>
    </div>

    <div class="row g-5">
        <div class="col-md-<?php echo $isCartEmpty ? "12" : "8" ?>">
            <?php if (!$isCartEmpty): ?>
                <?php foreach ($cartItems as $article): ?>
                    <?php require("components/cartItem.php") ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="lead mt-4">Nothing here! Come back once you added something to your cart.</p>
            <?php endif; ?>
        </div>

        <?php if (!$isCartEmpty) : ?>
            <div class="col-md-4 mt-2 mt-md-5">
                <div class="p-3" id="cart-summary">
                    <h3 class="mb-4">Order Summary</h3>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span id="cart-subtotal">€<?php echo $subtotal ?></span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span>€10</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total</strong>
                        <strong id="cart-total">€<?php echo ($subtotal + 10) ?></strong>
                    </div>

                    <a href=<?php echo Links::CHECKOUT ?> class="btn btn-success w-100">Proceed to Checkout</a>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>

<?php if (!$isCartEmpty) : ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInputs = document.querySelectorAll('.quantity-input');

            // Timeout to prevent multiple rapid requests
            let updateTimeout;

            // Add event listeners to all quantity inputs
            quantityInputs.forEach(input => {
                input.addEventListener('change', handleQuantityChange);
                input.addEventListener('input', handleQuantityChange);
            });

            function handleQuantityChange(e) {
                const input = e.target;
                const quantity = parseInt(input.value, 10);
                const articleId = input.dataset.articleId;
                const versionId = input.dataset.versionId;

                // Validate quantity
                if (quantity < 1) {
                    input.value = 1;
                    return;
                }

                // Get the price element
                const priceElement = input.closest('.row').querySelector('.item-price');
                const unitPrice = parseFloat(priceElement.dataset.unitPrice);

                // Update price immediately in UI
                priceElement.textContent = '€' + (unitPrice * quantity).toFixed(2);

                // Clear any pending updates
                clearTimeout(updateTimeout);

                // Schedule update to database
                updateTimeout = setTimeout(() => {
                    updateCartItemQuantity(articleId, versionId, quantity);
                }, 500);
            }

            function updateCartItemQuantity(articleId, versionId, quantity) {
                // Create form data
                const formData = new FormData();
                formData.append('articleId', articleId);
                formData.append('versionId', versionId);
                formData.append('quantity', quantity);
                formData.append('getTotal', 'true');

                // Show loading indicator
                // You could add a loading spinner here if desired

                // Send AJAX request
                fetch('/WebProject/website/src/utils/updateCartQuantity.php', {
                        method: 'POST',
                        body: formData,
                        credentials: 'include'
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Update the subtotal and total in the summary
                            if (data.subtotal !== null) {
                                document.getElementById('cart-subtotal').textContent = '€' + data.subtotal.toFixed(2);
                                document.getElementById('cart-total').textContent = '€' + data.total.toFixed(2);
                            }
                        } else {
                            console.error('Failed to update cart:', data.message || 'Unknown error');
                            alert('Could not update cart. Please try again later.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Could not update cart: ' + error.message);
                    });
            }
        });
    </script>
<?php endif ?>
