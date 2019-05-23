<?php
// define variables and set to empty values.
$err = "";

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
	$hiringCompany = cleanInput($_POST['hiringCompany']);
	$department = cleanInput($_POST['department']);
	$studentReportsTo = cleanInput($_POST['studentReportsTo']);
	$startDate = cleanInput($_POST['startDate']);
	$endDate = cleanInput($_POST['endDate']);
	$applicationDeadline = cleanInput($_POST['applicationDeadline']);
	$requestDate = cleanInput($_POST['requestDate']);
	$daysPerWeek = cleanInput($_POST['daysPerWeek']);
	$hoursPerWeek = cleanInput($_POST['hoursPerWeek']);
	
	if (empty($hiringCompany)) {
		$hiringCompanyErr = "Please, fill in the name of the hiring company.";
		$err = true;
	}
	if (empty($startDate)) {
		$startDateErr = "Please, select the date on which the student should start.";
		$err = true;
	}
	if (empty($endDate)) {
		$endDateErr = "Please, select the estimated end date of the contract.";
		$err = true;
	}
	
	if (empty($applicationDeadline)) {
		$applicationDeadlineErr = "Please, select the latest date on which students can still apply for this job.";
		$err = true;
	}
	if (empty($requestDate)) {
		$requestDateErr = "Please, select the date on which this job was requested.";
		$err = true;
	}
	if (empty($daysPerWeek)) {
		$daysPerWeekErr = "Please, insert the amount of days per week the student is expected to work for this job.";
		$err = true;
	}
	if (empty($hoursPerWeek)) {
		$hoursPerWeekErr = "Please, insert the amount of hours per week the student is expected to work for this job.";
		$err = true;
	}
	
	if (!$err) {
		/* Convert all the date information into datetime strings. */
		$requestDate = $requestDate . " 00:00:00";
		$start = $startDate . " 00:00:00";
		$end = $endDate . " 00:00:00";
		$applicationDeadline = $applicationDeadline . " 00:00:00";

		$studyRelevantJob = new studyRelevantJob(NULL, $companyId, $hiringCompany, $department, $studentReportsTo, $requestDate, $start, $end, $applicationDeadline, $daysPerWeek, $hoursPerWeek, NULL, NULL, NULL, 1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

		$_SESSION['studyRelevantJob'] = serialize($studyRelevantJob);

		header("Location: index.php?action=studyRelevantJob2&companyId=$companyId");
	}
}

?>


<h1>Please provide all required information about the job.</h1>

<p><span class="error">* = required fields</span></p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	
	<div class="userInput">
		<input type="text" name="hiringCompany" value="<?php if (isset($hiringCompany)) {echo $hiringCompany;} ?>" class="<?php if (isset($hiringCompanyErr)) {echo "invalid";} else if (isset($hiringCompany)) {echo "valid";} ?>">
		<label>The full legal name of the hiring company:</label>
		<span class="error"> * <?php if (isset($hiringCompanyErr)) {echo $hiringCompanyErr;} ?></span>
	</div>
	
	<div class="userInput">
		<input type="text" name="department" value="<?php if (isset($department)) {echo $department;} ?>" class="<?php if (isset($departmentErr)) {echo "invalid";} else if (isset($department)) {echo "valid";} ?>">
		<label>Which department will the student be working for?</label>
	</div>
	
	<div class="userInput">
		<input type="text" name="studentReportsTo" value="<?php if (isset($studentReportsTo)) {echo $studentReportsTo;} ?>" class="<?php if (isset($studentReportsToErr)) {echo "invalid";} else if (isset($studentReportsTo)) {echo "valid";} ?>">
		<label>Who will the student report to?</label>
	</div>
	
	<div class="userInput">
		<input type="hidden" id="startDate" name="startDate">
		<input type="text" id="datepicker1" class="datepicker <?php if (isset($startDateErr)) {echo "invalid";} ?>" readonly>
		<label>When should the student start?</label>
		<span class="error"> * <?php if (isset($startDateErr)) {echo $startDateErr;}?></span>
	</div>
	
	<div class="userInput">
		<input type="hidden" id="endDate" name="endDate">
		<input type="text" id="datepicker2" class="datepicker <?php if (isset($endDateErr)) {echo "invalid";} ?>" readonly>
		<label>When is the estimated end of the contract?</label>
		<span class="error"> * <?php if (isset($endDateErr)) {echo $endDateErr;}?></span>
	</div>
	
	<div class="userInput">
		<input type="hidden" id="applicationDeadline" name="applicationDeadline">
		<input type="text" id="datepicker3" class="datepicker <?php if (isset($applicationDeadlineErr)) {echo "invalid";} ?>" readonly>
		<label>When is the deadline for applying for this job?</label>
		<span class="error"> * <?php if (isset($applicationDeadlineErr)) {echo $applicationDeadlineErr;}?></span>
	</div>
	
	<div class="userInput">
		<input type="hidden" id="requestDate" name="requestDate">
		<input type="text" id="datepicker4" class="datepicker <?php if (isset($requestDateErr)) {echo "invalid";} ?>" readonly>
		<label>When did the request to fill this vacancy come in?</label>
		<span class="error"> * <?php if (isset($requestDateErr)) {echo $requestDateErr;}?></span>
	</div>
	
	<div class="userInput">
		<input type="text" name="daysPerWeek" value="<?php if (isset($daysPerWeek)) {echo $daysPerWeek;} ?>" class="<?php if (isset($daysPerWeekErr)) {echo "invalid";} else if (isset($daysPerWeek)) {echo "valid";} ?>" style="width:40px;"> days per week.
		<label>How many days per week is the student expected to work?</label>
		<span class="error"> * <?php if (isset($daysPerWeekErr)) {echo $daysPerWeekErr;} ?></span>
	</div>
	
	<div class="userInput">
		<input type="text" name="hoursPerWeek" value="<?php if (isset($hoursPerWeek)) {echo $hoursPerWeek;} ?>" class="<?php if (isset($hoursPerWeekErr)) {echo "invalid";} else if (isset($hoursPerWeek)) {echo "valid";} ?>" style="width:40px;"> hours per week.
		<label>How many hours per week is the student expected to work?</label>
		<span class="error"> * <?php if (isset($hoursPerWeekErr)) {echo $hoursPerWeekErr;} ?></span>
	</div>
	
	<input type="hidden" name="companyId" value="<?php echo $companyId ?>">
	
	<input type="hidden" name="action" value="studyRelevantJob1">
	
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
		
		/* Set the start date as minimum date for the end date and as maximum date for the application and request date. */
		$( "#datepicker1" ).datepicker( "option", "onSelect", function(selected){$("#datepicker2").datepicker("option","minDate", selected); $("#datepicker3").datepicker("option","maxDate", selected);} );
		
		// Put the selected date into the altField.
		$( "#datepicker2" ).datepicker( "option", "altField", "#endDate" );
		
		// Make sure the altField contains the right date format.
		$( "#datepicker2" ).datepicker( "option", "altFormat", "yy-mm-dd" );
		
		// Put the selected date into the altField.
		$( "#datepicker3" ).datepicker( "option", "altField", "#applicationDeadline" );
		
		// Make sure the altField contains the right date format.
		$( "#datepicker3" ).datepicker( "option", "altFormat", "yy-mm-dd" );
		
		// Set today's date as minimum for the event subscription deadline.
		$( "#datepicker3" ).datepicker("option","minDate", today);
		
		// Put the selected date into the altField.
		$( "#datepicker4" ).datepicker( "option", "altField", "#requestDate" );
		
		// Make sure the altField contains the right date format.
		$( "#datepicker4" ).datepicker( "option", "altFormat", "yy-mm-dd" );
		
		// Set today's date as minimum for the event subscription deadline.
		$( "#datepicker4" ).datepicker("option","maxDate", today);
	});
</script>