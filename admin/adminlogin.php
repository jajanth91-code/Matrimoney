<?php
session_start();
include_once '../Database/Db-Connect.php';

if (isset($_POST['uname']) && isset($_POST['password'])) {
    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: index.php?error=User Name is required");
        exit();
    } else if (empty($pass)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        // Use prepared statement for security
        $sql = "SELECT * FROM admin WHERE user_name = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            
            // Verify password (assuming passwords are hashed)
            // For now, using plain text comparison - should be updated to use password_verify()
            if ($pass === $row['password']) {
                $_SESSION['admin_username'] = $row['user_name'];
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_email'] = $row['email'];
                
                // Log the login
                $login_time = date('Y-m-d H:i:s');
                $ip_address = $_SERVER['REMOTE_ADDR'];
                
                header("location: dashboard.php");
                exit();
            } else {
                header("Location: index.php?error=Incorrect Username or Password");
                exit();
            }
        } else {
            header("Location: index.php?error=Incorrect Username or Password");
            exit();
        }
    }
} else {
    header("location: index.php");
    exit();
}
?>
