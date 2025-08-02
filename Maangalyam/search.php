 <?php
include('Database/db-connect.php'); // $conn should be MySQLi connection

$min_age = $_GET['min_age'] ?? '';
$max_age = $_GET['max_age'] ?? '';
$nakshatra = $_GET['nakshatra'] ?? '';
$raasi = $_GET['raasi'] ?? '';
$min_height = $_GET['min_height'] ?? '';
$max_height = $_GET['max_height'] ?? '';
$resident = $_GET['resident'] ?? '';

$conditions = [];
$types = '';
$values = [];

if ($min_age !== '') {
    $conditions[] = 'age >= ?';
    $types .= 'i';
    $values[] = $min_age;
}
if ($max_age !== '') {
    $conditions[] = 'age <= ?';
    $types .= 'i';
    $values[] = $max_age;
}
if ($nakshatra !== '') {
    $conditions[] = 'nakshatra LIKE ?';
    $types .= 's';
    $values[] = "%$nakshatra%";
}
if ($raasi !== '') {
    $conditions[] = 'raasi LIKE ?';
    $types .= 's';
    $values[] = "%$raasi%";
}
if ($min_height !== '') {
    $conditions[] = 'height >= ?';
    $types .= 'i';
    $values[] = $min_height;
}
if ($max_height !== '') {
    $conditions[] = 'height <= ?';
    $types .= 'i';
    $values[] = $max_height;
}
if ($resident !== '') {
    $conditions[] = 'resident LIKE ?';
    $types .= 's';
    $values[] = "%$resident%";
}

$sql = "SELECT id, name, gender, age, height, nakshatra, raasi, resident, user_image FROM user_details";
if ($conditions) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql);

if ($conditions) {
    // Create reference array for bind_param
    $bind_names[] = $types;
    for ($i=0; $i<count($values); $i++) {
        $bind_names[] = &$values[$i];
    }

    // Bind parameters dynamically
    call_user_func_array([$stmt, 'bind_param'], $bind_names);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Search Form -->
<h2>🔍 Search Profiles</h2>
<form method="GET" action="">
    Age: <input type="number" name="min_age" value="<?= htmlspecialchars($min_age) ?>" placeholder="Min Age">
    to <input type="number" name="max_age" value="<?= htmlspecialchars($max_age) ?>" placeholder="Max Age"><br><br>

    Height (cm): <input type="number" name="min_height" value="<?= htmlspecialchars($min_height) ?>" placeholder="Min Height">
    to <input type="number" name="max_height" value="<?= htmlspecialchars($max_height) ?>" placeholder="Max Height"><br><br>

    Nakshatra: <input type="text" name="nakshatra" value="<?= htmlspecialchars($nakshatra) ?>"><br><br>
    Raasi: <input type="text" name="raasi" value="<?= htmlspecialchars($raasi) ?>"><br><br>
    Resident: <input type="text" name="resident" value="<?= htmlspecialchars($resident) ?>"><br><br>

    <input type="submit" value="Search">
</form>

<hr>

<!-- Matching Results -->
<h2>👥 Matching Profiles</h2>
<?php if ($result && $result->num_rows > 0): ?>
    <?php while ($user = $result->fetch_assoc()): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <img src="uploads/<?= htmlspecialchars($user['user_image']) ?>" width="100" height="100"><br>
            <strong>Name:</strong> <?= htmlspecialchars($user['name']) ?><br>
            <strong>Gender:</strong> <?= htmlspecialchars($user['gender']) ?><br>
            <strong>Age:</strong> <?= htmlspecialchars($user['age']) ?><br>
            <strong>Height:</strong> <?= htmlspecialchars($user['height']) ?> cm<br>
            <strong>Nakshatra:</strong> <?= htmlspecialchars($user['nakshatra']) ?><br>
            <strong>Raasi:</strong> <?= htmlspecialchars($user['raasi']) ?><br>
            <strong>Resident:</strong> <?= htmlspecialchars($user['resident']) ?><br>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No matching profiles found.</p>
<?php endif; ?>
