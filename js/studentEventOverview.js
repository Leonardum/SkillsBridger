/* This function displays the confirm dialogue in case additional steps are required by the user in order to subscribe and redirects the user to the approprate webpage. */
function alertExternal() {
	'use strict';
    
    var confirmation = confirm("In order to subscribe for this event, you are required to follow some additional steps on a webpage set up by the organiser of this event! Do you want to add this event to your PENDING SUBSCRIPTIONS and open this webpage?");
	if (confirmation) {
		document.getElementById('subscribeLink').click();
		var button = document.getElementById('subscribeButton');
		button.click();
	}
}


/* This function displays the confirm dialogue to ask whether the user is sure to unsubscribe from the event. */
function unsubscribeConfirm() {
	'use strict';
    
    var confirmation = confirm("Are you sure you want to unsubscribe?");
	if (confirmation) {
		var button = document.getElementById('unsubscribeButton');
		button.click();
	}
}