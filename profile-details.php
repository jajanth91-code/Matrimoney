<?php
$page_title = "Profile Details - Thirumangalyam Matrimony";
include('includes/header.php');
include('Database/db-connect.php');

// Get profile ID from URL
$profile_id = $_GET['id'] ?? null;

if (!$profile_id) {
    header('Location: profiles.php');
    exit;
}

// Fetch profile details
$query = "SELECT * FROM user_details WHERE id = ? AND is_active = 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $profile_id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

if (!$profile) {
    header('Location: profiles.php');
    exit;
}

// Check if current user has already sent interest
$interest_sent = false;
if (isset($_SESSION['user_id'])) {
    $interest_query = "SELECT id FROM user_interests WHERE sender_id = ? AND receiver_id = ?";
    $interest_stmt = $conn->prepare($interest_query);
    $interest_stmt->bind_param("ii", $_SESSION['user_id'], $profile_id);
    $interest_stmt->execute();
    $interest_sent = $interest_stmt->get_result()->num_rows > 0;
}
?>

<div class="container mt-4">
    <div class="row">
        <!-- Profile Details -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user"></i> Profile Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Profile Image -->
                        <div class="col-md-4 text-center">
                            <?php
                            $image_path = 'images/default-profile.png';
                            if (!empty($profile['user_image'])) {
                                if (strpos($profile['user_image'], 'uploads/') === false) {
                                    $image_path = 'uploads/' . $profile['user_image'];
                                } else {
                                    $image_path = $profile['user_image'];
                                }
                                if (!file_exists($image_path)) {
                                    $image_path = 'images/default-profile.png';
                                }
                            }
                            ?>
                            <img src="<?php echo $image_path; ?>" alt="Profile Picture" class="img-fluid rounded mb-3" style="max-width: 250px; max-height: 300px; object-fit: cover;">
                            <h4 class="text-primary"><?php echo htmlspecialchars($profile['name']); ?></h4>
                            <p class="text-muted">ID: <?php echo $profile['id']; ?></p>
                        </div>
                        
                        <!-- Basic Information -->
                        <div class="col-md-8">
                            <h5 class="text-primary mb-3">Basic Information</h5>
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <strong>Age:</strong><br>
                                    <span class="text-muted"><?php echo $profile['age']; ?> years</span>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Height:</strong><br>
                                    <span class="text-muted"><?php echo htmlspecialchars($profile['height']); ?></span>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Gender:</strong><br>
                                    <span class="text-muted"><?php echo ucfirst($profile['gender']); ?></span>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Marital Status:</strong><br>
                                    <span class="text-muted"><?php echo htmlspecialchars($profile['marital_status']); ?></span>
                                </div>
                                <?php if (!empty($profile['complexion'])): ?>
                                <div class="col-sm-6 mb-3">
                                    <strong>Complexion:</strong><br>
                                    <span class="text-muted"><?php echo htmlspecialchars($profile['complexion']); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Information -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Detailed Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php if (!empty($profile['nakshatra']) || !empty($profile['raasi'])): ?>
                            <h6 class="text-primary">Astrological Details</h6>
                            <table class="table table-borderless">
                                <?php if (!empty($profile['nakshatra'])): ?>
                                <tr>
                                    <td><strong>Nakshatra:</strong></td>
                                    <td><?php echo htmlspecialchars($profile['nakshatra']); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if (!empty($profile['raasi'])): ?>
                                <tr>
                                    <td><strong>Raasi:</strong></td>
                                    <td><?php echo htmlspecialchars($profile['raasi']); ?></td>
                                </tr>
                                <?php endif; ?>
                            </table>
                            <?php endif; ?>
                            
                            <?php if (!empty($profile['resident']) || !empty($profile['native_place'])): ?>
                            <h6 class="text-primary mt-4">Location Details</h6>
                            <table class="table table-borderless">
                                <?php if (!empty($profile['resident'])): ?>
                                <tr>
                                    <td><strong>Resident:</strong></td>
                                    <td><?php echo htmlspecialchars($profile['resident']); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if (!empty($profile['native_place'])): ?>
                                <tr>
                                    <td><strong>Native Place:</strong></td>
                                    <td><?php echo htmlspecialchars($profile['native_place']); ?></td>
                                </tr>
                                <?php endif; ?>
                            </table>
                            <?php endif; ?>
                        </div>
                        
                        <div class="col-md-6">
                            <?php if (!empty($profile['qualification']) || !empty($profile['job'])): ?>
                            <h6 class="text-primary">Professional Details</h6>
                            <table class="table table-borderless">
                                <?php if (!empty($profile['qualification'])): ?>
                                <tr>
                                    <td><strong>Qualification:</strong></td>
                                    <td><?php echo htmlspecialchars($profile['qualification']); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if (!empty($profile['job'])): ?>
                                <tr>
                                    <td><strong>Job:</strong></td>
                                    <td><?php echo htmlspecialchars($profile['job']); ?></td>
                                </tr>
                                <?php endif; ?>
                            </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-heart"></i> Express Interest</h5>
                </div>
                <div class="card-body text-center">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <p class="text-muted">Please login to express interest</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                    <?php elseif ($_SESSION['user_id'] == $profile_id): ?>
                        <p class="text-muted">This is your own profile</p>
                        <a href="edit-profile.php" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                    <?php elseif ($interest_sent): ?>
                        <p class="text-success"><i class="fas fa-check"></i> Interest already sent</p>
                        <button class="btn btn-success" disabled>
                            <i class="fas fa-heart"></i> Interest Sent
                        </button>
                    <?php else: ?>
                        <p class="text-muted">Interested in this profile?</p>
                        <button class="btn btn-primary btn-lg" onclick="sendInterest(<?php echo $profile_id; ?>)">
                            <i class="fas fa-heart"></i> Send Interest
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0"><i class="fas fa-bolt"></i> Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="profiles.php" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Profiles
                        </a>
                        <a href="search.php" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-search"></i> Search More
                        </a>
                        <?php if (isset($_SESSION['user_id'])): ?>
                        <button class="btn btn-outline-success btn-sm" onclick="reportProfile(<?php echo $profile_id; ?>)">
                            <i class="fas fa-flag"></i> Report Profile
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function sendInterest(receiverId) {
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
            location.reload();
        } else {
            alert(data.message || 'Failed to send interest');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}

function reportProfile(profileId) {
    if (confirm('Are you sure you want to report this profile?')) {
        // Implement report functionality
        alert('Profile reported. Our team will review it.');
    }
}
</script>

<?php include('includes/footer.php'); ?>