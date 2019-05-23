<?php

require('../database.php');
require('../careerGoal_object.php');


$careerGoalLoad = filter_input (INPUT_POST, 'careerGoalLoad');
if ($careerGoalLoad == NULL) {
    $careerGoalLoad = filter_input (INPUT_GET, 'careerGoalLoad');
}

if ($careerGoalLoad == 'true') {
    $careerGoals = careerGoal::get_careerGoalArray();
    echo json_encode($careerGoals);
}


$careerGoalId = filter_input (INPUT_POST, 'careerGoalId');
if ($careerGoalId == NULL) {
    $careerGoalId = filter_input (INPUT_GET, 'careerGoalId');
}

if (isset($careerGoalId)) {
    $skills = careerGoal::get_skillOfCareerGoal($careerGoalId);
    echo json_encode($skills);
}

?>