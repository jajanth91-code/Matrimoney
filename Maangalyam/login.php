<?php
session_start();
include('Database/db-connect.php');

// Example login process
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check user credentials
    $query = "SELECT * FROM user_details  WHERE username = '$username' AND password = '$password'"; // Adjust table and field names
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
 
    if ($user) {
        // Set session variable after successful login
        $_SESSION['user_id'] = $user['user_id'];
        header('Location: index.php'); // Redirect to homepage or dashboard
    } else {
        // Invalid login credentials
        echo "Invalid username or password!";
    }
}
?>
