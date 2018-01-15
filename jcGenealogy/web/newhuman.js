function deathHide() {
	if (alive.checked === true) {
		document.getElementById("dead").disabled = true;
	} else {
		document.getElementById("dead").disabled = false;
	}
}

var originalAlive = false;

var alive = document.getElementById('alive');
var me = document.getElementById('me');

alive.onchange = function() {
	originalAlive = alive.checked;
	if (alive.checked === false) {
		me.checked = false;	
	}
	deathHide();
};

me.onchange = function() {
	if (me.checked === true) {
		alive.checked = true;
	} else {
		alive.checked = originalAlive;
	}
	deathHide();
};

document.getElementById("dead").onchange = function() {
	//document.getElementById("deadhidden").value = document.getElementById('dead').valueAsDate.toISOString().split("T")[0];
};
