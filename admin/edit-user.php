<?php
$page_title = "Edit User - Admin Panel";
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
    $result = mysqli_stmt_get_result($stmt);

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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $age = (int)$_POST['age'];
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $height = mysqli_real_escape_string($conn, $_POST['height']);
    $marital_status = mysqli_real_escape_string($conn, $_POST['marital_status']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $job = mysqli_real_escape_string($conn, $_POST['job']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $update_query = "UPDATE user_details SET 
                     name = ?, email = ?, phone_number = ?, age = ?, gender = ?, 
                     district = ?, height = ?, marital_status = ?, qualification = ?, 
                     job = ?, is_active = ?
                     WHERE id = ?";
    
    $update_stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($update_stmt, "sssissssssii", 
        $name, $email, $phone_number, $age, $gender, $district, 
        $height, $marital_status, $qualification, $job, $is_active, $user_id);

    if (mysqli_stmt_execute($update_stmt)) {
        $_SESSION['message'] = "User updated successfully!";
        header('Location: view-user.php?id=' . $user_id);
        exit();
    } else {
        $_SESSION['error'] = "Failed to update user.";
    }
}
?>

<!-- Display Messages -->
<?php
if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger alert-dismissible fade show'>{$_SESSION['error']}<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
    unset($_SESSION['error']);
}
?>

<!-- Edit User Form -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-edit"></i> Edit User: <?php echo htmlspecialchars($user['name']); ?>
                    <span class="badge bg-secondary ms-2">ID: <?php echo $user['id']; ?></span>
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                <div class="invalid-feedback">Please provide a valid name.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                <div class="invalid-feedback">Please provide a valid email address.</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number *</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
                                <div class="invalid-feedback">Please provide a valid phone number.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="age" class="form-label">Age *</label>
                                <input type="number" class="form-control" id="age" name="age" value="<?php echo $user['age']; ?>" min="18" max="80" required>
                                <div class="invalid-feedback">Please provide a valid age (18-80).</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender *</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male" <?php echo $user['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                                    <option value="female" <?php echo $user['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                                    <option value="other" <?php echo $user['gender'] == 'other' ? 'selected' : ''; ?>>Other</option>
                                </select>
                                <div class="invalid-feedback">Please select a gender.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="marital_status" class="form-label">Marital Status *</label>
                                <select class="form-select" id="marital_status" name="marital_status" required>
                                    <option value="">Select Status</option>
                                    <option value="Single" <?php echo $user['marital_status'] == 'Single' ? 'selected' : ''; ?>>Single</option>
                                    <option value="Divorced" <?php echo $user['marital_status'] == 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
                                    <option value="Widowed" <?php echo $user['marital_status'] == 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
                                </select>
                                <div class="invalid-feedback">Please select marital status.</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="height" class="form-label">Height</label>
                                <input type="text" class="form-control" id="height" name="height" value="<?php echo htmlspecialchars($user['height']); ?>" placeholder="e.g., 5'6\" or 168 cm">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="district" class="form-label">District</label>
                                <input type="text" class="form-control" id="district" name="district" value="<?php echo htmlspecialchars($user['district']); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="qualification" class="form-label">Qualification</label>
                                <input type="text" class="form-control" id="qualification" name="qualification" value="<?php echo htmlspecialchars($user['qualification']); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="job" class="form-label">Job/Profession</label>
                                <input type="text" class="form-control" id="job" name="job" value="<?php echo htmlspecialchars($user['job']); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" <?php echo $user['is_active'] ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="is_active">
                                Account is Active
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update User
                        </button>
                        <a href="view-user.php?id=<?php echo $user['id']; ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> User Information</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
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
                    <img src="<?php echo $image_path; ?>" alt="Profile" class="rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
                
                <table class="table table-borderless table-sm">
                    <tr>
                        <td><strong>User ID:</strong></td>
                        <td><?php echo $user['id']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Username:</strong></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Joined:</strong></td>
                        <td><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Last Updated:</strong></td>
                        <td><?php echo date('d M Y', strtotime($user['updated_at'])); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            <span class="badge bg-<?php echo $user['is_active'] ? 'success' : 'danger'; ?>">
                                <?php echo $user['is_active'] ? 'Active' : 'Inactive'; ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-tools"></i> Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="view-user.php?id=<?php echo $user['id']; ?>" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> View Profile
                    </a>
                    <a href="delete-user.php?id=<?php echo $user['id']; ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirmDelete('Are you sure you want to delete this user?');">
                        <i class="fas fa-trash"></i> Delete User
                    </a>
                    <hr>
                    <a href="manage-users.php" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Users
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/admin-footer.php'); ?>