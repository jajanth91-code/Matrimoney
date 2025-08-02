<?php
$page_title = "My Profile - Thirumangalyam Matrimony";
session_start();
include('Database/db-connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user_details WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "User not found.";
    exit();
}

// Check if personal details are filled
if (empty($user['height'])) {
    header('Location: personaldeatiles.php');
    exit();
}
?>

<?php include('includes/header.php'); ?>

<!-- Display Messages -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div style="background-color: #f8f9fa; min-height: 100vh; padding: 20px 0;">

    <div class="container">
        <div class="row">
            <!-- Main Profile Card -->
            <div class="col-lg-8">
                <!-- Profile Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-user"></i> My Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Profile Image -->
                            <div class="col-md-4 text-center">
                                <?php
                                $image_path = 'images/default-profile.png';
                                if (!empty($user['user_image'])) {
                                    if (strpos($user['user_image'], 'uploads/') === false) {
                                        $image_path = 'uploads/' . $user['user_image'];
                                    } else {
                                        $image_path = $user['user_image'];
                                    }
                                    if (!file_exists($image_path)) {
                                        $image_path = 'images/default-profile.png';
                                    }
                                }
                                ?>
                                <img src="<?php echo $image_path; ?>" alt="Profile Picture" class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover; border: 4px solid #e9ecef;">
                                <h4 class="text-primary"><?php echo htmlspecialchars($user['name']); ?></h4>
                                <p class="text-muted">ID: <?php echo $user['id']; ?></p>
                            </div>
                            
                            <!-- Basic Information -->
                            <div class="col-md-8">
                                <h5 class="text-primary mb-3">Basic Information</h5>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Information -->
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Detailed Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">Physical Details</h6>
                                <table class="table table-borderless">
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
                                <table class="table table-borderless">
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
                                <table class="table table-borderless">
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
                                <table class="table table-borderless">
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
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-cogs"></i> Profile Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="edit-profile.php" class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit Information
                            </a>
                            <a href="change-profile-picture.php" class="btn btn-outline-success">
                                <i class="fas fa-camera"></i> Change Profile Picture
                            </a>
                            <a href="search.php" class="btn btn-outline-info">
                                <i class="fas fa-search"></i> Find Matches
                            </a>
                            <a href="profiles.php" class="btn btn-outline-warning">
                                <i class="fas fa-users"></i> Browse Profiles
                            </a>
                            <hr>
                            <a href="logout.php" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to logout?')">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Profile Completion -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-chart-pie"></i> Profile Completion</h6>
                    </div>
                    <div class="card-body">
                        <?php
                        $fields = ['name', 'email', 'phone_number', 'height', 'nakshatra', 'raasi', 'job', 'qualification', 'user_image'];
                        $completed = 0;
                        foreach ($fields as $field) {
                            if (!empty($user[$field])) $completed++;
                        }
                        $percentage = round(($completed / count($fields)) * 100);
                        ?>
                        <div class="progress mb-2">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $percentage; ?>%" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="mb-0"><?php echo $percentage; ?>% Complete</p>
                        <?php if ($percentage < 100): ?>
                        <small class="text-muted">Complete your profile to get better matches!</small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
