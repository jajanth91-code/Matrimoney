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
    .contact-info {
      margin-top: 30px;
    }
    .map-container {
      margin-top: 30px;
      height: 400px;
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
    <div class="container contact-info">
  <div class="row">
    <div class="col-md-6">
      <h2>Contact Details</h2>
      <p><strong>Address:</strong> XYZ Street, City, Country</p>
      <p><strong>Phone:</strong> +123456789</p>
      <p><strong>Email:</strong> info@example.com</p>
      <p><strong>Business Hours:</strong> Monday - Friday, 9:00 AM - 6:00 PM</p>
    </div>
    
    <div class="col-md-6">
      <h2>Send Us a Message</h2>
      <form action="process_contact.php" method="POST">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="message">Message</label>
          <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
      </form>
    </div>
  </div>
</div>

<!-- Google Maps Section -->
<div class="container-fluid map-container">
  <h3 class="text-center">Our Location</h3>
  <div class="row">
    <div class="col-md-12">
      <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.186217487598!2d106.69519151479959!3d10.7612942624426!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752cc98fd937c9%3A0xd8633a1386f0da34!2zVGVzdCBPZmZpY2UsIENpdHksIFZpZXRuYW0gVGVzdA!5e0!3m2!1sen!2sus!4v1636707714642!5m2!1sen!2sus" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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