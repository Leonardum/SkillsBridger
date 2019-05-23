<?php

require('../database.php');
require('../skill_object.php');

$str = filter_input (INPUT_POST, 'str');
if ($str == NULL) {
    $str = filter_input (INPUT_GET, 'str');
}

$type = filter_input (INPUT_POST, 'type');
if ($type == NULL) {
    $type = filter_input (INPUT_GET, 'type');
}

if ($type == 'hardskill') {
    $skills = skill::get_skillsByType('hardskill');
} else if ($type == 'softskill') {
    $skills = skill::get_skillsByType('softskill');
} else if ($type == 'both') {
    $skills = skill::get_skillNames();
}

$hint = array();

// lookup all hints from array if $q is different from ""
if ($str !== "") {
    $str = ucfirst($str); //Returns $str with the first character capitalized.
    $len=strlen($str);
    foreach($skills as $skill) {
        if (stristr($str, substr($skill, 0, $len))) {
            array_push($hint, $skill);
        }
    }
}

echo json_encode($hint);

?>