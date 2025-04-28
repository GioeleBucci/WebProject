<?php

$templateParams["title"] = "Account";
Utils::requireLoggedUser();

if (isset($_POST["logout"])) {
    Utils::logout();
}

// Fetch user information from the database
$userInfo = $dbh->getUserInfo($_SESSION["userId"]);

?>

<div class="container py-5">
    <div class="text-center mb-4">
        <h2>Your Account</h2>
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
                                <span class="fs-5"><?php echo htmlspecialchars($userInfo["email"] ?? "Not provided"); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex flex-column">
                                <label class="text-muted small">Phone Number</label>
                                <span class="fs-5"><?php echo htmlspecialchars($userInfo["phoneNumber"] ?? "Not provided"); ?></span>
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
                                <span class="fs-5"><?php echo htmlspecialchars($userInfo["address"] ?? "Not provided"); ?></span>
                            </div>
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
