<?php
$page_title = "User Interests - Admin Panel";
session_start();
include('../Database/db-connect.php');
include('includes/admin-header.php');

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 15;
$offset = ($page - 1) * $limit;

// Filter by status
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$status_condition = '';
if ($status_filter && in_array($status_filter, ['pending', 'accepted', 'rejected'])) {
    $status_condition = "AND ui.status = '$status_filter'";
}

// Get total count
$count_query = "SELECT COUNT(*) as total FROM user_interests ui WHERE 1=1 $status_condition";
$count_result = mysqli_query($conn, $count_query);
$total_interests = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_interests / $limit);

// Fetch interests with user details
$query = "SELECT ui.*, 
          sender.name as sender_name, sender.email as sender_email,
          receiver.name as receiver_name, receiver.email as receiver_email
          FROM user_interests ui
          LEFT JOIN user_details sender ON ui.sender_id = sender.id
          LEFT JOIN user_details receiver ON ui.receiver_id = receiver.id
          WHERE 1=1 $status_condition
          ORDER BY ui.created_at DESC 
          LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Get status counts
$status_counts = [];
$status_query = "SELECT status, COUNT(*) as count FROM user_interests GROUP BY status";
$status_result = mysqli_query($conn, $status_query);
while ($row = mysqli_fetch_assoc($status_result)) {
    $status_counts[$row['status']] = $row['count'];
}
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

<!-- Status Filter -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Filter by Status:</h6>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="?" class="btn btn-outline-primary <?php echo !$status_filter ? 'active' : ''; ?>">
                            All (<?php echo array_sum($status_counts); ?>)
                        </a>
                        <a href="?status=pending" class="btn btn-outline-warning <?php echo $status_filter == 'pending' ? 'active' : ''; ?>">
                            Pending (<?php echo $status_counts['pending'] ?? 0; ?>)
                        </a>
                        <a href="?status=accepted" class="btn btn-outline-success <?php echo $status_filter == 'accepted' ? 'active' : ''; ?>">
                            Accepted (<?php echo $status_counts['accepted'] ?? 0; ?>)
                        </a>
                        <a href="?status=rejected" class="btn btn-outline-danger <?php echo $status_filter == 'rejected' ? 'active' : ''; ?>">
                            Rejected (<?php echo $status_counts['rejected'] ?? 0; ?>)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Interests Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-heart"></i> User Interests 
            <span class="badge bg-primary"><?php echo number_format($total_interests); ?></span>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Status</th>
                        <th>Date Sent</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($interest = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $interest['id']; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($interest['sender_name']); ?></strong><br>
                                <small class="text-muted"><?php echo htmlspecialchars($interest['sender_email']); ?></small>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($interest['receiver_name']); ?></strong><br>
                                <small class="text-muted"><?php echo htmlspecialchars($interest['receiver_email']); ?></small>
                            </td>
                            <td>
                                <?php
                                $status_class = '';
                                switch($interest['status']) {
                                    case 'pending': $status_class = 'warning'; break;
                                    case 'accepted': $status_class = 'success'; break;
                                    case 'rejected': $status_class = 'danger'; break;
                                }
                                ?>
                                <span class="badge bg-<?php echo $status_class; ?>">
                                    <?php echo ucfirst($interest['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('d M Y H:i', strtotime($interest['created_at'])); ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="view-user.php?id=<?php echo $interest['sender_id']; ?>" class="btn btn-sm btn-info" title="View Sender">
                                        <i class="fas fa-user"></i>
                                    </a>
                                    <a href="view-user.php?id=<?php echo $interest['receiver_id']; ?>" class="btn btn-sm btn-primary" title="View Receiver">
                                        <i class="fas fa-user-friends"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No interests found</h5>
                                <p class="text-muted">No user interests match your current filter.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <nav aria-label="Interests pagination">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&status=<?php echo urlencode($status_filter); ?>">Previous</a>
                </li>
                <?php endif; ?>

                <?php
                $start = max(1, $page - 2);
                $end = min($total_pages, $page + 2);
                
                for ($i = $start; $i <= $end; $i++):
                ?>
                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&status=<?php echo urlencode($status_filter); ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&status=<?php echo urlencode($status_filter); ?>">Next</a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>

<?php include('includes/admin-footer.php'); ?>