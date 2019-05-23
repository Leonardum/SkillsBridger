<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["save"])) {
	$passedJobTypes = cleanInput($_POST['checkedJobTypes']);
	$checkList = explode(",", $passedJobTypes);
	$passedRegions = cleanInput($_POST['checkedRegions']);
	if (empty($passedRegions)) {
		$passedRegions = NULL;
	} else {
		$passedRegions = explode(",", $passedRegions);
	}
	
	$student = student::get_studentById($studentId);
	if (in_array("internship", $checkList)) {
		 $student->setInternshipInterest(1);
	} else {
		$student->setInternshipInterest(0);
	}
	if (in_array("half-time job", $checkList)) {
		 $student->setHalfTimeInterest(1);
	} else {
		$student->setHalfTimeInterest(0);
	}
	if (in_array("full-time job", $checkList)) {
		 $student->setFullTimeInterest(1);
	} else {
		$student->setFullTimeInterest(0);
	}
	$student->save();
	
	if (empty($passedJobTypes)) {
		$noSelection = true;
	}
	
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
	$passedJobTypes = cleanInput($_POST['checkedJobTypes']);
	$checkList = explode(",", $passedJobTypes);
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
	$student = student::get_studentById($studentId);
	$checkList = array();
	if ($student->getInternshipInterest() == 1) {
		 array_push($checkList, "internship");
	}
	if ($student->getHalfTimeInterest() == 1) {
		 array_push($checkList, "half-time job");
	}
	if ($student->getFullTimeInterest() == 1) {
		 array_push($checkList, "full-time job");
	}
	
	if (empty($checkList)) {
		$checkList = NULL;
		$passedJobTypes = NULL;
		$noSelection = true;
	} else {
		$passedJobTypes = implode(",", $checkList);
	}
}

$studentAppliedForEvents = json_encode(student::get_appliedEvents($studentId));
$studentGoingToEvents = json_encode(student::get_studentEvents($studentId));

?>

<div class="row mobileFlex">
	<div id="eventList" class="col-16 sidebarContent" style="order:2;"></div>
	<div id="jobTypes" class="col-4 contentSidebar" style="order:1;"></div>
</div>