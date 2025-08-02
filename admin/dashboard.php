<?php
$page_title = "Dashboard - Admin Panel";
session_start();
include('../Database/db-connect.php');
include('includes/admin-header.php');

// Fetch user details from the database
$query = "SELECT COUNT(*) as total_users FROM user_details WHERE is_active = 1";
$result = mysqli_query($conn, $query);
$total_users = mysqli_fetch_assoc($result)['total_users'];

// Fetch contact messages count
$contact_query = "SELECT COUNT(*) as total_messages FROM contact_messages";
$contact_result = mysqli_query($conn, $contact_query);
$total_messages = mysqli_fetch_assoc($contact_result)['total_messages'];

// Fetch interests count
$interests_query = "SELECT COUNT(*) as total_interests FROM user_interests";
$interests_result = mysqli_query($conn, $interests_query);
$total_interests = mysqli_fetch_assoc($interests_result)['total_interests'];

// Fetch recent users
$recent_users_query = "SELECT id, name, email, created_at FROM user_details WHERE is_active = 1 ORDER BY created_at DESC LIMIT 5";
$recent_users_result = mysqli_query($conn, $recent_users_query);
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

<!-- Dashboard Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo number_format($total_users); ?></h4>
                        <p class="mb-0">Total Users</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo number_format($total_interests); ?></h4>
                        <p class="mb-0">Total Interests</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-heart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo number_format($total_messages); ?></h4>
                        <p class="mb-0">Contact Messages</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-envelope fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo date('d'); ?></h4>
                        <p class="mb-0">Today's Date</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Users -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-users"></i> Recent Users</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Joined Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($user = mysqli_fetch_assoc($recent_users_result)): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <a href="view-user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <a href="manage-users.php" class="btn btn-primary">View All Users</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="manage-users.php" class="btn btn-outline-primary">
                        <i class="fas fa-users"></i> Manage Users
                    </a>
                    <a href="user-interests.php" class="btn btn-outline-success">
                        <i class="fas fa-heart"></i> View Interests
                    </a>
                    <a href="contact-messages.php" class="btn btn-outline-info">
                        <i class="fas fa-envelope"></i> Contact Messages
                    </a>
                    <a href="reports.php" class="btn btn-outline-warning">
                        <i class="fas fa-chart-bar"></i> Generate Reports
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> System Info</h5>
            </div>
            <div class="card-body">
                <p><strong>Server Time:</strong><br><?php echo date('Y-m-d H:i:s'); ?></p>
                <p><strong>Admin:</strong><br><?php echo $_SESSION['admin_username']; ?></p>
                <p><strong>Last Login:</strong><br><?php echo date('Y-m-d H:i:s'); ?></p>
            </div>
        </div>
<?php include('includes/admin-footer.php'); ?>
