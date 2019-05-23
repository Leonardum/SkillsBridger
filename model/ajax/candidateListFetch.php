<?php

require('../database.php');
require('../event_object.php');

$eventId = filter_input (INPUT_POST, 'eventId');
if ($eventId == NULL) {
    $eventId = filter_input (INPUT_GET, 'eventId');
}

// Set the timezone.
date_default_timezone_set("Europe/Brussels");

$enableApproval = 1; // Could be set differently (like for the check in system).
$candidates = event::get_candidates($eventId);
$currentAttendeeAmount = event::get_attendeeAmount($eventId);
$event = event::get_eventById($eventId);
$capacity = $event->getCapacity();
if ($currentAttendeeAmount < $capacity) {
	$capacityReached = 0;
} else {
	$capacityReached = 1;
}

// Place the $capacityReached at the front of the $candidates array.
array_unshift($candidates, $capacityReached);

// Place the $enableApproval at the front of the $candidates array.
array_unshift($candidates, $enableApproval);

echo json_encode($candidates);

?>