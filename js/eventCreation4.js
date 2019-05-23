var counter = 0;
var addCounter = 0;
var addedSkills = [];


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
}


/* Takes the value of an inputfield with id 'id' and adds that value to the list on the page. Furthermore, it adds the value to a hidden input field of a form, separated of previously added values, if any, by a comma. */
function addToList(id) {
    'use strict';
    
	var eventType = AUXLIB.eventType();
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
	} else if (eventType == 'full-time job' || eventType == 'half-time job' || eventType == 'internship') {
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
function checkSkillsAdded() {
    'use strict';
	
	var eventPurpose = AUXLIB.eventPurpose();
	if (eventPurpose == 'learning' && counter == 0) {
		alert("You have to add at least one skill which will be taught at your learning event. Make sure you click the 'Add' button after selecting a skill!");
	} else {
		var form = document.getElementById('skillForm');
		form.submit();
	}
}