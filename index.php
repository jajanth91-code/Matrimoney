<?php
session_start();
include('Database/db-connect.php');

// If user is logged in already
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM user_details WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if (!empty($user['name']) && !empty($user['gender']) && !empty($user['phone_number'])) {
        header('Location: user-profile.php');
        exit;
    } else {
        header('Location: personal-details.php');
        exit;
    }
}

// Handle login form (modal)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM user_details WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];

        if (!empty($user['name']) && !empty($user['gender']) && !empty($user['phone_number'])) {
            header('Location: user-profile.php');
        } else {
            header('Location: personal-details.php');
        }
        exit;
    } else {
        echo "<script>alert('Invalid username or password!');</script>";
    }
}

// Handle Register Free form → Go to register.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['mobile'] = $_POST['mobile'];
    header('Location: register.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Matrimony</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .hero-section {
      background-image: url('./images/back.jpg');
      background-size: cover;
      background-position: center;
      height: 100vh;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
    }
    .hero-form input, .hero-form select {
      margin: 5px;
    }
    .navbar-brand img {
      height: 40px;
    }
    .modal-content {
      border-radius: 10px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
  <a class="navbar-brand" href="#"><img src="images/logo1.png" alt="Logo"></a>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Profiles</a></li>
      <li class="nav-item"><a class="nav-link" href="">Happy Stories</a></li>
      <li class="nav-item"><a class="nav-link" href="search.php">Search</a></li>
    </ul>
    <form class="d-flex align-items-center">
      
      <?php if (isset($_SESSION['username'])): ?>
        <span class="me-3">👤 <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      <?php else: ?>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
      <?php endif; ?>
    </form>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
  <h1>Divine Matches Happen</h1>
  <p>Destined to unite those divinely bonded partners, we strive towards perfection with utmost dedication.</p>
  <form class="hero-form d-flex justify-content-center flex-wrap" method="POST">
    <input type="text" class="form-control w-auto" name="name" placeholder="Enter Your Name" required>
    <select class="form-select w-auto" name="gender" required>
      <option selected disabled>Gender</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
    </select>
    <input type="text" class="form-control w-auto" name="mobile" placeholder="Mobile Number" required>
    <button type="submit" name="register" class="btn btn-primary">Register Free</button>
  </form>
</section>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <input type="hidden" name="login" value="1">
          <div class="mb-3">
            <label>Username</label>
            <input type="text" class="form-control" name="username" placeholder="Enter username" required>
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
