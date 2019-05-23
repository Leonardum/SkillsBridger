/* This function cancels the event. */
function cancelEvent(eventId) {
	'use strict';
    
    var confirmation = confirm("If you cancel this event, a notification will be send to all current subscribers and you will not be able to see or manage the event any longer! Are you sure you want to proceed?");
	if (confirmation) {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				document.getElementById('cancelLink').click();
			}
		}
		xmlhttp.open("GET", "./model/ajax/cancelEvent.php?eventId=" + eventId, true);
		xmlhttp.send();
	}
}