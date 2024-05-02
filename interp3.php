<?php

session_start();
include 'redir.php';
require_once 'login.php';
include 'header.html';

echo <<<_HEAD1
<html>
<head>
<link rel="stylesheet" href="global.css">
</head>
<body>
<div class="main-content">
_HEAD1;
include 'menuf.php';
$dbfs = array("natm", "ncar", "nnit", "noxy", "nsul", "ncycl", "nhdon", "nhacc", "nrotb", "mw", "TPSA", "XLogP");
$nms = array("n atoms", "n carbons", "n nitrogens", "n oxygens", "n sulphurs", "n cycles", "n H donors", "n H acceptors", "n rot bonds", "mol wt", "TPSA", "XLogP");
echo <<<_MAIN1
    <pre>
This is the Statistics Page  (not Complete)
    </pre>
_MAIN1;
if (isset($_POST['tgval'])) {
    $chosen = 0;
    $tgval = $_POST['tgval'];
    for ($j = 0; $j < sizeof($dbfs); ++$j) {
        if (strcmp($dbfs[$j], $tgval) == 0) $chosen = $j;
    }
    printf(" Statistics for %s (%s)<br />\n", $dbfs[$chosen], $nms[$chosen]);
// THE CONNECTION AND QUERY SECTIONS NEED TO BE MADE TO WORK FOR PHP 8 USING PDO... //
    //Your mysql and statistics calculation goes here
    try {
        // Create a new PDO connection
        $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL query
        $query = sprintf("SELECT AVG(%s), STD(%s) FROM Compounds", $dbfs[$chosen], $dbfs[$chosen]);
        // As a best practice, use prepared statements to prevent SQL injection
        $stmt = $pdo->prepare($query);

        // Execute the query
        $stmt->execute();

        // Fetch the results
        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row) {
            printf("Average %f  Standard Dev %f <br />\n", $row[0], $row[1]);
        } else {
            echo "No results found.";
        }
    } catch (PDOException $e) {
        die("Unable to connect to database: " . $e->getMessage());
    }
}
echo '<form action="p3.php" method="post"><pre>';
for ($j = 0; $j < sizeof($dbfs); ++$j) {
    if ($j == 0) {
        printf(' %15s <input type="radio" name="tgval" value="%s" checked"/>', $nms[$j], $dbfs[$j]);
    } else {
        printf(' %15s <input type="radio" name="tgval" value="%s"/>', $nms[$j], $dbfs[$j]);
    }
    echo "\n";
}
echo '<input type="submit" value="OK" />';
echo '</pre></form>';
echo <<<_TAIL1
</div>
</body>
</html>
_TAIL1;
include 'footerbar.html';


