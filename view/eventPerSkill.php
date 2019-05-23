<?php

$studentAppliedForEvents = json_encode(student::get_appliedEvents($studentId));
$studentGoingToEvents = json_encode(student::get_studentEvents($studentId));


/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
    $event = cleanInput($_POST['event']);
    $student = cleanInput($_POST['student']);
    
    event::add_studentToEvent($event, $student);
    
    header("Location: index.php?action=eventPerSkill&skillId=" . $skillId);
}

?>

<div id="eventList" class="col-20"></div>

<div>
	<a href="./index.php?action=profile"><button>Back</button></a>
</div>