/* Retrieves a list of all students who applied for an event. */
function loadCandidateList(eventId) {
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
    headCell3.innerHTML = "<b>Approve candidate</b>";
    
    table.appendChild(document.createElement('tbody'));
    var body = table.getElementsByTagName('tbody')[0];
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var candidates = JSON.parse(xmlhttp.responseText);
			
			var allowApproval = candidates[0];
			var capacityReached = candidates[1];
			
            var i;
            var arrayLength = candidates.length;
            for (i = 2; i < arrayLength; i++) {
                
                var firstName = candidates[i][1];
                var lastName = candidates[i][2];
                var email = candidates[i][3];
                var approved = candidates[i][4];
                var studentId = candidates[i][5];
                
                var row = body.insertRow(-1);
                var cell1 = row.insertCell(0);
                cell1.innerHTML = firstName + " " + lastName;
                var cell2 = row.insertCell(1);
                cell2.innerHTML = email;
                var cell3 = row.insertCell(2);
                cell3.setAttribute("id", studentId);
				cell3.setAttribute("align", "center");
				cell3.setAttribute("style", "padding:5px;");
                
				
				if (capacityReached === 0) {
					/* Check if the approval form needs to be generated: if it the right time to approve candidates for the event, allowApproval is set to 1. */
					if (allowApproval === 1) {
						/* Check if the student has been approved already or not. If not, generate the approval form. */
						if (approved !== 1) {
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
							input5.setAttribute("value", "candidateList");
							form.appendChild(input5);
							var attend = document.createElement('input');
							attend.setAttribute("type", "submit");
							attend.setAttribute("name", "submit");
							attend.setAttribute("value", "Approve");
							attend.setAttribute("style", "background-color:#35bb35;");
							form.appendChild(attend);
						} else {
							var isApproved = document.createElement('img');
							isApproved.setAttribute("src", "./images/check.png");
							isApproved.setAttribute("style", "width:50px");
							isApproved.setAttribute("alt", "Approved");
							cell3.appendChild(isApproved);
						}
					} else if (allowApproval === 0) { // Too early to approve.
						if (approved !== 1) {
							var isNotApproved = document.createElement('p');
							isNotApproved.innerHTML = "You will be able to approve the student later on!";
							cell3.appendChild(isNotApproved);
						} else {
							var isApproved = document.createElement('img');
							isApproved.setAttribute("src", "./images/check.png");
							isApproved.setAttribute("style", "width:50px");
							isApproved.setAttribute("alt", "Approved");
							cell3.appendChild(isApproved);
						}
					} else if (allowApproval === 2) { // Too late to approve.
						if (approved !== 1) {
							var isNotApproved = document.createElement('img');
							isNotApproved.setAttribute("src", "./images/noCheck.png");
							isNotApproved.setAttribute("style", "width:50px");
							isNotApproved.setAttribute("alt", "Not approved");
							cell3.appendChild(isNotApproved);
						} else {
							var isApproved = document.createElement('img');
							isApproved.setAttribute("src", "./images/check.png");
							isApproved.setAttribute("style", "width:50px");
							isApproved.setAttribute("alt", "Approved");
							cell3.appendChild(isApproved);
						}
					}
				} else {
					if (approved !== 1) {
						var isNotApproved = document.createElement('p');
						isNotApproved.innerHTML = "You have reached the capacity of your event!";
						cell3.appendChild(isNotApproved);
					} else {
						var isApproved = document.createElement('img');
						isApproved.setAttribute("src", "./images/check.png");
						isApproved.setAttribute("style", "width:50px");
						isApproved.setAttribute("alt", "Approved");
						cell3.appendChild(isApproved);
					}
				}
            }
        }
    }
    xmlhttp.open("GET", "./model/ajax/candidateListFetch.php?eventId=" + eventId, true);
    xmlhttp.send();
    
    list.appendChild(table);
}