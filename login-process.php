<?php
session_start();
include('Database/db-connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Query to check user credentials
    $query = "SELECT * FROM user_details WHERE username = '$username' AND is_active = 1";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables after successful login
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['name'] = $user['name'];

        // Check if profile is complete
        if (!empty($user['height']) && !empty($user['nakshatra']) && !empty($user['job'])) {
            header('Location: user-profile.php');
        } else {
            header('Location: personaldeatiles.php');
        }
        exit;
    } else {
        $_SESSION['error'] = "Invalid username or password!";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
?>