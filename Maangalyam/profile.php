

<?php
session_start();
include('Database/db-connect.php');



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
    <link rel="stylesheet" href="animation/animate.min.css">
  <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
/>

<style>


  .profile-card {
      border: 1px solid #ddd;
      padding: 15px;
      text-align: center;
    }
    .profile-image {
      width: 200px;
      height: 250px;
      object-fit: cover;
     
    }
    .profile-info {
      margin-top: 10px;
    }
      
      .profiles .container-fluid {
 
  padding-right: 70px;
}



</style>
</head>
<body>
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
                    <a class="nav-link" href="#">Profiles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Happy Stories</a>
                </li>
            </ul>

            <!-- Dynamic Section -->
            <?php if (!isset($_SESSION['user_id'])): ?>
                <!-- Show Login Button -->
                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Login</a>
            <?php else: ?>
                <!-- Show Profile Button -->
                <a href="user-profile.php" class="btn btn-success">My Profile</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="loginForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                    </form>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<?php




// Fetch all profiles from the database
$query = "SELECT * FROM user_details";
$result = mysqli_query($conn, $query);
?>
<div class="container-fluid mt-5">
    <div class="row">
        <?php while ($user = mysqli_fetch_assoc($result)): ?>
        <div class="col-md-3 mb-4">
            <div class="card" style="border: 1px solid #ddd; padding: 20px; border-radius: 10px;">
                <div class="profile-image text-center">
                    <?php
                    if (!empty($user['user_image'])) {
                        $user_image_path = strpos($user['user_image'], 'uploads/') === false
                            ? 'uploads/' . $user['user_image']
                            : $user['user_image'];
                        if (file_exists($user_image_path)) {
                            echo '<img src="' . $user_image_path . '" alt="User Image" height="250px" width="160px" style="border-radius: 5px;">';
                        } else {
                            echo '<p>Image not found at: ' . $user_image_path . '</p>';
                        }
                    } else {
                        echo '<img src="images/default-profile.png" alt="Default Profile Image" height="200px" width="120px" style="border-radius: 5px;">';
                    }
                    ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($user['name']); ?></h5>
                    <p><strong>Age:</strong> <?php echo htmlspecialchars($user['age']); ?></p>
                    <p><strong>Height:</strong> <?php echo htmlspecialchars($user['height']); ?></p>
                    <p><strong>Job:</strong> <?php echo htmlspecialchars($user['job']); ?></p>
                    <p><strong>Gender:</strong> <?php echo ucfirst(htmlspecialchars($user['gender'])); ?></p>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>
<section class="first-footer">
    <footer class="text-white pt-5 pb-4" style="background-image: linear-gradient(to right, #141c52, #01507f);">
      <div class="container-fluid text-center text-md-left">
        <div class="row">
          <!-- Need Help Section (On the same row) -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
            <h5 class="text-uppercase font-weight-bold text-white">Need Help?</h5>
            <p><a href="#" class="text-white" style="text-decoration: none;">Member Login</a></p>
            <p><a href="#" class="text-white" style="text-decoration: none;">Sign Up</a></p>
            <p><a href="#" class="text-white" style="text-decoration: none;">Partner Search</a></p>
            <p><a href="#" class="text-white" style="text-decoration: none;">How to Use Maangalyam.com</a></p>
            <p><a href="#" class="text-white" style="text-decoration: none;">Premium Memberships</a></p>
            <p><a href="#" class="text-white" style="text-decoration: none;">Customer Support</a></p>
            <p><a href="#" class="text-white" style="text-decoration: none;">Site Map</a></p>
          </div>
  
          <!-- Quick Links Section -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
            <h5 class="text-uppercase mb-4 font-weight-bold text-white">Quick Links</h5>
            <p><a href="#" class="text-white" style="text-decoration: none;">Home</a></p>
            <p><a href="#" class="text-white" style="text-decoration: none;">About Us</a></p>
            <p><a href="#" class="text-white" style="text-decoration: none;">Services</a></p>
            <p><a href="#" class="text-white" style="text-decoration: none;">Contact</a></p>
          </div>
  
          <!-- Services Section -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
            <h5 class="text-uppercase mb-4 font-weight-bold text-white">Services</h5>
            <p><a href="#" class="text-white" style="text-decoration: none;">Matrimony Services</a></p>
            <p><a href="#" class="text-white" style="text-decoration: none;">Wedding Planning</a></p>
            <p><a href="#" class="text-white" style="text-decoration: none;">Photography</a></p>
            <p><a href="#" class="text-white" style="text-decoration: none;">Video Coverage</a></p>
          </div>
  
          <!-- Other Services Section -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
            <h5 class="text-uppercase mb-4 font-weight-bold text-white">Other Services</h5>
            <p><a href="#" class="text-white" style="text-decoration: none;">Digital Magazine</a></p>
            <p><a href="#" class="text-white" style="text-decoration: none;">Celestial Matrimony</a></p>
            <p><a href="#" class="text-white" style="text-decoration: none;">Advertise With Us</a></p>
          </div>
  
          <!-- Contact Section -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
            <h5 class="text-uppercase mb-4 font-weight-bold text-white">Contact</h5>
            <p><i class="fa fa-home mr-3"></i> XYZ Street, City</p>
            <p><i class="fa fa-envelope mr-3"></i> info@example.com</p>
            <p><i class="fa fa-phone mr-3"></i> +123456789</p>
          </div>
        </div>
  
        <hr style="border: 1px solid white;">
  
        <!-- Social Media -->
        <div class="row mt-3">
          <div class="col-md-12 text-center">
            <ul class="list-unstyled list-inline">
              <li class="list-inline-item">
                <a href="#" class="btn btn-sm btn-outline-light"><i class="fa fa-facebook"></i></a>
              </li>
              <li class="list-inline-item">
                <a href="#" class="btn btn-sm btn-outline-light"><i class="fa fa-twitter"></i></a>
              </li>
              <li class="list-inline-item">
                <a href="#" class="btn btn-sm btn-outline-light"><i class="fa fa-instagram"></i></a>
              </li>
              <li class="list-inline-item">
                <a href="#" class="btn btn-sm btn-outline-light"><i class="fa fa-linkedin"></i></a>
              </li>
            </ul>
          </div>
        </div>
  
        <!-- Copyright Section -->
        <div class="row mt-3">
          <div class="col-md-12 text-center">
            <p class="text-white-50 mb-0">
              &copy; 2024 YourWebsiteName. All rights reserved. Powered by 
              <a href="#" style="text-decoration: none; color: white;" >Tks It Soultion</a>.
            </p>
          </div>
        </div>
      </div>
    </footer>
  </section>
  
  


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>