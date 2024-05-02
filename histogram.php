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

echo '<br><br><form action="#" method="post" class="supplier-form">';
echo '<div class="supplier-list">';
foreach ($dbfs as $index => $field) {
    // ????????????????????????
    $checked = $index == 0 ? 'checked' : '';
    echo '<label class="supplier-item">';
    // ????????name?????"tgval"????????
    echo ' <input type="radio" name="tgval" value="' . htmlspecialchars($field) . '" ' . $checked . '>';
    echo htmlspecialchars($nms[$index]) . '</label><br>';
}
echo '</div>';
echo '<br><input type="submit" value="Generate Histogram" />';
echo '</form>';

echo <<<_TAIL1
</body>
</html>
_TAIL1;

?>
