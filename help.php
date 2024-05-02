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

<div class="titleBox" onclick="toggleContent('contentBox1')">Compound Parameters in Search Page</div>
<div id="contentBox1" class="contentBox">
    <pre>
ID:      the compound id
natm:    the number of atoms in the compound
ncar:    the number of carbons in the compound
nnit:    the number of nitrogens in the compound
noxy:    the number of oxygens in the compound
nsul:    the numbers of sulphurs in the compound
ncycl:   the number of cycles in the compound
nhdon:   the number of hydrogen donors
nhacc:   the number of hydrogen acceptors
nrotb:   the number of rotatable bonds
ManuID:  the compound manufacturer
catn:    the catalogue name
mw:      the molecular weight
TPSA:    the Polar surface area
XLogP:   an estimate of the logP of the compound
</pre>
</div>
<br>
<div class="titleBox" onclick="toggleContent('contentBox2')">Compound Parameters in Stats Page</div>
<div id="contentBox2" class="contentBox">
    <pre>
n atoms:       The number of atoms in a compound.
n carbons:     The number of carbon atoms in a compound.
n nitrogens:   The number of nitrogen atoms in a compound.
n oxygens:     The number of oxygen atoms in a compound.
n sulphurs:    The number of sulphur atoms in a compound.
n cycles:      The number of ring structures in a compound.
n H donors:    The number of donors in a compound that can provide hydrogen bonding.
n H acceptors: The number of acceptors in a compound that can accept hydrogen bonds.
n rot bonds:   The number of rotatable bonds in a compound.
mol wt:        The molecular weight of the compound.
TPSA:          The Total Polar Surface Area of the compound.
XLogP:         An estimate of the LogP value of the compound.

</pre>
</div>

<script src="interface.js"></script>
</div>
</body>
</html>

_HEAD1;

include 'footerbar.html';
?>