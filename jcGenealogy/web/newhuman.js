function deathHide() {
	if (alive.checked === true) {
		document.getElementById("dead").style.display = "none";
	} else {
		document.getElementById("dead").style.display = "block";
	}
}

originalAlive = false;

alive = document.getElementById('alive')
me = document.getElementById('me');

alive.onchange = function() {
	originalAlive = alive.checked;
	deathHide();
};

me.onchange = function() {
	if (me.checked === true) {
		alive.checked = true;
	} else {
		alive.checked = originalAlive;
	}
	deathHide();
}

document.getElementById("dead").onchange = function() {
	document.getElementById("deadhidden").value = document.getElementById('dead').valueAsDate.toISOString().split("T")[0];
 }
}
