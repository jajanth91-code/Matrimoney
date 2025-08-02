<?php
session_start();
include('../Database/db-connect.php'); // Include database connection

// Check if 'id' is passed as a GET parameter
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the input

    // Prepare the DELETE query
    $query = "DELETE FROM user_details WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        $executed = mysqli_stmt_execute($stmt);

        if ($executed) {
            // Redirect with a success message
            $_SESSION['message'] = "User deleted successfully.";
            header("Location: dashboard.php"); // Change to your dashboard or admin panel URL
            exit;
        } else {
            // Handle error
            $_SESSION['error'] = "Failed to delete user.";
            header("Location: dashboard.php");
            exit;
        }
    } else {
        // Handle query preparation failure
        $_SESSION['error'] = "Failed to prepare query.";
        header("Location: dashboard.php");
        exit;
    }
} else {
    // Handle invalid access
    $_SESSION['error'] = "Invalid request.";
    header("Location: dashboard.php");
    exit;
}
?>
