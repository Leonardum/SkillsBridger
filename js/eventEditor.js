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


// Unchecks the "yes" answer if that is checked and hides the price input field.
function uncheckYes(isTicked) {
	var price = document.getElementById('price');
	var paymentMethod = document.getElementById('paymentMethod');
	if (isTicked) {
		var paidEntrance = document.getElementById('paidEntrance');
		if (paidEntrance.checked) {
			paidEntrance.checked = false;
			price.style.display = 'none';
			paymentMethod.style.display = 'none';
		}
		
		var entrancePaid = document.getElementById('entrancePaid');
		if (entrancePaid.checked) {
			entrancePaid.checked = false;
		}
		
		var onlinePaid = document.getElementById('onlinePaid');
		if (onlinePaid.checked) {
			onlinePaid.checked = false;
			
			alternateSubscription = document.getElementById('alternateSubscription');
			var subscriptionPage = document.getElementById('subscriptionPage');
			if (!alternateSubscription.checked) {
				subscriptionPage.style.display = 'none';
			}
		}
		
		/* var children = price.childNodes;
		for(var i = 0; i < children.length; i++) {
			children[i].style.display = 'none';
		} */
	}
}


// Unchecks the "no" answer if that is checked and shows the price input field.
function uncheckNo(isTicked) {
	var price = document.getElementById('price');
	var paymentMethod = document.getElementById('paymentMethod');
	if (isTicked) {
		var freeEntrance = document.getElementById('freeEntrance');
		if (freeEntrance.checked) {
			freeEntrance.checked = false;
		}
		price.style.display = 'block';
		paymentMethod.style.display = 'block';
	} else {
		price.style.display = 'none';
		paymentMethod.style.display = 'none';
		
		var entrancePaid = document.getElementById('entrancePaid');
		if (entrancePaid.checked) {
			entrancePaid.checked = false;
		}
		
		var onlinePaid = document.getElementById('onlinePaid');
		if (onlinePaid.checked) {
			onlinePaid.checked = false;
		}
	}
}


// Unchecks the "online" answer if that is checked.
function uncheckOnline(isTicked) {
	if (isTicked) {
		var onlinePaid = document.getElementById('onlinePaid');
		if (onlinePaid.checked) {
			onlinePaid.checked = false;
			var alternateSubscription = document.getElementById('alternateSubscription');
			if (!alternateSubscription.checked) {
				subscriptionPage.style.display = 'none';
			}
		}
	}
}


// Unchecks the "entrance" answer if that is checked.
function uncheckEntrance(isTicked) {
	var subscriptionPage = document.getElementById('subscriptionPage');
	if (isTicked) {
		var entrancePaid = document.getElementById('entrancePaid');
		if (entrancePaid.checked) {
			entrancePaid.checked = false;
		}
		
		subscriptionPage.style.display = 'block';
	} else {
		var alternateSubscription = document.getElementById('alternateSubscription');
		if (!alternateSubscription.checked) {
			subscriptionPage.style.display = 'none';
		}
	}
}


// Shows the input field for the external link if this box is checked and hides it  if it is not (unless the event should be paid online).
function setSubscriptionPage(isTicked) {
	var subscriptionPage = document.getElementById('subscriptionPage');
	if (isTicked) {
		subscriptionPage.style.display = 'block';
	} else {
		var onlinePaid = document.getElementById('onlinePaid');
		if (!onlinePaid.checked) {
			subscriptionPage.style.display = 'none';
		}
	}
}


/* Shows the textarea to describe who exactly the event is for, in case this box is checked. */
function setOpenFor(isTicked) {
	var openFor = document.getElementById('openFor');
	if (isTicked) {
		openFor.style.display = 'block';
	} else {
		openFor.style.display = 'none';
	}
}


// Unchecks the motivation letter required box when this box is checked.
function setMotivationLetterEncouraged(isTicked) {
	if (isTicked) {
		var motivationLetter = document.getElementById('motivationLetter');
		motivationLetter.checked = false;
	}
}


// Unchecks the motivation letter encouraged box when this box is checked.
function setMotivationLetter(isTicked) {
	if (isTicked) {
		var motivationLetterEncouraged = document.getElementById('motivationLetterEncouraged');
		motivationLetterEncouraged.checked = false;
	}
}


// Unchecks the cv required box when this box is checked.
function setCvEncouraged(isTicked) {
	if (isTicked) {
		var cv = document.getElementById('cv');
		cv.checked = false;
	}
}


// Unchecks the cv encouraged box when this box is checked.
function setCv(isTicked) {
	if (isTicked) {
		var cvEncouraged = document.getElementById('cvEncouraged');
		cvEncouraged.checked = false;
	}
}


var recordedSkills = AUXLIB.recordedSkills();
if (recordedSkills) {
	var counter = recordedSkills.length;
	var addCounter = counter;
	var addedSkills = [];
	var a;
	for (a = 0; a < counter; a++) {
		addedSkills.push(recordedSkills[a][0]);
	}
} else {
	var counter = 0;
	var addCounter = 0;
	var addedSkills = [];
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


/* This function loads the hard and softskills from the database into the select lists. */
function loadSkills() {
    'use strict';
    
    var hardSkillSelect = document.getElementById('hardSkillSelect');
    var softSkillSelect = document.getElementById('softSkillSelect');
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var skills = JSON.parse(xmlhttp.responseText);
            var i;
            var arrayLength = skills.length;
            for (i = 0; i < arrayLength; i++) {
                var option = document.createElement('option');
                var skillId = skills[i][0];
                var skillName = skills[i][1];
                var skillType = skills[i][2];
                var skillDescription = skills[i][3];
                option.value = skillId;
                option.text = skillName;
                option.title = skillDescription;
				
                if (skillType == 'hardskill') {
                    hardSkillSelect.appendChild(option);
                } else {
                    softSkillSelect.appendChild(option);
                }
            }
        }
    }
    xmlhttp.open("GET", "./model/ajax/allSkillsFetch.php", true);
    xmlhttp.send();
	
	if (recordedSkills) {
		var j;
		for (j = 0; j < recordedSkills.length; j++) {
			var skillId = recordedSkills[j][0];
			var skill = recordedSkills[j][1];
			var skillType = recordedSkills[j][2];
			
			var box = document.createElement('div');
			box.setAttribute("class", "skillDisplay");
			
			var skillname = document.createElement('span');
			skillname.innerHTML = skill;
			box.appendChild(skillname);
			
			var remover = document.createElement('button');
			remover.setAttribute("type", "button");
			remover.setAttribute("class", "button-tiny");
			remover.innerHTML = '×';
			box.appendChild(remover);
			
			if (skillType == 'hardskill') {
				box.setAttribute("id", "hardbox" + j);

				remover.setAttribute("onclick", "removes('hardskill', 'hardbox" + j + "','" + skillId +"')");

				var hardSkillDisplay = document.getElementById('hardSkillDisplay');
				hardSkillDisplay.appendChild(box);
			}
			if (skillType == 'softskill') {
				box.setAttribute("id", "softbox" + j);

				remover.setAttribute("onclick", "removes('softskill', 'softbox" + j + "','" + skillId +"')");

				var softSkillDisplay = document.getElementById('softSkillDisplay');
				softSkillDisplay.appendChild(box);
			}
		}
	}
	
	loadSelectedEventType();
}


/* This function loads event types appropriate event types into the select menu, based on the current event purpose and makes sure the current event type is selected. */
function loadSelectedEventType() {
    'use strict';
	
    var eventPurposeSelect = document.getElementById('eventPurpose');
	var selectedEventPurpose = eventPurposeSelect.options[eventPurposeSelect.selectedIndex].value;
	var eventTypeSelect = document.getElementById('eventType');
	var selectedEventType = AUXLIB.selectedEventType();
	
	while (eventType.lastChild) {
        eventType.removeChild(eventType.lastChild);
    }
	
	if (selectedEventPurpose == 'career') {
		var types = ['CV and interview coaching', 'in-house day and company presentation', 'info session', 'job fair', 'networking event', 'social media coaching'];
	} else if (selectedEventPurpose == 'job') {
		var types = ['full-time job', 'half-time job', 'internship'];
	} else if (selectedEventPurpose == 'learning') {
		var types = ['business game', 'consulting project','debate', 'lecture', 'masterclass', 'online course', 'skills-program', 'summer school', 'volunteering experience', 'workshop'];
	}
	
	if (selectedEventType == null) {
		var emptyOption = document.createElement('option');
		emptyOption.setAttribute("selected", "true");
		emptyOption.setAttribute("disabled", "true");
		emptyOption.setAttribute("hidden", "true");
		emptyOption.value = "";
		eventTypeSelect.appendChild(emptyOption);
	}
	
	var i;
	var arrayLength = types.length;
	for (i = 0; i < arrayLength; i++) {
		var typeOption = document.createElement('option');
		typeOption.value = types[i];
		typeOption.text = types[i].capitalize();
		if (types[i] == selectedEventType) {
			typeOption.selected = 'true';
		}
		eventTypeSelect.appendChild(typeOption);
	}
}


/* Takes the value of an inputfield with id $id and adds that value to the list on the page. Furthermore, it adds the value to a hidden input field of a form, separated of previously added values, if any, by a comma. */
function addToList(id) {
    'use strict';
    
	var eventTypeSelect = document.getElementById('eventType');
	var eventType = eventTypeSelect.options[eventTypeSelect.selectedIndex].value;
	if (eventType == 'job fair' || eventType == 'networking event' || eventType == 'info session') {
		var maxSkillAmount = 0;
	} else if (eventType == 'social media coaching') {
		var maxSkillAmount = 1;
	} else if (eventType == 'CV and interview coaching' || eventType == 'debate' || eventType == 'lecture') {
		var maxSkillAmount = 2;
	} else if (eventType == 'in-house day and company presentation' || eventType == 'masterclass' || eventType == 'workshop') {
		var maxSkillAmount = 3;
	} else if (eventType == 'skills-program' || eventType == 'volunteering experience' || eventType == 'business game') {
		var maxSkillAmount = 6;
	} else if (eventType == 'summer school' || eventType == 'consulting project' || eventType == 'online course') {
		var maxSkillAmount = 7;
	} else if (eventType == 'internship') {
		var maxSkillAmount = 10;
	} else {
		var maxSkillAmount = 3;
	}
	
    if (counter < maxSkillAmount) {
        var select = document.getElementById(id);
        var skillId = select.value;
		
		if (skillId != "") {
			if (!partOfArray(skillId, addedSkills)) {
				var skill = select.options[select.selectedIndex].innerHTML; /*get the text of the selected option */

				var box = document.createElement('div');
				box.setAttribute("class", "skillDisplay");

				var skillname = document.createElement('span');
				skillname.innerHTML = skill;
				box.appendChild(skillname);

				var remover = document.createElement('button');
				remover.setAttribute("class", "button-tiny");
				remover.innerHTML = '×';
				box.appendChild(remover);

				if (id == 'hardSkillSelect') {
					box.setAttribute("id", "hardbox" + addCounter);

					remover.setAttribute("onclick", "removes('hardskill', 'hardbox" + addCounter + "','" + skillId +"')");

					var hardSkillDisplay = document.getElementById('hardSkillDisplay');
					hardSkillDisplay.appendChild(box);
					var selection = document.getElementById('skillsSelection');
					if (selection.value == "") {
						selection.value = skillId;
					} else {
						selection.value = selection.value + "," + skillId;
					}
				}
				if (id == 'softSkillSelect') {
					box.setAttribute("id", "softbox" + addCounter);

					remover.setAttribute("onclick", "removes('softskill', 'softbox" + addCounter + "','" + skillId +"')");

					var softSkillDisplay = document.getElementById('softSkillDisplay');
					softSkillDisplay.appendChild(box);
					var selection = document.getElementById('skillsSelection');
					if (selection.value == "") {
						selection.value = skillId;
					} else {
						selection.value = selection.value + "," + skillId;
					}
				}

				counter += 1;
				addCounter += 1;
				addedSkills.push(skillId);
			} else {
				var error = document.getElementById('skillError');
				error.classList.remove('fade');
				/* The following line of code will trigger the browser to synchronously calculate the style and layout. This is called reflow or layout thrashing (and is common performance bottleneck). But it is a handy trick to restart CSS animations. */
				void error.offsetWidth;
				error.innerHTML = "Adding the same skill multiple times is not allowed!";
				error.className = "error fade";
			}
		}
    } else {
		var error = document.getElementById('skillError');
		error.classList.remove('fade');
		void error.offsetWidth;
		error.innerHTML = "You have reached the maximum amount of skills for this event type!";
		error.className = "error fade";
	}
}


//Removes the skill box and deletes its value from the hidden input fields.
function removes(type, boxId, skillId) {
    'use strict';
    
    var container = document.getElementById(boxId);
    container.parentNode.removeChild(container);
    
    var selection = document.getElementById('skillsSelection');      
    var array = selection.value.split(","); // Transform the string into an array.
    var index = array.indexOf(skillId); // Get the index of the skill.

    if (index > -1) {
        array.splice(index, 1); // Rmove the element witn index 'index' from the array
    }

    selection.value = array.toString(); // Convert the aray back to the string and insert it as value into the input.
    
    counter -= 1;
	var addedSkillsIndex = addedSkills.indexOf(skillId);
	if (addedSkillsIndex > -1) {
		addedSkills.splice(addedSkillsIndex, 1);
	}
}


// Checks if skills are added and alerts the user if there aren't any added.
function checkSkillsAdded(eventId) {
    'use strict';
	
	var eventPurposeSelect = document.getElementById('eventPurpose');
	var eventPurpose = eventPurposeSelect.options[eventPurposeSelect.selectedIndex].value;
	if (eventPurpose == 'learning' && counter == 0) {
		alert("You have to add at least one skill which will be taught at your learning event. Make sure you click the 'Add' button after selecting a skill!");
	} else {
		var submitButton = document.getElementById('submitButton');
		submitButton.click();
	}
}