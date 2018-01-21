<?php
include"/etc/jcGenealogy/load.php";
include"/etc/jcGenealogy/checkuser.php";
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
                                <p><b>Date of birth: </b><input type='date' name='birthdate' id='birth'></p>
				<p><input type='radio' name='gender' value='1'> Male</p>
				<p><input type='radio' name='gender' value='0'> Female</p>
				
				<input type='hidden' name='form' value='newhuman'>
                                <input type='submit'>
                        </form>
			<script src='assets/scripts/newhuman.js'></script>
                        ";
        } else {
                $nameArray = explode(" ", $_POST['name']);
		if ($_POST['alive'] == "on") {
			$alive = 1;	
		} else {
			$alive = 0;	
		}
                $mysqli->query("INSERT INTO humans (firstname, lastname, alive, birthdate, deathdate, gender) VALUES ('" . $nameArray[0] . "', '" . $nameArray[sizeof($nameArray) - 1]. "', '" . $alive . "', '" . $_POST['birthdate'] . "', '" . $_POST['deaddate'] . "', '" . $_POST['gender'] . "')");
        	if ($_POST['me'] == "on") {
			$mysqli->query("UPDATE users SET humanid='" . $mysqli->insert_id . "' WHERE id='" . $_SESSION['id'] . "'");
		}
	}
} else {
        echo "Not logged in!!!";
}
?>
