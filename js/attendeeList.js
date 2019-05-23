/* Retrieves a list of all students who subscribed for an event. */
function loadAttendeeList(eventId) {
    'use strict';
    
    var list = document.getElementById('list');
    while (list.lastChild) {
        list.removeChild(list.lastChild);
    }
    
    var table = document.createElement('table');
    table.setAttribute("class", "SBtable");
    
    var head = table.createTHead();
    var headRow = head.insertRow(0);
    var headCell1 = headRow.insertCell(0);
    headCell1.setAttribute("style", "width:30%;");
    headCell1.innerHTML = "<b>Name</b>";
    var headCell2 = headRow.insertCell(1);
    headCell2.setAttribute("style", "width:30%;");
    headCell2.innerHTML = "<b>E-mail</b>";
    var headCell3 = headRow.insertCell(2);
    headCell3.innerHTML = "<b>Check-in</b>";
    
    table.appendChild(document.createElement('tbody'));
    var body = table.getElementsByTagName('tbody')[0];
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var attendees = JSON.parse(xmlhttp.responseText);
			
			var allowCheckIn = attendees[0];
			
            var i;
            var arrayLength = attendees.length;
            for (i = 1; i < arrayLength; i++) {
                
                var x = i + 1;
                
                var firstName = attendees[i][1];
                var lastName = attendees[i][2];
                var email = attendees[i][3];
                var checkedIn = attendees[i][4];
                var studentId = attendees[i][5];
                
                var row = body.insertRow(-1);
                var cell1 = row.insertCell(0);
                cell1.innerHTML = firstName + " " + lastName;
                var cell2 = row.insertCell(1);
                cell2.innerHTML = email;
                var cell3 = row.insertCell(2);
                cell3.setAttribute("id", studentId);
				cell3.setAttribute("align", "center");
				cell3.setAttribute("style", "padding:5px;");
                
				/* Check if the checkin form needs to be generated: if it the right time to check in for the event, allowCheckIn is set to 1. */
				if (allowCheckIn === 1) {
					/* Check if the student has been checked in already or not. If not, generate the checkin form. */
					if (checkedIn !== 1) {
						var form = document.createElement('form');
						form.setAttribute("action", AUXLIB.thisPage());
						form.setAttribute("method", "post");
						cell3.appendChild(form);
						var input1 = document.createElement('input');
						input1.setAttribute("type", "hidden");
						input1.setAttribute("name", "eventId");
						input1.setAttribute("value", eventId);
						form.appendChild(input1);
						var input2 = document.createElement('input');
						input2.setAttribute("type", "hidden");
						input2.setAttribute("name", "studentId");
						input2.setAttribute("value", studentId);
						form.appendChild(input2);
						var input3 = document.createElement('input');
						input3.setAttribute("type", "hidden");
						input3.setAttribute("name", "organisationId");
						input3.setAttribute("value", AUXLIB.organisationId());
						form.appendChild(input3);
						var input4 = document.createElement('input');
						input4.setAttribute("type", "hidden");
						input4.setAttribute("name", "senderPage");
						input4.setAttribute("value", AUXLIB.senderPage());
						form.appendChild(input4);
						var input5 = document.createElement('input');
						input5.setAttribute("type", "hidden");
						input5.setAttribute("name", "action");
						input5.setAttribute("value", "attendeeList");
						form.appendChild(input5);
						var attend = document.createElement('input');
						attend.setAttribute("type", "submit");
						attend.setAttribute("name", "submit");
						attend.setAttribute("value", "Check-in");
						attend.setAttribute("style", "background-color:#35bb35;");
						form.appendChild(attend);
					} else {
						var checked = document.createElement('img');
						checked.setAttribute("src", "./images/check.png");
						checked.setAttribute("style", "width:50px");
						checked.setAttribute("alt", "Checked");
						cell3.appendChild(checked);
					}
				} else if (allowCheckIn === 0) { // Too early to check in.
					if (checkedIn !== 1) {
						var notChecked = document.createElement('p');
						notChecked.innerHTML = "The check-in will start after the event has ended!";
						cell3.appendChild(notChecked);
					} else {
						var checked = document.createElement('img');
						checked.setAttribute("src", "./images/check.png");
						checked.setAttribute("style", "width:50px");
						checked.setAttribute("alt", "Checked");
						cell3.appendChild(checked);
					}
				} else if (allowCheckIn === 2) { // Too late to check in.
					if (checkedIn !== 1) {
						var notChecked = document.createElement('img');
						notChecked.setAttribute("src", "./images/noCheck.png");
						notChecked.setAttribute("style", "width:50px");
						notChecked.setAttribute("alt", "Not checked");
						cell3.appendChild(notChecked);
					} else {
						var checked = document.createElement('img');
						checked.setAttribute("src", "./images/check.png");
						checked.setAttribute("style", "width:50px");
						checked.setAttribute("alt", "Checked");
						cell3.appendChild(checked);
					}
				}
            }
        }
    }
    xmlhttp.open("GET", "./model/ajax/attendeeListFetch.php?eventId=" + eventId, true);
    xmlhttp.send();
    
    list.appendChild(table);
}