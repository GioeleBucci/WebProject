<?php Utils::requireLoggedUser() ?>

<?php $templateParams["title"] = "Cart" ?>

<div class="container mt-md-2">
    <div class="text-center">
        <h2>Your Cart</h2>
    </div>

    <div class="row g-5">
        <div class="col-md-8">
            <!-- TODO this is just for display purposes and shall be removed, we'll use a PHP foreach cycle to avoid duplicating code -->
            <div class="row align-items-center border-bottom py-3">
                <div class="col-3 col-md-2">
                    <img
                        src="<?php echo Settings::UPLOAD_DIR . "sofa.png" ?>"
                        alt="ARTICLE NAME"
                        class="img-fluid" />
                </div>
                <div class="col-9 col-md-5">
                    <h5 class="mb-1">ARTICLE NAME</h5>
                    <small class="text-muted">Article description</small>
                </div>
                <div class="col-6 col-md-2 text-end mt-2 mt-md-0">
                    <strong>€49.99</strong>
                </div>
                <div class="col-3 col-md-2 text-end mt-2 mt-md-0">
                    <input
                        type="number"
                        class="form-control"
                        value="1"
                        min="1"
                        style="max-width: 80px; margin: 0 auto;" />
                </div>
                <div class="col-3 col-md-1 text-end mt-2 mt-md-0">
                    <button class="btn btn-link text-danger p-0" title="Remove item">
                        <i class="bi bi-x fs-5 mx-2"></i>
                    </button>
                </div>
            </div>

            <div class="row align-items-center border-bottom py-3">
                <div class="col-3 col-md-2">
                    <img
                        src="<?php echo Settings::UPLOAD_DIR . "sofa.png" ?>"
                        alt="ARTICLE NAME"
                        class="img-fluid" />
                </div>
                <div class="col-9 col-md-5">
                    <h5 class="mb-1">ARTICLE NAME</h5>
                    <small class="text-muted">Article description</small>
                </div>
                <div class="col-6 col-md-2 text-end mt-2 mt-md-0">
                    <strong>€49.99</strong>
                </div>
                <div class="col-3 col-md-2 text-end mt-2 mt-md-0">
                    <input
                        type="number"
                        class="form-control"
                        value="1"
                        min="1"
                        style="max-width: 80px; margin: 0 auto;" />
                </div>
                <div class="col-3 col-md-1 text-end mt-2 mt-md-0">
                    <button class="btn btn-link text-danger p-0" title="Remove item">
                        <i class="bi bi-x fs-5 mx-2"></i>
                    </button>
                </div>
            </div>

            <div class="row align-items-center border-bottom py-3">
                <div class="col-3 col-md-2">
                    <img
                        src="<?php echo Settings::UPLOAD_DIR . "sofa.png" ?>"
                        alt="ARTICLE NAME"
                        class="img-fluid" />
                </div>
                <div class="col-9 col-md-5">
                    <h5 class="mb-1">ARTICLE NAME</h5>
                    <small class="text-muted">Article description</small>
                </div>
                <div class="col-6 col-md-2 text-end mt-2 mt-md-0">
                    <strong>€49.99</strong>
                </div>
                <div class="col-3 col-md-2 text-end mt-2 mt-md-0">
                    <input
                        type="number"
                        class="form-control"
                        value="1"
                        min="1"
                        style="max-width: 80px; margin: 0 auto;" />
                </div>
                <div class="col-3 col-md-1 text-end mt-2 mt-md-0">
                    <button class="btn btn-link text-danger p-0" title="Remove item">
                        <i class="bi bi-x fs-5 mx-2"></i>
                    </button>
                </div>
            </div>

        </div>

        <div class="col-md-4 mt-2 mt-md-5">
            <div class="p-3">
                <h4 class="mb-4">Order Summary</h4>

                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>€149.97</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping</span>
                    <span>€10</span>
                </div>

                <hr />

                <div class="d-flex justify-content-between mb-3">
                    <strong>Total</strong>
                    <strong>€159.97</strong>
                </div>

                <button class="btn btn-success w-100">Proceed to Checkout</button>
            </div>
        </div>
    </div>
</div>