<?php

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
    if (isset($_POST['rating'])) {
		$rating = cleanInput($_POST['rating']);
	} else {
		$err = true;
	}
    $eventId = cleanInput($_POST['eventId']);
    $studentId = cleanInput($_POST['studentId']);
    
	if (!$err) {
		event::add_rating($rating, $eventId, $studentId);
		header("Location: index.php?action=beenToEvents&studentId=$studentId");
	}
}

?>

<div id="eventList" class="col-20"></div>