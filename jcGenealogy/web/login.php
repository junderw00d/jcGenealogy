<?php

if ($_POST['login'] === null) {
        echo "
                <form action='login.php' method='POST'>
                        <p><b>Email: </b><input type='email' name='email'></p>
                        <p><b>Password: <input type='password' name='password'></p>
                        <input type='hidden' name='login' value='1'>
                        <input type='submit' value='Log in'>
                </form>
        ";
} else {
        session_start();
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['password'] = hash("sha512", $_POST['password']);
        include "/etc/jcGenealogy/load.php";
        
	$userCheck = $mysqli->query("SELECT password, salt FROM users WHERE email='" . $_SESSION['email'] . "'")->fetch_assoc();
	if (hash("sha512", $_SESSION['password'] . $userCheck['salt']) == $userCheck['password'] ) {
	        $loggedin = true;
	} else {
	        $loggedin = false;
	}
        
        if ($loggedin == true) {
                $_SESSION['id'] = $mysqli->query("SELECT id FROM users WHERE email ='" . $_POST['email'] . "'")->fetch_assoc()['id'];
                echo "You're logged in now.";
        } else {
                echo "nonononononono";
                session_destroy();
        }
}

?>
