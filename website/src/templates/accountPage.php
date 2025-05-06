<?php require "utils/loadAccount.php" ?>

<?php $templateParams["title"] = "Account" ?>

<div class="container py-5">
    <div class="text-center mb-4">
        <h2>Your Account</h2>
        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success mt-3" role="alert">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="card-title mb-4">Personal Information</h3>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex flex-column">
                                <label class="text-muted small">Name</label>
                                <span class="fs-5"><?php echo htmlspecialchars($userInfo["name"] ?? "Not provided"); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex flex-column">
                                <label class="text-muted small">Email</label>
                                <div class="d-flex align-items-center">
                                    <span class="fs-5"><?php echo htmlspecialchars($userInfo["email"] ?? "Not provided"); ?></span>
                                    <button type="button" class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#emailModal">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex flex-column">
                                <label class="text-muted small">Phone Number</label>
                                <div class="d-flex align-items-center">
                                    <span class="fs-5"><?php echo htmlspecialchars($userInfo["phoneNumber"] ?? "Not provided"); ?></span>
                                    <button type="button" class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#phoneModal">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex flex-column">
                                <label class="text-muted small">Birth Date</label>
                                <span class="fs-5"><?php echo $userInfo["birthDate"] ? date("F j, Y", strtotime($userInfo["birthDate"])) : "Not provided"; ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-12 mb-3">
                            <div class="d-flex flex-column">
                                <label class="text-muted small">Address</label>
                                <div class="d-flex align-items-center">
                                    <span class="fs-5"><?php echo htmlspecialchars($userInfo["address"] ?? "Not provided"); ?></span>
                                    <button type="button" class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#addressModal">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#passwordModal">
                                <i class="bi bi-key"></i> Change Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 text-center">
                <form method="post">
                    <input type="hidden" id="logout" name="logout" value="logout">
                    <button type="submit" class="btn btn-secondary w-10">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
