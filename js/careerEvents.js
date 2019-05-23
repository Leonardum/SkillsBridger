var careerEventTypeArray = [];
if (AUXLIB.passedCareerEventTypes() != undefined) {
	var selectedEventTypes = AUXLIB.passedCareerEventTypes().split(',');
	var k;
	for (k = 0; k < selectedEventTypes.length; k++) {
		selectedEventTypes[k] = parseInt(selectedEventTypes[k]);
	}
} else {
	var selectedEventTypes = [];
}

if (AUXLIB.passedRegions() != undefined) {
	var selectedRegions = AUXLIB.passedRegions();
} else {
	var selectedRegions = [];
}

// Takes a MySql timestamp as input and outputs a formated time string.
function formatDate(date) {
    'use strict';
    
    // Split MySql timestamp into an array ['Y', 'M', 'D', 'h', 'm', 's']
    var t = date.split(/[- :]/);
	
	// Format the months
	if (t[1] == 1) {
		t[1] = "January";
	} else if (t[1] == 2) {
		t[1] = "February";
	} else if (t[1] == 3) {
		t[1] = "March";
	} else if (t[1] == 4) {
		t[1] = "April";
	} else if (t[1] == 5) {
		t[1] = "May";
	} else if (t[1] == 6) {
		t[1] = "June";
	} else if (t[1] == 7) {
		t[1] = "July";
	} else if (t[1] == 8) {
		t[1] = "August";
	} else if (t[1] == 9) {
		t[1] = "September";
	} else if (t[1] == 10) {
		t[1] = "October";
	} else if (t[1] == 11) {
		t[1] = "November";
	} else if (t[1] == 12) {
		t[1] = "December";
	}
	
	t[2] = t[2].replace(/^0+/, '');
	
	var time = t[2] + " " + t[1] + " " + t[0] + " at " + t[3] + "h" + t[4];
    return time;
}


// Checks if a value is part of an array.
function partOfArray(value, array) {
    'use strict';
    
	var arrLength = array.length;
	var j;
	for (j = 0; j < arrLength; j++) {
		if (array[j] == value) {
			return true;
		}
	}
}


/* This function loads a list with all 1st level career goals and displays them on the page immediately after it loads. */
function loadEventTypes() {
    'use strict';
	
    var eventTypes = document.getElementById('eventTypes');
    
    /* Use AJAX to get the array of level 1 career goals from the database and to create the overview buttons and the form tags with. */
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            careerEventTypeArray = JSON.parse(xmlhttp.responseText);
            var i;
			
			var instruction = document.createElement('p');
			instruction.innerHTML = "Refine your search:";
			eventTypes.appendChild(instruction);
			
			var instructionTitle = document.createElement('p');
            instructionTitle.setAttribute("class", "instructionTitle");
			instructionTitle.innerHTML = "By event type:";
			eventTypes.appendChild(instructionTitle);
            
            var form = document.createElement('form');
			form.setAttribute("method", "post");
            form.setAttribute("action", AUXLIB.thisPage());
            eventTypes.appendChild(form);
            
            var arrayLength = careerEventTypeArray.length;
            for (i = 0; i < arrayLength; i++) {
                var careerEventId = careerEventTypeArray[i][0];
                var careerEventType = careerEventTypeArray[i][1];
                
                var checkBox = document.createElement('input');
                checkBox.setAttribute("type", "checkbox");
                checkBox.setAttribute("id", careerEventType.toLowerCase().replace(/\s+/g, '') + "Box");
				if (typeof AUXLIB.checkList() !== 'undefined') {
					if (partOfArray(careerEventId, AUXLIB.checkList())) {
						checkBox.checked = true;
					}
				}
				checkBox.setAttribute("onchange", "processSelection(this, 'eventType', " + careerEventId + ")");
                form.appendChild(checkBox);
                
                var span = document.createElement('span');
                span.setAttribute("class", "tickBoxText");
                span.innerHTML = careerEventType.capitalize();
                form.appendChild(span);
                
                var br = document.createElement('br');
                form.appendChild(br);
            }
            
            var checkedEventTypes = document.createElement('input');
            checkedEventTypes.setAttribute("type", "hidden");
            checkedEventTypes.setAttribute("id", "checkedEventTypes");
            checkedEventTypes.setAttribute("name", "checkedEventTypes");
			if (typeof AUXLIB.passedCareerEventTypes() !== 'undefined') {
            	checkedEventTypes.setAttribute("value", AUXLIB.passedCareerEventTypes());
			} else {
				checkedEventTypes.setAttribute("value", "");
			}
            form.appendChild(checkedEventTypes);
			
			var checkedRegions = document.createElement('input');
            checkedRegions.setAttribute("type", "hidden");
            checkedRegions.setAttribute("id", "checkedRegions");
            checkedRegions.setAttribute("name", "checkedRegions");
			if (typeof AUXLIB.passedRegions() !== 'undefined') {
            	checkedRegions.setAttribute("value", AUXLIB.passedRegions());
			} else {
				checkedRegions.setAttribute("value", "");
			}
            form.appendChild(checkedRegions);
            
            var action = document.createElement('input');
            action.setAttribute("type", "hidden");
            action.setAttribute("name", "action");
            action.setAttribute("value", "careerEvents");
            form.appendChild(action);
            
            var save = document.createElement('input');
            save.setAttribute("type", "submit");
            save.setAttribute("name", "save");
            save.setAttribute("value", "Save event types");
            save.setAttribute("style", "margin-top: 5px");
            form.appendChild(save);
			
			var divider = document.createElement('div');
            divider.setAttribute("class", "selectionDivider");
            eventTypes.appendChild(divider);
			
			loadRegions();
			loadEvents();
        }
    }
    xmlhttp.open("GET", "./model/ajax/careerEventsFetch.php?eventTypeLoad=true", true);
    xmlhttp.send();
}


/* This function loads a list of all existing provinces and regions in the database and displays them on the page immediately after it loads. */
function loadRegions() {
	
	var eventTypes = document.getElementById('eventTypes');
	
	var regionsRequest = new XMLHttpRequest();
    regionsRequest.onreadystatechange = function () {
        if (regionsRequest.readyState === 4 && regionsRequest.status === 200) {
			
			var regions = JSON.parse(regionsRequest.responseText);
			
			var instructionTitle = document.createElement('p');
            instructionTitle.setAttribute("class", "instructionTitle");
			instructionTitle.innerHTML = "By region:";
			eventTypes.appendChild(instructionTitle);
			
			var form = document.createElement('form');
			form.setAttribute("method", "post");
            form.setAttribute("action", AUXLIB.thisPage());
            eventTypes.appendChild(form);
			
			var i;
            for (i = 0; i < regions.length; i++) {
				var region = regions[i];
                
                var checkBox = document.createElement('input');
                checkBox.setAttribute("type", "checkbox");
                checkBox.setAttribute("id", region.toLowerCase().replace(/\s+/g, '') + "Box");
				if (typeof AUXLIB.passedRegions() !== 'undefined') {
					if (partOfArray(region, AUXLIB.passedRegions())) {
						checkBox.checked = true;
					}
				}
				checkBox.setAttribute("onchange", "processSelection(this, 'region', " + "'" + region + "')");
                form.appendChild(checkBox);
                
                var span = document.createElement('span');
                span.setAttribute("class", "tickBoxText");
                span.innerHTML = region;
                form.appendChild(span);
                
                var br = document.createElement('br');
                form.appendChild(br);
            }
        }
    }
    regionsRequest.open("GET", "./model/ajax/careerEventsFetch.php?regionsLoad=true", true);
    regionsRequest.send();
}


/* This function creates and loads a list of events, depending on whether the checkboxes which are checked correspond to the events which will be loaded.*/
function loadEvents() {
    'use strict';
    
    var eventList = document.getElementById('eventList');
    while (eventList.lastChild) {
        eventList.removeChild(eventList.lastChild);
    }
	
	/* Use Ajax to retrieve the skills for the selected career goal and create the skillboxes and place them in the container div. */
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var events = JSON.parse(xmlhttp.responseText);
			var ids = [];
			var i;
			var arrayLength = events.length;
			for (i = 0; i < arrayLength; i++) {
				
				eventList.className = "col-16 masonry sidebarContent";
				var x = i + 1;
				
				ids.push([x, events[i].Event_id, events[i].Organisation_id, events[i].Address_id]);
				
				var eventBox = document.createElement('div');
				eventBox.setAttribute("id", "box" + x);
				eventBox.setAttribute("class", "eventBox");
				
				if (events[i].WebpageUrl != null) {
					var eventLink = document.createElement('a');
					eventLink.setAttribute("href", events[i].WebpageUrl);
					eventLink.setAttribute("target", "_blank");
					var name = document.createElement('p');
					name.setAttribute("class", "title");
					name.innerHTML = events[i].Name;
					eventLink.appendChild(name);
					eventBox.appendChild(eventLink);
				} else {
					var name = document.createElement('p');
					name.setAttribute("class", "title");
					name.innerHTML = events[i].Name;
					eventBox.appendChild(name);
				}
				
				var type = document.createElement('p');
				type.setAttribute("class", "col-20 type");
				type.innerHTML = events[i].Type.capitalize() + " by:";
				eventBox.appendChild(type);
				
				var eventType;
				var j;
				for (j = 0; j < careerEventTypeArray.length; j++) {
					var careerEventId = careerEventTypeArray[j][0];
					var careerEventType = careerEventTypeArray[j][1];
					if (events[i].Type == careerEventType) {
						eventType = careerEventId;
					}
				}
				
				var eventTypeInput = document.createElement('input');
				eventTypeInput.setAttribute("id", "eventType" + x);
				eventTypeInput.setAttribute("type", "hidden");
				eventTypeInput.value = eventType;
				eventBox.appendChild(eventTypeInput);
				
				var logoRow = document.createElement('div');
				logoRow.setAttribute("class", "col-20");
				eventBox.appendChild(logoRow);
				
				var logoBox = document.createElement('div');
				logoBox.setAttribute("class", "logoBox");
				logoRow.appendChild(logoBox);
				
				var logo = document.createElement('img');
				logo.setAttribute("id", "logo" + x);
				logo.setAttribute("class", "logo");
				logoBox.appendChild(logo);
				
				var organiser = document.createElement('p');
				organiser.setAttribute("id", "organiser" + x);
				organiser.setAttribute("class", "organiser");
				eventBox.appendChild(organiser);
				
				var skillsRow = document.createElement('div');
				skillsRow.setAttribute("id", "skills" + x);
				skillsRow.setAttribute("class", "col-20 skillsBox");
				eventBox.appendChild(skillsRow);
				
				var formRow = document.createElement('div');
				formRow.setAttribute("class", "col-20 eventBox-action");
				formRow.setAttribute("style", "");
				eventBox.appendChild(formRow);
				
				if (!partOfArray(events[i].Event_id, AUXLIB.studentGoingToEvents())) {
					var form = document.createElement('form');
					form.setAttribute("action", AUXLIB.thisPage());
					form.setAttribute("method", "post");
					form.setAttribute("id", "form" + x);
					formRow.appendChild(form);
					var input1 = document.createElement('input');
					input1.setAttribute("type", "hidden");
					input1.setAttribute("name", "student");
					input1.setAttribute("value", AUXLIB.studentId());
					form.appendChild(input1);
					var input2 = document.createElement('input');
					input2.setAttribute("type", "hidden");
					input2.setAttribute("name", "event");
					input2.setAttribute("value", events[i].Event_id);
					form.appendChild(input2);
					var input3 = document.createElement('input');
					input3.setAttribute("type", "hidden");
					input3.setAttribute("name", "action");
					input3.setAttribute("value", "careerEvents");
					form.appendChild(input3);
					var input4 = document.createElement('input');
					input4.setAttribute("type", "hidden");
					input4.setAttribute("id", "checkedEventTypes" + x);
					input4.setAttribute("name", "checkedEventTypes");
					input4.setAttribute("value", selectedEventTypes.toString());
					form.appendChild(input4);
					var input5 = document.createElement('input');
					input5.setAttribute("type", "hidden");
					input5.setAttribute("id", "checkedRegions" + x);
					input5.setAttribute("name", "checkedRegions");
					input5.setAttribute("value", selectedRegions.toString());
					form.appendChild(input5);
					
					var attend = document.createElement('input');
					attend.setAttribute("id", "submit" + x);
					attend.setAttribute("class", "subscribe-button");
					attend.setAttribute("type", "submit");
					attend.setAttribute("name", "submit");
					attend.setAttribute("value", "Subscribe to this event!");
					form.appendChild(attend);
					
					// Take student to external page if necessary.
					if (events[i].PaidOnline || events[i].AlternateSubscription) {
						attend.setAttribute("style", "display:none;");
						
						var externalLink = document.createElement('a');
						externalLink.setAttribute("href", events[i].SubscriptionUrl);
						externalLink.setAttribute("target", "_blank");
						externalLink.setAttribute("id", "link" + x);
						formRow.appendChild(externalLink);
						
						var externalButton = document.createElement('button');
						externalButton.setAttribute("onclick", "alertExternal('" + x + "');");
						externalButton.innerHTML = "Subscribe to this event!";
						formRow.appendChild(externalButton);
					}
				} else if (partOfArray(events[i].Event_id, AUXLIB.studentAppliedForEvents())) {
					var appliedLink = document.createElement('a');
					appliedLink.setAttribute("href", "./index.php?action=pendingEvents&studentId=" + AUXLIB.studentId());
					formRow.appendChild(appliedLink);
					
					var applied = document.createElement('div');
					applied.setAttribute("class", "attendingBox");
					applied.innerHTML = "Application sent!";
					appliedLink.appendChild(applied);
				} else {
					var attendingLink = document.createElement('a');
					attendingLink.setAttribute("href", "./index.php?action=subscribedEvents&studentId=" + AUXLIB.studentId());
					formRow.appendChild(attendingLink);
					
					var attending = document.createElement('div');
					attending.setAttribute("class", "attendingBox");
					attending.innerHTML = "Subscribed!";
					attendingLink.appendChild(attending);
				}
				
				var hiderRow = document.createElement('div');
				hiderRow.setAttribute("class", "col-20 hiderRow");
				hiderRow.setAttribute("onclick", "showInfo(" + x + ")");
				eventBox.appendChild(hiderRow);
				
				var hider = document.createElement('img');
				hider.setAttribute("class", "hider");
				hider.setAttribute("src", "./images/hider.png");
				hiderRow.appendChild(hider);
				
				var hiddenInfo = document.createElement('div');
				hiddenInfo.setAttribute("id", "info" + x);
				hiddenInfo.setAttribute("style", "display:none;")
				eventBox.appendChild(hiddenInfo);
				
				var descriptionRow = document.createElement('div');
				descriptionRow.setAttribute("class", "col-20 descriptionRow");
				hiddenInfo.appendChild(descriptionRow);
				
				var description = document.createElement('p');
				description.innerHTML = events[i].Description;
				descriptionRow.appendChild(description);
				
				if (events[i].OpenForAll === 0) {
					var OpenFor = document.createElement('p');
					OpenFor.innerHTML = "<br>" + events[i].OpenFor;
					descriptionRow.appendChild(OpenFor);
				}
				
				var timeRow = document.createElement('div');
				timeRow.setAttribute("class", "col-20 timeRow");
				hiddenInfo.appendChild(timeRow);
				
				var start = document.createElement('p');
				start.innerHTML = "From: " + formatDate(events[i].Start);
				timeRow.appendChild(start);
				
				var end = document.createElement('p');
				end.innerHTML = "To: " + formatDate(events[i].End);
				timeRow.appendChild(end);
				
				var address = document.createElement('div');
				address.setAttribute("id", "address" + x);
				address.setAttribute("class", "col-20 addressBox");
				hiddenInfo.appendChild(address);
				
				var eventRegion = document.createElement('input');
				eventRegion.setAttribute("id", "eventRegion" + x);
				eventRegion.setAttribute("type", "hidden");
				eventBox.appendChild(eventRegion);
				
				var sponsorsRow = document.createElement('div');
				sponsorsRow.setAttribute("id", "sponsors" + x);
				hiddenInfo.appendChild(sponsorsRow);
				
				var fullInfoRow = document.createElement('div');
				fullInfoRow.setAttribute("class", "col-20 fullInfoRow");
				fullInfoRow.setAttribute("style", "");
				hiddenInfo.appendChild(fullInfoRow);
				
				var link = document.createElement('a');
				link.setAttribute("href", "index.php?action=studentEventOverview&eventId=" + events[i].Event_id + "&senderPage=" + AUXLIB.currentPage());
				fullInfoRow.appendChild(link);
				
				var fullInfoButton = document.createElement('button');
				fullInfoButton.setAttribute("class", "eventbox-button");
				fullInfoButton.innerHTML = "See full information";
				link.appendChild(fullInfoButton);
				
				eventList.appendChild(eventBox);
			}
			
			loadAdditionalInfo(ids);
		}
	}
	xmlhttp.open("GET", "./model/ajax/careerEventsFetch.php", true);
	xmlhttp.send();
}


/* Load in the name and logo of the event organisation and the address of the events in the event overview. */
function loadAdditionalInfo(ids) {
	'use strict';
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var info = JSON.parse(xmlhttp.responseText);
			
			var i;
			var arrayLength = info.length;
			for (i = 0; i < arrayLength; i++) {
				
				var x = info[i][0];
				var skills = info[i][1];
				var organisationName = info[i][2];
				var organisationLogoUrl = info[i][3];
				var address = info[i][4];
				var LocationName = address['LocationName'];
				var Street = address['Street'];
				var StreetNumber = address['StreetNumber'];
				var ZipCode = address['ZipCode'];
				var City = address['City'];
				var Province = address['Province'];
				var Country = address['Country'];
				var sponsors = info[i][5];
				
				// Add the logo.
				var logo = document.getElementById('logo' + x);
				logo.setAttribute("src", organisationLogoUrl);
				
				//Add the organisation name.
				var organisationParagraph = document.getElementById('organiser' + x).innerHTML = organisationName;
				
				//Add the offered skills.
				var skillBox = document.getElementById('skills' + x);
				
				if (skills == 0) {
					skillBox.setAttribute("style", "display:none;");
				} else {
					var skillsAnnounce = document.createElement('p');
					skillsAnnounce.setAttribute("class", "skillAnnounce")
					skillsAnnounce.innerHTML = "Offering you these skills / subjects:"
					skillBox.appendChild(skillsAnnounce);
					
					var skillFrame = document.createElement('div');
					skillFrame.setAttribute("class", "skillFrame");
					skillBox.appendChild(skillFrame);
					
					var j;
					for (j = 0; j < skills.length; j++) {
						var skillId = skills[j][0];
						var skillName = skills[j][1];
						
						var skill = document.createElement('p');
						skill.setAttribute("class", "skill");
						skill.innerHTML = skillName;
						skillFrame.appendChild(skill);
					}
				}
				
				//Add the address information.
				var addressBox = document.getElementById('address' + x);
				var addressPar = document.createElement('p');
				addressBox.appendChild(addressPar);
				addressPar.innerHTML = LocationName + "<br>" + Street + " " + StreetNumber + ",<br>" + ZipCode + " " + City + ",<br>" + Province + " " + Country;
				
				var eventRegion = document.getElementById('eventRegion' + x);
				eventRegion.value = Province;
				
				// Add the sponsors.
				if (sponsors.length != 0) {
					var sponsorsRow = document.getElementById('sponsors' + x);
					sponsorsRow.setAttribute("class", "col-20 sponsorsRow");
					
					var sponsorPar = document.createElement('p');
					sponsorPar.innerHTML = "Also made possible by:";
					sponsorsRow.appendChild(sponsorPar);
					
					var k;
					for (k = 0; k < sponsors.length; k++) {
						var sponsorName = sponsors[k][0];
						var sponsorLogoUrl = sponsors[k][1];
						
						var logoBox = document.createElement('div');
						logoBox.setAttribute("class", "sponsorSmallLogo");
						sponsorsRow.appendChild(logoBox);
						
						var logoImg = document.createElement('img');
						logoImg.setAttribute("src", sponsorLogoUrl);
						logoImg.setAttribute("class", "sponsorSmallLogo");
						logoImg.setAttribute("alt", sponsorName);
						logoBox.appendChild(logoImg);
					}
				}
			}
			
			displayEvents();
        }
    }
    xmlhttp.open("GET", "./model/ajax/additionalEventInfoFetch.php?ids=" +  JSON.stringify(ids), true);
    xmlhttp.send();
}


/* This function checks if the user selection matches the event data and sets the display property of the event box to 'inline-block' when a match is found. If not matches are found or if there is no selection, then a watermark message is displayed. */
function displayEvents() {
	/* Assume there are no events displayed, until set otherwise. */
	var eventsDisplayed = false;
	/* Get all the eventBoxes and extract the 'x' value and the skills for that event from them. */
	var eventBoxes = document.getElementsByClassName('eventBox');
	var i;
	for (i = 0; i < eventBoxes.length; i++) {
		var eventBoxId = eventBoxes[i].id;
		var eventBox = document.getElementById(eventBoxId);
		var x = eventBoxId.replace('box', '');
		var eventType = document.getElementById('eventType' + x).value;
		var eventRegion = document.getElementById('eventRegion' + x).value;
		
		/* Assume event 'i' is not displayed, until set otherwise. */
		var displayEvent = false;
		/* If there are careergoals selected, display event 'i' if the skills of the event correspond to the skills of the selected career goals. If there are no career goals selected, display event 'i' by default. */
		if (selectedEventTypes[0] != null && selectedRegions[0] == null) {
			if (partOfArray(eventType, selectedEventTypes)) {
				displayEvent = true;
			} else {
				displayEvent = false;
			}
		} else if (selectedEventTypes[0] != null && selectedRegions[0] != null) {
			if (partOfArray(eventType, selectedEventTypes)) {
				displayEvent = true;
			}
			if (!partOfArray(eventRegion, selectedRegions)) {
				displayEvent = false;
			}
		} else if (selectedEventTypes[0] == null && selectedRegions[0] != null) {
			if (!partOfArray(eventRegion, selectedRegions)) {
				displayEvent = false;
			} else {
				displayEvent = true;
			}
		} else {
			displayEvent = true;
		}
		
		/* If event 'i' is set to be displayed, set the display value to inline-block and since at least one event is displayed in this case, set the eventsDisplayed variable to true. If event 'i' is not set to be displayed, set the display value to none. */
		if (displayEvent) {
			eventBox.setAttribute("style", "display:inline-block;");
			var eventsDisplayed = true;
		} else {
			eventBox.setAttribute("style", "display:none;");
		}
	}
	
	/* Get the 'eventList' and 'watermark' element and delete the 'watermark' element if it exists. */
	var eventList = document.getElementById('eventList');
	var watermark = document.getElementById('watermark');
	if (watermark) {
		eventList.removeChild(watermark);
	}
	/* If there are no events displayed, set a watermark message and set the class of the 'eventList' element to be non-masonry. If there is at least one event displayed, set the class of 'eventList' to include masonry. */
	if (eventsDisplayed == false) {
		eventList.className = "col-16 sidebarContent";
		
		var watermark = document.createElement('p');
		watermark.setAttribute("id", "watermark");
		watermark.setAttribute("class", "darkWatermark");
		eventList.appendChild(watermark);
		
		watermark.innerHTML = "It looks like there are no upcoming events matching your selection.";
	} else {
		eventList.className = "col-16 masonry sidebarContent";
	}
}


/* This function places the user selection values in the correct arrays for later comparison with events in order to display the corresponding events. Furthermore it updates the hidden input boxes which keep track of the selection and executes displayEvents(). */
function processSelection(checkboxElem, selectionType, selectedValue) {
	
	if (selectionType == "eventType") {
		var selection = document.getElementById('checkedEventTypes');
		if (checkboxElem.checked) {
			selectedEventTypes.push(selectedValue);
			if (selection.value == "null" || selection.value == "") {
				selection.value = selectedValue;
			} else {
				selection.value = selection.value + "," + selectedValue;
			}
		} else {
			var index = selectedEventTypes.indexOf(selectedValue);
			selectedEventTypes.splice(index,1);
			
			var array = selection.value.split(",");
			var stringIndex = array.indexOf(selectedValue.toString());
			array.splice(stringIndex,1);
			selection.value = array.toString();
		}
		
		displayEvents();
		
		var eventBoxes = document.getElementsByClassName('eventBox');
		var i;
		for (i = 0; i < eventBoxes.length; i++) {
			var x = i+1;
			var checked = document.getElementById('checkedEventTypes' + x);
			if (checked != null) {
				checked.value = selection.value;
			}
		}
		
		
	} else if (selectionType == "region") {
		var selection = document.getElementById('checkedRegions');
		if (checkboxElem.checked) {
			selectedRegions.push(selectedValue);
			if (selection.value == "null" || selection.value == "") {
				selection.value = selectedValue;
			} else {
				selection.value = selection.value + "," + selectedValue;
			}
		} else {
			var index = selectedRegions.indexOf(selectedValue);
			selectedRegions.splice(index,1);
			
			var array = selection.value.split(",");
			var stringIndex = array.indexOf(selectedValue.toString());
			array.splice(stringIndex,1);
			selection.value = array.toString();
		}
		
		displayEvents();
		
		var eventBoxes = document.getElementsByClassName('eventBox');
		var i;
		for (i = 0; i < eventBoxes.length; i++) {
			var x = i+1;
			var checked = document.getElementById('checkedRegions' + x);
			if (checked != null) {
				checked.value = selection.value;
			}
		}
	}
}


/* This function shows the additional event information, when clicked on the show information icon. */
function showInfo(element) {
	'use strict';
    
    var infoBox = document.getElementById('info' + element);
	
	if (infoBox.style.display == 'none') {
		infoBox.style.display = 'block';
	} else {
		infoBox.style.display = 'none';
	}
}


/* This function displays the confirm dialogue in case additional steps are required by the user in order to subscribe and redirects the user to the approprate webpage. */
function alertExternal(x) {
	'use strict';
    
    var confirmation = confirm("In order to subscribe for this event, you are required to follow some additional steps on a webpage set up by the organiser of this event! Do you want to add this event to your PENDING SUBSCRIPTIONS and open this webpage?");
	if (confirmation) {
		document.getElementById('link' + x).click();
		var button = document.getElementById('submit' + x);
		button.click();
	}
}