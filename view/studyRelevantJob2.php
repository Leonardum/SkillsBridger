<?php
// define variables and set to empty values.
$err = "";

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
	
	$description = cleanInput($_POST['description']);
	$goal = cleanInput($_POST['goal']);
	$grossWage = cleanInput($_POST['grossWage']);
	// Make sure the comma denoted floats are transformed to dot denoted ones.
	$grossWage = (float) str_replace(',', '.', $grossWage);
	if (isset($_POST['study'])) {
		$study = cleanInput($_POST['study']);
	}
	
	if (isset($_POST['bachelor'])) {
		$bachelor = 1;
	} else {
		$bachelor = 0;
	}
	if (isset($_POST['firstMaster'])) {
		$firstMaster = 1;
	} else {
		$firstMaster = 0;
	}
	if (isset($_POST['secondMaster'])) {
		$secondMaster = 1;
	} else {
		$secondMaster = 0;
	}
	if (isset($_POST['maNaMa'])) {
		$maNaMa = 1;
	} else {
		$maNaMa = 0;
	}
	
	
	if (empty($description)) {
		$description = NULL;
		$descriptionErr = "Please, describe the job.";
		$err = true;
	}
	// Check if the description is not longer than 500 characters.
	if (strlen($description) > 500) {
		$descriptionErr = "This job description exceeds the maximum of 500 characters! Kindly shorten it.";
		$err = true;
	}
	// Check if the description is not longer than 150 characters.
	if (strlen($goal) > 150) {
		$goalErr = "This goal description exceeds the maximum of 150 characters! Kindly shorten it.";
		$err = true;
	}
	if (empty($grossWage)) {
		$grossWageErr = "Please, insert the gross wage the student will be earning.";
		$err = true;
	}
	if (empty($study)) {
		$studyErr = "Please, select the study which best corresponds to this job.";
		$err = true;
	}
	
	if (!$err) {

		$studyRelevantJob = unserialize($_SESSION['studyRelevantJob']);

		$studyRelevantJob->setDescription($description);
		$studyRelevantJob->setGoal($goal);
		$studyRelevantJob->setGrossWage($grossWage);
		$studyRelevantJob->setDesiredStudy($study);
		$studyRelevantJob->setBachelor($bachelor);
		$studyRelevantJob->setFirstMaster($firstMaster);
		$studyRelevantJob->setSecondMaster($secondMaster);
		$studyRelevantJob->setMaNaMa($maNaMa);

		$_SESSION['studyRelevantJob'] = serialize($studyRelevantJob);

		header("Location: index.php?action=studyRelevantJob3&companyId=$companyId");
	}
}

?>


<h1>Please provide all required information about the job.</h1>

<p><span class="error">* = required fields</span></p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	
	<div class="userInput">
		<textarea id="description" name="description" style="width:375px;" rows="10" maxlength="500" class="<?php if (isset($descriptionErr)) {echo "invalid";} else if (isset($description)) {echo "valid";} ?>" onkeyup="countdown('description', 500, 'charsLeft')"><?php if (isset($description)) {echo $description;} ?></textarea>
		<label>Please, describe the job briefly (max 500 chars):</label>
		<span class="error"> * <?php if (isset($descriptionErr)) {echo $descriptionErr;}?></span>
		<br>
		<span id="charsLeft" class="charCountDown">Characters left: 500</span>
	</div>
	
	<div class="userInput">
		<textarea id="goal" name="goal" style="width:375px;" rows="10" maxlength="150" class="<?php if (isset($goalErr)) {echo "invalid";} else if (isset($goal)) {echo "valid";} ?>" onkeyup="countdown('goal', 150, 'goalCharsLeft')"><?php if (isset($goal)) {echo $goal;} ?></textarea>
		<label>What is the goal of the job (max 150 chars)?</label>
		<span class="error"> <?php if (isset($goalErr)) {echo $goalErr;}?></span>
		<br>
		<span id="goalCharsLeft" class="charCountDown">Characters left: 150</span>
	</div>
	
	<div id="grossWage" class="userInput" class="<?php if (isset($grossWageErr)) {echo "invalid";} else if (isset($grossWage)) {echo "valid";} ?>">
		<input type="text" name="grossWage" value="<?php if (isset($grossWage)) {echo $grossWage;} ?>" style="width:60px;"  class="<?php if (isset($grossWageErr)) {echo "invalid";} else if (isset($grossWage)) {echo "valid";} ?>"><span class="checkboxtext">EUR</span>
		<label>What is the gross wage the student can expect for this job?</label>
		<span class="error"> * <?php if (isset($grossWageErr)) {echo $grossWageErr;} ?></span>
	</div>
	
	<div class="userInput">
		<select id="study" name="study" class="<?php if (isset($studyErr)) {echo "invalid";} ?>">
			<option selected disabled hidden value=""></option>
		</select>
		<label>Which is the ideal study for this job?</label>
		<span class="error"> * <?php if (isset($studyErr)) {echo $studyErr;}?></span>
	</div>
	
	<div class="userInput">
		<input id="bachelor" type="checkbox" name="bachelor" value="true" <?php if(isset($bachelor) && $bachelor == 1) {echo "checked";} ?>><span class="checkboxtext">Bachelor's students</span><br>
		<input id="firstMaster" type="checkbox" name="firstMaster" value="true" <?php if(isset($firstMaster) && $firstMaster == 1) {echo "checked";} ?>><span class="checkboxtext">First master's students</span><br>
		<input id="secondMaster" type="checkbox" name="secondMaster" value="true" <?php if(isset($secondMaster) && $secondMaster == 1) {echo "checked";} ?>><span class="checkboxtext">Second master's students</span><br>
		<input id="maNaMa" type="checkbox" name="maNaMa" value="true" <?php if(isset($maNaMa) && $maNaMa == 1) {echo "checked";} ?>><span class="checkboxtext">ManaMa</span><br>
		<label>Which students are allowed to apply for this job (multiple selections possible)?</label>
	</div>
	
	<input type="hidden" name="companyId" value="<?php echo $companyId ?>">
	
	<input type="hidden" name="action" value="studyRelevantJob2">
	
	<input type="submit" name="submit" value="Next">
</form>