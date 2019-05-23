<?php

require('../database.php');
require('../event_object.php');
require('../notification_object.php');

$eventId = filter_input (INPUT_POST, 'eventId');
if ($eventId == NULL) {
    $eventId = filter_input (INPUT_GET, 'eventId');
}

$event = event::get_eventById($eventId);
$event->setCancelled(1);
$event->save();

$eventName = $event->getName();

$notification = new notification(NULL, "An event you are going to, $eventName, has been CANCELLED!", "Event", $eventId, date('Y-m-d H:i:s'));

$notificationId = $notification->save();

$attendees = event::get_candidates($eventId);
$arrLength = count($attendees);
for($x = 0; $x < $arrLength; $x++) {
	notification::add_notificationForUser($attendees[$x][0], $notificationId);
}

?>