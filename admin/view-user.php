<?php
$page_title = "View User Details - Admin Panel";
session_start();
include('../Database/db-connect.php');
include('includes/admin-header.php');

// Get user ID from the URL
if (isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];

    // Fetch user details
    $query = "SELECT * FROM user_details WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_query($conn, $query);

    // Check if user exists
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['error'] = "User not found.";
        header('Location: manage-users.php');
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header('Location: manage-users.php');
    exit();
}
?>

<!-- User Details -->
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-user"></i> User Profile Details
                    <span class="badge bg-light text-dark ms-2">ID: <?php echo $user['id']; ?></span>
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Profile Image -->
                    <div class="col-md-4 text-center">
                        <?php
                        $image_path = '../images/default-profile.png';
                        if (!empty($user['user_image'])) {
                            if (strpos($user['user_image'], 'uploads/') === false) {
                                $image_path = '../uploads/' . $user['user_image'];
                            } else {
                                $image_path = '../' . $user['user_image'];
                            }
                            if (!file_exists($image_path)) {
                                $image_path = '../images/default-profile.png';
                            }
                        }
                        ?>
                        <img src="<?php echo $image_path; ?>" alt="Profile Picture" class="img-fluid rounded mb-3" style="max-width: 200px; max-height: 250px; object-fit: cover;">
                        <h4 class="text-primary"><?php echo htmlspecialchars($user['name']); ?></h4>
                        <p class="text-muted">Member since: <?php echo date("d M Y", strtotime($user['created_at'])); ?></p>
                    </div>
                    
                    <!-- Basic Information -->
                    <div class="col-md-8">
                        <h6 class="text-primary mb-3">Basic Information</h6>
                        <div class="row">
                            <div class="col-sm-6 mb-2">
                                <strong>Email:</strong><br>
                                <span class="text-muted"><?php echo htmlspecialchars($user['email']); ?></span>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <strong>Phone:</strong><br>
                                <span class="text-muted"><?php echo htmlspecialchars($user['phone_number']); ?></span>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <strong>Username:</strong><br>
                                <span class="text-muted"><?php echo htmlspecialchars($user['username']); ?></span>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <strong>Date of Birth:</strong><br>
                                <span class="text-muted"><?php echo date("d M Y", strtotime($user['dob'])); ?></span>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <strong>Age:</strong><br>
                                <span class="text-muted"><?php echo $user['age']; ?> years</span>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <strong>Gender:</strong><br>
                                <span class="text-muted"><?php echo ucfirst($user['gender']); ?></span>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <strong>Marital Status:</strong><br>
                                <span class="text-muted"><?php echo htmlspecialchars($user['marital_status']); ?></span>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <strong>District:</strong><br>
                                <span class="text-muted"><?php echo htmlspecialchars($user['district']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Detailed Information -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Detailed Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Physical Details</h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td><strong>Height:</strong></td>
                                <td><?php echo htmlspecialchars($user['height']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Complexion:</strong></td>
                                <td><?php echo htmlspecialchars($user['complexion']); ?></td>
                            </tr>
                        </table>
                        
                        <h6 class="text-primary mt-4">Location Details</h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td><strong>Resident:</strong></td>
                                <td><?php echo htmlspecialchars($user['resident']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Native Place:</strong></td>
                                <td><?php echo htmlspecialchars($user['native_place']); ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h6 class="text-primary">Astrological Details</h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td><strong>Nakshatra:</strong></td>
                                <td><?php echo htmlspecialchars($user['nakshatra']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Raasi:</strong></td>
                                <td><?php echo htmlspecialchars($user['raasi']); ?></td>
                            </tr>
                        </table>
                        
                        <h6 class="text-primary mt-4">Professional Details</h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td><strong>Qualification:</strong></td>
                                <td><?php echo htmlspecialchars($user['qualification']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Job:</strong></td>
                                <td><?php echo htmlspecialchars($user['job']); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-tools"></i> Admin Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="edit-user.php?id=<?php echo $user['id']; ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit User
                    </a>
                    <a href="delete-user.php?id=<?php echo $user['id']; ?>" 
                       class="btn btn-danger" 
                       onclick="return confirmDelete('Are you sure you want to delete this user? This action cannot be undone.');">
                        <i class="fas fa-trash"></i> Delete User
                    </a>
                    <hr>
                    <a href="manage-users.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Users
                    </a>
                    <a href="dashboard.php" class="btn btn-outline-primary">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Account Status -->
        <div class="card shadow-sm mt-3">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0"><i class="fas fa-user-check"></i> Account Status</h6>
            </div>
            <div class="card-body">
                <p><strong>Status:</strong> 
                    <span class="badge bg-<?php echo $user['is_active'] ? 'success' : 'danger'; ?>">
                        <?php echo $user['is_active'] ? 'Active' : 'Inactive'; ?>
                    </span>
                </p>
                <p><strong>Created:</strong><br><?php echo date("d M Y H:i", strtotime($user['created_at'])); ?></p>
                <p><strong>Last Updated:</strong><br><?php echo date("d M Y H:i", strtotime($user['updated_at'])); ?></p>
            </div>
        </div>
    </div>
</div>

<?php include('includes/admin-footer.php'); ?>