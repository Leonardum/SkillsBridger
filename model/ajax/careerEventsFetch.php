<?php

require('../database.php');

$eventTypeLoad = filter_input (INPUT_POST, 'eventTypeLoad');
if ($eventTypeLoad == NULL) {
    $eventTypeLoad = filter_input (INPUT_GET, 'eventTypeLoad');
}

$regionsLoad = filter_input (INPUT_POST, 'regionsLoad');
if ($regionsLoad == NULL) {
    $regionsLoad = filter_input (INPUT_GET, 'regionsLoad');
}


if (isset($eventTypeLoad)) {
	require('../careerEvent_object.php');
	
	$careerEventTypes = careerEventType::get_careerEventTypeArray();
	
	/* [[1,"in-house day"],[2,"job fair"]] */
	
	echo json_encode($careerEventTypes);
	
} else if (isset($regionsLoad)) {
	require('../event_object.php');
	require('../address_object.php');
	
	$upcomingEvents = event::get_upcomingNonFullEvents();
	
	$regions = array();
	for($x = 0; $x < count($upcomingEvents); $x++) {
		if ($upcomingEvents[$x]['Purpose'] == "career") {
			$eventAddress = address::get_addressById($upcomingEvents[$x]['Address_id']);
			$region = $eventAddress->getProvince();
			if (!in_array($region, $regions)) {
				array_push($regions, $region);
			}
		}
	}
	
	sort($regions);
	
    echo json_encode($regions);
	
} else {
	require('../event_object.php');
	
	$upcomingEvents = event::get_upcomingNonFullEvents();
	$events = array();
	for($x = 0; $x < count($upcomingEvents); $x++) {
		/* MAKE SURE ONLY CAREER EVENTS ARE SHOWN! */
		if ($upcomingEvents[$x]['Purpose'] == "career") {
			if (!in_array($upcomingEvents[$x], $events)) {
				array_push($events, $upcomingEvents[$x]);
			}
		}
	}
	sort($events);
	
    echo json_encode($events);
	
}

?>