<?php $templateParams["title"] = "Login" ?>

<?php require 'utils/login.php' ?>


<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Login</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <?php if (isset($templateParams["loginError"])): ?>
                            <div class="alert alert-warning show mb-1 mt-0" role="alert">
                                <?php echo $templateParams["loginError"]; ?>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <small>Don't have an account? <a href=<?php echo Links::REGISTER ?>>Register here</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
