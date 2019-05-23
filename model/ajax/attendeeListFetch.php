<?php

require('../database.php');
require('../event_object.php');

$eventId = filter_input (INPUT_POST, 'eventId');
if ($eventId == NULL) {
    $eventId = filter_input (INPUT_GET, 'eventId');
}

/* The date($format, $timestamp) function converts a Unix timestamp (the number of seconds between the given time and the Unix Epoch = January 1 1970 00:00:00 GMT) into a string with the given format. The second parameter is an optional Unix timestamp. When not given, the second parameter is assumed to be the current (server) time.
The time() funtion returns the Unix timestamp of the current (server) time.
Therefore date("Y-m-d H:i:s") = date("Y-m-d H:i:s", time());

The generated timestrings can be adjusted for different time zones with the date_default_timezone_set($timezone_identifier) function, which takes any valid time zone identifier to convert the timestring to the appropriate time for the given time zone identifier.

The strtotime($timestring) function does the oposite of the date() function and takes any valid timestring and converts it to a Unix timestamp. Regardless of the server location, you will always get the same timestamp.
Therefore strtotime(date("Y-m-d H:i:s")) = time(); 

The mktime($hour, $minute, $second, $month, $day, $year) function creates a Unix timestamp for the given values:
$timestamp = mktime(9, 46, 0, 10, 7, 2016);
You could then transform it into a string with the date() function:
echo date("Y-m-d H:i:s", $timestamp);
*/

// Set the timezone.
date_default_timezone_set("Europe/Brussels");

// Get the current time.
$now = time();

/* Check if the moment at which this script is called is after the end of the event and before the checkIn deadline (30 days now, but could also be set to "+ 4 hours" or even a different value per event type). */
$event = event::get_eventById($eventId);
$end = $event->getEndOfEvent();
$checkinOpen = strtotime(date("Y-m-d H:i:s", strtotime("$end -60 minutes")));
$checkInDeadline = strtotime(date("Y-m-d H:i:s", strtotime("$end + 30 days")));

if ($now < $checkinOpen) {
	$enableCheckIn = 0; // Too soon to check in.
} else if (($checkinOpen < $now) && ($now < $checkInDeadline)) {
	$enableCheckIn = 1; // Perfect to check in.
} else {
	$enableCheckIn = 2; // Too late to check in.
}

$attendees = event::get_attendees($eventId);
// Place the $enableCheckIn at the front of the $attendees array.
array_unshift($attendees, $enableCheckIn);

echo json_encode($attendees);

?>