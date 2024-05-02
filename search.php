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

        <div class="rightBox" style="flex-grow: 1;">
            <div class="titleBox" onclick="toggleContent('searchcompounds')">Search Compounds</div>
            <div id="searchcompounds" class="contentBox">
                <?php include 'p2new.php';?>
            </div><br>
        </div>
    </div>



</div>
<script src="interface.js"></script>
</body>
</html>

<?php include 'footerbar.html';?>


