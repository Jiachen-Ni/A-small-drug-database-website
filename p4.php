<?php
session_start();
include 'redir.php';
require_once 'login.php';
include 'header.html';

echo<<<_HEAD1
<html>
<head>
<link rel="stylesheet" href="global.css">
</head>
<body>
<div class="main-content">
_HEAD1;

$dbfs = array("natm","ncar","nnit","noxy","nsul","ncycl","nhdon","nhacc","nrotb","mw","TPSA","XLogP");
$nms = array("n atoms","n carbons","n nitrogens","n oxygens","n sulphurs","n cycles","n H donors","n H acceptors","n rot bonds","mol wt","TPSA","XLogP");

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

echo '<div class="show-supplier"><br><label for="sup0"><span class="text-background">Currently selected Suppliers: ';
foreach ($sact as $index => $isActive) {
    if ($isActive) {
        echo htmlspecialchars($snm[$index]) . ", ";
    }
}
echo '</span></label></div>';

if(isset($_POST['tgval']) && isset($_POST['tgvalb']))
{
    $chosen = 0;
    $tgval = $_POST['tgval'];
    $tgvalb = $_POST['tgvalb'];
    for($j = 0 ; $j <sizeof($dbfs) ; ++$j) {
        if(strcmp($dbfs[$j],$tgval) == 0) $chosen = $j;
    }
    for($j = 0 ; $j <sizeof($dbfs) ; ++$j) {
        if(strcmp($dbfs[$j],$tgvalb) == 0) $chosenb = $j;
    }

    $comtodo = "./correlate3.py ".$dbfs[$chosen]." ".$dbfs[$chosenb]." \"".$mansel."\"";
    printf(" Correlation for %s (%s) vs %s (%s) :\n",$dbfs[$chosen],$nms[$chosen],$dbfs[$chosenb],$nms[$chosenb]);
    $rescor = system($comtodo);
    printf("\n");


}

echo '<form action="p4.php" method="post"><pre>';
for($j = 0 ; $j <sizeof($dbfs) ; ++$j) {
    if($j == 0) {
        printf(' %15s <input type="radio" name="tgval" value="%s" checked"/> %15s <input type="radio" name="tgvalb" value="%s" checked"/>',
$nms[$j],$dbfs[$j],$nms[$j],$dbfs[$j]);
  } else {
     printf(' %15s <input type="radio" name="tgval" value="%s"/>  %15s <input type="radio" name="tgvalb" value="%s"/>',$nms[$j],$dbfs[$j],$nms[$j],$dbfs[$j]);
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

?>