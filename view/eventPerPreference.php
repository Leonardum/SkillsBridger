<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["reload"])) {
    $passedCareerGoals = cleanInput($_POST['checked']);
	$checkList = explode(",", $passedCareerGoals);
	if (empty($passedCareerGoals)) {
		$noSelection = true;
	}
	
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["save"])) {
	$passedCareerGoals = cleanInput($_POST['checked']);
	$checkList = explode(",", $passedCareerGoals);
	
	student::delete_studentCareerGoals($studentId);
	if (!empty($passedCareerGoals)) {
		for ($x = 0; $x < count($checkList); $x++) {
			student::add_studentToCareerGoal($studentId, $checkList[$x]);
		}
	} else {
		$noSelection = true;
	}
	
} else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
	$passedCareerGoals = cleanInput($_POST['checked']);
	$checkList = explode(",", $passedCareerGoals);
	
    $event = cleanInput($_POST['event']);
    $student = cleanInput($_POST['student']);
	
    event::add_studentToEvent($event, $student);
	
} else {
	$checkList = student::get_studentCareerGoals($studentId);
	if (empty($checkList)) {
		$checkList = NULL;
		$passedCareerGoals = NULL;
		$noSelection = true;
	} else {
		$passedCareerGoals = implode(",", $checkList);
	}
}

$studentAppliedForEvents = json_encode(student::get_appliedEvents($studentId));
$studentGoingToEvents = json_encode(student::get_studentEvents($studentId));

?>

<div class="row mobileFlex">
	<div id="eventList" class="col-16 sidebarContent" style="order:2;">
		<p id="message" class="darkWatermark" style="display:block;">Select a careergoal to see the events which will help you work on the necessary skills!</p>
	</div>
	<div id="careerGoals" class="col-4 contentSidebar" style="padding:5px; -webkit-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75); -moz-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75); box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75); order:1; margin-bottom:10px;"></div>
</div>