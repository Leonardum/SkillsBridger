/* This function loads the current organisation users in the page, along with a button to remove them as user. */
function loadMembers(companyId, userId) {
	var memberList = document.getElementById('memberList');
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			
			var members = JSON.parse(xmlhttp.responseText);
			var companyAdminId = members[0];
			
			var arrayLength = members.length;
			var i;
			for (i = 1; i < arrayLength; i++) {
				
				var memberId = members[i].memberId;
				var memberName = members[i].memberName;
				var picUrl = members[i].picUrl;
				
				var memberBox = document.createElement('div');
				memberBox.setAttribute("class", "memberLargePic");
				memberList.appendChild(memberBox);
				
				var nameTag = document.createElement('p');
				if (memberId == companyAdminId) {
					nameTag.innerHTML = memberName + " (admin)";
				} else {
					nameTag.innerHTML = memberName;
				}
				memberBox.appendChild(nameTag);
				
				var logoImg = document.createElement('img');
				if (picUrl != null) {
					logoImg.setAttribute("src", picUrl);
				} else {
					logoImg.setAttribute("src", "./images/userAccount.png");
				}
				logoImg.setAttribute("class", "memberLargePic");
				logoImg.setAttribute("alt", memberName);
				memberBox.appendChild(logoImg);
				
				if ((userId == companyAdminId) && (userId != memberId)) {
					var form = document.createElement('form');
					form.setAttribute("action", AUXLIB.thisPage());
					form.setAttribute("method", "post");
					memberBox.appendChild(form);
					var input1 = document.createElement('input');
					input1.setAttribute("type", "hidden");
					input1.setAttribute("name", "memberId");
					input1.setAttribute("value", memberId);
					form.appendChild(input1);
					var input2 = document.createElement('input');
					input2.setAttribute("type", "hidden");
					input2.setAttribute("name", "userId");
					input2.setAttribute("value", userId);
					form.appendChild(input2);
					var input3 = document.createElement('input');
					input3.setAttribute("type", "hidden");
					input3.setAttribute("name", "companyId");
					input3.setAttribute("value", companyId);
					form.appendChild(input3);
					var input4 = document.createElement('input');
					input4.setAttribute("type", "hidden");
					input4.setAttribute("name", "action");
					input4.setAttribute("value", "company");
					form.appendChild(input4);
					var removeMember = document.createElement('input');
					removeMember.setAttribute("type", "submit");
					removeMember.setAttribute("name", "remove");
					removeMember.setAttribute("value", "Remove");
					removeMember.setAttribute("class", "sponsorRemoveButton");
					form.appendChild(removeMember);
				}
			}
		}
	}
	xmlhttp.open("GET", "./model/ajax/companyMembersFetch.php?companyId=" + companyId, true);
	xmlhttp.send();
}


/* This function provides hints for user names when typing parts of them in a text field. */
function nameHint(e, str) {
    'use strict';
	
	var keynum;
	
	if(window.event) { // IE
		keynum = e.keyCode;
    } else if(e.which){ // Netscape, Firefox, Opera
		keynum = e.which;
    }
	
	if (keynum != 16) { // If the key is not shift.
		
		var name = document.getElementById('name');
		name.setAttribute("class", "");
		
		var newUserId = document.getElementById('newUserId');
		newUserId.value = "";
		
		if (str.length == 0) {
			while (hints.firstChild) {
				hints.removeChild(hints.firstChild);
			}
			hints.style.display = "none";
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
						var users = JSON.parse(xmlhttp.responseText);
						var i;
						var arrayLength = users.length;
						for (i = 0; i < arrayLength; i++) {
							
							var newUserId = users[i][0];
							var userName = users[i][1];
							var thumbnailUrl = users[i][2];
							
							var hint = document.createElement('li');
							
							var hintLink = document.createElement('a');
							hintLink.setAttribute("href", "javascript:selectHint('" + userName + "'," + newUserId +")");
							hintLink.innerHTML = userName;
							
							var hintImgBox = document.createElement('div');
							hintImgBox.setAttribute("class", "thumbnailBox");
							var hintImg = document.createElement('img');
							hintImg.setAttribute("class", "thumbnail");
							if (thumbnailUrl != undefined) {
								hintImg.setAttribute("src", thumbnailUrl);
							} else {
								hintImg.setAttribute("src", "./images/userAccount.png");
							}
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
			xmlhttp.open("GET", "./model/ajax/memberHintFetch.php?str=" + str, true);
			
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
    
    var userName = document.getElementById('name');
    userName.value = name;
    
    var newUserId = document.getElementById('newUserId');
    newUserId.value = id;

    var hints = document.getElementById('hints');
    while (hints.firstChild) {
        hints.removeChild(hints.firstChild);
    }
    
    hints.style.display = "none";
}