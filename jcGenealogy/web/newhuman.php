<?php
include"/etc/jcGenealogy/load.php";
if ($loggedin === true) {
        if ($_POST['form'] !== "newhuman") {
                echo"Hello, " . $_SESSION['email'] . "!";
                echo "
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
                                <p><b>Date of death: </b><input type='date' name='deaddate' id='dead'></p>
                                <input type='hidden' name='form' value='newhuman'>
                                
                                <input type='submit'>
                        </form>
			<script src='newhuman.js'></script>
                        ";
        } else {
                $nameArray = explode(" ", $_POST['name']);
		if ($_POST['alive'] == "on") {
			$alive = 1;	
		} else {
			$alive = 0;	
		}
                $mysqli->query("INSERT INTO humans (firstname, lastname, alive, deathdate) VALUES ('" . $nameArray[0] . "', '" . $nameArray[sizeof($nameArray) - 1]. "', '" . $alive . "', '" . $_POST['deaddate'] . "')");
        }
} else {
        echo "Not logged in!!!";
}
?>
