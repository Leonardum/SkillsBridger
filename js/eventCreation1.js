/* This function loads the appropriate event types into the select menu, based on the selected event purpose. */
function loadTypes(value) {
    'use strict';
	
	var eventType = document.getElementById('eventType');
	while (eventType.lastChild) {
        eventType.removeChild(eventType.lastChild);
    }
	
	if (value == 'career') {
		var types = ['CV and interview coaching', 'in-house day and company presentation', 'info session', 'job fair', 'networking event', 'social media coaching'];
	} else if (value == 'job') {
		var types = ['full-time job', 'half-time job', 'internship'];
	} else if (value == 'learning') {
		var types = ['business game', 'consulting project','debate', 'lecture', 'masterclass', 'online course', 'skills-program', 'summer school', 'volunteering experience', 'workshop'];
	}
	
	var emptyOption = document.createElement('option');
	emptyOption.setAttribute("selected", "true");
	emptyOption.setAttribute("disabled", "true");
	emptyOption.setAttribute("hidden", "true");
	emptyOption.value = "";
	eventType.appendChild(emptyOption);
	
	var i;
	var arrayLength = types.length;
	for (i = 0; i < arrayLength; i++) {
		var typeOption = document.createElement('option');
		typeOption.value = types[i];
		typeOption.text = types[i].capitalize();
		eventType.appendChild(typeOption);
	}
}