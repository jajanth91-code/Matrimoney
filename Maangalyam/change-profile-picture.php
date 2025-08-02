<?php
session_start();
include('Database/db-connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $image = $_FILES['profile_image'];
    $image_name = $image['name'];
    $image_tmp_name = $image['tmp_name'];
    $image_size = $image['size'];
    $image_error = $image['error'];

    if ($image_error === 0) {
        if ($image_size < 5000000000) { // Check size (1MB limit)
            $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
            $image_extension = strtolower($image_extension);
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($image_extension, $allowed_extensions)) {
                $new_image_name = uniqid('', true) . '.' . $image_extension;
                $image_upload_path = 'uploads/' . $new_image_name;

                // Move the uploaded image to the "uploads" folder
                if (move_uploaded_file($image_tmp_name, $image_upload_path)) {
                    // Update the user's image in the database
                    $update_query = "UPDATE user_details SET user_image = '$new_image_name' WHERE id = '$user_id'";

                    if (mysqli_query($conn, $update_query)) {
                        $_SESSION['message'] = "Profile picture updated successfully!";
                        header('Location: user-profile.php'); // Redirect to profile page
                        exit();
                    } else {
                        $_SESSION['message'] = "Error updating profile picture.";
                    }
                } else {
                    $_SESSION['message'] = "Failed to upload image.";
                }
            } else {
                $_SESSION['message'] = "Invalid image format.";
            }
        } else {
            $_SESSION['message'] = "Image size exceeds the limit of 1MB.";
        }
    } else {
        $_SESSION['message'] = "Error uploading the image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Profile Picture</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Change Profile Picture</h2>

    <?php
    // Display message if there is any
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }
    ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="profile_image">Upload New Profile Picture</label>
            <input type="file" class="form-control-file" id="profile_image" name="profile_image" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload Image</button>
    </form>
</div>

</body>
</html>
