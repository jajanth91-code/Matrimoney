<?php
$page_title = "Search Profiles - Thirumangalyam Matrimony";
include('includes/header.php');
include('Database/db-connect.php');

// Initialize search parameters
$min_age = $_GET['min_age'] ?? '';
$max_age = $_GET['max_age'] ?? '';
$gender = $_GET['gender'] ?? '';
$nakshatra = $_GET['nakshatra'] ?? '';
$raasi = $_GET['raasi'] ?? '';
$min_height = $_GET['min_height'] ?? '';
$max_height = $_GET['max_height'] ?? '';
$resident = $_GET['resident'] ?? '';
$marital_status = $_GET['marital_status'] ?? '';
$qualification = $_GET['qualification'] ?? '';
$district = $_GET['district'] ?? '';

// Build the search query
$conditions = [];
$params = [];
$types = '';

if ($min_age !== '') {
    $conditions[] = 'age >= ?';
    $params[] = $min_age;
    $types .= 'i';
}
if ($max_age !== '') {
    $conditions[] = 'age <= ?';
    $params[] = $max_age;
    $types .= 'i';
}
if ($gender !== '') {
    $conditions[] = 'gender = ?';
    $params[] = $gender;
    $types .= 's';
}
if ($nakshatra !== '') {
    $conditions[] = 'nakshatra LIKE ?';
    $params[] = "%$nakshatra%";
    $types .= 's';
}
if ($raasi !== '') {
    $conditions[] = 'raasi LIKE ?';
    $params[] = "%$raasi%";
    $types .= 's';
}
if ($min_height !== '') {
    $conditions[] = 'CAST(SUBSTRING_INDEX(height, " ", 1) AS UNSIGNED) >= ?';
    $params[] = $min_height;
    $types .= 'i';
}
if ($max_height !== '') {
    $conditions[] = 'CAST(SUBSTRING_INDEX(height, " ", 1) AS UNSIGNED) <= ?';
    $params[] = $max_height;
    $types .= 'i';
}
if ($resident !== '') {
    $conditions[] = 'resident LIKE ?';
    $params[] = "%$resident%";
    $types .= 's';
}
if ($marital_status !== '') {
    $conditions[] = 'marital_status = ?';
    $params[] = $marital_status;
    $types .= 's';
}
if ($qualification !== '') {
    $conditions[] = 'qualification LIKE ?';
    $params[] = "%$qualification%";
    $types .= 's';
}
if ($district !== '') {
    $conditions[] = 'district LIKE ?';
    $params[] = "%$district%";
    $types .= 's';
}

// Base query
$sql = "SELECT id, name, gender, age, height, nakshatra, raasi, resident, user_image, job, qualification, marital_status 
        FROM user_details WHERE is_active = 1";

if ($conditions) {
    $sql .= " AND " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY created_at DESC LIMIT 50";

// Prepare and execute the query
if ($conditions) {
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = false;
    }
} else {
    $result = mysqli_query($conn, $sql);
}
?>

<div class="container mt-4">
    <!-- Search Form -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-search"></i> Search Your Perfect Match</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <!-- Age Range -->
                            <div class="col-md-3">
                                <label class="form-label">Age Range</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="min_age" value="<?= htmlspecialchars($min_age) ?>" placeholder="Min Age" min="18" max="80">
                                    <span class="input-group-text">to</span>
                                    <input type="number" class="form-control" name="max_age" value="<?= htmlspecialchars($max_age) ?>" placeholder="Max Age" min="18" max="80">
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="col-md-3">
                                <label class="form-label">Gender</label>
                                <select class="form-select" name="gender">
                                    <option value="">Any Gender</option>
                                    <option value="male" <?= $gender === 'male' ? 'selected' : '' ?>>Male</option>
                                    <option value="female" <?= $gender === 'female' ? 'selected' : '' ?>>Female</option>
                                </select>
                            </div>

                            <!-- Height Range -->
                            <div class="col-md-3">
                                <label class="form-label">Height (cm)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="min_height" value="<?= htmlspecialchars($min_height) ?>" placeholder="Min" min="140" max="220">
                                    <span class="input-group-text">to</span>
                                    <input type="number" class="form-control" name="max_height" value="<?= htmlspecialchars($max_height) ?>" placeholder="Max" min="140" max="220">
                                </div>
                            </div>

                            <!-- Marital Status -->
                            <div class="col-md-3">
                                <label class="form-label">Marital Status</label>
                                <select class="form-select" name="marital_status">
                                    <option value="">Any Status</option>
                                    <option value="Single" <?= $marital_status === 'Single' ? 'selected' : '' ?>>Single</option>
                                    <option value="Divorced" <?= $marital_status === 'Divorced' ? 'selected' : '' ?>>Divorced</option>
                                    <option value="Widowed" <?= $marital_status === 'Widowed' ? 'selected' : '' ?>>Widowed</option>
                                </select>
                            </div>

                            <!-- Nakshatra -->
                            <div class="col-md-3">
                                <label class="form-label">Nakshatra</label>
                                <select class="form-select" name="nakshatra">
                                    <option value="">Any Nakshatra</option>
                                    <option value="Ashwini" <?= $nakshatra === 'Ashwini' ? 'selected' : '' ?>>Ashwini</option>
                                    <option value="Bharani" <?= $nakshatra === 'Bharani' ? 'selected' : '' ?>>Bharani</option>
                                    <option value="Kritika" <?= $nakshatra === 'Kritika' ? 'selected' : '' ?>>Kritika</option>
                                    <option value="Rohini" <?= $nakshatra === 'Rohini' ? 'selected' : '' ?>>Rohini</option>
                                    <option value="Mrigashira" <?= $nakshatra === 'Mrigashira' ? 'selected' : '' ?>>Mrigashira</option>
                                    <option value="Ardra" <?= $nakshatra === 'Ardra' ? 'selected' : '' ?>>Ardra</option>
                                    <option value="Punarvasu" <?= $nakshatra === 'Punarvasu' ? 'selected' : '' ?>>Punarvasu</option>
                                    <option value="Pushya" <?= $nakshatra === 'Pushya' ? 'selected' : '' ?>>Pushya</option>
                                    <option value="Ashlesha" <?= $nakshatra === 'Ashlesha' ? 'selected' : '' ?>>Ashlesha</option>
                                    <option value="Magha" <?= $nakshatra === 'Magha' ? 'selected' : '' ?>>Magha</option>
                                    <option value="Purva Phalguni" <?= $nakshatra === 'Purva Phalguni' ? 'selected' : '' ?>>Purva Phalguni</option>
                                    <option value="Uttara Phalguni" <?= $nakshatra === 'Uttara Phalguni' ? 'selected' : '' ?>>Uttara Phalguni</option>
                                    <option value="Hasta" <?= $nakshatra === 'Hasta' ? 'selected' : '' ?>>Hasta</option>
                                    <option value="Chitra" <?= $nakshatra === 'Chitra' ? 'selected' : '' ?>>Chitra</option>
                                    <option value="Swati" <?= $nakshatra === 'Swati' ? 'selected' : '' ?>>Swati</option>
                                    <option value="Vishakha" <?= $nakshatra === 'Vishakha' ? 'selected' : '' ?>>Vishakha</option>
                                    <option value="Anuradha" <?= $nakshatra === 'Anuradha' ? 'selected' : '' ?>>Anuradha</option>
                                    <option value="Jyeshtha" <?= $nakshatra === 'Jyeshtha' ? 'selected' : '' ?>>Jyeshtha</option>
                                    <option value="Mula" <?= $nakshatra === 'Mula' ? 'selected' : '' ?>>Mula</option>
                                    <option value="Purva Ashadha" <?= $nakshatra === 'Purva Ashadha' ? 'selected' : '' ?>>Purva Ashadha</option>
                                    <option value="Uttara Ashadha" <?= $nakshatra === 'Uttara Ashadha' ? 'selected' : '' ?>>Uttara Ashadha</option>
                                    <option value="Shravana" <?= $nakshatra === 'Shravana' ? 'selected' : '' ?>>Shravana</option>
                                    <option value="Dhanishta" <?= $nakshatra === 'Dhanishta' ? 'selected' : '' ?>>Dhanishta</option>
                                    <option value="Shatabhisha" <?= $nakshatra === 'Shatabhisha' ? 'selected' : '' ?>>Shatabhisha</option>
                                    <option value="Purva Bhadrapada" <?= $nakshatra === 'Purva Bhadrapada' ? 'selected' : '' ?>>Purva Bhadrapada</option>
                                    <option value="Uttara Bhadrapada" <?= $nakshatra === 'Uttara Bhadrapada' ? 'selected' : '' ?>>Uttara Bhadrapada</option>
                                    <option value="Revati" <?= $nakshatra === 'Revati' ? 'selected' : '' ?>>Revati</option>
                                </select>
                            </div>

                            <!-- Raasi -->
                            <div class="col-md-3">
                                <label class="form-label">Raasi</label>
                                <select class="form-select" name="raasi">
                                    <option value="">Any Raasi</option>
                                    <option value="Mesha" <?= $raasi === 'Mesha' ? 'selected' : '' ?>>Mesha (Aries)</option>
                                    <option value="Vrishabha" <?= $raasi === 'Vrishabha' ? 'selected' : '' ?>>Vrishabha (Taurus)</option>
                                    <option value="Mithuna" <?= $raasi === 'Mithuna' ? 'selected' : '' ?>>Mithuna (Gemini)</option>
                                    <option value="Karka" <?= $raasi === 'Karka' ? 'selected' : '' ?>>Karka (Cancer)</option>
                                    <option value="Simha" <?= $raasi === 'Simha' ? 'selected' : '' ?>>Simha (Leo)</option>
                                    <option value="Kanya" <?= $raasi === 'Kanya' ? 'selected' : '' ?>>Kanya (Virgo)</option>
                                    <option value="Tula" <?= $raasi === 'Tula' ? 'selected' : '' ?>>Tula (Libra)</option>
                                    <option value="Vrishchika" <?= $raasi === 'Vrishchika' ? 'selected' : '' ?>>Vrishchika (Scorpio)</option>
                                    <option value="Dhanu" <?= $raasi === 'Dhanu' ? 'selected' : '' ?>>Dhanu (Sagittarius)</option>
                                    <option value="Makara" <?= $raasi === 'Makara' ? 'selected' : '' ?>>Makara (Capricorn)</option>
                                    <option value="Kumbha" <?= $raasi === 'Kumbha' ? 'selected' : '' ?>>Kumbha (Aquarius)</option>
                                    <option value="Meena" <?= $raasi === 'Meena' ? 'selected' : '' ?>>Meena (Pisces)</option>
                                </select>
                            </div>

                            <!-- District -->
                            <div class="col-md-3">
                                <label class="form-label">District</label>
                                <input type="text" class="form-control" name="district" value="<?= htmlspecialchars($district) ?>" placeholder="Enter district">
                            </div>

                            <!-- Resident -->
                            <div class="col-md-3">
                                <label class="form-label">Resident</label>
                                <input type="text" class="form-control" name="resident" value="<?= htmlspecialchars($resident) ?>" placeholder="Enter resident location">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg me-2">
                                    <i class="fas fa-search"></i> Search Profiles
                                </button>
                                <a href="search.php" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-redo"></i> Clear Filters
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Results -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-users"></i> 
                        <?php 
                        $total_results = $result ? $result->num_rows : 0;
                        echo "Search Results ($total_results profiles found)";
                        ?>
                    </h4>
                </div>
                <div class="card-body">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <div class="row g-4">
                            <?php while ($user = $result->fetch_assoc()): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 shadow-sm border-0">
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
                                                <img src="<?= $image_path ?>" alt="Profile" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #e9ecef;">
                                            </div>

                                            <!-- Profile Info -->
                                            <h5 class="card-title text-primary"><?= htmlspecialchars($user['name']) ?></h5>
                                            
                                            <div class="row text-start">
                                                <div class="col-6">
                                                    <small class="text-muted">Age:</small><br>
                                                    <strong><?= htmlspecialchars($user['age']) ?> years</strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Height:</small><br>
                                                    <strong><?= htmlspecialchars($user['height']) ?></strong>
                                                </div>
                                                <div class="col-6 mt-2">
                                                    <small class="text-muted">Gender:</small><br>
                                                    <strong><?= ucfirst(htmlspecialchars($user['gender'])) ?></strong>
                                                </div>
                                                <div class="col-6 mt-2">
                                                    <small class="text-muted">Status:</small><br>
                                                    <strong><?= htmlspecialchars($user['marital_status']) ?></strong>
                                                </div>
                                                <?php if (!empty($user['nakshatra'])): ?>
                                                <div class="col-6 mt-2">
                                                    <small class="text-muted">Nakshatra:</small><br>
                                                    <strong><?= htmlspecialchars($user['nakshatra']) ?></strong>
                                                </div>
                                                <?php endif; ?>
                                                <?php if (!empty($user['raasi'])): ?>
                                                <div class="col-6 mt-2">
                                                    <small class="text-muted">Raasi:</small><br>
                                                    <strong><?= htmlspecialchars($user['raasi']) ?></strong>
                                                </div>
                                                <?php endif; ?>
                                                <?php if (!empty($user['job'])): ?>
                                                <div class="col-12 mt-2">
                                                    <small class="text-muted">Profession:</small><br>
                                                    <strong><?= htmlspecialchars($user['job']) ?></strong>
                                                </div>
                                                <?php endif; ?>
                                                <?php if (!empty($user['resident'])): ?>
                                                <div class="col-12 mt-2">
                                                    <small class="text-muted">Location:</small><br>
                                                    <strong><?= htmlspecialchars($user['resident']) ?></strong>
                                                </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="mt-3">
                                                <a href="profile-details.php?id=<?= $user['id'] ?>" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i> View Profile
                                                </a>
                                                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $user['id']): ?>
                                                <button class="btn btn-outline-success btn-sm" onclick="sendInterest(<?= $user['id'] ?>)">
                                                    <i class="fas fa-heart"></i> Interest
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No profiles found</h4>
                            <p class="text-muted">Try adjusting your search criteria to find more matches.</p>
                            <a href="search.php" class="btn btn-primary">Reset Search</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function sendInterest(receiverId) {
    if (!<?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>) {
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