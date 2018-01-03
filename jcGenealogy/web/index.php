<?php
// If you are reading this in your browser, you do not have PHP, which is required for jcGenealogy.
include "/etc/jcGenealogy/mysqlconf.php";

function generateRandomString($length = 16) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
$code = generateRandomString();
$mysqli->query("TRUNCATE TABLE accesscodes");
$mysqli->query("INSERT INTO accesscodes (code, expires) VALUES ('" . $code . "', '" . date(u) + 600 . "')");
echo "<a href='register.php'>Register</a> an account and enter the access code <code>" . $code . "</code>. You have 10 minutes.";
?>
