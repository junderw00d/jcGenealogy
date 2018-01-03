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
$expires = date(U) + 600;
$mysqli->query("TRUNCATE TABLE access_codes");
$mysqli->query("INSERT INTO access_codes (code, expires) VALUES ('" . $code . "', '" . $expires . "')");
echo "<a href='register.php'>Register</a> an account and enter the access code <code>" . $code . "</code>. You have 10 minutes.";
?>
