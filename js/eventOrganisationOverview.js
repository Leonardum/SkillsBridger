/* Generates a list of all event oranisations of which the user with user id UserId is a part of. */
function loadEventOrganisations(userId) {
    'use strict';
    var content = document.getElementById('content');
    var eventOrganisationList = document.createElement('div');
	eventOrganisationList.setAttribute("style", "order:1; margin-bottom:20px;");
	eventOrganisationList.setAttribute("class", "col-20");
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var eventOrganisations = JSON.parse(xmlhttp.responseText);
            var i;
            var arrayLength = eventOrganisations.length;
            if (arrayLength == 0) {
                eventOrganisationList.innerHTML = "<p class='darkWatermark'>There are no event organisations you are part of.</p>";
            } else {
                for (i = 0; i < arrayLength; i++) {
                    var organisationId = eventOrganisations[i][0];
                    var organisation = eventOrganisations[i][1];
                    
                    var link = document.createElement('a');
                    link.setAttribute("href", "index.php?action=upcomingEvents&organisationId=" + organisationId);
					link.setAttribute("id", "anchor" + i);
					                    
                    var orgBox = document.createElement('div');
					orgBox.setAttribute("class", "col-20 orgBox");
                    orgBox.setAttribute("id", organisation.toLowerCase() + "Button");
					
					var col1 = document.createElement('div');
					col1.setAttribute("class", "orgBoxLogo");
					
					var auxBox = document.createElement('div');
					auxBox.setAttribute("class", "orgLogoDiv");
					
					var orgLogo = document.createElement('img');
					orgLogo.setAttribute("id", organisationId + "Logo");
					orgLogo.setAttribute("class", "orgLogo");
					
					auxBox.appendChild(orgLogo);
					col1.appendChild(auxBox);
					orgBox.appendChild(col1);
					
					
					var col2 = document.createElement('div');
					col2.setAttribute("class", "orgBoxName");
										
					var p = document.createElement('p');
                    p.innerHTML = organisation;
					col2.appendChild(p);
					orgBox.appendChild(col2);
					
					
                    link.appendChild(orgBox);
                    eventOrganisationList.appendChild(link);
					
					/* Prevent the organisation link to work in case the user clicks on the logo and trigger the upload of a new logo instead (not in use, cause it's annoying):
					document.getElementById("anchor" + i).addEventListener("click", function(event) {
						if (event.target.nodeName == "IMG") {
							event.preventDefault();
							document.getElementById(organisation + 'Logo').click();
						}
					}); */
                }
            }
			
			loadLogos();
        }
    }
    xmlhttp.open("GET", "./model/ajax/eventOrganisationsFetch.php?userId=" + userId, true);
    xmlhttp.send();
	
	content.appendChild(eventOrganisationList);
}


/* Load in the logos of the event organisations to display in the overview. */
function loadLogos() {
	var organisationIds = new Array();
	var userOrganisations = document.getElementsByClassName('orgLogo');
	var i;
	for (i = 0; i < userOrganisations.length; i++) {
		var logoId = userOrganisations[i].id;
		logoId = logoId.replace('Logo', '');
		organisationIds.push(logoId);
	}
	
	
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var logoUrls = JSON.parse(xmlhttp.responseText);
            var i;
            var arrayLength = logoUrls.length;
			for (i = 0; i < arrayLength; i++) {
				var orgLogo = document.getElementById(organisationIds[i] + "Logo");
				if (logoUrls[i] === 0) {
					orgLogo.setAttribute("src", "./images/logo.png");
				} else {
					orgLogo.setAttribute("src", logoUrls[i]);
				}
            }
        }
    }
    xmlhttp.open("GET", "./model/ajax/eventOrganisationsFetch.php?organisationIds=" + JSON.stringify(organisationIds), true);
    xmlhttp.send();
}


/* Removes the button that calls this function and replaces it with a form necessary to add a new event organisation to the database. */
function eventCreation(id) {
    'use strict';
    
    var container = document.getElementById(id);
    while (container.lastChild) {
        container.removeChild(container.lastChild);
    }
    
    var form = document.createElement('form');
    form.setAttribute("action", AUXLIB.thisPage());
    form.setAttribute("method", "post");
    
    var input1 = document.createElement('input');
    input1.setAttribute("type", "text");
    input1.setAttribute("name", "organisationName");
    input1.setAttribute("placeholder", "Organisation name");
	if (typeof AUXLIB.organisationName() !== 'undefined') {
		input1.setAttribute("value", AUXLIB.organisationName());
	}
    form.appendChild(input1);
    
    var input2 = document.createElement('input');
    input2.setAttribute("type", "hidden");
    input2.setAttribute("name", "action");
    input2.setAttribute("value", "eventOrganisationOverview");
    form.appendChild(input2);
    
    var input3 = document.createElement('input');
    input3.setAttribute("type", "submit");
    input3.setAttribute("name", "submit");
    input3.setAttribute("value", "Create event organisation");
    form.appendChild(input3);
    
    container.appendChild(form);
}