<?php
session_start();
echo"Hello, " . $_SESSION['email'] . "!";

echo "
<b>Add a human!</b>
<form method='POST' action='newhuman.php'>
<input type='checkbox' id='me' name='me'>
<label for='me'>This is ME!</label>
</form>
";
?>
