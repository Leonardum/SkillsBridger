<?php

$eventPurpose = $_SESSION['eventPurpose'];
$eventType = $_SESSION['eventType'];
// Define error variable and set to empty value.
$err = "";

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$skillsSelection = cleanInput($_POST['skillsSelection']);
	if (isset($_POST['termsOfUseAccept'])) {
		$termsOfUseAcceptIp = $_SERVER['REMOTE_ADDR'];
		if ($termsOfUseAcceptIp == NULL) {
			$termsOfUseAcceptIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
	}
	
	/* The explode function takes a string and returns it as an array. It takes 3 parameters: 1) the separator to specify where to break the string 2) the string to split 3) the limit (optional) to Specify the maximum number of array elements to return. */
	$skillsSelection = explode(',',$skillsSelection,11);
	if ($skillsSelection[0] == "") {
		$length = 0;
	} else {
		$length = count($skillsSelection);
	}
	
	
	$event = unserialize($_SESSION['event']);
	$eventType = $event->getType();
	if ($eventType == 'job fair' || $eventType == 'networking event' || $eventType == 'info session') {
		$maxSkillAmount = 0;
	} else if ($eventType == 'social media coaching') {
		$maxSkillAmount = 1;
	} else if ($eventType == 'CV and interview coaching' || $eventType == 'debate' || $eventType == 'lecture') {
		$maxSkillAmount = 2;
	} else if ($eventType == 'in-house day and company presentation' || $eventType == 'masterclass' || $eventType == 'workshop') {
		$maxSkillAmount = 3;	
	} else if ($eventType == 'skills-program' || $eventType == 'volunteering experience' || $eventType == 'business game') {
		$maxSkillAmount = 6;
	} else if ($eventType == 'summer school' || $eventType == 'consulting project' || $eventType == 'online course') {
		$maxSkillAmount = 7;
	} else if ($eventType == 'internship' || $eventType == 'full-time job' || $eventType == 'half-time job') {
		$maxSkillAmount = 10;
	} else {
		$maxSkillAmount = 3;
	}
	
	if ($length > $maxSkillAmount && $maxSkillAmount == 0) {
		$skillAmountErr = "You cannot enter any skills for an event of the following type: $eventType";
		$err = true;
	} else if ($length > $maxSkillAmount) {
		$skillAmountErr = "You cannot enter more than $maxSkillAmount skills for an event of the following type: $eventType";
		$err = true;
	}
	
	if (!isset($_POST['termsOfUseAccept'])) {
		$termsOfUseAcceptIp = NULL;
		$termsOfUseAcceptErr = "This tickbox is obligatory.";
		$err = true;
	}
	
	if (!$err) {
		$event->setCancelled(0);
		$event->setTermsOfUseAcceptIp($termsOfUseAcceptIp);
		$eventId = $event->save();
		if ($length !== 0) {
			for($x = 0; $x < $length; $x++) {
				event::add_skillToEvent($eventId, $skillsSelection[$x]);
			}
		}
		
		unset($_SESSION['event']);
		
		header("Location: index.php?action=upcomingEvents&organisationId=$organisationId");
	}
}

?>

<div style="margin:0 0 20px 2rem;">
	<div class="col-20">
		<div class="col-9" style="margin-right:5%;">
			<p style="margin-bottom: 10px;">Which hard skill(s) or subject(s) will be taught on this event?</p>
			<select id="hardSkillSelect" name="hardskill">
				<option selected disabled hidden value=""></option>
			</select>
			<button class="button-small" onclick="addToList('hardSkillSelect')">+ Add</button>
			<div id="hardSkillDisplay" class="SkillList"></div>
		</div>
		
		<div class="col-9" style="margin-right:5%;">
			<p style="margin-bottom: 10px;">Which soft skill(s) will be taught on this event?</p>
			<select id="softSkillSelect" name="softskill">
				<option selected disabled hidden value=""></option>
			</select>
			<button class="button-small" onclick="addToList('softSkillSelect')">+ Add</button>
			<div id="softSkillDisplay" class="SkillList"></div>
		</div>
		
		<div class="col-20">
			<form id="skillForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				<input id="skillsSelection" name="skillsSelection" type="hidden" value="">
				
				<div class="userInput">
					<input type="checkbox" name="termsOfUseAccept" value="true" <?php if(isset($termsOfUseAcceptIp)) {echo "checked";} ?>><span class="checkboxtext">I hereby declare that all information on and skills added to the event are accurate and that my organisation will check in only those attendees who were present at this event.</span>
					<span class="error"> * <?php if (isset($termsOfUseAcceptErr)) {echo $termsOfUseAcceptErr;}?></span>
				</div>
				
				<input type="hidden" name="organisationId" value="<?php echo $organisationId ?>">
				
				<input type="hidden" name="action" value="eventCreation4">
			</form>
		</div>
		<span id="skillError" class="error"><?php if (isset($skillAmountErr)) {echo $skillAmountErr;} ?></span>
		
		<div class="col-20">
			<button style="margin-top:10px;" onclick="checkSkillsAdded()">Finish</button>
		</div>
	</div>
</div>