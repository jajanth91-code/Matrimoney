 
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
<div class="container my-5">
    <div class="row align-items-center">
        <!-- Left Side: Image -->
        <div class="col-md-6">
            <img src="images/couple4.jpg" alt="Thirumangalyam Matrimony" class="img-fluid rounded shadow">
        </div>

        <!-- Right Side: Content -->
        <div class="col-md-6">
            <h1>About Thirumangalyam Matrimony</h1>
            <p>
                <strong>Thirumangalyam Matrimony</strong> is your trusted destination to find the perfect life partner.
                We combine tradition with technology to ensure meaningful and lasting matrimonial connections.
            </p>

            <h4>Why Choose Us?</h4>
            <ul>
                <li>✅ Verified and secure profiles</li>
                <li>📅 Matches based on age, nakshatra, raasi, education, and more</li>
                <li>🔔 Real-time interest and message notifications</li>
                <li>📱 Fully responsive design, accessible on all devices</li>
            </ul>

            <p>
                Join thousands of happy families and take the first step toward your forever today.
            </p>

            <a href="register.php" class="btn btn-primary mt-2">Register Now</a>
        </div>
    </div>
</div>
</body>
</html>


