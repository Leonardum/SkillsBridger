/* This function translates the position on the slider to understandable, interpretable text. */
function showValue(x, displayId) {
	var value = x.value;
	if (value == 0) {value = "not required.";}
	else if (value == 1) {value = "basic.";}
	else if (value == 2) {value = "conversational.";}
	else if (value == 3) {value = "fluent.";}
	else if (value == 4) {value = "bilingual or native.";}
	else {value = "undefined.";}
	document.getElementById(displayId).innerHTML = value;
}