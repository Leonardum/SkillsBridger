<?php
// define variables and set to empty values.
$err = "";

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
	
	$softwareMastery = cleanInput($_POST['softwareMastery']);
	$desiredSkills = cleanInput($_POST['desiredSkills']);
	$english = (int) cleanInput($_POST['english']);
	$dutch = (int) cleanInput($_POST['dutch']);
	$french = (int) cleanInput($_POST['french']);
	$german = (int) cleanInput($_POST['german']);
	$remarks = cleanInput($_POST['remarks']);
	
	if (empty($softwareMastery)) {
		$softwareMasteryErr = "Please, describe which software skills the student should have for the job.";
		$err = true;
	}
	
	// Check if the desired software mastery is not longer than 200 characters.
	if (strlen($softwareMastery) > 200) {
		$softwareMasteryErr = "These software requirements exceed the maximum of 200 characters! Kindly shorten them.";
		$err = true;
	}
	// Check if the desired skills description is not longer than 300 characters.
	if (strlen($desiredSkills) > 300) {
		$desiredSkillsErr = "These skill requirements exceed the maximum of 300 characters! Kindly shorten them.";
		$err = true;
	}
	
	/* Generate an array from 0 to 4 to check the entered language requirement values against. */
	$languageArray = array();
	for($x = 0; $x < 5; $x++) {
		array_push($languageArray, $x);
	}
	
	function assignValue($language) {
		switch ($language) {
			case 0:
				$value = "not required.";
				break;
			case 1:
				$value = "basic.";
				break;
			case 2:
				$value = "conversational.";
				break;
			case 3:
				$value = "fluent.";
				break;
			case 4:
				$value = "bilingual or native.";
				break;
			default:
				$value = "not required.";
		}
		return $value;
	}
	
	if (!in_array ($english, $languageArray)) {
		$englishErr = "Please, select a valid requirement for English.";
		$err = true;
	} else {
		$englishValue = assignValue($english);
	}
	if (!in_array ($dutch, $languageArray)) {
		$dutchErr = "Please, select a valid requirement for Dutch.";
		$err = true;
	} else {
		$dutchValue = assignValue($dutch);
	}
	if (!in_array ($french, $languageArray)) {
		$frenchErr = "Please, select a valid requirement for French.";
		$err = true;
	} else {
		$frenchValue = assignValue($french);
	}
	if (!in_array ($german, $languageArray)) {
		$germanErr = "Please, select a valid requirement for German.";
		$err = true;
	} else {
		$germanValue = assignValue($german);
	}
	// Check if the remarks are not longer than 200 characters.
	if (strlen($remarks) > 200) {
		$remarksErr = "These remarks exceed the maximum of 200 characters! Kindly shorten them.";
		$err = true;
	}
	
	if (!$err) {
		$studyRelevantJob = unserialize($_SESSION['studyRelevantJob']);

		$studyRelevantJob->setSoftwareMastery($softwareMastery);
		$studyRelevantJob->setDesiredSkills($desiredSkills);
		$studyRelevantJob->setRemarks($remarks);
		
		$_SESSION['english'] = serialize($english);
		$_SESSION['dutch'] = serialize($dutch);
		$_SESSION['french'] = serialize($french);
		$_SESSION['german'] = serialize($german);
		$_SESSION['studyRelevantJob'] = serialize($studyRelevantJob);

		header("Location: index.php?action=studyRelevantJob4&companyId=$companyId");
	}
}

?>


<h1>Please provide all required information about the job.</h1>

<p><span class="error">* = required fields</span></p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	
	<div class="userInput">
		<textarea id="softwareMastery" name="softwareMastery" style="width:375px;" rows="10" maxlength="200" class="<?php if (isset($softwareMasteryErr)) {echo "invalid";} else if (isset($softwareMastery)) {echo "valid";} ?>" onkeyup="countdown('softwareMastery', 200, 'softwareMasteryCharsLeft')"><?php if (isset($softwareMastery)) {echo $softwareMastery;} ?></textarea>
		<label>Which software skills should the student have to get started (max 200 chars)?</label>
		<span class="error"> * <?php if (isset($softwareMasteryErr)) {echo $softwareMasteryErr;}?></span>
		<br>
		<span id="softwareMasteryCharsLeft" class="charCountDown">Characters left: 200</span>
	</div>
	
	<div class="userInput">
		<textarea id="desiredSkills" name="desiredSkills" style="width:375px;" rows="10" maxlength="300" class="<?php if (isset($desiredSkillsErr)) {echo "invalid";} else if (isset($desiredSkills)) {echo "valid";} ?>" onkeyup="countdown('desiredSkills', 300, 'desiredSkillsCharsLeft')"><?php if (isset($desiredSkills)) {echo $desiredSkills;} ?></textarea>
		<label>Which other skills should the student have to get started (max 300 chars):</label>
		<span class="error"> <?php if (isset($desiredSkillsErr)) {echo $desiredSkillsErr;}?></span>
		<br>
		<span id="desiredSkillsCharsLeft" class="charCountDown">Characters left: 300</span>
	</div>
	
	<div class="userInput">
		Level of English desired: <span id="englishValue"><?php if (isset($englishValue)) {echo $englishValue;} else {echo "not required."; } ?></span><br>
		<input type="range" name="english" min="0" max="4" value="<?php if (isset($english)) {echo $english;} else {echo 0;}?>" onmousemove="showValue(this, 'englishValue')" onchange="showValue(this, 'englishValue')"><span class="error"> <?php if (isset($englishErr)) {echo $englishErr;}?></span>
	</div>
	
	<div class="userInput">
		Level of Dutch desired: <span id="dutchValue"><?php if (isset($dutchValue)) {echo $dutchValue;} else {echo "not required."; } ?></span><br>
		<input type="range" name="dutch" min="0" max="4" value="<?php if (isset($dutch)) {echo $dutch;} else {echo 0;}?>" onmousemove="showValue(this, 'dutchValue')" onchange="showValue(this, 'dutchValue')"><span class="error"> <?php if (isset($dutchErr)) {echo $dutchErr;}?></span>
	</div>
	
	<div class="userInput">
		Level of French desired: <span id="frenchValue"><?php if (isset($frenchValue)) {echo $frenchValue;} else {echo "not required."; } ?></span><br>
		<input type="range" name="french" min="0" max="4" value="<?php if (isset($french)) {echo $french;} else {echo 0;}?>" onmousemove="showValue(this, 'frenchValue')" onchange="showValue(this, 'frenchValue')"><span class="error"> <?php if (isset($frenchErr)) {echo $frenchErr;}?></span>
	</div>
	
	<div class="userInput">
		Level of German desired: <span id="germanValue"><?php if (isset($germanValue)) {echo $germanValue;} else {echo "not required."; } ?></span><br>
		<input type="range" name="german" min="0" max="4" value="<?php if (isset($german)) {echo $german;} else {echo 0;}?>" onmousemove="showValue(this, 'germanValue')" onchange="showValue(this, 'germanValue')"><span class="error"> <?php if (isset($germanErr)) {echo $germanErr;}?></span>
	</div>
	
	<div class="userInput">
		<textarea id="remarks" name="remarks" style="width:375px;" rows="10" maxlength="200" class="<?php if (isset($remarksErr)) {echo "invalid";} else if (isset($remarks)) {echo "valid";} ?>" onkeyup="countdown('remarks', 200, 'remarksCharsLeft')"><?php if (isset($remarks)) {echo $remarks;} ?></textarea>
		<label>Are there any other remarks concerning this job (max 200 chars)?</label>
		<span class="error"> <?php if (isset($remarksErr)) {echo $remarksErr;}?></span>
		<br>
		<span id="remarksCharsLeft" class="charCountDown">Characters left: 200</span>
	</div>
	
	<input type="hidden" name="companyId" value="<?php echo $companyId; ?>">
	
	<input type="hidden" name="action" value="studyRelevantJob3">
	
	<input type="submit" name="submit" value="Next">
</form>