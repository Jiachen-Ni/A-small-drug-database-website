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

// THE CONNECTION AND QUERY SECTIONS NEED TO BE MADE TO WORK FOR PHP 8 USING PDO... //

$setpar = isset($_POST['natmax']);



echo '<form action="#" method="post" class="filter-form">' ;
echo '<div style="margin-bottom: 20px;font-weight: bold;">Please enter your filtering criteria:</div>';
// Atoms
echo '<div class="filter-section">';
echo '  <div class="label-and-input"><label>Max Atoms' . (isset($_POST['natmax']) && $_POST['natmax'] !== '' ? ': ' . htmlspecialchars($_POST['natmax']) : '') . '</label><input type="text" name="natmax"/></div>';
echo '  <div class="label-and-input"><label>Min Atoms' . (isset($_POST['natmin']) && $_POST['natmin'] !== '' ? ': ' . htmlspecialchars($_POST['natmin']) : '') . '</label><input type="text" name="natmin"/></div>';
echo '</div>';

// Carbons
echo '<div class="filter-section">';
echo '  <div class="label-and-input"><label>Max Carbons' . (isset($_POST['ncrmax']) && $_POST['ncrmax'] !== '' ? ': ' . htmlspecialchars($_POST['ncrmax']) : '') . '</label><input type="text" name="ncrmax"/></div>';
echo '  <div class="label-and-input"><label>Min Carbons' . (isset($_POST['ncrmin']) && $_POST['ncrmin'] !== '' ? ': ' . htmlspecialchars($_POST['ncrmin']) : '') . '</label><input type="text" name="ncrmin"/></div>';
echo '</div>';

// Nitrogens
echo '<div class="filter-section">';
echo '  <div class="label-and-input"><label>Max Nitrogens' . (isset($_POST['nntmax']) && $_POST['nntmax'] !== '' ? ': ' . htmlspecialchars($_POST['nntmax']) : '') . '</label><input type="text" name="nntmax"/></div>';
echo '  <div class="label-and-input"><label>Min Nitrogens' . (isset($_POST['nntmin']) && $_POST['nntmin'] !== '' ? ': ' . htmlspecialchars($_POST['nntmin']) : '') . '</label><input type="text" name="nntmin"/></div>';
echo '</div>';

// Oxygens
echo '<div class="filter-section">';
echo '  <div class="label-and-input"><label>Max Oxygens' . (isset($_POST['noxmax']) && $_POST['noxmax'] !== '' ? ': ' . htmlspecialchars($_POST['noxmax']) : '') . '</label><input type="text" name="noxmax"/></div>';
echo '  <div class="label-and-input"><label>Min Oxygens' . (isset($_POST['noxmin']) && $_POST['noxmin'] !== '' ? ': ' . htmlspecialchars($_POST['noxmin']) : '') . '</label><input type="text" name="noxmin"/></div>';
echo '</div>';

// Submit button
echo '<div class="submit-button-container">';
echo '  <input type="submit" value="Search"/>';
echo '</div>';

echo '</form>';

if($setpar) {
    $conditions = [];
    $params = [];

    if (!empty($_POST['natmax']) && !empty($_POST['natmin'])) {
        $conditions[] = "(natm > :natmin AND natm < :natmax)";
        $params[':natmin'] = $_POST['natmin'];
        $params[':natmax'] = $_POST['natmax'];
    }

    if (!empty($_POST['ncrmax']) && !empty($_POST['ncrmin'])) {
        $conditions[] = "(ncar > :ncrmin AND ncar < :ncrmax)";
        $params[':ncrmin'] = $_POST['ncrmin'];
        $params[':ncrmax'] = $_POST['ncrmax'];
    }

    if (!empty($_POST['nntmax']) && !empty($_POST['nntmin'])) {
        $conditions[] = "(nnit > :nntmin AND nnit < :nntmax)";
        $params[':nntmin'] = $_POST['nntmin'];
        $params[':nntmax'] = $_POST['nntmax'];
    }

    if (!empty($_POST['noxmax']) && !empty($_POST['noxmin'])) {
        $conditions[] = "(noxy > :noxmin AND noxy < :noxmax)";
        $params[':noxmin'] = $_POST['noxmin'];
        $params[':noxmax'] = $_POST['noxmax'];
    }

    if ($conditions) {
        // ?????
        $compsel = "SELECT * FROM Compounds WHERE " . implode(' AND ', $conditions) . " AND " . $mansel;

        $stmt = $pdo->prepare($compsel);
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            // ?????????????
            $_SESSION['compsel'] = $compsel;
            $_SESSION['query_params'] = $params;
            echo "<br><a href='download.php'>Download Results as CSV</a>";
        } else {
            echo "No results found.";
        }


        if (count($results) > 100) {
            echo "Too many results ", count($results), " Max is 100\n";
        } else {
            echo "<table class='results-table'>";
            // ??
            echo "<tr>
                  <th>ID</th>
                  <th>natm</th>
                  <th>ncar</th>
                  <th>nnit</th>
                  <th>noxy</th>
                  <th>nsul</th>
                  <th>ncycl</th>
                  <th>nhdon</th>
                  <th>nhacc</th>
                  <th>nrotb</th>
                  <th>ManuID</th>
                  <th>catn</th>
                  <th>mw</th>
                  <th>TPSA</th>
                  <th>XLogP</th>
               </tr>";
            // ???
            foreach ($results as $row) {
                echo "<tr>";
                foreach ($row as $cell) {
                    echo "<td>" . htmlspecialchars($cell) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
    } else {
        echo "No Query Given\n";
    }

}


echo <<<_TAIL1
</body>
</html>
_TAIL1;
function get_post($pdo, $var) {
    return $pdo->quote($_POST[$var]);
}

?>
