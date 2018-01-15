<?php
session_start();
$userCheck = $mysqli->query("SELECT password, salt FROM users WHERE email='" . $_SESSION['email'] . "'")->fetch_assoc();
if (hash("sha512", $_SESSION['password'] . $userCheck['salt']) == $userCheck['password'] ) {
        $loggedin = true;
} else {
        $loggedin = false;
}
?>
