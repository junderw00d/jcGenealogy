<body>
<head>
<style>
body {
        padding-top:1%;

        padding-left:10%;
        padding-right:10%;
}
h1 {
//      float: left;
}

table {
        position:sticky;
        border-radius: 8px;
        border:solid;
        float:right;
        padding:5px;
        margin-top:20px;
}
th {
        text-align:left;
}
#fullname {
        font-size:125%;
        text-align:center;
}
hr {
border-color: black;
}
</style>
</head>

<?php
include "/etc/jcGenealogy/load.php";
$humanQuery = $mysqli->query("SELECT * FROM humans WHERE ID='" . $_GET['id'] . "'")->fetch_assoc();
$fullname = $humanQuery['firstname'] . " " . $humanQuery['lastname'];

if ($humanQuery['gender'] == 1) {
        $gender = "Male";
} else {
        $gender = "Female";
}

$birthDateDate = date_create($humanQuery['birthdate']);
$currentDate = date_create(date("Y-m-d"));
$age = floor(date_diff($birthDateDate, $currentDate)->format("%a") / 365);

$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
$birthdateExplode = explode("-", $humanQuery['birthdate']);


$birthday = $months[intval(ltrim($birthdateExplode[1]), 0) - 1] . " " . ltrim($birthdateExplode[2],0) . ", " . $birthdateExplode[0];

echo "
<div id='content'>
<h1>$fullname</h1>
<hr>
<table>
        <tbody>
                <tr id='top'><td id='fullname' colspan='2'><span>" . $fullname . "</span></td></tr>
                <tr>
                        <th scope='row'>Gender</th>
                        <td>" . $gender .  "</td>
                </tr>
                <tr>
                        <th scope='row'>Date of birth</th>
                        <td>" . $birthday . " (age $age)</td>
                </tr>

        </tbody>
</table>

</div>
"

?>
</body>
