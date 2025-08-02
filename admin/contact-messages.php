<?php
$page_title = "Contact Messages - Admin Panel";
session_start();
include('../Database/db-connect.php');
include('includes/admin-header.php');

// Handle message deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    $delete_query = "DELETE FROM contact_messages WHERE id = ?";
    $delete_stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($delete_stmt, "i", $delete_id);
    
    if (mysqli_stmt_execute($delete_stmt)) {
        $_SESSION['message'] = "Message deleted successfully.";
    } else {
        $_SESSION['error'] = "Failed to delete message.";
    }
    header('Location: contact-messages.php');
    exit;
}

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Get total count
$count_query = "SELECT COUNT(*) as total FROM contact_messages";
$count_result = mysqli_query($conn, $count_query);
$total_messages = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_messages / $limit);

// Fetch messages
$query = "SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
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

<!-- Messages Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-envelope"></i> Contact Messages 
            <span class="badge bg-primary"><?php echo number_format($total_messages); ?></span>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($message = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $message['id']; ?></td>
                            <td><?php echo htmlspecialchars($message['name']); ?></td>
                            <td><?php echo htmlspecialchars($message['email']); ?></td>
                            <td>
                                <div style="max-width: 300px;">
                                    <?php 
                                    $msg = htmlspecialchars($message['message']);
                                    echo strlen($msg) > 100 ? substr($msg, 0, 100) . '...' : $msg;
                                    ?>
                                </div>
                            </td>
                            <td><?php echo date('d M Y H:i', strtotime($message['created_at'])); ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#messageModal<?php echo $message['id']; ?>" title="View Full Message">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="?delete=<?php echo $message['id']; ?>" 
                                       class="btn btn-sm btn-danger" 
                                       title="Delete Message"
                                       onclick="return confirmDelete('Are you sure you want to delete this message?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Message Modal -->
                        <div class="modal fade" id="messageModal<?php echo $message['id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Message from <?php echo htmlspecialchars($message['name']); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Name:</strong><br>
                                                <?php echo htmlspecialchars($message['name']); ?>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Email:</strong><br>
                                                <a href="mailto:<?php echo htmlspecialchars($message['email']); ?>">
                                                    <?php echo htmlspecialchars($message['email']); ?>
                                                </a>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-12">
                                                <strong>Message:</strong><br>
                                                <div class="bg-light p-3 rounded mt-2">
                                                    <?php echo nl2br(htmlspecialchars($message['message'])); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-12">
                                                <strong>Received:</strong><br>
                                                <?php echo date('d M Y H:i:s', strtotime($message['created_at'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="mailto:<?php echo htmlspecialchars($message['email']); ?>" class="btn btn-primary">
                                            <i class="fas fa-reply"></i> Reply via Email
                                        </a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No messages found</h5>
                                <p class="text-muted">No contact messages have been received yet.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <nav aria-label="Messages pagination">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                </li>
                <?php endif; ?>

                <?php
                $start = max(1, $page - 2);
                $end = min($total_pages, $page + 2);
                
                for ($i = $start; $i <= $end; $i++):
                ?>
                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>

<?php include('includes/admin-footer.php'); ?>