<?php
$page_title = "Register - Thirumangalyam Matrimony";
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
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert the data into the database
        $sql = "INSERT INTO user_details (name, gender, phone_number, dob, email, username, password, age, marital_status) 
                VALUES ('$name', '$gender', '$mobile', '$dob', '$email', '$username', '$hashedPassword', '$age', '$disct')";

        if (mysqli_query($conn, $sql)) {
            // Get the inserted user ID
            $user_id = mysqli_insert_id($conn);
            
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;
            $_SESSION['success'] = "Registration successful! Please complete your profile.";
            
            // After successful registration, clear session data
            unset($_SESSION['name'], $_SESSION['gender'], $_SESSION['mobile']);
            header('Location: personaldeatiles.php');
            exit;
        } else {
            $_SESSION['error'] = "Registration failed: " . mysqli_error($conn);
        }
    }
} else {
    // If session data is missing, redirect to index.php
    header('Location: index.php');
    exit;
}
?>

<?php include('includes/header.php'); ?>

<!-- Display Messages -->
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div style="background-color: rgb(222, 222, 241); min-height: 100vh;">

   <section class="reg-nav">
    <nav class="navbar navbar-custom bg-light">
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
        <div class="row bg-white rounded shadow p-4">
            <div class="col-md-6">
                <div class="form-image">
                    <img src="images/form-img.jpg" alt="Form Illustration" class="img-fluid rounded" style="max-height: 550px;">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-container">
                    <h3 class="text-center mb-4">Tell us about your basic details</h3>
                    <form action="register.php" method="POST" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="dobDay">Day</label>
                                    <input type="number" class="form-control" name="dobDay" placeholder="DD" min="1" max="31" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="dobMonth">Month</label>
                                    <input type="number" class="form-control" name="dobMonth" placeholder="MM" min="1" max="12" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="dobYear">Year</label>
                                    <input type="number" class="form-control" name="dobYear" placeholder="YYYY" min="1950" max="2005" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="userId">Username</label>
                            <input type="text" class="form-control" name="userId" placeholder="Create a User ID" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Create a Password" minlength="6" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="marital_status">Marital Status *</label>
                            <select name="disc" class="form-control" required>
                                <option value="">Select Marital Status</option>
                                <option value="Single">Single</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg">Submit & Continue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

</div>

<?php include('includes/footer.php'); ?>