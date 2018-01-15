<?php
include"/etc/jcGenealogy/load.php";
if ($loggedin === true) {
        echo"Hello, " . $_SESSION['email'] . "!";
        echo "
                <b>Add a human!</b>
                <form method='POST' action='newhuman.php'>
                        <p><b>Full name: </b><input name='name'></p>
                        <p><input type='checkbox' id='alive' name='alive'>
                        <label for='alive'>Alive</label></p>
                        <p><input type='checkbox' id='me' name='me'>
                        <label for='me'>This is ME!</label></p>
                </form>
        ";
} else {
        echo "Not logged in!!!";
}
?>
