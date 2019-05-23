<?php
// define variables and set to empty values.
$err = "";

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST') {
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
}

if (isset($_POST["submit"]) && !$err) {
	/* Convert all the information about the start of the event into one variable. */
	$start = $startDate . " " . $startHour . ":" . $startMinute . ":00";
	$end = $endDate . " " . $endHour . ":" . $endMinute . ":00";
	$subscription = $subscriptionDeadline . " " . $subscriptionHour . ":" . $subscriptionMinute . ":00";
	
	$event = new event(NULL, $organisationId, $name, $purpose, $type, $start, $end, $subscription, NULL, NULL, NULL, NULL, 0, 0, NULL, 1, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0);
	
	$_SESSION['eventPurpose'] = $event->getPurpose();
	$_SESSION['eventType'] = $event->getType();
	$_SESSION['event'] = serialize($event);
	
	header("Location: index.php?action=eventCreation2&organisationId=$organisationId");
}

?>


<h1>Please provide all required information for your new event.</h1><br>

<p><span class="error">* = required fields</span></p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	
	<div class="userInput">
		<input type="text" name="name" value="<?php if (isset($name)) {echo $name;} ?>" class="<?php if (isset($nameErr)) {echo "invalid";} else if (isset($name)) {echo "valid";} ?>">
		<label>The name of your event:</label>
		<span class="error"> * <?php if (isset($nameErr)) {echo $nameErr;} ?></span>
	</div>
	
	<div class="userInput">
		<select name="purpose" class="<?php if (isset($purposeErr)) {echo "invalid";} ?>" onchange="loadTypes(this.value)">
			<option selected disabled hidden value=""></option>
			<option value="career"; title="These are events with the purpose of guiding attendants in their search and preparation for a job (e.g.: in-house days, job fairs, coaching sessions on improving CV, ...).";>Career</option>
			<option value="job"; title="These are events with the purpose of offering the students a chance to apply for a job and work experience.";>Job</option>
			<option value="learning"; title="These are events with the purpose of teaching the attendants new skills (e.g.: valuation workshop, intellectual property lecture, ...).";>Learning</option>
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
		<input type="text" name="startHour" placeholder="hh" value="<?php if (isset($startHour)) {echo $startHour;} ?>" class="<?php if (isset($startHourErr) || isset($startHourValidErr)) {echo "invalid";} else if (isset($startHour))  {echo "valid";} ?>" style="width:40px"><span style="color:black;"> : </span><input type="text" name="startMinute" placeholder="mm" value="<?php if (isset($startMinute)) {echo $startMinute;} ?>" class="<?php if (isset($startHourErr) || isset($startMinuteValidErr)) {echo "invalid";} else if (isset($startMinute)) {echo "valid";} ?>" style="width:40px">
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
		<input type="text" name="endHour" placeholder="hh" value="<?php if (isset($endHour)) {echo $endHour;} ?>" class="<?php if (isset($endHourErr) || isset($endHourValidErr)) {echo "invalid";} else if (isset($endHour)) {echo "valid";} ?>" style="width:40px"><span style="color:black;"> : </span><input type="text" name="endMinute" placeholder="mm" value="<?php if (isset($endMinute)) {echo $endMinute;} ?>" class="<?php if (isset($endHourErr) || isset($endMinuteValidErr)) {echo "invalid";} else if (isset($endMinute)) {echo "valid";} ?>" style="width:40px">
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
		<input type="text" name="subscriptionHour" placeholder="hh" value="<?php if (isset($subscriptionHour)) {echo $subscriptionHour;} ?>" class="<?php if (isset($subHourErr) || isset($subHourValidErr)) {echo "invalid";} else if (isset($subscriptionHour)) {echo "valid";} ?>" style="width:40px"><span style="color:black;"> : </span><input type="text" name="subscriptionMinute" placeholder="mm" value="<?php if (isset($subscriptionMinute)) {echo $subscriptionMinute;} ?>" class="<?php if (isset($subHourErr) || isset($subMinuteValidErr)) {echo "invalid";} else if (isset($subscriptionMinute)) {echo "valid";} ?>" style="width:40px">
		<label>At:</label>
		<span class="error"> * <?php if (isset($subHourErr)) {echo $subHourErr;} else if (isset($subHourValidErr)) {echo $subHourValidErr;} else if (isset($subMinuteValidErr)) {echo $subMinuteValidErr;} ?></span>
	</div>
	
	
	<input type="hidden" name="organisationId" value="<?php echo $organisationId ?>">
	
	<input type="hidden" name="action" value="eventCreation1">
	
	<input type="submit" name="submit" value="Next">
</form>

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