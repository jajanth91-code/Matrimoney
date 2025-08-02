<?php
$page_title = "All Profiles - Thirumangalyam Matrimony";
include('includes/header.php');
include('Database/db-connect.php');

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

// Get total count
$count_query = "SELECT COUNT(*) as total FROM user_details WHERE is_active = 1";
$count_result = mysqli_query($conn, $count_query);
$total_profiles = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_profiles / $limit);

// Fetch profiles with pagination
$query = "SELECT id, name, age, height, job, gender, user_image, district, marital_status, qualification 
          FROM user_details 
          WHERE is_active = 1 
          ORDER BY created_at DESC 
          LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold text-primary">Browse Profiles</h1>
            <p class="lead">Find your perfect life partner from our verified profiles</p>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <a href="search.php" class="btn btn-primary">
                    <i class="fas fa-search"></i> Advanced Search
                </a>
                <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="register.php" class="btn btn-success">
                    <i class="fas fa-user-plus"></i> Join Now
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-users"></i> 
                <strong><?php echo number_format($total_profiles); ?></strong> verified profiles available
            </div>
        </div>
    </div>

    <!-- Profiles Grid -->
    <div class="row g-4">
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php while ($user = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 profile-card">
                        <div class="card-body text-center">
                            <!-- Profile Image -->
                            <div class="mb-3">
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
                                <img src="<?php echo $image_path; ?>" alt="Profile" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #e9ecef;">
                            </div>

                            <!-- Profile Info -->
                            <h5 class="card-title text-primary"><?php echo htmlspecialchars($user['name']); ?></h5>
                            
                            <div class="row text-start">
                                <div class="col-6">
                                    <small class="text-muted">Age:</small><br>
                                    <strong><?php echo htmlspecialchars($user['age']); ?> years</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Height:</small><br>
                                    <strong><?php echo htmlspecialchars($user['height']); ?></strong>
                                </div>
                                <div class="col-6 mt-2">
                                    <small class="text-muted">Gender:</small><br>
                                    <strong><?php echo ucfirst(htmlspecialchars($user['gender'])); ?></strong>
                                </div>
                                <div class="col-6 mt-2">
                                    <small class="text-muted">Status:</small><br>
                                    <strong><?php echo htmlspecialchars($user['marital_status']); ?></strong>
                                </div>
                                <?php if (!empty($user['job'])): ?>
                                <div class="col-12 mt-2">
                                    <small class="text-muted">Profession:</small><br>
                                    <strong><?php echo htmlspecialchars($user['job']); ?></strong>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($user['district'])): ?>
                                <div class="col-12 mt-2">
                                    <small class="text-muted">Location:</small><br>
                                    <strong><?php echo htmlspecialchars($user['district']); ?></strong>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-3">
                                <a href="profile-details.php?id=<?php echo $user['id']; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> View Profile
                                </a>
                                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $user['id']): ?>
                                <button class="btn btn-outline-success btn-sm" onclick="sendInterest(<?php echo $user['id']; ?>)">
                                    <i class="fas fa-heart"></i> Interest
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No profiles found</h4>
                <p class="text-muted">Be the first to join our community!</p>
                <a href="register.php" class="btn btn-primary">Register Now</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <div class="row mt-5">
        <div class="col-12">
            <nav aria-label="Profile pagination">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
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
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">
                            Next <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.profile-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}
</style>

<script>
function sendInterest(receiverId) {
    if (!<?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>) {
        alert('Please login to send interest');
        return;
    }
    
    fetch('send-interest.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            receiver_id: receiverId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Interest sent successfully!');
        } else {
            alert(data.message || 'Failed to send interest');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}
</script>

<?php include('includes/footer.php'); ?>