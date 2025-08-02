<?php

include('Database/db-connect.php'); 

session_start();

// Check if session data is available (data from index.php)
if (isset($_SESSION['name'], $_SESSION['gender'], $_SESSION['mobile'])) {
    // Use session data to populate the fields
    $name = $_SESSION['name'];
    $gender = $_SESSION['gender'];
    $mobile = $_SESSION['mobile'];

    // Handle form submission and save the data to the database
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the form data from register.php
        $dobDay = $_POST['dobDay'];
        $dobMonth = $_POST['dobMonth'];
        $dobYear = $_POST['dobYear'];
        $email = $_POST['email'];
        $username = $_POST['userId'];
        $password = $_POST['password'];
        $disct = $_POST['disc'];

        // Convert DOB to Date format
        $dob = $dobYear . '-' . $dobMonth . '-' . $dobDay;

        // Calculate age (optional)
        $dobTimestamp = strtotime($dob);
        $age = floor((time() - $dobTimestamp) / 31556926);  // Age calculation in years

        // Hash password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the data into the database
        $sql = "INSERT INTO user_details (name, gender, phone_number, dob, email, username, password, age,district) 
                VALUES ('$name', '$gender', '$mobile', '$dob', '$email', '$username', '$hashedPassword', '$age','$disct')";

        if (mysqli_query($conn, $sql)) {
            echo "Registration Successful!";
            // After successful registration, clear session data
            session_unset();
            session_destroy();
            header('Location:index.php'); // Corrected the file name here
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    // If session data is missing, redirect to index.php
    header('Location: index.php');
    exit;
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
      
    </style>
</head>
<body style="background-color: rgb(222, 222, 241);">

   <section class="reg-nav">
    <nav class="navbar navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="images/logo1.png" alt="Logo" class="d-inline-block align-top">
            </a>
            <span class="slogan">Two souls, one journey, endless love.</span>
        </div>
    </nav>
</section>

<section class="register">
    <div class="container mt-5">
        <div class="row" style="background-color: white; padding: 10px 10px 10px;">
            <div class="col-md-6">
                <div class="form-image">
                    <img src="images/form-img.jpg" alt="Form Illustration"  height="550px">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-container">
                    <h3 class="text-center mb-4">Tell us about your basic details</h3>
                    <form action="register.php" method="POST">
    
    <div class="form-row">
        <div class="form-group col-4">
            <input type="number" name="dobDay" placeholder="DD" required>
        </div>
        <div class="form-group col-4">
            <input type="number" name="dobMonth" placeholder="MM" required>
        </div>
        <div class="form-group col-4">
            <input type="number" name="dobYear" placeholder="YYYY" required>
        </div>
    </div>
    <div class="form-group">
        <input type="email" name="email" placeholder="Enter your email" required>
    </div>
    <div class="form-group">
        <input type="text" name="userId" placeholder="Create a User ID" required>
    </div>
    <div class="form-group">
        <input type="password" name="password" placeholder="Create a Password" required>
    </div>
      <div class="form-group">
       <label for="marital_status">Marital Status*</label>

            <select name="disc" class="form-control" required>
                                    <option value="">maritial status</option>
                                    <option value="Single">Single</option>
                                    <option value="diverce">Divorce</option>
                                    <option value="vidow">vidow</option>
           </select>
                            </div>

    <button type="submit" class="btn btn-primary btn-block">Submit & Continue</button>
</form>

                </div>
            </div>
        </div>
    </div>
</section>

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
  
    
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
