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
// Check if form is filled in

if(isset($_POST['tgval']))
{
    $chosen = 0;
    $tgval = $_POST['tgval'];
// Figure out which radio button was chosen

    for($j = 0 ; $j <sizeof($dbfs) ; ++$j) {
        if(strcmp($dbfs[$j],$tgval) == 0) $chosen = $j;
    }


    $comtodo = "./histog.py " . $dbfs[$chosen] . " \"" . $nms[$chosen] . "\" \"" . $mansel . "\"";
    $shellOutput = shell_exec($comtodo);
    $output = base64_encode($shellOutput !== null ? $shellOutput : '');

    echo <<<_IMGPUT
     <pre>
     <img src="data:image/png;base64,$output" />                                              
     </pre>
_IMGPUT;
}

echo <<<_TAIL1
</body>
</html>
_TAIL1;

?>
