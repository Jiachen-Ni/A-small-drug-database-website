<?php
session_start();
require_once 'login.php';
if (isset($_POST['fn']) && isset($_POST['sn'])) {
    $_SESSION['forname'] = $_POST['fn'];
    $_SESSION['surname'] = $_POST['sn'];
}


if (!empty($_SESSION['forname']) && !empty($_SESSION['surname'])) {
    $forname = $_SESSION['forname'];
    $surname = $_SESSION['surname'];

    include 'header.html';
    echo<<<_HEAD1
    <html>
    <head>
    <link rel="stylesheet" href="global.css">
    </head>
    <body>
    <div class="main-content">
    _HEAD1;

    echo "<div class=titleBox>";
    echo "<div class = welcome>";

    $hour = date("H");
    if ($hour >= 5 && $hour < 12) {
        echo "Good morning,";

    } elseif ($hour >= 18 || $hour < 5) {
        echo "Good evening,";
    } else {
        echo "Good afternoon,";
    }
    echo " $forname!";

      try {
          $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          echo "<br>Welcome to the Drug Discovery Database!!<br><br>";
      } catch (PDOException $e) {
          die("Unable to connect to database: " . $e->getMessage());
      }
        echo "</div>";
        echo 'Click the navigation bar above to start your compound exploration journey!<br>';
        echo 'Looking for guidence: <a href="help.php">help</a>.<br>';
        echo 'Contact us: <a href="about.php">about</a>.<br><br>';
        echo "</div><br>";

// ?? PDO ?????
    try {
        $query = "SELECT * FROM Manufacturers";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $manufacturers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo <<<_boxstart
            <div class="titleBox" onclick="toggleContent('contentBox3')">Manufacturers table</div>
            <div id="contentBox3" class="contentBox">
            _boxstart;
        echo "<table class='manu-table'>";
        echo '<tr><th>ID</th><th>Manufacturer</th><th>Contact</th></tr>';
        // Loop through the $manufacturers array to add the data rows
        foreach ($manufacturers as $row) {
            echo "<tr>";
            echo "<td style='border: 1px solid transparent;'>" . (isset($row['id']) ? $row['id'] : '') . "</td>";
            echo "<td style='border: 1px solid transparent;'>" . (isset($row['name']) ? $row['name'] : '') . "</td>";
            echo "<td style='border: 1px solid transparent;'>" . (isset($row['contact']) ? $row['contact'] : '') . "</td>";
            echo "</tr>";
        }
        // Close the table
        echo '</table></div>';


    } catch (PDOException $e) {
        die("Unable to process query: " . $e->getMessage());
    }

    $rows = count($manufacturers);
    $mask = 0;
    for ($j = 0; $j < $rows; ++$j) {
        $mask = (2 * $mask) + 1;
    }
    $_SESSION['supmask'] = $mask;

    echo <<<_TAIL1
    </div>
    <script src="interface.js"></script>
    </body>
    </html>
    _TAIL1;
    include 'footerbar.html';
  } else {
    header('location: https://bioinfmsc8.bio.ed.ac.uk/~s2441797/complib.php');
  }
?>
