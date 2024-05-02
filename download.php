<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="search_results.csv"');
session_start();
require_once 'login.php';
if (!empty($_SESSION['compsel'])) {
    $compsel = $_SESSION['compsel'];
    $params = $_SESSION['query_params'];

    $pdo = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare($compsel);
    foreach ($params as $param => $value) {
        $stmt->bindValue($param, $value);
    }
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ??PHP???????
    $output = fopen('php://output', 'w');

    // ??CSV??????
    $headers = ['ID','natm','ncar','nnit','noxy','nsul','ncycl','nhdon','nhacc',
            'nrotb','ManuID','catn','mw','TPSA','XLogP'];
    fputcsv($output, $headers);

    // ?????????CSV??
    foreach ($results as $row) {
        fputcsv($output, $row); // ??$row??????????????CSV?
    }

    fclose($output);
    exit();
} else {
    echo "No results to download.";
}

?>