/* Generates a list of all event oranisations of which the user with user id UserId is a part of. */
function loadCompanies(userId) {
    'use strict';
    var content = document.getElementById('content');
    var companyList = document.createElement('div');
	companyList.setAttribute("style", "order:1; margin-bottom:20px;");
	companyList.setAttribute("class", "col-20");
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var companies = JSON.parse(xmlhttp.responseText);
            var i;
            var arrayLength = companies.length;
            if (arrayLength == 0) {
                companyList.innerHTML = "<p class='darkWatermark'>There are currently no companies you represent on SkillsBridger.</p>";
            } else {
                for (i = 0; i < arrayLength; i++) {
                    var companyId = companies[i][0];
                    var company = companies[i][1];
                    
                    var link = document.createElement('a');
                    link.setAttribute("href", "index.php?action=vacantJobs&companyId=" + companyId);
					link.setAttribute("id", "anchor" + i);
					                    
                    var companyBox = document.createElement('div');
					companyBox.setAttribute("class", "col-20 orgBox");
                    companyBox.setAttribute("id", company.toLowerCase() + "Button");
					
					var col1 = document.createElement('div');
					col1.setAttribute("class", "orgBoxLogo");
					
					var auxBox = document.createElement('div');
					auxBox.setAttribute("class", "orgLogoDiv");
					
					var companyLogo = document.createElement('img');
					companyLogo.setAttribute("id", companyId + "Logo");
					companyLogo.setAttribute("class", "orgLogo");
					
					auxBox.appendChild(companyLogo);
					col1.appendChild(auxBox);
					companyBox.appendChild(col1);
					
					
					var col2 = document.createElement('div');
					col2.setAttribute("class", "orgBoxName");
										
					var p = document.createElement('p');
                    p.innerHTML = company;
					col2.appendChild(p);
					companyBox.appendChild(col2);
					
					
                    link.appendChild(companyBox);
                    companyList.appendChild(link);
					
					/* Prevent the company link to work in case the user clicks on the logo and trigger the upload of a new logo instead (not in use, cause it's annoying):
					document.getElementById("anchor" + i).addEventListener("click", function(event) {
						if (event.target.nodeName == "IMG") {
							event.preventDefault();
							document.getElementById(company + 'Logo').click();
						}
					}); */
                }
            }
			
			loadLogos();
        }
    }
    xmlhttp.open("GET", "./model/ajax/companiesFetch.php?userId=" + userId, true);
    xmlhttp.send();
	
	content.appendChild(companyList);
}


/* Load in the logos of the event companies to display in the overview. */
function loadLogos() {
	var companyIds = new Array();
	var userCompanies = document.getElementsByClassName('orgLogo');
	var i;
	for (i = 0; i < userCompanies.length; i++) {
		var logoId = userCompanies[i].id;
		logoId = logoId.replace('Logo', '');
		companyIds.push(logoId);
	}
	
	
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var logoUrls = JSON.parse(xmlhttp.responseText);
            var i;
            var arrayLength = logoUrls.length;
			for (i = 0; i < arrayLength; i++) {
				var companyLogo = document.getElementById(companyIds[i] + "Logo");
				if (logoUrls[i] === 0) {
					companyLogo.setAttribute("src", "./images/logo.png");
				} else {
					companyLogo.setAttribute("src", logoUrls[i]);
				}
            }
        }
    }
    xmlhttp.open("GET", "./model/ajax/companiesFetch.php?companyIds=" + JSON.stringify(companyIds), true);
    xmlhttp.send();
}