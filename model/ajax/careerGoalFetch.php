<?php

require('../database.php');
require('../careerGoal_object.php');

$level = filter_input (INPUT_POST, 'level');
if ($level == NULL) {
    $level = filter_input (INPUT_GET, 'level');
}

if ($level == 2) {
    $parents = careerGoal::get_careerGoalsByLevel(1);
} else if ($level == 3) {
    $parents = careerGoal::get_careerGoalsByLevel(2);
} else if ($level == 4) {
    $parents = careerGoal::get_careerGoalsByLevel(3);
} else if ($level == 5) {
    $parents = careerGoal::get_careerGoalsByLevel(4);
}

echo json_encode($parents);

?>