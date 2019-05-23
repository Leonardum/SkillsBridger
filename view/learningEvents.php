<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["save"])) {
	$passedCareerGoals = cleanInput($_POST['checkedCareergoals']);
	$checkList = explode(",", $passedCareerGoals);
	$passedRegions = cleanInput($_POST['checkedRegions']);
	if (empty($passedRegions)) {
		$passedRegions = NULL;
	} else {
		$passedRegions = explode(",", $passedRegions);
	}
	
	student::delete_studentCareerGoals($studentId);
	if (!empty($passedCareerGoals)) {
		for ($x = 0; $x < count($checkList); $x++) {
			student::add_studentToCareerGoal($studentId, $checkList[$x]);
		}
	} else {
		$noSelection = true;
	}
	
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
	$passedCareerGoals = cleanInput($_POST['checkedCareergoals']);
	$checkList = explode(",", $passedCareerGoals);
	$passedRegions = cleanInput($_POST['checkedRegions']);
	if (empty($passedRegions)) {
		$passedRegions = NULL;
	} else {
		$passedRegions = explode(",", $passedRegions);
	}
	
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
	<div id="eventList" class="col-16 sidebarContent" style="order:2;"></div>
	<div id="careerGoals" class="col-4 contentSidebar" style="order:1;"></div>
</div>