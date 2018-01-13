<?php
include "/etc/jcGenealogy/load.php";
$humanQuery = $mysqli->query("SELECT * FROM humans WHERE ID='" . $_GET['id'] . "'")->fetch_assoc();
echo $humanQuery['firstname'];
?>
