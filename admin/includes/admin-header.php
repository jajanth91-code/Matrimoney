<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_username'])) {
    // Allow access only to login page
    $current_page = basename($_SERVER['PHP_SELF']);
    if ($current_page !== 'index.php' && $current_page !== 'adminlogin.php') {
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Admin Panel - Thirumangalyam Matrimony'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admincss/admincss.css">
    <style>
        .admin-sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .admin-content {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .sidebar-link {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            border-radius: 8px;
            margin: 5px 10px;
            transition: all 0.3s ease;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background-color: rgba(255,255,255,0.2);
            color: white;
            text-decoration: none;
        }
        .admin-header {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
    </style>
</head>
<body>

<?php if (isset($_SESSION['admin_id'])): ?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 admin-sidebar p-0">
            <div class="p-4">
                <div class="text-center mb-4">
                    <img src="../images/logo1.png" alt="Logo" style="max-height: 60px;" class="mb-2">
                    <h5 class="text-white">Admin Panel</h5>
                </div>
                
                <nav class="nav flex-column">
                    <a href="dashboard.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="manage-users.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage-users.php' ? 'active' : ''; ?>">
                        <i class="fas fa-users me-2"></i> Manage Users
                    </a>
                    <a href="user-interests.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'user-interests.php' ? 'active' : ''; ?>">
                        <i class="fas fa-heart me-2"></i> User Interests
                    </a>
                    <a href="contact-messages.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact-messages.php' ? 'active' : ''; ?>">
                        <i class="fas fa-envelope me-2"></i> Contact Messages
                    </a>
                    <a href="reports.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'reports.php' ? 'active' : ''; ?>">
                        <i class="fas fa-chart-bar me-2"></i> Reports
                    </a>
                    <a href="settings.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
                        <i class="fas fa-cog me-2"></i> Settings
                    </a>
                    <hr class="text-white-50">
                    <a href="logout.php" class="sidebar-link" onclick="return confirm('Are you sure you want to logout?')">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 admin-content p-0">
            <!-- Header -->
            <div class="admin-header">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 text-primary"><?php echo isset($page_title) ? $page_title : 'Admin Dashboard'; ?></h4>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-shield"></i> <?php echo $_SESSION['admin_username']; ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="logout.php" onclick="return confirm('Are you sure you want to logout?')"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="container-fluid p-4">
<?php endif; ?>