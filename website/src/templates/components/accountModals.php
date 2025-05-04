<!-- Email Edit Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalLabel">Update Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new_email" class="form-label">New Email Address</label>
                        <input type="email" class="form-control" id="new_email" name="new_email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="update_email" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Password Edit Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="passwordForm" onsubmit="return validatePasswordForm()">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="invalid-feedback d-none" id="password-error">
                        Passwords do not match or are too short (minimum 6 characters).
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="update_password" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Phone Edit Modal -->
<div class="modal fade" id="phoneModal" tabindex="-1" aria-labelledby="phoneModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="phoneModalLabel">Update Phone Number</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new_phone" class="form-label">New Phone Number</label>
                        <input type="tel" class="form-control" id="new_phone" name="new_phone" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="update_phone" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Address Edit Modal -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Update Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new_address" class="form-label">New Address</label>
                        <textarea class="form-control" id="new_address" name="new_address" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="update_address" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Password validation function
    function validatePasswordForm() {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const errorElement = document.getElementById('password-error');

        if (newPassword !== confirmPassword || newPassword.length < 6) {
            errorElement.classList.remove('d-none');
            errorElement.classList.add('d-block');
            return false; // Prevent form submission
        }

        errorElement.classList.add('d-none');
        errorElement.classList.remove('d-block');
        return true; 
    }

    document.addEventListener('DOMContentLoaded', function() {
        const passwordModal = document.getElementById('passwordModal');
        const newPasswordField = document.getElementById('new_password');
        const confirmPasswordField = document.getElementById('confirm_password');
        const errorElement = document.getElementById('password-error');

        // Clear validation errors when modal is opened
        passwordModal.addEventListener('show.bs.modal', function() {
            newPasswordField.value = '';
            confirmPasswordField.value = '';
            errorElement.classList.add('d-none');
            errorElement.classList.remove('d-block');
        });

        // Validate on input changes
        function validatePasswords() {
            if (newPasswordField.value && confirmPasswordField.value) {
                if (newPasswordField.value !== confirmPasswordField.value || newPasswordField.value.length < 6) {
                    errorElement.classList.remove('d-none');
                    errorElement.classList.add('d-block');
                } else {
                    errorElement.classList.add('d-none');
                    errorElement.classList.remove('d-block');
                }
            }
        }

        newPasswordField.addEventListener('input', validatePasswords);
        confirmPasswordField.addEventListener('input', validatePasswords);
    });
</script>
