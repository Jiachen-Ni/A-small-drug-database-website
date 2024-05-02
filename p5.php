<?php
session_start();
include 'redir.php';
$fn = $_SESSION['forname'];
$_SESSION = array();
if( session_id() != "" || isset($_COOKIE[session_name()])) {
  setcookie(session_name(), '', time() - 2592000, '/');
}
session_destroy();

include 'header.html';

echo <<<_HEAD1
<html>
<head>
  <link rel="stylesheet" href="global.css">
  <script type="text/javascript">
    var timeLeft = 5; // ?????????
    function countdown() {
      document.getElementById("countdown").innerHTML = "The page will automatically jump after "+timeLeft+" seconds.";
      timeLeft--;
      if (timeLeft >= 0) {
        setTimeout(countdown, 1000);
      } else {
        window.location.href = "complib.php"; // ??????????URL
      }
    }
    window.onload = countdown;
  </script>
</head>
<body>
<div class="main-content">
_HEAD1;

echo <<<_MAIN1
<div class=titleBox>
<div class = welcome>
Goodbye, $fn<br><br>
You have now exited Complib<br><br>
  <div id="countdown"></div><br> <!-- ????? -->
  <a href="complib.php">Click here to jump to Login Page immediately</a>
</div>
_MAIN1;

echo <<<_TAIL1
</div>
</div>
</body>
</html>
_TAIL1;

include 'footerbar.html';
?>
