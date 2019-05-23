/* This function loads the possible studies to the form. */
function loadStudies() {
    'use strict';
    
    var studySelect = document.getElementById('study');
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var studies = JSON.parse(xmlhttp.responseText);
            var i;
            var arrayLength = studies.length;
            for (i = 0; i < arrayLength; i++) {
                var studyOption = document.createElement('option');
                studyOption.value = studies[i][0];
                studyOption.text = studies[i][1];
                studySelect.appendChild(studyOption);
            }
        }
    }
    xmlhttp.open("GET", "./model/ajax/studyAndUniversityFetch.php?request=studies", true);
    xmlhttp.send();
}