<body>
<head>
<style>
body {
        padding-top:1%;

        padding-left:10%;
        padding-right:10%;
}
table {
        border-radius: 8px;
        border:solid;
        float:right;
        padding:5px;
}
th {
        text-align:left;
}
#fullname {
        font-size:125%;
        text-align:center;
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

echo "

<table>
        <tbody>
                <tr><td id='fullname' colspan='2'><span>" . $fullname . "</span></td></tr>
                <tr>
                        <th scope='row'>Gender</th>
                        <td>" . $gender .  "</td>
                </tr>
                <tr>
                        <th scope='row'>Date of birth</th>
                        <td>" . $humanQuery['birthdate'] . "</td>
                </tr>

        </tbody>
</table>


"

?>
</body>
