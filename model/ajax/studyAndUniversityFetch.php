<?php

require('../database.php');
require('../study_object.php');
require('../university_object.php');

$request = filter_input (INPUT_POST, 'request');
if ($request == NULL) {
    $request = filter_input (INPUT_GET, 'request');
}

if ($request == 'studies') {
    $studies = study::get_allStudyInfo();
    echo json_encode($studies);
} else if ($request == 'universities') {
    $universities = university::get_allUniversityInfo();
	echo json_encode($universities);
}

?>