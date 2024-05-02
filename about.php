<?php
session_start();
require_once 'login.php';
include 'header.html';

echo<<<_HEAD1
<html>
<head>
<link rel="stylesheet" href="global.css">
</head>
<body>
<div class="main-content">

<div class="titleBox" onclick="toggleContent('contentBox1')">Website Introduction</div>
<div id="contentBox1" class="contentBox">
    <p>
Welcome to our Drug Discovery Database website! 
This website aims to provide an interactive platform to help students and researchers explore compound information in 
depth through data mining and pharmacophore search capabilities.
</p>
</div>
<br>

<div class="titleBox" onclick="toggleContent('contentBox2')">Data sources</div>
<div id="contentBox2" class="contentBox">
    <p>
These molecules were extracted from the <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC3013767/" target="_blank">EDULISS<a> (EDinburgh University Ligand Selection System) molecule database, 
a small molecule database with data mining and pharmacophore search capabilities, maintained by the University of Edinburgh.
<br>The molecules included in the database are from the following manufacturers:
<br>Asinex
<br>KeyOrganics
<br>MayBridge
<br>Nanosyn
<br>Oai40000
</p>
</div>
<br>

<div class="titleBox" onclick="toggleContent('contentBox3')">Team and Contact Information</div>
<div id="contentBox3" class="contentBox">
    <p>
This website is developed and maintained by a student. The student wishes to remain anonymous and will only refer to himself as -- s2441797.
<br><br>
If you have any comments or suggestions about this website, please feel free to contact:
<br><br>
Email: s2441797@ed.ac.uk
</p>
</div>
<br>


<div class="titleBox" onclick="toggleContent('contentBox4')">Funding Information</div>
<div id="contentBox4" class="contentBox">
    <p>
Thanks to the University of Edinburgh for sponsoring $5 !!!(not yet available).
</p>
</div>
<br>
<script src="interface.js"></script>
</div>
</body>
</html>

_HEAD1;

include 'footerbar.html';
?>