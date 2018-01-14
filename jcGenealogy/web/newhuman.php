<?php
session_start();
echo"Hello, " . $_SESSION['email'] . "!";

echo "
<b>Add a human!</b>
<form method='POST' action='newhuman.php'>
<p><b>Full name: </b><input name='name'></p>

<input type='checkbox' id='alive' name='alive'>
<label for='alive'>Alive</label>

<input type='checkbox' id='me' name='me'>
<label for='me'>This is ME!</label>
</form>
";
?>
