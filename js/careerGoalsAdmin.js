var hardSelected = 0;
var softSelected = 0;
var addCounter = 0;

function selectCareerGoal() {
	var skillTypeSelect = document.getElementById('careerGoalLevel');
	skillTypeSelect.options[1].selected = "true";
	checkValue(skillTypeSelect.options[1].value);
}

function selectCareerArea() {
	var skillTypeSelect = document.getElementById('careerGoalLevel');
	skillTypeSelect.options[2].selected = "true";
	checkValue(skillTypeSelect.options[2].value);
}

/* This function allows to show and populate a dropdown list based upon the value of another dropdown list. More specifically it shows the potential parent career goals, based upon the level of the current one that is being added. */
function checkValue(value) {
    'use strict';
    
    /* If the value is 1 of the careerGoalLevel, then there should be no parent added. So the parent select menu should only appear when the careerGoalLevel is not one. */
    if (value != 1) {
        
        // Get the container element and delete its current content.
        var container = document.getElementById('container');
        while (container.firstChild) {
            container.removeChild(container.firstChild);
        }
        
        //create and display the explanation paragraph.
        var text = document.createElement('p');
        text.innerHTML = "Select the parent career goal for this career goal.";
        container.appendChild(text);
        
        //Create a select element and put it in the container.
        var selectList = document.createElement('select');
        selectList.setAttribute("name", "parent");
        selectList.setAttribute("id", "careerGoalParent");
        container.appendChild(selectList);
		
		var emptyOption = document.createElement('option');
		emptyOption.setAttribute("selected", "true");
		emptyOption.setAttribute("disabled", "true");
		emptyOption.setAttribute("hidden", "true");
		emptyOption.value = "";
		selectList.appendChild(emptyOption);
        
        /* Use AJAX to get the array of potential parent career goals from the database, based upon the level of the one that is being added and populate the select element with these potential parent career goals. */
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var parents = JSON.parse(xmlhttp.responseText);
                var i;
                var arrayLength = parents.length;
                for (i = 0; i < arrayLength; i++) {
                    var parentOption = document.createElement('option');
                    parentOption.value = parents[i];
                    parentOption.text = parents[i];
                    selectList.appendChild(parentOption);
                }
            }
        }
        xmlhttp.open("GET", "./model/ajax/careerGoalFetch.php?level=" + value, true);
        xmlhttp.send();
        
        // Display the break after the container.
        var breakOne = document.getElementById('breakOne');
        breakOne.style = "display:;";
        
    } else {
        // Get the container element and delete its current content.
        var container = document.getElementById('container');
        while (container.firstChild) {
            container.removeChild(container.firstChild);
        }
        
        // Hide the break after the container.
        var breakOne = document.getElementById('breakOne');
        breakOne.style = "display:none;";
    }
}


/* This function provides hints for hard and softskills when typing them in a text field. */
function skillHint(str, type) {
    'use strict';
    
    if (type === 'hardskill') {
		var hardHints = document.getElementById('hardHints');
        while (hardHints.firstChild) {
            hardHints.removeChild(hardHints.firstChild);
        }
        if (str.length === 0) {
            hardHints.style.display = "none";
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                    var hintList = document.createElement('ul');
                    hintList.setAttribute("style", "display:;");
                    var skills = JSON.parse(xmlhttp.responseText);
                    var i;
                    var arrayLength = skills.length;
                    for (i = 0; i < arrayLength; i++) {
                        
                        var hint = document.createElement('li');
						
						var hintLink = document.createElement('a');
                        hintLink.setAttribute("href", "javascript:selectHint('" + skills[i] +"', 'hard')");
                        hintLink.innerHTML = skills[i];
                        hint.appendChild(hintLink);
						
                        hintList.appendChild(hint);
                    }
                    hardHints.style.display = "block";
                    hardHints.appendChild(hintList);
                }
            }
            xmlhttp.open("GET", "./model/ajax/skillHint.php?str=" + str + "&type=" + type, true);
            xmlhttp.send();
        }
		
		hardSelected = 0;
    }
    
    if (type === 'softskill') {
		var softHints = document.getElementById('softHints');
        while (softHints.firstChild) {
            softHints.removeChild(softHints.firstChild);
        }
        if (str.length === 0) {
            softHints.style.display = "none";
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                    var hintList = document.createElement('ul');
                    hintList.setAttribute("style", "display:;");
                    var skills = JSON.parse(xmlhttp.responseText);
                    var i;
                    var arrayLength = skills.length;
                    for (i = 0; i < arrayLength; i++) {
                        
                        var hint = document.createElement('li');
						
                        var hintLink = document.createElement('a');
                        hintLink.setAttribute("href", "javascript:selectHint('" + skills[i] +"', 'soft')");
                        hintLink.innerHTML = skills[i];
                        hint.appendChild(hintLink);
						
                        hintList.appendChild(hint);
                    }
                    softHints.style.display = "block";
                    softHints.appendChild(hintList);
                }
            }
            xmlhttp.open("GET", "./model/ajax/skillHint.php?str=" + str + "&type=" + type, true);
            xmlhttp.send();
        }
		
		softSelected = 0;
    }
}


/* This function automatically fills in the clicked hint in the input field. */
function selectHint(hint, type) {
    'use strict';
	
    if (type == 'hard') {
        var hardSkillInput = document.getElementById('hardSkillInput');
        hardSkillInput.value = hint;

        var hardHints = document.getElementById('hardHints');
        while (hardHints.firstChild) {
            hardHints.removeChild(hardHints.firstChild);
        }
        hardHints.style.display = "none";
		hardSelected = 1;
    }
    if (type == 'soft') {
        var softSkillInput = document.getElementById('softSkillInput');
        softSkillInput.value = hint;

        var softHints = document.getElementById('softHints');
        while (softHints.firstChild) {
            softHints.removeChild(softHints.firstChild);
        }
        softHints.style.display = "none";
		softSelected = 1;
    }
    
}


/* Takes the value of an inputfield with id $id and adds that value to the list on the page. Furthermore, it adds the value to a hidden input field of a form, separated of previously added values, if any, by a comma. */
function addToList(id) {
	'use strict';
	
	if ((id == 'hardSkillInput') && (hardSelected == 1)) {
		
		var input = document.getElementById(id);
		var skill = input.value;
		
		var box = document.createElement('div');
		box.setAttribute("id", "hardbox" + addCounter);
		box.setAttribute("class", "skillDisplay");
		
		var skillname = document.createElement('span');
		skillname.innerHTML = skill;
		box.appendChild(skillname);
		
		var remover = document.createElement('button');
		remover.setAttribute("class", "button-tiny");
		remover.setAttribute("onclick", "removes('hardskill', 'hardbox" + addCounter + "','" + skill +"')");
		remover.innerHTML = '×';
		box.appendChild(remover);
		
		document.getElementById('hardSkillDisplay').appendChild(box);
		
		var selection = document.getElementById('hardSkillsSelection');
		if (selection.value == "") {
			selection.value = skill;
		} else {
			selection.value = selection.value + "," + skill;
		}
		
		addCounter += 1;
		hardSelected = 0;
    }
    if ((id == 'softSkillInput') && (softSelected == 1)) {
			
		var input = document.getElementById(id);
		var skill = input.value;

		var box = document.createElement('div');
		box.setAttribute("id", "softbox" + addCounter);
		box.setAttribute("class", "skillDisplay");

		var skillname = document.createElement('span');
		skillname.innerHTML = skill;
		box.appendChild(skillname);

		var remover = document.createElement('button');
		remover.setAttribute("class", "button-tiny");
		remover.setAttribute("onclick", "removes('softskill', 'softbox" + addCounter + "','" + skill +"')");
		remover.innerHTML = '×';
		box.appendChild(remover);

		document.getElementById('softSkillDisplay').appendChild(box);

		var selection = document.getElementById('softSkillsSelection');
		if (selection.value == "") {
			selection.value = skill;
		} else {
			selection.value = selection.value + "," + skill;
		}

		addCounter += 1;
		softSelected = 0;
    }
}


//Removes the skill box and deletes its value from the hidden input fields.
function removes(type, boxId, skill) {
    'use strict';
    
    var container = document.getElementById(boxId);
    container.parentNode.removeChild(container);
    
	if (type === 'hardskill') {
		var selection = document.getElementById('hardSkillsSelection');      
		var array = selection.value.split(","); // Transform the string into an array.
		var index = array.indexOf(skill); // Get the index of the skillName.
		
		if (index > -1) {
			array.splice(index, 1); // Rmove the element witn index 'index' from the array
		}
		
		selection.value = array.toString(); // Convert the aray back to the string and insert it as value into the input.
	}
	
	if (type === 'softskill') {
		var selection = document.getElementById('softSkillsSelection');      
		var array = selection.value.split(",");
		var index = array.indexOf(skill);
		
		if (index > -1) {
			array.splice(index, 1);
		}
		
		selection.value = array.toString();
	}
}