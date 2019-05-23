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


/* Loads the events for a certain skill in the list. If the student viewing the list is already attending one of these events, this will show up. */
function loadEvents(skillId, studentId) {
    'use strict';
    
    var eventList = document.getElementById('eventList');
    
    /* Use Ajax to retrieve the skills for the selected career goal and create the skillboxes and place them in the container div. */
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var events = JSON.parse(xmlhttp.responseText);
            var ids = [];
			var i;
            var arrayLength = events.length;
            if (arrayLength == 0) {
                eventList.innerHTML = "<p class='darkWatermark'>It looks like there are no upcoming events near you where you can work on this skill.</p>";
            } else {
                for (i = 0; i < arrayLength; i++) {
					
					eventList.className = "col-20 masonry";
					
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
						formRow.appendChild(form);
						var input1 = document.createElement('input');
						input1.setAttribute("type", "hidden");
						input1.setAttribute("name", "student");
						input1.setAttribute("value", studentId);
						form.appendChild(input1);
						var input2 = document.createElement('input');
						input2.setAttribute("type", "hidden");
						input2.setAttribute("name", "event");
						input2.setAttribute("value", events[i].Event_id);
						form.appendChild(input2);
						var input3 = document.createElement('input');
						input3.setAttribute("type", "hidden");
						input3.setAttribute("name", "action");
						input3.setAttribute("value", "eventPerSkill");
						form.appendChild(input3);
						var input4 = document.createElement('input');
						input4.setAttribute("type", "hidden");
						input4.setAttribute("name", "skillId");
						input4.setAttribute("value", skillId);
						form.appendChild(input4);
						var attend = document.createElement('input');
						attend.setAttribute("id", "submit" + x);
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
						appliedLink.setAttribute("href", "./index.php?action=pendingEvents&studentId=" + studentId);
						formRow.appendChild(appliedLink);
						
						var applied = document.createElement('div');
						applied.setAttribute("class", "attendingBox");
						applied.innerHTML = "Application sent!";
						appliedLink.appendChild(applied);
					} else {
						var attendingLink = document.createElement('a');
						attendingLink.setAttribute("href", "./index.php?action=subscribedEvents&studentId=" + studentId);
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
					
					var sponsorsRow = document.createElement('div');
					sponsorsRow.setAttribute("id", "sponsors" + x);
					hiddenInfo.appendChild(sponsorsRow);
					
					var fullInfoRow = document.createElement('div');
					fullInfoRow.setAttribute("class", "col-20 fullInfoRow");
					fullInfoRow.setAttribute("style", "");
					hiddenInfo.appendChild(fullInfoRow);
					
					var link = document.createElement('a');
                    link.setAttribute("href", "index.php?action=studentEventOverview&eventId=" + events[i].Event_id + "&senderPage=" + AUXLIB.currentPage() + "&skillId=" + AUXLIB.skillId());
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
    }
    xmlhttp.open("GET", "./model/ajax/eventListFetch.php?skillId=" + skillId, true);
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
				
				//Add the address information.
				var addressBox = document.getElementById('address' + x);
				var addressPar = document.createElement('p');
				addressBox.appendChild(addressPar);
				addressPar.innerHTML = LocationName + "<br>" + Street + " " + StreetNumber + ",<br>" + ZipCode + " " + City + ",<br>" + Province + " " + Country;
				
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
        }
    }
    xmlhttp.open("GET", "./model/ajax/additionalEventInfoFetch.php?ids=" +  JSON.stringify(ids), true);
    xmlhttp.send();
}


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
    
    var confirmation = confirm("In order to subscribe for this event, you are required to follow some additional steps on a webpage set up by the organiser of this event! This webpage will open if you accept. Are you sure you want to proceed?");
	if (confirmation) {
		document.getElementById('link' + x).click();
		var button = document.getElementById('submit' + x);
		button.click();
	}
}