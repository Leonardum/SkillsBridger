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


/* Generates a list of all events which an oranisation is organising. */
function loadOrganisationEvents(organisationId) {
    'use strict';
    
    var eventList = document.getElementById('eventList');
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var events = JSON.parse(xmlhttp.responseText);
			var ids = [];
            var i;
            var arrayLength = events.length;
            if (arrayLength == 0) {
                eventList.innerHTML = "<p class='darkWatermark'>There are no upcoming events your organisation is hosting in our database.</p>";
            } else {
                for (i = 0; i < arrayLength; i++) {
					
					eventList.className = "col-20 masonry";
					
                    var x = i + 1;
					
					ids.push([x, events[i].Event_id, events[i].Organisation_id, events[i].Address_id]);
					
					var link = document.createElement('a');
                    link.setAttribute("href", "index.php?action=eventManager&eventId=" + events[i].Event_id + "&organisationId=" + organisationId + "&senderPage=upcomingEvents");
					
					var eventBox = document.createElement('div');
					eventBox.setAttribute("id", "box" + x);
					eventBox.setAttribute("class", "eventBox");
                    link.appendChild(eventBox);
					
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
					
					var hiddenInfo = document.createElement('div');
					hiddenInfo.setAttribute("id", "info" + x);
					eventBox.appendChild(hiddenInfo);
					
					var skillsRow = document.createElement('div');
					skillsRow.setAttribute("id", "skills" + x);
					skillsRow.setAttribute("class", "col-20 skillsBox");
					hiddenInfo.appendChild(skillsRow);
					
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
					
					eventList.appendChild(link);
                }
				
				loadAdditionalInfo(ids);
            }
        }
    }
    xmlhttp.open("GET", "./model/ajax/upcomingEventsFetch.php?organisationId=" + organisationId, true);
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
				
				// Add the logo.
				var logo = document.getElementById('logo' + x);
				logo.setAttribute("src", organisationLogoUrl);
				
				//Add the organisation name.
				var organisationParagraph = document.getElementById('organiser' + x).innerHTML = organisationName;
				
				// Add the offered skills.
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
			}
        }
    }
    xmlhttp.open("GET", "./model/ajax/additionalEventInfoFetch.php?ids=" +  JSON.stringify(ids), true);
    xmlhttp.send();
}