/* This function loads the current event sponsors in the page, along with a button to remove them as event spsonsor. */
function loadSponsors(eventId) {
	var sponsorList = document.getElementById('sponsorList');
	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			
			var sponsors = JSON.parse(xmlhttp.responseText);
			var arrayLength = sponsors.length;
			
			if (arrayLength != 0) {
				var currentSponsors = document.getElementById('currentSponsors');
				currentSponsors.innerHTML = "These are your current sponsors:";
			}
			
			var i;
			for (i = 0; i < arrayLength; i++) {
				
				
				var sponsorId = sponsors[i][0];
				var sponsorName = sponsors[i][1];
				var sponsorLogoUrl = sponsors[i][2];
				
				var logoBox = document.createElement('div');
				logoBox.setAttribute("class", "sponsorLargeLogo");
				sponsorList.appendChild(logoBox);
				
				var logoImg = document.createElement('img');
				logoImg.setAttribute("src", sponsorLogoUrl);
				logoImg.setAttribute("class", "sponsorLargeLogo");
				logoImg.setAttribute("alt", sponsorName);
				logoBox.appendChild(logoImg);
				
				var form = document.createElement('form');
				form.setAttribute("action", AUXLIB.thisPage());
				form.setAttribute("method", "post");
				logoBox.appendChild(form);
				var input1 = document.createElement('input');
				input1.setAttribute("type", "hidden");
				input1.setAttribute("name", "sponsorId");
				input1.setAttribute("value", sponsorId);
				form.appendChild(input1);
				var input2 = document.createElement('input');
				input2.setAttribute("type", "hidden");
				input2.setAttribute("name", "eventId");
				input2.setAttribute("value", eventId);
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
				input5.setAttribute("value", "addSponsor");
				form.appendChild(input5);
				var removeSponsor = document.createElement('input');
				removeSponsor.setAttribute("type", "submit");
				removeSponsor.setAttribute("name", "remove");
				removeSponsor.setAttribute("value", "Remove");
				removeSponsor.setAttribute("class", "sponsorRemoveButton");
				form.appendChild(removeSponsor);
			}
		}
	}
	xmlhttp.open("GET", "./model/ajax/sponsorsFetch.php?eventId=" + eventId, true);
	xmlhttp.send();
}


/* This function provides hints for sponsor names when typing parts of them in a text field. */
function sponsorHint(e, str) {
    'use strict';
	
	var keynum;
	
	if(window.event) { // IE
		keynum = e.keyCode;
    } else if(e.which){ // Netscape/Firefox/Opera
		keynum = e.which;
    }
	
	if (keynum != 16) { //If the key is not shift
		
		var name = document.getElementById('name');
		name.setAttribute("class", "");
		
		var newSponsorId = document.getElementById('newSponsorId');
		newSponsorId.value = "";
		
		if (str.length === 0) {
			hints.style.display = "none";
			while (hints.firstChild) {
				hints.removeChild(hints.firstChild);
			}
		} else {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function () {
				if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
					
					var hints = document.getElementById('hints');
					while (hints.firstChild) {
						hints.removeChild(hints.firstChild);
					}
					
					if (name.value != '') {
						var hintList = document.createElement('ul');
						hintList.setAttribute("style", "display:;");
						var sponsors = JSON.parse(xmlhttp.responseText);
						var i;
						var arrayLength = sponsors.length;
						for (i = 0; i < arrayLength; i++) {
							
							var newSponsorId = sponsors[i][0];
							var sponsorName = sponsors[i][1];
							var thumbnailUrl = sponsors[i][2];
							
							var hint = document.createElement('li');
							
							var hintLink = document.createElement('a');
							hintLink.setAttribute("href", "javascript:selectHint('" + sponsorName + "'," + newSponsorId +")");
							hintLink.innerHTML = sponsorName;
							
							var hintImgBox = document.createElement('div');
							hintImgBox.setAttribute("class", "thumbnailBox");
							var hintImg = document.createElement('img');
							hintImg.setAttribute("class", "thumbnail");
							hintImg.setAttribute("src", thumbnailUrl);
							hintImgBox.appendChild(hintImg);
							hintLink.appendChild(hintImgBox);
							
							hint.appendChild(hintLink);
							hintList.appendChild(hint);
							
							if (i < arrayLength - 1) {
								var divider = document.createElement('li');
								divider.setAttribute("class", "divider");
								divider.setAttribute("style", "margin:0;");
								hintList.appendChild(divider);
							}
						}
						hints.style.display = "block";
						hints.appendChild(hintList);
					}
				}
			}
			xmlhttp.open("GET", "./model/ajax/sponsorsFetch.php?str=" + str, true);

			xmlhttp.setRequestHeader("Pragma", "no-cache");
			xmlhttp.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
			xmlhttp.setRequestHeader("Expires", 0);
			xmlhttp.setRequestHeader("Last-Modified", new Date(0));
			xmlhttp.setRequestHeader("If-Modified-Since", new Date(0));
			
			xmlhttp.send();
		}
    }
}


/* This function automatically fills in the clicked hint in the input field. */
function selectHint(name, id) {
    'use strict';
	
	var elem = document.createElement('textarea');
	elem.innerHTML = name;
	var decodedName = elem.value;
    
    var sponsorName = document.getElementById('name');
    sponsorName.value = decodedName;
    
    var newSponsorId = document.getElementById('newSponsorId');
    newSponsorId.value = id;
	
    var hints = document.getElementById('hints');
    while (hints.firstChild) {
        hints.removeChild(hints.firstChild);
    }
    
    hints.style.display = "none";
}