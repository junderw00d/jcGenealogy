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


if ($_POST['edit'] == true) {

        $humanGender = $mysqli->query("SELECT gender FROM humans WHERE id='" . $_POST['id'] . "'")->fetch_assoc();
        if ($humanGender == 0) {
                $humanGenderParentValue = "motherid";
        } else {
                $humanGenderParentValue = "fatherid";
        }

        $mysqli->query("UPDATE humans SET $humanGenderParentValue=null WHERE $humanGenderParentValue='" . $_POST['id'] . "'");

$N = count($_POST['addChild']);

for($i=0; $i < $N; $i++) {
        $mysqli->query("UPDATE humans SET $humanGenderParentValue='" . $_POST['id'] . "' WHERE id='" . $_POST['addChild'][$i] . "'");
}

$mysqli->query("UPDATE humans SET biography = '" . nl2br($_POST['biography'],false) . "' WHERE ID='" . $_POST['id'] . "'");

header("Location: human.php?id=" . $_POST['id']);
}


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

if ($humanQuery['gender'] == 1) {
        $children = $mysqli->query("SELECT * FROM humans WHERE fatherid='" . $humanQuery['id'] . "'");
} else {
        $children = $mysqli->query("SELECT * FROM humans WHERE motheridid='" . $humanQuery['id'] . "'");
}
$childList = "";
while ($result = $children->fetch_assoc()) {
        $childList = $childList . "<li><a href='human.php?id=" . $result['id'] . "'>" . $result['firstname'] . "</a></li>";
}

echo "
<span><div id='page-content'>
<div id='human-header'>
<h1>$fullname</h1>
";

if ($_GET['action'] == "edit") {
        //echo "<div id='edit-view'><img src='assets/view.svg' width='15px'> <a href='human.php?id=" . $humanQuery['id'] . "'>View</a></div>";

} else {

echo "
<div id='edit-view'>
        <img src='assets/edit.svg' width='15px'> <a href='human.php?id=" . $humanQuery['id'] . "&action=edit'>Edit</a>
</div>";
}

echo "
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
                                        <th scope='row'>Gender</th>";

                                        if ($_GET['action'] == "edit") {

                                                if ($humanQuery['gender'] == 0) {
                                                        echo"
                                                        <td>
                                                                <input form='edit-form' type='radio' name='gender' value='1'>Male</input>
                                                                <input form='edit-form' type='radio' name='gender' value='0' checked>Female</input>
                                                        </td>";
                                                } else {
                                                        echo"
                                                        <td>
                                                                <input form='edit-form' type='radio' name='gender' value='1' checked>Male</input>
                                                                <input form='edit-form' type='radio' name='gender' value='0'>Female</input>
                                                        </td>";
                                                }
                                        } else {
                                                echo"<td>" . $gender .  "</td>";
                                        }
                                echo "

                                </tr>
                                <tr>
                                        <th scope='row'>Date of birth</th>";

                                if ($_GET["action"] == "edit") {
                                        echo"<td><input form='edit-form' type='date' value='" . $humanQuery['birthdate'] . "'></td>";
                                } else {
                                        echo "<td>" . $birthday . " (age $age)</td>";
                                }
                                echo"
                                </tr>
                                <tr>
                                        <th scope='row'>Children</th>";

                                        if ($_GET['action'] == "edit") {
                                                echo "<td>";
                                                $addChildrenQuery = $mysqli->query("SELECT * FROM humans");
                                                while ($addChildren = $addChildrenQuery->fetch_assoc()) {
                                                        if ($addChildren['fatherid'] == $_GET['id'] || $addChildren['motherid'] == $_GET['id']) {
                                                                $checked = " checked";
                                                        } else {
                                                                $checked = null;
                                                        }
                                                        echo "<div><input id='addchild" . $addChildren['id'] . "' form='edit-form' type='checkbox' value='" . $addChildren['id'] . "' name='addChild[]'$checked>";
                                                        echo "<label for='addchild" . $addChildren['id'] . "'>" . $addChildren['firstname'] . " " . $addChildren['lastname'] . "</label></div>";
                                                }
                                                echo "</td>";
                                        } else {
                                                echo "

                                                <td><ul>$childList</ul></td>";
                                        }
                                echo"
                                </tr>
                        </tbody>
                </table>
        </details>
</div>
<div id='biography-div'>
        <p id='biography'";

if ($_GET['action'] == "edit") {
        echo " contenteditable class='bio-edit' placeholder='test'";
}
echo "
>
        " . $humanQuery['biography'] . "
        </p>
</div>

";

if ($_GET['action'] == "edit") {
        echo "<form id='edit-form' method='POST'><input type='hidden' value='true' name='edit'><input type='hidden' name='id' value='" . $_GET['id'] . "'><input type='hidden' id='biography-hidden' name='biography'><input type='submit' value='Save changes'></form><a href='human.php?id=" . $_GET['id'] . "'><button>Cancel</button></a>";
}

echo"

</div>
";

?>

<script>
function detailsToggle() {
        if (document.getElementById("details").open === true) {
                document.getElementById("quickfactstoggle").innerHTML = "Hide Quick Facts";
        } else {
                document.getElementById("quickfactstoggle").innerHTML = "Show Quick Facts";
        }
}


document.getElementById("biography").onkeyup =  function() {
  document.getElementById("biography-hidden").value = this.innerText;
};
</script>

</body>
