<?php

require('../database.php');
require('../skill_object.php');

$skills = skill::get_allSkillsInfo();

echo json_encode($skills);
?>