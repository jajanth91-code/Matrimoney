<?php
$page_title = "Reports - Admin Panel";
session_start();
include('../Database/db-connect.php');
include('includes/admin-header.php');

// Get statistics
$stats = [];

// Total users
$query = "SELECT COUNT(*) as total FROM user_details WHERE is_active = 1";
$result = mysqli_query($conn, $query);
$stats['total_users'] = mysqli_fetch_assoc($result)['total'];

// Users by gender
$query = "SELECT gender, COUNT(*) as count FROM user_details WHERE is_active = 1 GROUP BY gender";
$result = mysqli_query($conn, $query);
$stats['gender'] = [];
while ($row = mysqli_fetch_assoc($result)) {
    $stats['gender'][$row['gender']] = $row['count'];
}

// Users by marital status
$query = "SELECT marital_status, COUNT(*) as count FROM user_details WHERE is_active = 1 GROUP BY marital_status";
$result = mysqli_query($conn, $query);
$stats['marital_status'] = [];
while ($row = mysqli_fetch_assoc($result)) {
    $stats['marital_status'][$row['marital_status']] = $row['count'];
}

// Monthly registrations (last 12 months)
$query = "SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count 
          FROM user_details 
          WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
          GROUP BY DATE_FORMAT(created_at, '%Y-%m')
          ORDER BY month";
$result = mysqli_query($conn, $query);
$stats['monthly_registrations'] = [];
while ($row = mysqli_fetch_assoc($result)) {
    $stats['monthly_registrations'][$row['month']] = $row['count'];
}

// Interest statistics
$query = "SELECT status, COUNT(*) as count FROM user_interests GROUP BY status";
$result = mysqli_query($conn, $query);
$stats['interests'] = [];
while ($row = mysqli_fetch_assoc($result)) {
    $stats['interests'][$row['status']] = $row['count'];
}

// Contact messages count
$query = "SELECT COUNT(*) as total FROM contact_messages";
$result = mysqli_query($conn, $query);
$stats['contact_messages'] = mysqli_fetch_assoc($result)['total'];

// Age distribution
$query = "SELECT 
    CASE 
        WHEN age BETWEEN 18 AND 25 THEN '18-25'
        WHEN age BETWEEN 26 AND 30 THEN '26-30'
        WHEN age BETWEEN 31 AND 35 THEN '31-35'
        WHEN age BETWEEN 36 AND 40 THEN '36-40'
        WHEN age > 40 THEN '40+'
        ELSE 'Unknown'
    END as age_group,
    COUNT(*) as count
    FROM user_details 
    WHERE is_active = 1 AND age IS NOT NULL
    GROUP BY age_group
    ORDER BY age_group";
$result = mysqli_query($conn, $query);
$stats['age_distribution'] = [];
while ($row = mysqli_fetch_assoc($result)) {
    $stats['age_distribution'][$row['age_group']] = $row['count'];
}
?>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo number_format($stats['total_users']); ?></h4>
                        <p class="mb-0">Total Users</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo number_format(array_sum($stats['interests'])); ?></h4>
                        <p class="mb-0">Total Interests</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-heart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo number_format($stats['contact_messages']); ?></h4>
                        <p class="mb-0">Contact Messages</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-envelope fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo number_format($stats['interests']['accepted'] ?? 0); ?></h4>
                        <p class="mb-0">Successful Matches</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-handshake fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <!-- Gender Distribution -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Gender Distribution</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Gender</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stats['gender'] as $gender => $count): ?>
                            <tr>
                                <td><?php echo ucfirst($gender); ?></td>
                                <td><?php echo number_format($count); ?></td>
                                <td><?php echo round(($count / $stats['total_users']) * 100, 1); ?>%</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Marital Status Distribution -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Marital Status Distribution</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stats['marital_status'] as $status => $count): ?>
                            <tr>
                                <td><?php echo $status; ?></td>
                                <td><?php echo number_format($count); ?></td>
                                <td><?php echo round(($count / $stats['total_users']) * 100, 1); ?>%</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Age Distribution and Interest Status -->
<div class="row mt-4">
    <!-- Age Distribution -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-line"></i> Age Distribution</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Age Group</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stats['age_distribution'] as $age_group => $count): ?>
                            <tr>
                                <td><?php echo $age_group; ?></td>
                                <td><?php echo number_format($count); ?></td>
                                <td><?php echo round(($count / $stats['total_users']) * 100, 1); ?>%</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Interest Status -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-heart"></i> Interest Status</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total_interests = array_sum($stats['interests']);
                            foreach ($stats['interests'] as $status => $count): 
                            ?>
                            <tr>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo $status == 'pending' ? 'warning' : 
                                             ($status == 'accepted' ? 'success' : 'danger'); 
                                    ?>">
                                        <?php echo ucfirst($status); ?>
                                    </span>
                                </td>
                                <td><?php echo number_format($count); ?></td>
                                <td><?php echo $total_interests > 0 ? round(($count / $total_interests) * 100, 1) : 0; ?>%</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Registrations -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-area"></i> Monthly Registrations (Last 12 Months)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Registrations</th>
                                <th>Visual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $max_registrations = max(array_values($stats['monthly_registrations']));
                            foreach ($stats['monthly_registrations'] as $month => $count): 
                            ?>
                            <tr>
                                <td><?php echo date('M Y', strtotime($month . '-01')); ?></td>
                                <td><?php echo number_format($count); ?></td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: <?php echo $max_registrations > 0 ? ($count / $max_registrations) * 100 : 0; ?>%">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Options -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-download"></i> Export Reports</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex">
                    <button class="btn btn-success" onclick="exportToCSV()">
                        <i class="fas fa-file-csv"></i> Export to CSV
                    </button>
                    <button class="btn btn-primary" onclick="window.print()">
                        <i class="fas fa-print"></i> Print Report
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function exportToCSV() {
    // Simple CSV export functionality
    let csv = 'Report Type,Value,Count\n';
    
    // Add gender data
    <?php foreach ($stats['gender'] as $gender => $count): ?>
    csv += 'Gender,<?php echo $gender; ?>,<?php echo $count; ?>\n';
    <?php endforeach; ?>
    
    // Add marital status data
    <?php foreach ($stats['marital_status'] as $status => $count): ?>
    csv += 'Marital Status,<?php echo $status; ?>,<?php echo $count; ?>\n';
    <?php endforeach; ?>
    
    // Create and download file
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.setAttribute('hidden', '');
    a.setAttribute('href', url);
    a.setAttribute('download', 'matrimony_report_' + new Date().toISOString().split('T')[0] + '.csv');
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}
</script>

<?php include('includes/admin-footer.php'); ?>