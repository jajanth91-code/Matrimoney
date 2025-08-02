<?php
$page_title = "Home - Thirumangalyam Matrimony";
include('includes/header.php');
include('Database/db-connect.php');

// Handle Register Free form → Go to register.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['mobile'] = $_POST['mobile'];
    header('Location: register.php');
    exit;
}
?>

<!-- Display Messages -->
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Hero Section -->
<section class="hero-section" style="background-image: url('./images/back.jpg'); background-size: cover; background-position: center; height: 100vh; color: white; display: flex; align-items: center; justify-content: center; flex-direction: column; text-align: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">Divine Matches Happen Here</h1>
                <p class="lead mb-5">Destined to unite those divinely bonded partners, we strive towards perfection with utmost dedication.</p>
                
                <?php if (!isset($_SESSION['user_id'])): ?>
                <form class="hero-form d-flex justify-content-center flex-wrap gap-2" method="POST">
                    <input type="text" class="form-control" style="max-width: 200px;" name="name" placeholder="Enter Your Name" required>
                    <select class="form-select" style="max-width: 150px;" name="gender" required>
                        <option selected disabled>Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <input type="text" class="form-control" style="max-width: 200px;" name="mobile" placeholder="Mobile Number" required>
                    <button type="submit" name="register" class="btn btn-primary btn-lg">Register Free</button>
                </form>
                <?php else: ?>
                <div class="text-center">
                    <a href="search.php" class="btn btn-primary btn-lg me-3">Find Your Match</a>
                    <a href="user-profile.php" class="btn btn-outline-light btn-lg">View Profile</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-12">
                <h2 class="display-5 fw-bold">Why Choose Thirumangalyam?</h2>
                <p class="lead">Your trusted partner in finding the perfect life companion</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="main-box text-center">
                    <div class="main-box-sub p-4 rounded">
                        <i class="fas fa-shield-alt fa-3x mb-3"></i>
                        <h3>Verified Profiles</h3>
                        <p>All profiles are thoroughly verified for authenticity and security</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="main-box text-center">
                    <div class="main-box-sub p-4 rounded">
                        <i class="fas fa-search fa-3x mb-3"></i>
                        <h3>Advanced Search</h3>
                        <p>Find your perfect match with our advanced search filters</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="main-box text-center">
                    <div class="main-box-sub p-4 rounded">
                        <i class="fas fa-heart fa-3x mb-3"></i>
                        <h3>Success Stories</h3>
                        <p>Join thousands of couples who found their soulmate through us</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recent Profiles Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-12">
                <h2 class="display-5 fw-bold">Recent Profiles</h2>
                <p class="lead">Meet our newest members</p>
            </div>
        </div>
        <div class="row g-4">
            <?php
            // Fetch recent profiles
            $recent_query = "SELECT id, name, age, height, job, gender, user_image FROM user_details WHERE is_active = 1 ORDER BY created_at DESC LIMIT 6";
            $recent_result = mysqli_query($conn, $recent_query);
            
            while ($profile = mysqli_fetch_assoc($recent_result)):
            ?>
            <div class="col-md-4 col-lg-2">
                <div class="card h-100 shadow-sm">
                    <div class="text-center p-3">
                        <?php
                        $image_path = !empty($profile['user_image']) ? $profile['user_image'] : 'images/default-profile.png';
                        if (!empty($profile['user_image']) && strpos($profile['user_image'], 'uploads/') === false) {
                            $image_path = 'uploads/' . $profile['user_image'];
                        }
                        ?>
                        <img src="<?php echo $image_path; ?>" alt="Profile" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                        <h6 class="card-title"><?php echo htmlspecialchars($profile['name']); ?></h6>
                        <p class="card-text small text-muted">
                            Age: <?php echo $profile['age']; ?><br>
                            <?php echo htmlspecialchars($profile['job']); ?>
                        </p>
                        <a href="profile-details.php?id=<?php echo $profile['id']; ?>" class="btn btn-sm btn-outline-primary">View Profile</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="text-center mt-4">
            <a href="profiles.php" class="btn btn-primary btn-lg">View All Profiles</a>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>