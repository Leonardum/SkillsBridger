<?php

require('../database.php');
require('../event_object.php');

$skillId = filter_input (INPUT_POST, 'skillId');
if ($skillId == NULL) {
    $skillId = filter_input (INPUT_GET, 'skillId');
}

$studentId = filter_input (INPUT_POST, 'studentId');
if ($studentId == NULL) {
    $studentId = filter_input (INPUT_GET, 'studentId');
}

$subscribed = filter_input (INPUT_POST, 'subscribed');
if ($subscribed == NULL) {
    $subscribed = filter_input (INPUT_GET, 'subscribed');
}

$pending = filter_input (INPUT_POST, 'pending');
if ($pending == NULL) {
    $pending = filter_input (INPUT_GET, 'pending');
}

$attended = filter_input (INPUT_POST, 'attended');
if ($attended == NULL) {
    $attended = filter_input (INPUT_GET, 'attended');
}

// Set the timezone.
date_default_timezone_set("Europe/Brussels");

if (isset($skillId)) {
    $events = event::get_upcomingEventsBySkill($skillId);
    echo json_encode($events);
	
} else if ((isset($studentId)) && $subscribed == 1) {
	require('../student_object.php');
	
	// Get an array of event ID's of the events a student is going to.
	$studentGoingToEvents = student::get_upcomingSubscribedEvents($studentId);
	
	$events = array();
	$arrLength = count($studentGoingToEvents);
	// For all event ID's returned, look up the complete event information.
	for($x = 0; $x < $arrLength; $x++) {
		// Get an associative array of all event information of a certain event.
		$event = event::get_eventArrayById($studentGoingToEvents[$x]);
		
		// Store the current date and time in a variable.
		$now = time();
		// If the event has already finished, it should not be in the list.
		if (strtotime($event['End']) > $now) {
			// Gather all arrays in one array.
			array_push($events, $event);
		}
	}
	echo json_encode($events);
	
} else if ((isset($studentId)) && $pending == 1) {
	require('../student_object.php');
	
	// Get an array of event ID's of the events a student is going to.
	$studentGoingToEvents = student::get_upcomingAppliedEvents($studentId);
	
	$events = array();
	$arrLength = count($studentGoingToEvents);
	// For all event ID's returned, look up the complete event information.
	for($x = 0; $x < $arrLength; $x++) {
		// Get an associative array of all event information of a certain event.
		$event = event::get_eventArrayById($studentGoingToEvents[$x]);
		
		// Store the current date and time in a variable.
		$now = time();
		// If the event has already finished, it should not be in the list.
		if (strtotime($event['End']) > $now) {
			// Gather all arrays in one array.
			array_push($events, $event);
		}
	}
	echo json_encode($events);
	
} else if ((isset($studentId)) && $attended == 1) {
	require('../student_object.php');
	
	// Get an array of event ID's of the events a student is going to.
	$studentGoingToEvents = student::get_attendedEvents($studentId);
	
	$events = array();
	$arrLength = count($studentGoingToEvents);
	// For all event ID's returned, look up the complete event information.
	for($x = 0; $x < $arrLength; $x++) {
		// Get an associative array of all event information of a certain event.
		$event = event::get_eventArrayById($studentGoingToEvents[$x]);
		
		// Store the current date and time in a variable.
		$now = time();
		// If the event has not yet finished, it should not be in the list.
		if (strtotime($event['End']) < $now) {
			// Gather all arrays in one array.
			array_push($events, $event);
		}
	}
	echo json_encode($events);
	
} else if (isset($careerGoals)) { // NOT IN USE
	require('../careerGoal_object.php');
	
	// Transform the career goals ID's string into an array.
    $careerGoals = explode(",", $careerGoals);
	
	$skills = array();
	
	/* For every (parent) career goal ID, look up the skills required for all their child career goals and put them in the $skills array. */
	for($x = 0; $x<count($careerGoals); $x++) {
		// Get the name of the (parent) career goal.
		$careerGoal = careerGoal::get_careerGoalById($careerGoals[$x]);
		$name = $careerGoal->getName();
		
		/* Get a 2-dimensional array of all the child career goals of the parent career goal. This will return something of the form: [[2,"Accounting Audit"],[6,"Income Statement Analysis"],[13,"SME Accounting"]]. */
		$childCareerGoals = careerGoal::get_childCareerGoals($name);
		
		/* For every child career goal, get the skills which are required for it and add them to the $skills array, unless they are already in that array. (Thus you get a skills array with all the skills required for the child career goals of all parent career goals which were passed to this script.) */
		$arrLength = count($childCareerGoals);
		for($y = 0; $y < $arrLength; $y++) {
			$skillSet = careerGoal::get_skillOfCareerGoal($childCareerGoals[$y][0]);
			for($z = 0; $z<count($skillSet); $z++) {
				if (!in_array($skillSet[$z][0], $skills)) {
					array_push($skills, $skillSet[$z][0]);
				}
			}
		}
	}
	// Sort the skills (by ID).
	sort($skills);
	
	/* For every skill in the $skills array, get the events at which this skill is offered and put the information into the $events array, unless that event is already in that array. (Thus you get an $events array with all the events which are useful for the child career goals of all parent career goals which were passed to this script.) */
	$events = array();
	$arrLength = count($skills);
	for($x = 0; $x < $arrLength; $x++) {
		$eventPerSkill = event::get_upcomingEventsBySkill($skills[$x]);
		
		for($y = 0; $y<count($eventPerSkill); $y++) {
			/* Remove the last variable from the $eventPerSkill array. Since otherwise the same event can appear multiple times in a unique way. This is bad, since we want each event only once in the resulting $events array. */
			unset($eventPerSkill[$y]['Skill_id']);
			/* MAKE SURE ONLY EVENTS ARE SHOWN WHICH OFFER SKILLS (AND THUS MICRODEGREES)! */
			$skillsOffered = event::get_skillsOfferedOnEvent($eventPerSkill[$y]['Event_id']);
			if ($skillsOffered) {
				if (!in_array($eventPerSkill[$y], $events)) {
					array_push($events, $eventPerSkill[$y]);
				}
			}
			
			/* MAKE SURE ONLY LEARNING EVENTS ARE SHOWN
			if ($eventPerSkill[$y]['Purpose'] === "learning") {
				if (!in_array($eventPerSkill[$y], $events)) {
					array_push($events, $eventPerSkill[$y]);
				}
			} */
		}
	}
	sort($events);
	
    echo json_encode($events);
	
} else if (isset($careerEventTypes)) { // NOT IN USE
	require('../careerEvent_object.php');
	
	// Transform the career goals ID's string into an array.
    $careerEventTypes = explode(",", $careerEventTypes);
	
	/* For every event type in the $careerEventTypes array, get the events which are of this type. */
	$events = array();
	$arrLength = count($careerEventTypes);
	for($x = 0; $x < $arrLength; $x++) {
		$careerEvent = careerEventType::get_careerEventTypeById($careerEventTypes[$x]);
		
		$careerEventType = $careerEvent->getType();
		
		$eventsForType = event::get_upcomingEventsByType($careerEventType);
		
		for($y = 0; $y < count($eventsForType); $y++) {
			if (!in_array($eventsForType[$y], $events)) {
				array_push($events, $eventsForType[$y]);
			}
		}
	}
	sort($events);
	
    echo json_encode($events);
	
}

?>