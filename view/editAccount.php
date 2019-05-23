<?php

$emailSuccess = filter_input (INPUT_POST, 'emailSuccess');
if ($emailSuccess == NULL) {
    $emailSuccess = filter_input (INPUT_GET, 'emailSuccess');
}
$pwSuccess = filter_input (INPUT_POST, 'pwSuccess');
if ($pwSuccess == NULL) {
    $pwSuccess = filter_input (INPUT_GET, 'pwSuccess');
}
$studentSuccess = filter_input (INPUT_POST, 'studentSuccess');
if ($studentSuccess == NULL) {
    $studentSuccess = filter_input (INPUT_GET, 'studentSuccess');
}

// define variables and set to empty values.
$err = "";

/* Check whether the email form has been submitted using the POST method. */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitNewEmail'])) {
	
	$email = cleanInput($_POST['email']);
	$pwAuthorise = cleanInput($_POST['pwAuthorise']);
	
	/* Check if an e-mail address has been submitted and if it is a valid one with the FILTER_VALIDATE_EMAIL function */
	if (empty($email)) {
		$emailErr = "Please, fill in your e-mail address.";
		$err = true;
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$emailErr = "Whoops, looks like the e-mail address you inserted is invalid. Please, make sure you have written it correctly.";
		$err = true;
	}
	
	/* Check if the submitted e-mail address is unique in the database. */
	$emails = user::get_emails();
	$arrLength = count($emails);
	for($x = 0; $x < $arrLength; $x++) {
		if (!empty($email) && $emails[$x] === $email) {
			$emailAvailableErr = "Whoops! Looks like this e-mail address is already in use!";
			$err = true;
		}
	}
	
	// Check if a password has been submitted
	if (empty($pwAuthorise)) {
		$pwErr = "Please, fill in your password.";
		$err = true;
	}
	
	// Encrypt the password to check it against the one in the database.
	$pwAuthorise = hash('sha256', $pwAuthorise);
	
	// Check if the given password is correct.
	$passwordCheck = $user->getPassword();
	if ($pwAuthorise !== $passwordCheck) {
		$passwordMatchErr = "Whoops! It looks like your password is not correct. Check if you spelled it correctly.";
		$err = true;
	}
	
	if (!$err) {
		$user->setEmail($email);
		$user->save();
		
		header("Location: index.php?action=editAccount&emailSuccess=true");
	}
}


/* Check whether the password form has been submitted using the POST method. */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitNewPassword'])) {
	
	$oldPassword = cleanInput($_POST['oldPassword']);
	$newPassword = cleanInput($_POST['newPassword']);
	$passwordConfirm = cleanInput($_POST['passwordConfirm']);
	
	if (empty($oldPassword)) {
		$oldPwErr = "Please, fill in your new password.";
		$err = true;
	}
	if (empty($newPassword)) {
		$newPwErr = "Please, fill in your old password.";
		$err = true;
	}
	if (empty($passwordConfirm)) {
		$pwConfirmErr = "Please, fill in your old password for confirmation.";
		$err = true;
	}
	
	// Encrypt the old password to check it against the one in the database.
	$oldPassword = hash('sha256', $oldPassword);
	
	// Check if the given password is correct.
	$passwordCheck = $user->getPassword();
	if ($oldPassword !== $passwordCheck) {
		$oldPwMatchErr = "Whoops! It looks like your password is not correct. Check if you spelled it correctly.";
		$err = true;
	}
	
	
	// Check if the passwords meets security requirements.
	if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{8,16}$/', $newPassword)) {
		$pwConditionErr = "Your password must be between 8 and 16 characters long and contain at least one upper case letter, one lower case letter and one  numeric digit! Spaces are not allowed!";
		$err = true;
	}
	
	// Check if both passwords match.
	if ($newPassword !== $passwordConfirm) {
		$pwMatchErr = "Whoops! It looks like both passwords do not match! Please, fill them in again.";
		$err = true;
	}
	
	if (!$err) {
		// Encrypt the old password to check it against the one in the database.
		$newPassword = hash('sha256', $newPassword);
		
		$user->setPassword($newPassword);
		$user->save();
		
		header("Location: index.php?action=editAccount&pwSuccess=true");
	}
}


/* Check whether the student settings form has been submitted using the POST method. */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitStudentSettings'])) {
	if (isset($_POST['study'])) {
		$study = (int) cleanInput($_POST['study']);
	}
	if (isset($_POST['university'])) {
		$university = (int) cleanInput($_POST['university']);
	}
	if (isset($_POST['currentYear'])) {
		$currentYear = cleanInput($_POST['currentYear']);
	}
	if (isset($_POST['graduationMonth'])) {
		$graduationMonth = (int) cleanInput($_POST['graduationMonth']);
	}
	if (isset($_POST['graduationYear'])) {
		$graduationYear = (int) cleanInput($_POST['graduationYear']);
	}
	if (isset($_POST['internshipInterest'])) {
		$internshipInterest = 1;
	} else {
		$internshipInterest = 0;
	}
	if (isset($_POST['halfTimeInterest'])) {
		$halfTimeInterest = 1;
	} else {
		$halfTimeInterest = 0;
	}
	if (isset($_POST['fullTimeInterest'])) {
		$fullTimeInterest = 1;
	} else {
		$fullTimeInterest = 0;
	}
	if (isset($_POST['termsOfUseAccept'])) {
		$termsOfUseAcceptIp = $_SERVER['REMOTE_ADDR'];
		if ($termsOfUseAcceptIp == NULL) {
			$termsOfUseAcceptIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
	}
	$studentId = cleanInput($_POST['studentId']);

	if (empty($study)) {
		$studyErr = "Please, select your study.";
		$err = true;
	}
	if (empty($university)) {
		$universityErr = "Please, select your university.";
		$err = true;
	}
	if (empty($currentYear)) {
		$currentYearErr = "Please, select the stage of your study you are currently in.";
		$err = true;
	}
	if (empty($graduationMonth) || empty($graduationYear)) {
		$graduationErr = "Please, select the month and year in which you expect to graduate.";
		$err = true;
	}
	/* Set an error if the terms of use have NOT been accepted. */
	if (!isset($_POST['termsOfUseAccept'])) {
		$termsOfUseAcceptIp = NULL;
		$termsOfUseAcceptErr = "This tickbox is obligatory.";
		$err = true;
	}
	
	if (!$err) {
		$student = student::get_studentById($studentId);
			
		$student->setStudyId($study);
		$student->setUniversityId($university);
		$student->setCurrentYear($currentYear);
		$student->setGraduationMonth($graduationMonth);
		$student->setGraduationYear($graduationYear);
		$student->setInternshipInterest($internshipInterest);
		$student->setHalfTimeInterest($halfTimeInterest);
		$student->setFullTimeInterest($fullTimeInterest);
		$student->setTermsOfUseAcceptIp($termsOfUseAcceptIp);
		
		$student->save();
		
		header("Location: index.php?action=editAccount&studentSuccess=true");
	}
}


?>

<h1>Change your login e-mail address:</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<div class="userInput">
		<input type="text" name="email" value="<?php if (isset($email)) {echo $email;} ?>" class="<?php if (isset($emailErr) || isset($emailAvailableErr)) {echo "invalid";} else if (isset($email)) {echo "valid";} ?>">
		<label>Change e-mail address:</label>
		<span class="error">
			<?php
				if (isset($emailErr)) {echo $emailErr;}
				if (isset($emailAvailableErr)) {echo $emailAvailableErr;}
			?>
		</span>
	</div>
	
	<div class="userInput">
		<input type="password" name="pwAuthorise" class="<?php if (isset($pwErr) || isset($passwordMatchErr)) {echo "invalid";} else if (isset($pwAuthorise)) {echo "valid";} ?>">
		<label>Enter your password to confirm:</label>
		<span class="error">
			<?php
				if (isset($pwErr)) {echo $pwErr;}
				if (isset($passwordMatchErr)) {echo $passwordMatchErr;}
			?>
		</span>
		<span class="success">
			<?php
				if (isset($emailSuccess)) {echo "Your e-mail address has been successfully changed!";}
			?>
		</span>
	</div>
	
	<input type="hidden" name="action" value="editAccount">
	
	<input type="submit" name="submitNewEmail" style="margin-left:2rem;" value="Change username">
</form>

<div class="col20 rowDivider"></div>

<h1>Change your password:</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<div class="userInput">
		<input type="password" name="oldPassword" class="<?php if (isset($oldPwErr) || isset($oldPwMatchErr)) {echo "invalid";} else if (isset($oldPassword)) {echo "valid";} ?>">
		<label>Enter your current password:</label>
		<span class="error">
			<?php
				if (isset($oldPwErr)) {echo $oldPwErr;}
				if (isset($oldPwMatchErr)) {echo $oldPwMatchErr;}
			?>
		</span>
	</div>
	
	<div class="userInput">
		<input type="password" name="newPassword" class="<?php if (isset($newPwErr) || isset($pwConditionErr)) {echo "invalid";} else if (isset($newPassword)) {echo "valid";} ?>">
		<label>Enter your new password:</label>
		<span class="error">
			<?php
				if (isset($newPwErr)) {echo $newPwErr;}
				if (isset($pwConditionErr)) {echo $pwConditionErr;}
			?>
		</span>
	</div>
	
	<div class="userInput">
		<input type="password" name="passwordConfirm" class="<?php if (isset($pwConfirmErr) || isset($pwMatchErr)) {echo "invalid";} else if (isset($passwordConfirm)) {echo "valid";} ?>">
		<label>Enter your new password again to confirm:</label>
		<span class="error">
			<?php
				if (isset($pwConfirmErr)) {echo $pwConfirmErr;}
				if (isset($pwMatchErr)) {echo $pwMatchErr;}
			?>
		</span>
		<span class="success">
			<?php
				if (isset($pwSuccess)) {echo "Your password has been successfully changed!";}
			?>
		</span>
	</div>
	
	<input type="hidden" name="action" value="editAccount">
	
	<input type="submit" name="submitNewPassword" style="margin-left:2rem;" value="Change password">
</form>

<?php
$student = student::get_studentByUser($user->getId());

if ($student->getId() !== NULL) {
    echo "<div class='col20 rowDivider'></div>";
    include('./view/studentSettings.php');
}

?>