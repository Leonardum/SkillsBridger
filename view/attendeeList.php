<?php
$eventId = filter_input (INPUT_POST, 'eventId');
if ($eventId == NULL) {
    $eventId = filter_input (INPUT_GET, 'eventId');
}

$organisationId = filter_input (INPUT_POST, 'organisationId');
if ($organisationId == NULL) {
    $organisationId = filter_input (INPUT_GET, 'organisationId');
}

$senderPage = filter_input (INPUT_POST, 'senderPage');
if ($senderPage == NULL) {
    $senderPage = filter_input (INPUT_GET, 'senderPage');
}

$event = event::get_eventById($eventId);

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
    $eventId = cleanInput($_POST['eventId']);
    $studentId = cleanInput($_POST['studentId']);
    
    event::checkIn($eventId, $studentId);
    
    header("Location: index.php?action=attendeeList&organisationId=$organisationId&eventId=$eventId&senderPage=$senderPage");
}
?>

<h1>
	<?php
	if ($senderPage == 'upcomingEvents') {
		echo "Check in who was here for " . $event->getName() . ":";
	} else if ($senderPage == 'passedEvents') {
		echo "This is the check-in list for " . $event->getName() . ":";
	}
	?>
</h1>
<div id="list"></div>

<div>
	<a href="./index.php?action=eventManager&eventId=<?php echo $eventId ?>&organisationId=<?php echo $organisationId ?>&senderPage=<?php echo $senderPage ?>"><button>Back</button></a>
</div>