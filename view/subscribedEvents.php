<?php

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
    $eventId = cleanInput($_POST['eventId']);
    $studentId = cleanInput($_POST['studentId']);
    
    event::delete_studentFromEvent($eventId, $studentId);
    
    header("Location: index.php?action=subscribedEvents&studentId=$studentId");
}

?>


<div id="eventList" class="col-20"></div>