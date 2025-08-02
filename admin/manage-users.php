<?php
$page_title = "Manage Users - Admin Panel";
session_start();
include('../Database/db-connect.php');
include('includes/admin-header.php');

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$search_condition = '';
if ($search) {
    $search_condition = "AND (name LIKE '%$search%' OR email LIKE '%$search%' OR phone_number LIKE '%$search%')";
}

// Get total count
$count_query = "SELECT COUNT(*) as total FROM user_details WHERE is_active = 1 $search_condition";
$count_result = mysqli_query($conn, $count_query);
$total_users = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_users / $limit);

// Fetch users
$query = "SELECT * FROM user_details WHERE is_active = 1 $search_condition ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);
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

<!-- Search and Actions -->
<div class="row mb-4">
    <div class="col-md-6">
        <form method="GET" class="d-flex">
            <input type="text" class="form-control me-2" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search users...">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Search
            </button>
        </form>
    </div>
    <div class="col-md-6 text-end">
        <a href="?search=" class="btn btn-secondary">
            <i class="fas fa-refresh"></i> Clear Search
        </a>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-users"></i> All Users 
            <span class="badge bg-primary"><?php echo number_format($total_users); ?></span>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Age/Gender</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td>
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
                            <img src="<?php echo $image_path; ?>" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                        </td>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['phone_number']); ?></td>
                        <td>
                            <?php echo $user['age']; ?> / <?php echo ucfirst($user['gender']); ?>
                        </td>
                        <td><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="view-user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-info" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="edit-user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-warning" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete-user.php?id=<?php echo $user['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   title="Delete User"
                                   onclick="return confirmDelete('Are you sure you want to delete this user? This action cannot be undone.');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <nav aria-label="Users pagination">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                </li>
                <?php endif; ?>

                <?php
                $start = max(1, $page - 2);
                $end = min($total_pages, $page + 2);
                
                for ($i = $start; $i <= $end; $i++):
                ?>
                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">Next</a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>

<?php include('includes/admin-footer.php'); ?>