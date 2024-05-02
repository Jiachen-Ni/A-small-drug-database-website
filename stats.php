<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'login.php';
include 'redir.php';
include 'header.html';
?>


<html>
<head>
    <link rel="stylesheet" href="global.css">
</head>
<body>
<div class="main-content">

    <div class="bigbox">
        <div class="leftBox" style="flex-basis: 20%;margin-right:20px;">
            <div class="titleBox">Select Suppliers</div>
            <div id="selectsuppliers" class="normalBox">
                <?php include 'p1new.php';?>
            </div><br>
        </div>

        <div class="rightBox" style="flex-grow: 1; overflow: auto;">
            <div class="titleBox">Statistics</div>
            <div id="statistics" class="normalBox">
                <?php include 'p3new.php';?>
            </div><br>
        </div>
    </div>

    <div class="titleBox">Data Histogram</div>

    <div class="bigbox">
        <div class="leftBox" style="flex-basis: 20%;margin-right:20px;">
            <div id="histogram" class="normalBox">
                <?php include 'histogram.php';?>
            </div><br>
        </div>

        <div class="rightBox" style="flex-grow: 1; overflow: hidden;">
            <div id="histogramout" class="normalBox">
                <?php include 'histogramout.php';?>
            </div><br>
        </div>
    </div>

</div>
<script src="interface.js"></script>
</body>
</html>

<?php include 'footerbar.html';?>


