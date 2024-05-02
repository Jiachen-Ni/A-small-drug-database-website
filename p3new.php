<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'login.php';
include 'redir.php';
echo<<<_HEAD1
<html>
<head>
<link rel="stylesheet" href="global.css">
</head>
<body>
_HEAD1;

$dbfs = array("natm", "ncar", "nnit", "noxy", "nsul", "ncycl", "nhdon", "nhacc", "nrotb", "mw", "TPSA", "XLogP");
$nms = array("n atoms", "n carbons", "n nitrogens", "n oxygens", "n sulphurs", "n cycles", "n H donors", "n H acceptors", "n rot bonds", "mol wt", "TPSA", "XLogP");

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to select all manufacturers using PDO
    $stmt = $pdo->query("SELECT * FROM Manufacturers");
    $manufacturers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Process manufacturers data
    $smask = $_SESSION['supmask'];
    $firstmn = false;
    $mansel = "(";
    foreach ($manufacturers as $index => $row) {
        $sid[$index] = $row['id'];
        $snm[$index] = $row['name'];
        $sact[$index] = 0;
        $tvl = 1 << ($sid[$index] - 1);
        if ($tvl == ($tvl & $smask)) {
            $sact[$index] = 1;
            $mansel .= $firstmn ? " OR " : "";
            $firstmn = true;
            $mansel .= "(ManuID = " . $pdo->quote($sid[$index]) . ")";
        }
    }
    $mansel .= ")";


} catch (PDOException $e) {
    die("Unable to connect to database: " . $e->getMessage());
}


// ??????
echo "<table class=results-table>";
echo "<tr><th>Field</th><th>Average</th><th>Standard Deviation</th></tr>";

// ??????
foreach ($dbfs as $index => $field) {
    try {
        // ?????????
        $query = sprintf("SELECT AVG(%s) AS avg_val, STD(%s) AS std_dev FROM Compounds WHERE %s", $field, $field, $mansel);
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // ??????
        if ($row) {
            // ???????????
            echo "<tr><td>{$nms[$index]}</td><td>{$row['avg_val']}</td><td>{$row['std_dev']}</td></tr>";
        }
    } catch (PDOException $e) {
        die("Unable to connect to database: " . $e->getMessage());
    }
}

// ????
echo "</table>";
echo <<<_TAIL1
</body>
</html>
_TAIL1;


