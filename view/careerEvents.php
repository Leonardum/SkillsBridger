<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["save"])) {
	$passedCareerEventTypes = cleanInput($_POST['checkedEventTypes']);
	$checkList = explode(",", $passedCareerEventTypes);
	$passedRegions = cleanInput($_POST['checkedRegions']);
	if (empty($passedRegions)) {
		$passedRegions = NULL;
	} else {
		$passedRegions = explode(",", $passedRegions);
	}
	
	student::delete_studentCareerEventTypes($studentId);
	if (!empty($passedCareerEventTypes)) {
		for ($x = 0; $x < count($checkList); $x++) {
			student::add_studentToCareerEventType($studentId, $checkList[$x]);
		}
	} else {
		$noSelection = true;
	}
	
} else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
	$passedCareerEventTypes = cleanInput($_POST['checkedEventTypes']);
	$checkList = explode(",", $passedCareerEventTypes);
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
	$checkList = student::get_studentCareerEventTypes($studentId);
	if (empty($checkList)) {
		$checkList = NULL;
		$passedCareerEventTypes = NULL;
		$noSelection = true;
	} else {
		$passedCareerEventTypes = implode(",", $checkList);
	}
}

$studentAppliedForEvents = json_encode(student::get_appliedEvents($studentId));
$studentGoingToEvents = json_encode(student::get_studentEvents($studentId));

?>

<div class="row mobileFlex">
	<div id="eventList" class="col-16 sidebarContent" style="order:2;"></div>
	<div id="eventTypes" class="col-4 contentSidebar" style="order:1;"></div>
</div>