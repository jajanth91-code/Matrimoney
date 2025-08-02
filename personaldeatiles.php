<?php
$page_title = "Complete Profile - Thirumangalyam Matrimony";
session_start();
include('Database/db-connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: register.php');
    exit();
}

// Initialize error and success messages
$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $height = mysqli_real_escape_string($conn, $_POST['height']);
    $nakshatra = mysqli_real_escape_string($conn, $_POST['nakshatra']);
    $raasi = mysqli_real_escape_string($conn, $_POST['raasi']);
    $resident = mysqli_real_escape_string($conn, $_POST['resident']);
    $native_place = mysqli_real_escape_string($conn, $_POST['native_place']);
    $complexion = mysqli_real_escape_string($conn, $_POST['complexion']);
    $marital_status = mysqli_real_escape_string($conn, $_POST['marital_status']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $job = mysqli_real_escape_string($conn, $_POST['job']);
    $image = "";

    // Image upload handling
    if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] == 0) {
        $image_name = $_FILES['user_image']['name'];
        $image_tmp = $_FILES['user_image']['tmp_name'];
        $image_size = $_FILES['user_image']['size'];
        $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);

        // Validate file type and size
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($image_ext), $allowed_ext) && $image_size <= 50000000000) { // 5MB max size
            $image_new_name = 'user_' . time() . '.' . $image_ext;
            $image_upload_path = 'uploads/' . $image_new_name;

            // Ensure the 'uploads' directory exists
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }

            // Move the file to the uploads directory
            if (move_uploaded_file($image_tmp, $image_upload_path)) {
                $image = $image_upload_path;
            } else {
                $error = "Failed to upload the image.";
            }
        } else {
            $error = "Invalid image format or size exceeded (max: 5MB).";
        }
    }

    if (!$error) {
        // Update user details in the database
        $sql = "UPDATE user_details SET 
        height = '$height', nakshatra = '$nakshatra', raasi = '$raasi', 
        resident = '$resident', native_place = '$native_place', complexion = '$complexion', 
        marital_status = '$marital_status', qualification = '$qualification', job = '$job'";

        // Include image in the query if uploaded
        if (!empty($image)) {
            $sql .= ", user_image = '$image'";
        }

        $sql .= " WHERE id = '{$_SESSION['user_id']}'";

        if (mysqli_query($conn, $sql)) {
            $success = "Details updated successfully!";
            header('Location: user-profile.php');
            exit();
        } else {
            $error = "Error updating details: " . mysqli_error($conn);
        }
    }
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

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div style="background-color: rgb(222, 222, 241); min-height: 100vh; padding: 20px 0;">

    <section class="register">
        <div class="container mt-5">
            <div class="row bg-white rounded shadow p-4">
                <div class="col-md-6">
                    <img src="images/form-img2.jpg" alt="Form Illustration" class="img-fluid rounded" style="max-height: 800px;">
                </div>
                <div class="col-md-6">
                    <div class="form-container">
                        <h3 class="text-center mb-4">Additional Personal Information</h3>

                        <form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="height">Height*</label>
                                    <input type="text" name="height" class="form-control" placeholder="e.g., 5'6\" or 168 cm" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nakshatra">Nakshatra*</label>
                                    <select name="nakshatra" class="form-control" required>
                                        <option value="">Select Nakshatra</option>
                                        <option value="Ashwini">Ashwini</option>
                                        <option value="Bharani">Bharani</option>
                                        <option value="Kritika">Kritika</option>
                                        <option value="Rohini">Rohini</option>
                                        <option value="Mrigashira">Mrigashira</option>
                                        <option value="Ardra">Ardra</option>
                                        <option value="Punarvasu">Punarvasu</option>
                                        <option value="Pushya">Pushya</option>
                                        <option value="Ashlesha">Ashlesha</option>
                                        <option value="Magha">Magha</option>
                                        <option value="Purva Phalguni">Purva Phalguni</option>
                                        <option value="Uttara Phalguni">Uttara Phalguni</option>
                                        <option value="Hasta">Hasta</option>
                                        <option value="Chitra">Chitra</option>
                                        <option value="Swati">Swati</option>
                                        <option value="Vishakha">Vishakha</option>
                                        <option value="Anuradha">Anuradha</option>
                                        <option value="Jyeshtha">Jyeshtha</option>
                                        <option value="Mula">Mula</option>
                                        <option value="Purva Ashadha">Purva Ashadha</option>
                                        <option value="Uttara Ashadha">Uttara Ashadha</option>
                                        <option value="Shravana">Shravana</option>
                                        <option value="Dhanishta">Dhanishta</option>
                                        <option value="Shatabhisha">Shatabhisha</option>
                                        <option value="Purva Bhadrapada">Purva Bhadrapada</option>
                                        <option value="Uttara Bhadrapada">Uttara Bhadrapada</option>
                                        <option value="Revati">Revati</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="raasi">Raasi*</label>
                                    <select name="raasi" class="form-control" required>
                                        <option value="">Select Raasi</option>
                                        <option value="Mesha">Mesha (Aries)</option>
                                        <option value="Vrishabha">Vrishabha (Taurus)</option>
                                        <option value="Mithuna">Mithuna (Gemini)</option>
                                        <option value="Karka">Karka (Cancer)</option>
                                        <option value="Simha">Simha (Leo)</option>
                                        <option value="Kanya">Kanya (Virgo)</option>
                                        <option value="Tula">Tula (Libra)</option>
                                        <option value="Vrishchika">Vrishchika (Scorpio)</option>
                                        <option value="Dhanu">Dhanu (Sagittarius)</option>
                                        <option value="Makara">Makara (Capricorn)</option>
                                        <option value="Kumbha">Kumbha (Aquarius)</option>
                                        <option value="Meena">Meena (Pisces)</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="resident">Resident*</label>
                                    <input type="text" name="resident" class="form-control" placeholder="Enter your resident" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="native_place">Native Place*</label>
                                    <input type="text" name="native_place" class="form-control" placeholder="Enter your native place" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="complexion">Complexion*</label>
                                    <select name="complexion" class="form-control" required>
                                        <option value="">Select Complexion</option>
                                        <option value="Fair">Fair</option>
                                        <option value="Wheatish">Wheatish</option>
                                        <option value="Dusky">Dusky</option>
                                        <option value="Dark">Dark</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="marital_status">Marital Status*</label>
                                <select name="marital_status" class="form-control" required>
                                    <option value="">Select Marital Status</option>
                                    <option value="Single">Single</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="qualification">Qualification*</label>
                                    <select name="qualification" class="form-control" required>
                                        <option value="">Select Qualification</option>
                                        <option value="High School">High School</option>
                                        <option value="Diploma">Diploma</option>
                                        <option value="Degree">Degree</option>
                                        <option value="Masters">Masters</option>
                                        <option value="PhD">PhD</option>
                                        <option value="Professional">Professional Course</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="job">Job*</label>
                                    <input type="text" name="job" class="form-control" placeholder="Enter your job" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_image">Upload Image</label>
                                <input type="file" name="user_image" class="form-control" accept="image/*">
                                <small class="form-text text-muted">Upload a clear photo (JPG, PNG, GIF - Max 5MB)</small>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-lg">
                                <i class="fas fa-save"></i> Submit & Continue
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('includes/footer.php'); ?>
