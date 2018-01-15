<?php
include"/etc/jcGenealogy/load.php";
if ($loggedin === true) {
        if ($_POST['form'] !== "newhuman") {
                echo"Hello, " . $_SESSION['email'] . "!";
                echo "
                        <script src='newhuman.js'></script>
                        <b>Add a human!</b>
                        <form method='POST' action='newhuman.php'>
                                <p><b>Full name: </b><input name='name'></p>
                                <p>
                                        <input type='checkbox' id='alive' name='alive'>
                                        <label for='alive'>Alive</label>
                                </p>
                                <p>
                                        <input type='checkbox' id='me' name='me'>
                                        <label for='me'>This is ME!</label>
                                </p>
                                <input type='date' name='dead' id='dead'>
                                <input type='hidden' name='form' value='newhuman'>
                                <input type='hidden' name='deathhidden' id='deathhidden'>
                                <input type='submit'>
                        </form>
                        
                        ";
        } else {
                $nameArray = explode(" ", $_POST['name']);
                echo "It looks like you want to add a human with... name1=" . $nameArray[0] . "and two=" . $nameArray[sizeof($nameArray) - 1];
                
        }
} else {
        echo "Not logged in!!!";
}
?>
