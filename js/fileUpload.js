/* These functions check the size of a file when selected for upload. In case it exceeds the limit, then it will not be uploaded and the file will be removed from the selection. In case the file is under the limit, the selection will automatically be submitted for upload. */
function checkProfilePictureSize() {
    'use strict';
    
    if (typeof FileReader !== "undefined") {
        var size = document.getElementById('userFile').files[0].size;
        if (size > 524288) { //524288 bytes = 0.5MB
            alert('This file is too large to upload! The limit is 512kb.');
            document.getElementById('userFile').value = "";
        } else {
            var form = document.getElementById('ProPicForm');
            form.submit();
        }
    }
}


function checkOrganisationLogoSize() {
    'use strict';
    
    if (typeof FileReader !== "undefined") {
        var size = document.getElementById('orgLogo').files[0].size;
        if (size > 524288) { //524288 bytes = 0.5MB
            alert('This file is too large to upload! The limit is 512kb.');
            document.getElementById('orgLogo').value = "";
        } else {
            var form = document.getElementById('orgLogoForm');
            form.submit();
        }
    }
}


function checkSponsorLogoSize() {
    'use strict';
    
    if (typeof FileReader !== "undefined") {
        var size = document.getElementById('sponsorLogo').files[0].size;
        if (size > 524288) { //524288 bytes = 0.5MB
            alert('This file is too large to upload! The limit is 512kb.');
            document.getElementById('sponsorLogo').value = "";
        } else {
			var submitNewSponsor = document.getElementById('submitNewSponsor');
            submitNewSponsor.click();
        }
    }
}


function checkCompanyLogoSize() {
    'use strict';
    
    if (typeof FileReader !== "undefined") {
        var size = document.getElementById('companyLogo').files[0].size;
        if (size > 524288) { //524288 bytes = 0.5MB
            alert('This file is too large to upload! The limit is 512kb.');
            document.getElementById('companyLogo').value = "";
        } else {
            var form = document.getElementById('companyLogoForm');
            form.submit();
        }
    }
}