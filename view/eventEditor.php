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

$isPurpose = $event->getPurpose();
$isType = $event->getType();

$startTimestamp = $event->getStart();
$endTimestamp = $event->getEndOfEvent();
$subTimestamp = $event->getSubscriptionDeadline();
/* date("d F Y",$startTime) would output: "00 Month XXXX" */
$startTime = strtotime($startTimestamp);
$endTime = strtotime($endTimestamp);
$subTime = strtotime($subTimestamp);
$startTimeArray = explode( " ", $startTimestamp);
$endTimeArray = explode( " ", $endTimestamp);
$subTimeArray = explode( " ", $subTimestamp);

$isPrice = $event->getTicketPrice();
$isPaidOnline = $event->getPaidOnline();
$isAlternateSubscription = $event->getAlternateSubscription();
$isSubscriptionUrl = $event->getSubscriptionUrl();
$isOpenForAll = $event->getOpenForAll();
$isOpenFor = $event->getOpenFor();
$isWebpage = $event->getWebpageUrl();

$address = address::get_addressById($event->getAddressId());

$isLocation = $address->getName();
$isStreet = $address->getStreet();
$isNumber = $address->getNumber();
$isZip = $address->getZip();
$isCity = $address->getCity();
$isProvince = $address->getProvince();
$isAddressDescription = $event->getAddressDescription();

$skillsInfo = $event->get_skillsOfferedOnEvent($eventId);
$skillIds = array();
for($x = 0; $x < count($skillsInfo); $x++) {
	array_push($skillIds, $skillsInfo[$x][0]);
}
$isSkillsSelection = implode(",", $skillIds);

// Define error variable and set to empty value.
$err = "";

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
	
	/* UNSET DATABASE VARIABLES TO ONLY WORK WITH WHAT HAS BEEN SUBMITTED. */
	$isPrice = "";
	unset($isPurpose);
	unset($isType);
	unset($isPaidOnline);
	unset($isAlternateSubscription);
	unset($isSubscriptionUrl);
	unset($isOpenForAll);
	unset($isOpenFor);
	unset($isWebpage);
	unset($isLocation);
	unset($isStreet);
	unset($isNumber);
	unset($isZip);
	unset($isCity);
	unset($isProvince);
	unset($isAddressDescription);
	unset($isSkillsSelection);
	unset($skillsInfo);
	unset($skillNames);
	
	/* CLEAN FORM VARIABLES. */
	$name = cleanInput($_POST['name']);
	if (isset($_POST['purpose'])) {
		$purpose = cleanInput($_POST['purpose']);
	}
	if (isset($_POST['eventType'])) {
		$type = cleanInput($_POST['eventType']);
	}
	$startDate = cleanInput($_POST['startDate']);
	$startHour = cleanInput($_POST['startHour']);
	$startMinute = cleanInput($_POST['startMinute']);
	$endDate = cleanInput($_POST['endDate']);
	$endHour = cleanInput($_POST['endHour']);
	$endMinute = cleanInput($_POST['endMinute']);
	$subscriptionDeadline = cleanInput($_POST['subscriptionDeadline']);
	$subscriptionHour = cleanInput($_POST['subscriptionHour']);
	$subscriptionMinute = cleanInput($_POST['subscriptionMinute']);
	
	$description = cleanInput($_POST['description']);
	$capacity = (int) cleanInput($_POST['capacity']);
	if (isset($_POST['language'])) {
		$language = cleanInput($_POST['language']);
	}
	if (isset($_POST['freeForAll'])) {
		$freeForAll = 1;
	} else if (isset($_POST['notFreeForAll'])) {
		$freeForAll = 0;
	}
	$price = cleanInput($_POST['price']);
	// Make sure the comma denoted floats are transformed to dot denoted ones.
	$price = (float) str_replace(',', '.', $price);
	if (isset($_POST['paidOnline'])) {
		$paidOnline = 1;
	} else if (isset($_POST['entrancePaid'])) {
		$paidOnline = 0;
	}
	if (isset($_POST['alternateSubscription'])) {
		$alternateSubscription = 1;
	} else {
		$alternateSubscription = 0;
	}
	$subscriptionUrl = cleanInput($_POST['subscriptionUrl']);
	if (isset($_POST['notOpenForAll'])) {
		$openForAll = 0;
	} else {
		$openForAll = 1;
	}
	$openFor = cleanInput($_POST['openFor']);
	if (isset($_POST['motivationLetterEncouraged'])) {
		$motivationLetterEncouraged = 1;
	} else {
		$motivationLetterEncouraged = 0;
	}
	if (isset($_POST['motivationLetter'])) {
		$motivationLetter = 1;
	} else {
		$motivationLetter = 0;
	}
	// Makes sure motivation letter is not both encouraged and required.
	if (isset($_POST['motivationLetterEncouraged']) && isset($_POST['motivationLetter'])) {
		$motivationLetterEncouraged = 0;
		$motivationLetter = 1;
	}
	if (isset($_POST['cvEncouraged'])) {
		$cvEncouraged = 1;
	} else {
		$cvEncouraged = 0;
	}
	if (isset($_POST['cv'])) {
		$cv = 1;
	} else {
		$cv = 0;
	}
	// Makes sure cv is not both encouraged and required.
	if (isset($_POST['cvEncouraged']) && isset($_POST['cv'])) {
		$cvEncouraged = 0;
		$cv = 1;
	}
	$webpage = cleanInput($_POST['webpage']);
	
	$location = cleanInput($_POST['location']);
	$street = cleanInput($_POST['street']);
	(int) $number = cleanInput($_POST['number']);
	(int) $zip = cleanInput($_POST['zip']);
	$city = cleanInput($_POST['city']);
	if (isset($_POST['province'])) {
		$province = cleanInput($_POST['province']);
	}
	if (isset($_POST['state'])) {
		$state = cleanInput($_POST['state']);
	}
	if (isset($_POST['country'])) {
		$country = cleanInput($_POST['country']);
	}
	$addressDescription = cleanInput($_POST['addressDescription']);
	
	
	$skillsSelection = cleanInput($_POST['skillsSelection']);
	
	
	
	/* CHECK FOR ERRORS. */
	if (empty($name)) {
		$nameErr = "Please, fill in the event's name.";
		$err = true;
	}
	if (empty($purpose)) {
		$purposeErr = "Please, select the purpose of your event.";
		$err = true;
	}
	if (empty($type)) {
		$typeErr = "Please, select what type of an event you are organising.";
		$err = true;
	}
	if (empty($startDate)) {
		$startDateErr = "Please, select the date on which your event starts.";
		$err = true;
	}
	/* Generate an array from 1 to 12 to check the entered hour values against. */
	$hourArray = array();
	for($x = 0; $x < 25; $x++) {
		array_push($hourArray, $x);
	}
	/* Generate an array from 1 to 60 to check the entered minute values against. */
	$minuteArray = array();
	for($y = 0; $y < 61; $y++) {
		array_push($minuteArray, $y);
	}
	if (empty($startHour) || empty($startMinute)) {
		$startHourErr = "Please, fill in the starting time of your event.";
		$err = true;
	} else {
		$startHourCheck = (int) $startHour;
		if (!in_array ($startHourCheck, $hourArray)) {
			$startHourValidErr = "Please, fill in a correct value for the starting hour of your event.";
			$err = true;
		}
		$startMinuteCheck = (int) $startMinute;
		if (!in_array ($startMinuteCheck, $minuteArray)) {
			$startMinuteValidErr = "Please, fill in a correct value for the starting minute of your event.";
			$err = true;
		}
	}
	if (empty($endDate)) {
		$endDateErr = "Please, select the date on which your event ends.";
		$err = true;
	}
	if (empty($endHour) || empty($endMinute)) {
		$endHourErr = "Please, fill in the time on which your event ends.";
		$err = true;
	} else {
		$endHourCheck = (int) $endHour;
		if (!in_array ($endHourCheck, $hourArray)) {
			$endHourValidErr = "Please, fill in a correct value for the hour on which your event ends.";
			$err = true;
		}
		$endMinuteCheck = (int) $endMinute;
		if (!in_array ($endMinute, $minuteArray)) {
			$endMinuteValidErr = "Please, fill in a correct value for the minute on which your event ends.";
			$err = true;
		}
	}
	if (empty($subscriptionDeadline)) {
		$subDeadlineErr = "Please, select the maximum date on which people can still subscribe for your event.";
		$err = true;
	}
	if (empty($subscriptionHour) || empty($subscriptionMinute)) {
		$subHourErr = "Please, fill in the latest time on which people can still subscribe for your event.";
		$err = true;
	} else {
		$subHourCheck = (int) $subscriptionHour;
		if (!in_array ($subHourCheck, $hourArray)) {
			$subHourValidErr = "Please, fill in a correct value for the latest hour on which people can still subscribe for your event.";
			$err = true;
		}
		$subMinuteCheck = (int) $subscriptionMinute;
		if (!in_array ($subMinuteCheck, $minuteArray)) {
			$subMinuteValidErr = "Please, fill in a correct value for the latest minute on which people can still subscribe for your event.";
			$err = true;
		}
	}
	
	
	if (empty($description)) {
		$description = NULL;
		$descriptionErr = "Please, describe what your event is about and who it is for.";
		$err = true;
	}
	// Check if the description is not longer than 270 characters.
	if (strlen($description) > 270) {
		$descriptionErr = "This event description exceeds the maximum of 270 characters! Kindly shorten it.";
		$err = true;
	}
	if (empty($capacity)) {
		$capacity = NULL;
		$capacityErr = "Please, fill in the event's capacity.";
		$err = true;
	}
	if (empty($language)) {
		$languageErr = "Please, select a language for your event.";
		$err = true;
	}
	if (!isset($freeForAll)) {
		unset($price);
		$paidOnline = ""; // Avoid unknown variable error for later logic
		$freeForAllErr = "Please choose if your event will be free or payable.";
		$err = true;
	} else {
		if ($freeForAll) {
			$price = NULL;
			$paidOnline = 0; /* Avoid unknown variable error for later logic */
		} else {
			if (empty($price)) {
				$price = NULL;
				$priceErr = "Please, write down the price for your event.";
				$err = true;
			}
			if (!isset($paidOnline)) {
				$paidOnline = NULL; /* Avoid unknown variable error for later logic */
				$paidOnlineErr = "Please choose if your event will be paid for at the entrance or online.";
				$err = true;
			}
		}
	}
	if ($alternateSubscription === 1 || $paidOnline === 1) {
		if (empty($subscriptionUrl)) {
			$subscriptionUrlErr = "Please, write the url of the webpage handling the subscription and/or payment process.";
			$err = true;
		}
	} else {
		$subscriptionUrl = NULL;
	}
	if (isset($openForAll)) {
		if (!$openForAll) {
			if (empty($openFor)) {
				$openFor = NULL;
				$openForErr = "Please, briefly state the target audience of your event.";
				$err = true;
			}
			// Check if the openFor description is not longer than 180 characters.
			if (strlen($openFor) > 180) {
				$openForErr = "This event description exceeds the maximum of 180 characters! Kindly shorten it.";
				$err = true;
			}
		} else {
			$openFor = NULL;
		}
	}
	if (empty($webpage)) {
		$webpage = NULL;
	}
	
	
	if (empty($street)) {
		$streetErr = "Please, fill in the street name.";
		$err = true;
	}
	if (empty($number)) {
		$numberErr = "Please, fill in the street number.";
		$err = true;
	}
	if (empty($zip)) {
		$zipErr = "Please, fill in the zip code.";
		$err = true;
	}
	if (empty($city)) {
		$cityErr = "Please, fill in the city name.";
		$err = true;
	}
	if (empty($province)) {
		$provinceErr = "Please, select a province.";
		$err = true;
	}
	if (empty($state)) {
		$state = NULL;
	}
	if (empty($country)) {
		$country = 'Belgium';
	}
	if (empty($addressDescription)) {
		$addressDescription = NULL;
	}
	
	$skillsSelection = explode(',',$skillsSelection);
	$skillsInfo = array();
	for($x = 0; $x < count($skillsSelection); $x++) {
		$skill = skill::get_skillArrayById($skillsSelection[$x]);
		
		$skill = array($skill['Skill_id'], $skill['Name'], $skill['Type'], $skill['Description']);
		
		array_push($skillsInfo, $skill);
	}
}


/* IF THERE ARE NO ERRORS, PROCESS THE DATA TO THE DATABASE. */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"]) && !$err) {
	
	/* Convert all the information about the start of the event into one variable. */
	$start = $startDate . " " . $startHour . ":" . $startMinute . ":00";
	$end = $endDate . " " . $endHour . ":" . $endMinute . ":00";
	$subscription = $subscriptionDeadline . " " . $subscriptionHour . ":" . $subscriptionMinute . ":00";
	
	$event->setName($name);
	$event->setPurpose($purpose);
	$event->setType($type);
	$event->setStart($start);
	$event->setEndOfEvent($end);
	$event->setSubscriptionDeadline($subscription);
	
	$event->setDescription($description);
	$event->setCapacity($capacity);
	$event->setLanguage($language);
	$event->setTicketPrice($price);
	$event->setPaidOnline($paidOnline);
	$event->setAlternateSubscription($alternateSubscription);
	$event->setSubscriptionUrl($subscriptionUrl);
	$event->setOpenForAll($openForAll);
	$event->setMotivationLetterEncouraged($motivationLetterEncouraged);
	$event->setMotivationLetter($motivationLetter);
	$event->setOpenFor($openFor);
	$event->setCvEncouraged($cvEncouraged);
	$event->setCv($cv);
	$event->setWebpageUrl($webpage);
	
	$address = new address(NULL, $location, $street, $number, $zip, $city, $province, $state, $country);
	$existingAddresses = $address->compare_address();
	if ($existingAddresses[0] == 1) {
		$addressId = $existingAddresses[1];
	} else {
		$addressId = $address->save();
	}
	
	$event->setAddressId($addressId);
	$event->setAddressDescription($addressDescription);
	
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
	
	if ($skillsSelection[0] == "") {
		$length = 0;
	} else {
		$length = count($skillsSelection);
	}
	
	if ($length > $maxSkillAmount && $maxSkillAmount == 0) {
		$skillAmountErr = "You cannot enter any skills for an event of the following type: $eventType";
		$err = true;
	} else if ($length > $maxSkillAmount) {
		$skillAmountErr = "You cannot enter more than $maxSkillAmount skills for an event of the following type: $eventType";
		$err = true;
	}
	
	if (!$err) {
		$event->save();
		
		event::delete_skillsFromEvent($eventId);
		for($x = 0; $x < count($skillsSelection); $x++) {
			event::add_skillToEvent($eventId, $skillsSelection[$x]);
		}
		$eventName = $event->getName();
		
		$notification = new notification(NULL, "An event you are going to, $eventName, has been modified!", "Event", $eventId, date('Y-m-d H:i:s'));
		
		$notificationId = $notification->save();
		
		$attendees = event::get_attendees($eventId);
		for($x = 0; $x < count($attendees); $x++) {
			notification::add_notificationForUser($attendees[$x][0], $notificationId);
		}
		
		event::add_editHistory($eventId, $user->getId());
		
		header("Location: index.php?action=eventManager&eventId=$eventId&organisationId=$organisationId&senderPage=$senderPage");
	}
}
?>


<h1>Adjust the information for <?php echo $event->getName(); ?>.</h1><br>
<p><span class="error">* = required fields</span></p>
<div class="col-20">
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		
		<div class="userInput">
			<input type="text" name="name" value="<?php echo $event->getName(); ?>" class="<?php if (isset($nameErr)) {echo "invalid";} else if (isset($name)) {echo "valid";} ?>">
			<label>The name of your event:</label>
			<span class="error"> * <?php if (isset($nameErr)) {echo $nameErr;} ?></span>
		</div>
		
		<div class="userInput">
			<select id="eventPurpose" name="purpose" class="<?php if (isset($purposeErr)) {echo "invalid";} ?>" onchange="loadTypes(this.value)">
				<option selected disabled hidden value=""></option>
				<option value="career"; title="These are events with the purpose of guiding attendants in their search and preparation for a job (e.g.: in-house days, job fairs, coaching sessions on improving CV, ...)."; <?php if (isset($isPurpose) && $isPurpose == "career") {echo "selected";} ?>>Career</option>
				<option value="job"; title="These are events with the purpose of offering the students a chance to apply for a job and work experience."; <?php if (isset($isPurpose) && $isPurpose == "job") {echo "selected";} ?>>Job</option>
				<option value="learning"; title="These are events with the purpose of teaching the attendants new skills (e.g.: valuation workshop, intellectual property lecture, ...)."; <?php if (isset($isPurpose) && $isPurpose == "learning") {echo "selected";} ?>>Learning</option>
			</select>
			<label>The purpose of your event:</label>
			<span class="error"> * <?php if (isset($purposeErr)) {echo $purposeErr;}?></span>
		</div>
		
		<div class="userInput">
			<select id="eventType" name="eventType" class="<?php if (isset($typeErr)) {echo "invalid";} ?>" >
				<option selected disabled hidden value=""></option>
			</select>
			<label>The type of event you are organising:</label>
			<span class="error"> * <?php if (isset($typeErr)) {echo $typeErr;}?></span>
		</div>
		
		<div class="userInput">
			<input type="hidden" id="startDate" name="startDate">
			<input type="text" id="datepicker1" class="datepicker <?php if (isset($startDateErr)) {echo "invalid";} ?>" readonly>
			<label>When does your event start?</label>
			<span class="error"> * <?php if (isset($startDateErr)) {echo $startDateErr;}?></span>
		</div>
		<div class="userInput">
			<input type="text" name="startHour" placeholder="hh" value="<?php if (isset($startHour)) {echo $startHour;} else {echo date("H", $startTime);} ?>" class="<?php if (isset($startHourErr) || isset($startHourValidErr)) {echo "invalid";} else if (isset($startHour))  {echo "valid";} ?>" style="width:40px"><span style="color:black;"> : </span><input type="text" name="startMinute" placeholder="mm" value="<?php if (isset($startMinute)) {echo $startMinute;} else {echo date("i", $startTime);} ?>" class="<?php if (isset($startHourErr) || isset($startMinuteValidErr)) {echo "invalid";} else if (isset($startMinute)) {echo "valid";} ?>" style="width:40px">
			<label>At:</label>
			<span class="error"> * <?php if (isset($startHourErr)) {echo $startHourErr;} else if (isset($startHourValidErr)) {echo $startHourValidErr;} else if (isset($startMinuteValidErr)) {echo $startMinuteValidErr;} ?></span>
		</div>
		
		<div class="userInput">
			<input type="hidden" id="endDate" name="endDate">
			<input type="text" id="datepicker2" class="datepicker <?php if (isset($endDateErr)) {echo "invalid";} ?>" readonly>
			<label>When does your event end?</label>
			<span class="error"> * <?php if (isset($endDateErr)) {echo $endDateErr;}?></span>
		</div>
		<div class="userInput">
			<input type="text" name="endHour" placeholder="hh" value="<?php if (isset($endHour)) {echo $endHour;} else {echo date("H", $endTime);} ?>" class="<?php if (isset($endHourErr) || isset($endHourValidErr)) {echo "invalid";} else if (isset($endHour)) {echo "valid";} ?>" style="width:40px"><span style="color:black;"> : </span><input type="text" name="endMinute" placeholder="mm" value="<?php if (isset($endMinute)) {echo $endMinute;} else {echo date("i", $endTime);} ?>" class="<?php if (isset($endHourErr) || isset($endMinuteValidErr)) {echo "invalid";} else if (isset($endMinute)) {echo "valid";} ?>" style="width:40px">
			<label>At:</label>
			<span class="error"> * <?php if (isset($endHourErr)) {echo $endHourErr;} else if (isset($endHourValidErr)) {echo $endHourValidErr;} else if (isset($endMinuteValidErr)) {echo $endMinuteValidErr;} ?></span>
		</div>
		
		<div class="userInput">
			<input type="hidden" id="subDeadline" name="subscriptionDeadline">
			<input type="text" id="datepicker3" class="datepicker <?php if (isset($subDeadlineErr)) {echo "invalid";} ?>" readonly>
			<label>What is the deadline for subscribing to your event?</label>
			<span class="error"> * <?php if (isset($subDeadlineErr)) {echo $subDeadlineErr;}?></span>
		</div>
		<div class="userInput">
			<input type="text" name="subscriptionHour" placeholder="hh" value="<?php if (isset($subscriptionHour)) {echo $subscriptionHour;} else {echo date("H", $subTime);} ?>" class="<?php if (isset($subHourErr) || isset($subHourValidErr)) {echo "invalid";} else if (isset($subscriptionHour)) {echo "valid";} ?>" style="width:40px"><span style="color:black;"> : </span><input type="text" name="subscriptionMinute" placeholder="mm" value="<?php if (isset($subscriptionMinute)) {echo $subscriptionMinute;} else {echo date("i", $subTime);} ?>" class="<?php if (isset($subHourErr) || isset($subMinuteValidErr)) {echo "invalid";} else if (isset($subscriptionMinute)) {echo "valid";} ?>" style="width:40px">
			<label>At:</label>
			<span class="error"> * <?php if (isset($subHourErr)) {echo $subHourErr;} else if (isset($subHourValidErr)) {echo $subHourValidErr;} else if (isset($subMinuteValidErr)) {echo $subMinuteValidErr;} ?></span>
		</div>
		
		
		<div class="userInput">
			<textarea name="description" rows="10" cols="50" maxlength="270" class="<?php if (isset($descriptionErr)) {echo "invalid";} else if (isset($description)) {echo "valid";} ?>"><?php if (isset($description)) {echo $description;} else {echo $event->getDescription();} ?></textarea>
			<label>Give a brief description of your event (max 270 chars):</label>
			<span class="error"> * <?php if (isset($descriptionErr)) {echo $descriptionErr;}?></span>
		</div>

		<div class="userInput">
			<input type="text" name="capacity" placeholder="e.g.: 65" value="<?php if (isset($capacity)) {echo $capacity;} else {echo $event->getCapacity();} ?>" class="<?php if (isset($capacityErr)) {echo "invalid";} else if (isset($capacity)) {echo "valid";} ?>">
			<label>What is the capacity of your event (how many people can maximum take part)?</label>
			<span class="error"> * <?php if (isset($capacityErr)) {echo $capacityErr;} ?></span>
		</div>

		<div class="userInput">
			<select name="language" class="<?php if (isset($languageErr)) {echo "invalid";} ?>">
				<option value="english" <?php $selectedLanguage = $event->getLanguage(); if ($selectedLanguage == "english") {echo "selected";} ?>>English</option>
				<option value="francais" <?php $selectedLanguage = $event->getLanguage(); if ($selectedLanguage == "francais") {echo "selected";} ?>>Français</option>
				<option value="nederlands" <?php $selectedLanguage = $event->getLanguage(); if ($selectedLanguage == "nederlands") {echo "selected";} ?>>Nederlands</option>
			</select>
			<label> In which language will your event be presented?</label>
			<span class="error"> * <?php if (isset($languageErr)) {echo $languageErr;} ?></span>
		</div>

		<br>
		<div class="userInput">
			<input id="freeEntrance" type="checkbox" name="freeForAll" value="true" onchange="uncheckYes(this.checked)" <?php if(isset($freeForAll) && $freeForAll == 1) {echo "checked";} else if (!isset($isPrice)) {echo "checked";} ?>><span class="checkboxtext">No</span>
			<input id="paidEntrance" type="checkbox" name="notFreeForAll" value="true" onchange="uncheckNo(this.checked)" style="margin-left:20px;" <?php if(isset($freeForAll) && $freeForAll == 0) {echo "checked";} else if (isset($isPrice) && $isPrice != 0) {echo "checked";} ?>><span class="checkboxtext">Yes</span>
			<label>Does your event have an entrance fee?</label>
			<span class="error"> * <?php if (isset($freeForAllErr)) {echo $freeForAllErr;} ?></span>
		</div>

		<div id="price" class="userInput" style="<?php if(isset($freeForAll) && $freeForAll == 0) {echo "display:block;";} else if (isset($isPrice) && $isPrice != 0) {echo "display:block;";} else {echo "display:none;";} ?>">
			<input type="text" name="price" value="<?php if (isset($price)) {echo $price;} else if (isset($isPrice) && $isPrice != 0) {echo $isPrice;} ?>" style="width:60px;"  class="<?php if (isset($priceErr)) {echo "invalid";} else if (isset($price)) {echo "valid";} ?>"><span class="checkboxtext">EUR</span>
			<label>What does it cost to participate in your event?</label>
			<span class="error"> * <?php if (isset($priceErr)) {echo $priceErr;} ?></span>
		</div>
		
		<div id="paymentMethod" class="userInput" style="<?php if(isset($freeForAll) && $freeForAll == 0) {echo "display:block;";} else if (isset($isPrice) && $isPrice != 0) {echo "display:block;";} else {echo "display:none;";} ?>">
			<input id="entrancePaid" type="checkbox" name="entrancePaid" value="true" onchange="uncheckOnline(this.checked)" <?php if(isset($paidOnline) && $paidOnline === 0) {echo "checked";} else if (isset($isPaidOnline) && $isPaidOnline == 0) {echo "checked";} ?>><span class="checkboxtext">At the entrance</span>
			<input id="onlinePaid" type="checkbox" name="paidOnline" value="true" onchange="uncheckEntrance(this.checked)" <?php if(isset($paidOnline) && $paidOnline == 1) {echo "checked";} else if (isset($isPaidOnline) && $isPaidOnline == 1) {echo "checked";} ?>><span class="checkboxtext">Online through your own or a third party webpage</span>
			<label>How shall your event attendees pay?</label>
			<span class="error"> * <?php if (isset($paidOnlineErr)) {echo $paidOnlineErr;} ?></span>
		</div>
		
		<div class="userInput">
			<input id="alternateSubscription" type="checkbox" name="alternateSubscription" value="true" onchange="setSubscriptionPage(this.checked)" <?php if(isset($alternateSubscription) && $alternateSubscription == 1) {echo "checked";} else if (isset($isAlternateSubscription) && $isAlternateSubscription == 1) {echo "checked";} ?>><span class="checkboxtext">Subscribers have to finalize their subscription through another link, such as "EventBrite" or your own webpage.</span>
		</div>
		
		<div id="subscriptionPage" class="userInput" style="<?php if ((isset($alternateSubscription) && $alternateSubscription == 1) || (isset($paidOnline) && $paidOnline == 1) || (isset($isPaidOnline) && $isPaidOnline == 1) || (isset($isAlternateSubscription) && $isAlternateSubscription == 1)) {echo "display:block;";} else {echo "display:none;";} ?>">
			<input type="url" name="subscriptionUrl" placeholder="http://www.example.com/event" value="<?php if (isset($subscriptionUrl)) {echo $subscriptionUrl;} else if (isset($isSubscriptionUrl)) {echo $isSubscriptionUrl;} ?>" class="<?php if (isset($subscriptionUrlErr)) {echo "invalid";} else if (isset($subscriptionUrl)) {echo "valid";} ?>">
			<label>Alternate subscription page:</label>
			<span class="error"> * <?php if (isset($subscriptionUrlErr)) {echo $subscriptionUrlErr;} ?></span>
		</div>

		<div class="userInput">
			<input type="checkbox" name="notOpenForAll" value="true" onchange="setOpenFor(this.checked)" <?php if(isset($openForAll) && $openForAll == 0) {echo "checked";} else if(isset($isOpenForAll) && $isOpenForAll == 0) {echo "checked";} ?>><span class="checkboxtext">This event is NOT open for students of all proficiency and knowledge levels.</span>
		</div>

		<div id="openFor" class="userInput" style="<?php if ((isset($openForAll) && $openForAll == 0) || (isset($isOpenForAll) && $isOpenForAll == 0)) {echo "display:block;";} else {echo "display:none;";} ?>">
			<textarea name="openFor" rows="5" cols="50" maxlength="180" class="<?php if (isset($openForErr)) {echo "invalid";} else if (isset($openFor)) {echo "valid";} ?>"><?php if (isset($openFor)) {echo $openFor;} else if (isset($isOpenFor)) {echo $isOpenFor;} ?></textarea>
			<label>Who is welcome at your event (max 180 chars)?</label>
			<span class="error"> * <?php if (isset($openForErr)) {echo $openForErr;} ?></span>
		</div>
		
		<!--
		<div class="userInput">
			<input id="motivationLetterEncouraged" type="checkbox" name="motivationLetterEncouraged" value="true" onchange="setMotivationLetterEncouraged(this.checked)" <?php if(isset($motivationLetterEncouraged)) { if($motivationLetterEncouraged) {echo "checked";}} ?>><span class="checkboxtext">Subscribers ARE ENCOURAGED TO send in a motivation letter through SkillsBridger.</span><br>
			<input id="motivationLetter" type="checkbox" name="motivationLetter" value="true" onchange="setMotivationLetter(this.checked)" <?php if(isset($motivationLetter)) { if($motivationLetter) {echo "checked";}} ?>><span class="checkboxtext">Subscribers HAVE TO send in a motivation letter through SkillsBridger to be eligible for this event.</span>
		</div>

		<div class="userInput">
			<input id="cvEncouraged" type="checkbox" name="cvEncouraged" value="true" onchange="setCvEncouraged(this.checked)" <?php if(isset($cvEncouraged)) { if($cvEncouraged) {echo "checked";}} ?>><span class="checkboxtext">Subscribers ARE ENCOURAGED TO send in their CV through SkillsBridger.</span><br>
			<input id="cv" type="checkbox" name="cv" value="true" onchange="setCv(this.checked)" <?php if(isset($cv)) { if($cv) {echo "checked";}} ?>><span class="checkboxtext">Subscribers HAVE TO send in their CV through SkillsBridger to be eligible for this event.</span>
		</div>
		-->
		
		<div class="userInput">
			<input type="url" name="webpage" placeholder="http://www.example.com/event" value="<?php if (isset($webpage)) {echo $webpage;} else if (isset($isWebpage)) {echo $isWebpage;} ?>">
			<label>Do you have a webpage for this event? In that case, feel free to give us the url:</label>
		</div>
		
		
		<div class="userInput">
			<input type="text" name="location" value="<?php if (isset($location)) {echo $location;} else if (isset($isLocation)) {echo $isLocation;} ?>">
			<label>Location / building name:</label>
		</div>
		
		<div class="userInput">
			<input type="text" name="street" value="<?php if (isset($street)) {echo $street;} else if (isset($isStreet)) {echo $isStreet;} ?>" class="<?php if (isset($streetErr)) {echo "invalid";} else if (isset($street)) {echo "valid";} ?>">
			<label>Street:</label>
			<span class="error"> * <?php if (isset($streetErr)) {echo $streetErr;} ?></span>
		</div>
		
		<div class="userInput">
			<input type="text" name="number" value="<?php if (isset($number)) {echo $number;} else if (isset($isNumber)) {echo $isNumber;} ?>" class="<?php if (isset($numberErr)) {echo "invalid";} else if (isset($number)) {echo "valid";} ?>">
			<label>Number:</label>
			<span class="error"> * <?php if (isset($numberErr)) {echo $numberErr;} ?></span>
		</div>
		
		<div class="userInput">
			<input type="text" name="zip" value="<?php if (isset($zip)) {echo $zip;} else if (isset($isZip)) {echo $isZip;} ?>" class="<?php if (isset($zipErr)) {echo "invalid";} else if (isset($zip)) {echo "valid";} ?>">
			<label>Zip code:</label>
			<span class="error"> * <?php if (isset($zipErr)) {echo $zipErr;} ?></span>
		</div>
		
		<div class="userInput">
			<input type="text" name="city" value="<?php if (isset($city)) {echo $city;} else if (isset($isCity)) {echo $isCity;} ?>" class="<?php if (isset($cityErr)) {echo "invalid";} else if (isset($city)) {echo "valid";} ?>">
			<label>City:</label>
			<span class="error"> * <?php if (isset($cityErr)) {echo $cityErr;} ?></span>
		</div>
		
		<div class="userInput">
			<select name="province" class="<?php if (isset($provinceErr)) {echo "invalid";} ?>">
				<option selected disabled hidden value=""></option>
				<option value="Antwerpen" <?php if ((isset($isProvince) && $isProvince == "Antwerpen") || (isset($province) && $province == "Antwerpen")) {echo "selected";} ?>>Antwerpen</option>
				<option value="Brabant wallon" <?php if ((isset($isProvince) && $isProvince == "Brabant wallon") || (isset($province) && $province == "Brabant wallon")) {echo "selected";} ?>>Brabant wallon</option>
				<option value="Brussels" <?php if ((isset($isProvince) && $isProvince == "Brussels") || (isset($province) && $province == "Brussels")) {echo "selected";} ?>>Brussels</option>
				<option value="Hainaut" <?php if ((isset($isProvince) && $isProvince == "Hainaut") || (isset($province) && $province == "Hainaut")) {echo "selected";} ?>>Hainaut</option>
				<option value="Liège" <?php if ((isset($isProvince) && $isProvince == "Liège") || (isset($province) && $province == "Liège")) {echo "selected";} ?>>Liège</option>
				<option value="Limburg" <?php if ((isset($isProvince) && $isProvince == "Limburg") || (isset($province) && $province == "Limburg")) {echo "selected";} ?>>Limburg</option>
				<option value="Luxembourg" <?php if ((isset($isProvince) && $isProvince == "Luxembourg") || (isset($province) && $province == "Luxembourg")) {echo "selected";} ?>>Luxembourg</option>
				<option value="Namur" <?php if ((isset($isProvince) && $isProvince == "Namur") || (isset($province) && $province == "Namur")) {echo "selected";} ?>>Namur</option>
				<option value="Oost-Vlaanderen" <?php if ((isset($isProvince) && $isProvince == "Oost-Vlaanderen") || (isset($province) && $province == "Oost-Vlaanderen")) {echo "selected";} ?>>Oost Vlaanderen</option>
				<option value="Vlaams-Brabant" <?php if ((isset($isProvince) && $isProvince == "Vlaams-Brabant") || (isset($province) && $province == "Vlaams-Brabant")) {echo "selected";} ?>>Vlaams-Brabant</option>
				<option value="West-Vlaanderen" <?php if ((isset($isProvince) && $isProvince == "West-Vlaanderen") || (isset($province) && $province == "West-Vlaanderen")) {echo "selected";} ?>>West Vlaanderen</option>
			</select>
			<label>Province or region:</label>
			<span class="error"> * <?php if (isset($provinceErr)) {echo $provinceErr;} ?></span>
		</div>
		
		<div class="userInput">
			<textarea name="addressDescription" rows="10" cols="50" maxlength="100"><?php if (isset($addressDescription)) {echo $addressDescription;} else if (isset($isAddressDescription)) {echo $isAddressDescription;} ?></textarea>
			<label>Give a brief description of how to get to or recognize this location (max 100 chars):</label>
		</div>
		
		<div style="margin:0 0 20px 2rem;">
			<div class="col-20">
				<div class="col-9" style="margin-right:5%;">
					<p style="margin-bottom: 10px;">Which hard skill(s) or subject(s) will be taught on this event?</p>
					<select id="hardSkillSelect" name="hardskill">
						<option selected disabled hidden value=""></option>
					</select>
					<!-- Make sure the button is of the type button, because if it is in the form without the type declared to button, it will refresh the page. -->
					<button type="button" class="button-small" onclick="addToList('hardSkillSelect')">+ Add</button>
					<div id="hardSkillDisplay" class="SkillList"></div>
				</div>
				
				<div class="col-9" style="margin-right:5%;">
					<p style="margin-bottom: 10px;">Which soft skill(s) will be taught on this event?</p>
					<select id="softSkillSelect" name="softskill">
						<option selected disabled hidden value=""></option>
					</select>
					<button type="button" class="button-small" onclick="addToList('softSkillSelect')">+ Add</button>
					<div id="softSkillDisplay" class="SkillList"></div>
				</div>
			</div>
		</div>
		
		<div style="margin: 0 0 1rem 2rem;"><span id="skillError" class="error"><?php if (isset($skillAmountErr)) {echo $skillAmountErr;} ?></span></div>
		
		<input id="skillsSelection" name="skillsSelection" type="hidden" value="<?php if (isset($skillsSelection)) {echo implode(",", $skillsSelection);} else if (isset($isSkillsSelection)) {echo $isSkillsSelection;} ?>">
		
		<input type="hidden" name="eventId" value="<?php echo $eventId ?>">
		
		<input type="hidden" name="organisationId" value="<?php echo $organisationId ?>">
		
		<input type="hidden" name="senderPage" value="<?php echo $senderPage ?>">
		
		<input type="hidden" name="action" value="eventEditor">
		
		<input id="submitButton" type="submit" name="submit" value="submit" style="display:none;">
	</form>
	
	<div>
		<a href="./index.php?action=eventManager&eventId=<?php echo $eventId ?>&organisationId=<?php echo $organisationId ?>&senderPage=<?php echo $senderPage ?>"><button>Back</button></a>
		
		<button type="button" onclick="checkSkillsAdded(<?php echo $eventId; ?>)">Save changes</button><span class="error"> All current attendants will be notified of the changes you made!</span>
	</div>
	
</div>

<script>
	$(function() {
		$( ".datepicker" ).datepicker();
		
		// Sets the chosen date format to something like 16 June 2016.
		$( ".datepicker" ).datepicker( "option", "dateFormat", "dd MM yy" );
		
		// Sets the first day to 1 (Sunday is the default setting).
		$( ".datepicker" ).datepicker( "option", "firstDay", 1 );
		
		// Sets the number of months displayed for selection.
		$( ".datepicker" ).datepicker( "option", "numberOfMonths", 2 );
		
		// Store today's date and set it as minimum for the event start date.
		var today = new Date();
		$( "#datepicker1" ).datepicker("option","minDate", today);
		
		// Put the selected date into the altField.
		$( "#datepicker1" ).datepicker( "option", "altField", "#startDate" );
		
		// Make sure the altField contains the right date format.
		$( "#datepicker1" ).datepicker( "option", "altFormat", "yy-mm-dd" );
		
		/* $( ".datepicker1" ).datepicker( "option", "defaultDate", +7 ); */
		
		/* Set the start date as minimum date for the end date and as maximum date for the subscription date. */
		$( "#datepicker1" ).datepicker( "option", "onSelect", function(selected){$("#datepicker2").datepicker("option","minDate", selected); $("#datepicker3").datepicker("option","maxDate", selected);} );
		
		// Put the selected date into the altField.
		$( "#datepicker2" ).datepicker( "option", "altField", "#endDate" );
		
		// Make sure the altField contains the right date format.
		$( "#datepicker2" ).datepicker( "option", "altFormat", "yy-mm-dd" );
		
		// Put the selected date into the altField.
		$( "#datepicker3" ).datepicker( "option", "altField", "#subDeadline" );
		
		// Make sure the altField contains the right date format.
		$( "#datepicker3" ).datepicker( "option", "altFormat", "yy-mm-dd" );
		
		// Set today's date as minimum for the event subscription deadline.
		$( "#datepicker3" ).datepicker("option","minDate", today);
	});
</script>