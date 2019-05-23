<?php

require('../database.php');
require('../student_object.php');
require('../event_object.php');
require('../careerGoal_object.php');
require('../skill_object.php');


$eventId = filter_input (INPUT_POST, 'eventId');
if ($eventId == NULL) {
    $eventId = filter_input (INPUT_GET, 'eventId');
}

$careerGoalLoad = filter_input (INPUT_POST, 'careerGoalLoad');
if ($careerGoalLoad == NULL) {
    $careerGoalLoad = filter_input (INPUT_GET, 'careerGoalLoad');
}

$careerGoalId = filter_input (INPUT_POST, 'careerGoalId');
if ($careerGoalId == NULL) {
    $careerGoalId = filter_input (INPUT_GET, 'careerGoalId');
}

$studentId = filter_input (INPUT_POST, 'studentId');
if ($studentId == NULL) {
    $studentId = filter_input (INPUT_GET, 'studentId');
}

$getMicrodegrees = filter_input (INPUT_POST, 'getMicrodegrees');
if ($getMicrodegrees == NULL) {
    $getMicrodegrees = filter_input (INPUT_GET, 'getMicrodegrees');
}


if (isset($eventId)) {
	$skills = event::get_skillsOfferedOnEvent($eventId);
	echo json_encode($skills);
	
} else if ($careerGoalLoad == 'true') {
    $careerGoals = careerGoal::get_careerGoalArray();
    echo json_encode($careerGoals);
	
} else if (isset($careerGoalId) && isset($studentId)) {
	/* This section which has been commented out serves in case all the microdegrees belonging to a PARENT career goal should be loaded.
	
	$careerGoal = careerGoal::get_careerGoalById($careerGoalId);
	$careerGoalName = $careerGoal->getName();
	$childCareerGoals = careerGoal::get_childCareerGoals($careerGoalName);
	
	$skills = array();
	
	For all the child career goals, push the skill ids associated with them in an array.
	$arrLength = count($childCareerGoals);
	for($x = 0; $x < $arrLength; $x++) {
		$skillSet = careerGoal::get_skillOfCareerGoal($childCareerGoals[$x][0]);
		for($y = 0; $y<count($skillSet); $y++) {
			if (!in_array($skillSet[$y][0], $skills)) {
				array_push($skills, $skillSet[$y][0]);
			}
		}
	}
	
	$skillsArray = array();
	
	for($x = 0; $x < count($skills); $x++) {
		$skillArray = skill::get_skillArrayById($skills[$x]);
		array_push($skillsArray, $skillArray);
	} */
	
	// Get all the skills for this career goal.
	$careerGoalSkills = careerGoal::get_skillOfCareerGoal($careerGoalId);
	
	/* Transform the skill information into an associative array (for javascript file to load the event boxes). */
	$skillsArray = array();
	for($x = 0; $x < count($careerGoalSkills); $x++) {
		$skillArray = skill::get_skillArrayById($careerGoalSkills[$x][0]);
		$upcomingEventsForSkill = event::get_upcomingEventsBySkill($careerGoalSkills[$x][0]);
		$skillArray['Event_count'] = count($upcomingEventsForSkill);
		array_push($skillsArray, $skillArray);
	}
	
	// Adding the microdegrees to the AJAX response text.
	// Get the event ID's of the events the student has attended.
	$attendedEvents = student::get_attendedEvents($studentId);
	
	$microdegrees = array();
	
	for($x = 0; $x < count($attendedEvents); $x++) {
		
		$event = event::get_eventById($attendedEvents[$x]);
		$eventMicrodegree = [$event->getId(), $event->getOrganisationId(), $event->getName(), $event->getPurpose(), $event->getType()];
		
		$eventSkills = event::get_skillsOfferedOnEvent($attendedEvents[$x]);
		for($y = 0; $y<count($eventSkills); $y++) {
			array_push($eventMicrodegree, $eventSkills[$y][0]);
		}
		array_push($microdegrees, $eventMicrodegree);
	}
	
	/* Just stuffing the array at the end...not the most elegant way, but it works. */
	array_push($skillsArray, $microdegrees);
	
	echo json_encode($skillsArray);
	
} else if (isset($studentId) && $getMicrodegrees == 'true') {
	$attendedEvents = student::get_attendedEvents($studentId); //Yields event ID's.
	
	$microdegrees = array();
	
	for($x = 0; $x < count($attendedEvents); $x++) {
		
		$event = event::get_eventById($attendedEvents[$x]);
		$eventMicrodegree = [$event->getId(), $event->getOrganisationId(), $event->getName(), $event->getPurpose(), $event->getType()];
		
		$eventSkills = event::get_skillsOfferedOnEvent($attendedEvents[$x]);
		for($y = 0; $y<count($eventSkills); $y++) {
			array_push($eventMicrodegree, $eventSkills[$y][0]);
		}
		array_push($microdegrees, $eventMicrodegree);
	}
	
	echo json_encode($microdegrees); 
	/* $microdegrees will be an array like this:
	[[1,1,"Valuation Workshop","learning","workshop",12],[3,1,"From intern to associate","learning","lecture",6,8,12]] */
}

?>