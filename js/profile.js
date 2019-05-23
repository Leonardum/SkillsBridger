/* This function loads a list with all career goals of the 1st and 2nd level and displays them on the page immediately after it loads. */
function loadMicrodegrees() {
    'use strict';
    
    var careerGoalsDiv = document.getElementById('careerGoals');
    
    /* Use AJAX to get the array of level 1 career goals from the database and to create the overview buttons and the form tags with. */
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var careerGoals = JSON.parse(xmlhttp.responseText);
            var i;
            var arrayLength = careerGoals.length;
            for (i = 0; i < arrayLength; i++) {
                var parent = careerGoals[i][0];
                
                var btn = document.createElement('button');
                btn.setAttribute("class", "button-overview");
                btn.setAttribute("id", parent.toLowerCase() + "Button");
                btn.setAttribute("onclick", "hide('" + parent.toLowerCase() + "Form')");
                btn.innerHTML = parent;
                careerGoalsDiv.appendChild(btn);
                
                var form = document.createElement('form');
                form.setAttribute("id", parent.toLowerCase() + "Form");
                form.setAttribute("Style", "display:none; margin-left:20px;");
                careerGoalsDiv.appendChild(form);
                
                var j;
                var arrLength = careerGoals[i].length;
                for (j = 2; j < arrLength; j++) {
                    var radio = document.createElement("input");
                    radio.setAttribute("type", "radio");
                    radio.setAttribute("name", parent.toLowerCase() + "Skills");
                    radio.setAttribute("onchange", "showSkills('"+ careerGoals[i][j][1] +"','container','" + parent.toLowerCase() + "Form')");
                    radio.setAttribute("id", careerGoals[i][j][0]);
                    form.appendChild(radio);
                    
                    var span = document.createElement('span');
                    span.setAttribute("class", "tickBoxText");
                    span.innerHTML = careerGoals[i][j][0];
                    form.appendChild(span);
                    
                    var br = document.createElement('br');
                    form.appendChild(br);
                }
            }
            
            var clearSelection = document.createElement('button');
            clearSelection.setAttribute("class", "button-overview");
			clearSelection.setAttribute("style", "background-color:rgba(120, 144, 156, 1) !important;");
            clearSelection.setAttribute("onclick", "clearSelection('container')");
            clearSelection.innerHTML = "Clear Selection";
            careerGoalsDiv.appendChild(clearSelection);
        }
    }
    xmlhttp.open("GET", "./model/ajax/skillsOverviewFetch.php?careerGoalLoad=true", true);
    xmlhttp.send();
	
	
	var eventOverviewDiv = document.getElementById('eventOverview');
	
	var table = document.createElement('table');
	table.setAttribute("class", "SBtable");
    
    var head = table.createTHead();
    var headRow = head.insertRow(0);
    var headCell1 = headRow.insertCell(0);
    headCell1.setAttribute("style", "width:20%;");
    headCell1.innerHTML = "<b>Event type</b>";
    var headCell2 = headRow.insertCell(1);
    headCell2.setAttribute("style", "width:80%;");
    headCell2.innerHTML = "<b>Certificates</b>";
    
    table.appendChild(document.createElement('tbody'));
    var body = table.getElementsByTagName('tbody')[0];
	
	var http = new XMLHttpRequest();
    http.onreadystatechange = function () {
        if (http.readyState === 4 && http.status === 200) {
            var microdegrees = JSON.parse(http.responseText);
            var j;
            var arrLength = microdegrees.length;
            for (j = 0; j < arrLength; j++) {
				var eventId = microdegrees[j][0];
				var organisationId = microdegrees[j][1];
				var eventName = microdegrees[j][2];
				var eventPurpose = microdegrees[j][3];
				var eventType = microdegrees[j][4];
				var eventSkillOne = microdegrees[j][5];
				
				/* If there is a skill offered on the event, show the microdegree. */
				if (eventSkillOne != null) {
					/* The !! before the DOM query makes sure that the query returns true if the element is found or false if it is not. Therefore it can be used to check if an element exists. */
					var rowExists = !!document.getElementById(eventType + "Row");
					
					if (rowExists) {
						var row = document.getElementById(eventType + "Row");
						var cell2 = row.cells[1];
						var degree = document.createElement('img');
						degree.setAttribute("src", "./images/microDegree.png");
						degree.setAttribute("title", eventName);
						degree.setAttribute("class", "microdegree");
						cell2.appendChild(degree);
					} else {
						var row = body.insertRow(-1);
						row.setAttribute("id", eventType + "Row");
						var cell1 = row.insertCell(0);
						cell1.innerHTML = "<b>" + eventType.capitalize() + "</b>";
						var cell2 = row.insertCell(-1);
						var degree = document.createElement('img');
						degree.setAttribute("src", "./images/microDegree.png");
						degree.setAttribute("title", eventName);
						degree.setAttribute("class", "microdegree");
						cell2.appendChild(degree);
					}
				}
			}
        }
    }
    http.open("GET", "./model/ajax/microdegreesFetch.php?getMicrodegrees=true&studentId=" + AUXLIB.studentId(), true);
    http.send();
	
	eventOverviewDiv.appendChild(table);
}


/* This function first removes the complere content of an element. Next it adds new skill boxes to that same element.

This function takes 3 parameters: the career goal it is loading the skills for, containerId, the id of the container where the content will be deleted and the new skillboxes will be added and formId, the id of the form where the radio box has been ticked on. The last 2 parameters must be passed as a string! */
function showSkills(careerGoalId, containerId, formId) {
    'use strict';
    
    /* Reset all forms in the careerGoals div, except the one which has called this function. */
    var formAmmount = document.forms.length;
    var form = document.forms;
    var j;
    for (j = 0; j < formAmmount; j++) {
        if (form[j].parentNode.id == 'careerGoals') {
            if (form[j].id !== formId) {
                form[j].reset();
            }
        }
    }
    
    // Empty the container of current elements.
    var container = document.getElementById(containerId);
    while (container.lastChild) {
        container.removeChild(container.lastChild);
    }
    
    /* Use Ajax to retrieve the skills for the selected career goal and create the skillboxes and place them in the container div. */
    var hardContainer = document.createElement('div');
    hardContainer.setAttribute("class", "col-20 skillContainer");
    container.appendChild(hardContainer);
    var hardTitle = document.createElement('h2');
    hardTitle.innerHTML = "Hardskills and subjects:";
    hardContainer.appendChild(hardTitle);
    
    var softContainer = document.createElement('div');
    softContainer.setAttribute("class", "col-20 skillContainer");
    container.appendChild(softContainer);
    var softTitle = document.createElement('h2');
    softTitle.innerHTML = "Softskills:";
    softContainer.appendChild(softTitle);
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var skills = JSON.parse(xmlhttp.responseText);
            var i;
            var arrayLength = skills.length;
            for (i = 0; i < arrayLength - 1; i++) {
                
				var skillLink = document.createElement('a');
                skillLink.setAttribute("href", "index.php?action=eventPerSkill&studentId=" + AUXLIB.studentId() + "&skillId=" + skills[i]['Skill_id']);
				
				var skillBox = document.createElement('div');
                skillBox.setAttribute("id", skills[i]['Skill_id'] + "box");
                skillBox.setAttribute("display", "inline;");
                skillBox.setAttribute("class", "skillBox");
                skillBox.setAttribute("title", skills[i]['Description']);
                skillBox.innerHTML = "<p style='text-align:center;'>" + skills[i]['Name'] + "!</p>";
				
				var eventCount = skills[i]['Event_count'];
				if (eventCount !== 0) {
					var eventCounter = document.createElement('div');
					eventCounter.setAttribute("class", "eventCounter");
					eventCounter.innerHTML = "View " + eventCount + "event(s)!";
					skillBox.appendChild(eventCounter);
				}
				
				skillLink.appendChild(skillBox);
				
                if (skills[i]['Type'] == 'hardskill') {
                    hardContainer.appendChild(skillLink);
                } else {
                    softContainer.appendChild(skillLink);
                }
            }
			
			var microdegrees = arrayLength - 1;
			var j;
			var arrLength = skills[microdegrees].length;
            for (j = 0; j < arrLength; j++) {
				var eventId = skills[microdegrees][j][0];
				var organisationId = skills[microdegrees][j][1];
				var eventName = skills[microdegrees][j][2];
				var eventPurpose = skills[microdegrees][j][3];
				var eventType = skills[microdegrees][j][4];
				
				var k;
				var microdgree = skills[microdegrees][j].length;
				for (k = 5; k < microdgree; k++) {
					var skillId = skills[microdegrees][j][k];
					
					var box = document.getElementById(skillId + 'box');
					if (box) {
						var degree = document.createElement('img');
						degree.setAttribute("src", "./images/microDegree.png");
						degree.setAttribute("title", eventName);
						degree.setAttribute("class", "microdegree");
						
						box.appendChild(degree);
					}
				}
			}
		}			
    }
    xmlhttp.open("GET", "./model/ajax/microdegreesFetch.php?careerGoalId=" + careerGoalId + "&studentId=" + AUXLIB.studentId(), true);
    xmlhttp.send();
}


/* This function clears the skills container of all elements and places a watermark style message in it instead (which give the user instructions on how to use the screen they see). Moreover it clears the selection of all forms within the careerGoals div. */
function clearSelection(containerId) {
    'use strict';
    
    var formAmmount = document.forms.length;
    var form = document.forms;
    var j;
    for (j = 0; j < formAmmount; j++) {
        if (form[j].parentNode.id === 'careerGoals') {
            form[j].reset();
			form[j].style.display = "none";
        }
    }
    
    var container = document.getElementById(containerId);
    while (container.lastChild) {
        container.removeChild(container.lastChild);
    }
    
    container.innerHTML = "<p style='color:rgb(220,220,220); text-align:center; font-size:30px; padding:50px 0 50px 0;'>Select a Career Goal in the list to show the skills!</p>";
}