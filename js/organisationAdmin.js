/* This function provides hints for user names when typing parts of them in a text field. */
function nameHint(e, str) {
    'use strict';
	
	var keynum;
	
	if(window.event) { // IE
		keynum = e.keyCode;
    } else if(e.which){ // Netscape/Firefox/Opera
		keynum = e.which;
    }
	
	if (keynum != 16) { //If the key is not shift
		
		var adminUser = document.getElementById('adminUser');
		adminUser.setAttribute("class", "");
		
		var adminUserId = document.getElementById('adminUserId');
		adminUserId.value = "";
		
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
					
					if (adminUser.value != '') {
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
    
    var adminUser = document.getElementById('adminUser');
    adminUser.value = name;
    
    var adminUserId = document.getElementById('adminUserId');
    adminUserId.value = id;

    var hints = document.getElementById('hints');
    while (hints.firstChild) {
        hints.removeChild(hints.firstChild);
    }
    
    hints.style.display = "none";
}