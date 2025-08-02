<?php
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chavara Matrimony</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body style="background-color:gray;">
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="#">
            <img src="images/logo1.png" alt="Logo"> <!-- Replace with your logo URL -->
        </a>

        <!-- Toggler for mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profiles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Happy Stories</a>
                </li>
            </ul>

            <!-- Dynamic Section -->
            <?php if (!isset($_SESSION['user_id'])): ?>
                <!-- Show Login Button -->
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Login</a>
            <?php else: ?>
                <!-- Show Profile Button -->
                <a href="user-profile.php" class="btn btn-success">My Profile</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

    <div class="container-fluid profile-container ml-auto">
        <div class="row">
            <div class="col-md-8">
                <!-- Profile Card -->
                <div class="profile-card" style="background-color: white; display: flex; align-items: center; padding: 20px; border-radius: 10px; border: 1px solid #ddd; width: 70%;">
                    <!-- Profile Image -->
                    <div class="profile-header" style="flex-shrink: 0; margin-right: 20px;">
                        <?php
                       // Check if the user has uploaded an image and display it
                        if (!empty($user['user_image'])) {
                       // Check if the image already contains the "uploads/" path
                            if (strpos($user['user_image'], 'uploads/') === false) {
                       // If the 'uploads/' part is missing, add it to the path
                                $user_image_path = 'uploads/' . $user['user_image'];
                            } else {
                       // If the path already contains 'uploads/', just use it as is
                                $user_image_path = $user['user_image'];
                            }



                  // Check if the image file exists
                            if (file_exists($user_image_path)) {
            // If the file exists, display the image
                                echo '<img src="' . $user_image_path . '" alt="User Image" height="250px" width="200px">';
                            } else {
            // If the file doesn't exist, show an error message
                                echo '<p>Image not found at: ' . $user_image_path . '</p>';
                            }
                        } else {
        // If no user image, show a default image
                            echo '<p>No profile image available. Displaying default image.</p>';
                            echo '<img src="images/default-profile.png" alt="Default Profile Image" height="250px" width="200px">';
                        }
                        ?>
                    </div>

                    <!-- Profile Info -->
                    <div class="profile-info">
                        <p><strong>User Name:</strong> <?php echo $user['name']; ?></p>
                        <p><strong>User ID:</strong> <?php echo $user['id']; ?></p>
                        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                        <p><strong>Phone Number:</strong> <?php echo $user['phone_number']; ?></p>
                        <p><strong>Date of Birth:</strong> <?php echo date("d M Y", strtotime($user['dob'])); ?></p>
                        <p><strong>Gender:</strong> <?php echo ucfirst($user['gender']); ?></p>
                        <p><strong>district:</strong> <?php echo ($user['district']); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="profile-card">
                    <div class="profile-actions">
                        <ul class="list-unstyled">
                            <li><a href="edit-profile.php"><i class="fas fa-edit"></i> Edit Information</a></li>
                            <li><a href="change-profile-picture.php"><i class="fas fa-camera"></i> Change Profile Picture</a></li>
                            <li><a href="delete-profile.php"><i class="fas fa-trash-alt"></i> Delete Profile</a></li>
                            <li><a href="log-out.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="profile-card">
                    <div class="profile-info">
                        <p><strong>Age:</strong> <?php echo $user['age']; ?></p>
                        <p><strong>Height:</strong> <?php echo $user['height']; ?></p>
                        <p><strong>Nakshatra:</strong> <?php echo $user['nakshatra']; ?></p>
                        <p><strong>Raasi:</strong> <?php echo $user['raasi']; ?></p>
                        <p><strong>Resident:</strong> <?php echo $user['resident']; ?></p>
                        <p><strong>Native Place:</strong> <?php echo $user['native_place']; ?></p>
                        <p><strong>Complexion:</strong> <?php echo $user['complexion']; ?></p>
                        <p><strong>Marital Status:</strong> <?php echo $user['marital_status']; ?></p>
                        <p><strong>Qualification:</strong> <?php echo $user['qualification']; ?></p>
                        <p><strong>Job:</strong> <?php echo $user['job']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-links">
                <a href="#">Home</a>
                <a href="#">Service</a>
                <a href="#">Contact Us</a>
                <a href="#">FAQs</a>
                <a href="#">Terms & Conditions</a>
                <a href="#">Privacy Policy</a>
            </div>
            <div class="footer-bottom">
                <p>Copyright © 2024 All rights reserved.</p>
                <p>Powered by | TKS IT Solution | Matrimony Version 1.0</p>
            </div>
        </div>
    </footer>

</body>
</html>
