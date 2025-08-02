<?php
session_start();
include('../Database/db-connect.php');


if (isset($_SESSION['id']) && isset($_SESSION['username'])) {}

// Get user ID from the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch user details
    $query = "SELECT * FROM user_details WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);

    // Check if user exists
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">User Details</h2>
        <div class="card">
            <div class="card-body">
                <p><strong>ID:</strong> <?php echo $user['id']; ?></p>
                <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
                <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                <p><strong>Phone Number:</strong> <?php echo $user['phone_number']; ?></p>
                <p><strong>Date of Birth:</strong> <?php echo date("d M Y", strtotime($user['dob'])); ?></p>
                <p><strong>Gender:</strong> <?php echo ucfirst($user['gender']); ?></p>
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
        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Admin Panel</a>
    </div>
</body>
</html>
