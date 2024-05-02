<?php
session_start();
require_once 'login.php';
include 'redir.php';
include 'header.html';


echo<<<_HEAD1
<html>
<head>
<link rel="stylesheet" href="global.css">
</head>
<body>
<div class="main-content">
_HEAD1;

// PDO Connection
try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Unable to connect to database: " . $e->getMessage());
}


echo <<<_getid
    <form action="p6.php" method="POST">
        <label for="catn">Enter Compound Category (catn) to get smiles:</label>
        <input type="text" id="catn" name="catn" required>
        <input type="submit" value="Get smiles">
    </form>
_getid;


if (!empty($_POST['catn'])) {
    echo "Compound Category (catn):" . htmlspecialchars($_POST['catn']) . "<br>";
    try {
        $stmt = $pdo->prepare("SELECT id, catn, ManuID FROM Compounds WHERE catn = :catn");
        $stmt->execute([':catn' => $_POST['catn']]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            foreach ($results as $result) {
                echo "<br>ID: " . htmlspecialchars($result['id']) . "<br>";
                // Determine the modified ID based on ManuID
                $modifiedId = ($result['ManuID'] == 5) ? $result['id'] + 66558 : $result['id'] - 1558;

                // Query the Smiles table for each modified ID
                $stmtSmiles = $pdo->prepare("SELECT smiles FROM Smiles WHERE id = ?");
                $stmtSmiles->execute([$modifiedId]);
                $smilesResult = $stmtSmiles->fetch(PDO::FETCH_ASSOC);

                if ($smilesResult) {
                    echo "Smiles: " . htmlspecialchars($smilesResult['smiles']) . "<br>";
                } else {
                    echo "No corresponding smiles found for ID " . htmlspecialchars($result['id']) . "<br>";
                }
            }
        } else {
            echo "No results found";
        }
    } catch (PDOException $e) {
        die("Unable to process query: " . $e->getMessage());
    }
}





include "smile_draw.php";

echo <<<_TAIL1
</div>
</body>
</html>
_TAIL1;
include 'footerbar.html';
?>
