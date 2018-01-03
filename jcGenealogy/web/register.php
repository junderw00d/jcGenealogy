<?php
if ($_POST['register'] === null) {
        echo "
        <form action='register.php' method='POST'>
                <p><b>Email: </b><input type='email' name='email' required></p>
                <p><b>Password: </b><input type='password' name='password' required></p>
                <p><b>Confirm Password: </b><input type='password' name='confirmpassword' required></p>
                <p><b>Access Code: </b><input name='accesscode' required></p>
                <input type='hidden' name='register' value='true'>
                <input type='submit'>
        </form>
        ";
} else {
        include "/etc/jcGenealogy/mysqlconf.php";
        $accessCheck = $mysqli->query("SELECT * FROM access_codes WHERE code='" . $_POST['accesscode'] . "' AND expires > '" . date(U) . "'");
        if ($accessCheck->num_rows === 0) {
                echo "No such access code, or the access code is expired.";
        } else {
                if ($accessCheck->fetch_object()->original == 1) {
                        echo "Welcome to jcGenealogy.";
                } else {
                	echo "<form id='selectHumanForm' method='POST' action='register.php'>";
                	echo "<select name='humanLink' id='select' form='selectHumanForm'>";
                	$humanGen = $mysqli->query("SELECT * FROM humans ORDER BY lastname");
                	while ($humanGenResult = $humanGen->fetch_assoc()) {
                	        echo "<option"; 
                	        if ($humanGenResult['alive'] == 0) {
                	        	echo " disabled";
                	        }
                        echo" value='" . $humanGenResult['id'] . "'>" . $humanGenResult['firstname'] . " " . $humanGenResult['lastname'] . "</option>";
                	}
               		echo "</select><br>";
                	echo "<input type='submit'></form>";
                	echo "<button onclick='idwt'>I do not want to link my account to a member of the family tree.</button>";
		}
        }
}
?>
