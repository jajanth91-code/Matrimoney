<?php
$page_title = "Settings - Admin Panel";
session_start();
include('../Database/db-connect.php');
include('includes/admin-header.php');

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Verify current password
        $admin_id = $_SESSION['admin_id'];
        $query = "SELECT password FROM admin WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $admin_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $admin = mysqli_fetch_assoc($result);
        
        if ($admin && $current_password === $admin['password']) { // Note: Should use password_verify in production
            if ($new_password === $confirm_password) {
                if (strlen($new_password) >= 6) {
                    // Update password (should be hashed in production)
                    $update_query = "UPDATE admin SET password = ? WHERE id = ?";
                    $update_stmt = mysqli_prepare($conn, $update_query);
                    mysqli_stmt_bind_param($update_stmt, "si", $new_password, $admin_id);
                    
                    if (mysqli_stmt_execute($update_stmt)) {
                        $_SESSION['message'] = "Password changed successfully!";
                    } else {
                        $_SESSION['error'] = "Failed to update password.";
                    }
                } else {
                    $_SESSION['error'] = "Password must be at least 6 characters long.";
                }
            } else {
                $_SESSION['error'] = "New passwords do not match.";
            }
        } else {
            $_SESSION['error'] = "Current password is incorrect.";
        }
        
        header('Location: settings.php');
        exit;
    }
    
    if (isset($_POST['update_profile'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $admin_id = $_SESSION['admin_id'];
        
        $update_query = "UPDATE admin SET email = ? WHERE id = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($update_stmt, "si", $email, $admin_id);
        
        if (mysqli_stmt_execute($update_stmt)) {
            $_SESSION['admin_email'] = $email;
            $_SESSION['message'] = "Profile updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update profile.";
        }
        
        header('Location: settings.php');
        exit;
    }
}

// Get current admin details
$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM admin WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $admin_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($result);
?>

<!-- Display Messages -->
<?php
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-success alert-dismissible fade show'>{$_SESSION['message']}<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
    unset($_SESSION['message']);
}

if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger alert-dismissible fade show'>{$_SESSION['error']}<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
    unset($_SESSION['error']);
}
?>

<div class="row">
    <!-- Profile Settings -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-cog"></i> Profile Settings</h5>
            </div>
            <div class="card-body">
                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($admin['user_name']); ?>" readonly>
                        <div class="form-text">Username cannot be changed.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                        <div class="invalid-feedback">Please provide a valid email address.</div>
                    </div>
                    
                    <button type="submit" name="update_profile" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Profile
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Change Password -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-lock"></i> Change Password</h5>
            </div>
            <div class="card-body">
                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        <div class="invalid-feedback">Please enter your current password.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" minlength="6" required>
                        <div class="invalid-feedback">Password must be at least 6 characters long.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="6" required>
                        <div class="invalid-feedback">Please confirm your new password.</div>
                    </div>
                    
                    <button type="submit" name="change_password" class="btn btn-warning">
                        <i class="fas fa-key"></i> Change Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- System Information -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> System Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>PHP Version:</strong></td>
                                <td><?php echo phpversion(); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Server Software:</strong></td>
                                <td><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></td>
                            </tr>
                            <tr>
                                <td><strong>MySQL Version:</strong></td>
                                <td><?php echo mysqli_get_server_info($conn); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Server Time:</strong></td>
                                <td><?php echo date('Y-m-d H:i:s'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Admin Login:</strong></td>
                                <td><?php echo $_SESSION['admin_username']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Session ID:</strong></td>
                                <td><?php echo substr(session_id(), 0, 10) . '...'; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Database Maintenance -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-database"></i> Database Maintenance</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Warning:</strong> Database maintenance operations should be performed with caution. 
                    Always backup your database before performing any maintenance tasks.
                </div>
                
                <div class="d-grid gap-2 d-md-flex">
                    <button class="btn btn-info" onclick="alert('Database backup functionality would be implemented here.')">
                        <i class="fas fa-download"></i> Backup Database
                    </button>
                    <button class="btn btn-warning" onclick="alert('Database optimization functionality would be implemented here.')">
                        <i class="fas fa-tools"></i> Optimize Tables
                    </button>
                    <button class="btn btn-danger" onclick="if(confirm('Are you sure you want to clear old logs? This cannot be undone.')) alert('Log cleanup functionality would be implemented here.')">
                        <i class="fas fa-trash"></i> Clear Old Logs
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Password confirmation validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = this.value;
    
    if (newPassword !== confirmPassword) {
        this.setCustomValidity('Passwords do not match');
    } else {
        this.setCustomValidity('');
    }
});
</script>

<?php include('includes/admin-footer.php'); ?>