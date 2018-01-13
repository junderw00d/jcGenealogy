<?php
// If you are reading this in your browser, you do not have PHP, which is required for jcGenealogy.
include "/etc/jcGenealogy/load.php";
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
$mysqli->query("INSERT INTO access_codes (code, expires, original) VALUES ('" . $code . "', '" . $expires . "', '1')");
echo"
<form action='register.php' method='post'>
<input name='begin' type='hidden' value='true'>
<input name='accesscode' type='hidden' value='" . $code . "'>
<input type='submit' value='Begin using jcGenealogy'>
";
?>
