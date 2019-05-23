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
	
    event::approve($eventId, $studentId);
	
	
	$event =  event::get_eventById($eventId);
	$eventName = $event->getName();
	
	$notification = new notification(NULL, "You have been accepted for $eventName.", "Event", $eventId, date('Y-m-d H:i:s'));
	$notificationId = $notification->save();
	notification::add_notificationForUser($_SESSION['userId'], $notificationId);
    
    header("Location: index.php?action=candidateList&organisationId=$organisationId&eventId=$eventId&senderPage=$senderPage");
}
?>

<h1>Approve the suitable candidates for <?php echo $event->getName(); ?>:</h1>
<div id="list"></div>

<div>
	<a href="./index.php?action=eventManager&eventId=<?php echo $eventId ?>&organisationId=<?php echo $organisationId ?>&senderPage=<?php echo $senderPage ?>"><button>Back</button></a>
</div>