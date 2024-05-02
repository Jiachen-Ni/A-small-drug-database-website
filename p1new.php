<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'login.php';
include 'redir.php';
echo <<<_HEAD1
<html>
<head>
<link rel="stylesheet" href="global.css">
</head>
<body>
_HEAD1;

// PDO Connection
try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Unable to connect to database: " . $e->getMessage());
}

// Query to select all manufacturers
try {
    $stmt = $pdo->query("SELECT * FROM Manufacturers");
    $manufacturers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Unable to process query: " . $e->getMessage());
}
$rows = count($manufacturers);
$sid = array_column($manufacturers, 'id');
$snm = array_column($manufacturers, 'name');
$sact = array_fill(0, $rows, 0);

$smask = $_SESSION['supmask'];

foreach ($manufacturers as $index => $row) {
    $tvl = 1 << ($row['id'] - 1);
    if ($tvl == ($tvl & $smask)) {
        $sact[$index] = 1;
    }
}


if (isset($_POST['supplier'])) {
    $supplier = $_POST['supplier'];
    $sact = array_fill(0, $rows, 0);
    foreach ($manufacturers as $index => $row) {
        if (in_array($row['name'], $supplier)) {
            $sact[$index] = 1;
        }
    }

    $smask = 0;
    foreach ($sact as $index => $isActive) {
        if ($isActive) {
            $smask |= 1 << ($sid[$index] - 1);
        }
    }
    $_SESSION['supmask'] = $smask;
}


echo '<br><br><form action="#" method="post" class="supplier-form">';
echo '<div class="supplier-list">';
foreach ($snm as $index => $name) {
    $checked = $sact[$index] ? 'checked' : '';
    echo '<label class="supplier-item">';
    echo ' <input type="checkbox" name="supplier[]" value="' . htmlspecialchars($name) . '" ' . $checked . '>';
    echo htmlspecialchars($name) . '</label><br>';
}
echo '</div>';
echo '<br><input type="submit" value="Save Selection" />';
echo '</form>';

echo <<<_TAIL1
</body>
</html>
_TAIL1;

