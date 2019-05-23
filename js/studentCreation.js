/* Retrieves the full list of studies and universities and populates the appropriate select lists with them. */
function loadStudyAndUniversity() {
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
    
    
    var universitySelect = document.getElementById('university');
    
    var univXmlhttp = new XMLHttpRequest();
    univXmlhttp.onreadystatechange = function() {
        if (univXmlhttp.readyState === 4 && univXmlhttp.status === 200) {
            var universities = JSON.parse(univXmlhttp.responseText);
            var i;
            var arrayLength = universities.length;
            for (i = 0; i < arrayLength; i++) {
                var universityOption = document.createElement('option');
                universityOption.value = universities[i][0];
                universityOption.text = universities[i][1];
                universitySelect.appendChild(universityOption);
            }
        }
    }
    univXmlhttp.open("GET", "./model/ajax/studyAndUniversityFetch.php?request=universities", true);
    univXmlhttp.send();
}