<body>
<head>
        <link rel='stylesheet' href='assets/style.css'>
</head>

<div id='sidebar'>
        <div id='sidebarHeader'>
                <img id='logo' src='http://192.168.1.189/mediawiki/images/0/07/Progress_Wiki_Logo.png'>
                <h3 style='text-align:center'>Underwood Family Tree</h3>
        </div>
        <ul>
                <li><a href='register.php'>Create account</a></li>
                <li><a href='tree.php'>View tree</a></li>
        </ul>
</div>

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
<span><div id='page-content'>
<div id='human-header'>
<h1>$fullname</h1>
<div id='edit'><img src='assets/edit.svg' width='15px'> <a href='humanedit.php'>Edit</a></div>
<br>
<hr>
</div>

<div id='table'>
        <details open ontoggle='detailsToggle()' id='details'>
                <summary id='summary'><small id='quickfactstoggle'>Hide Quick Facts</small></summary>
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
        </details>
</div>

<div id='biography'>
        <p>
aoisdjgoijsdfoigj soidjfg iosdjfg iosjdfgi osjdfgipo jsdifpgo jsdofipg jsidofpg 
sidufg idfhgu isdhfgui sdhfgui hdsfuigh dsfuigh dfisugh disufgh disufgh dfisughs
sdifugh siudfhgui sfdhgiu sdfhgiu sdguis dfguisdfhgui sdhfgui hdsfuigh usidfhgui shdfg 
sdiufgh uisdfhgui sdhfgui hdsuifghs idfhgiu sdhfgui sdhfiug hdisufghisu dfhgui sdhfuig
suidfhg isudfhgiu sdhfgui sdhfugi dhsiughsi iusdfhgiu sdhfgiu hsdif uhsduf h g
        </p>
</div>

</div>
"

?>

<script>
function detailsToggle() {
        if (document.getElementById("details").open === true) {
                document.getElementById("quickfactstoggle").innerHTML = "Hide Quick Facts";
        } else {
                document.getElementById("quickfactstoggle").innerHTML = "Show Quick Facts";
        }
}
</script>

</body>
