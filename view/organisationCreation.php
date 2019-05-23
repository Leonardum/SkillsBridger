<?php

// define variables and set to empty values.
$err = "";

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$name = cleanInput($_POST['name']);
	$phone = cleanInput(preg_replace('/[^+0-9]/', '', $_POST['phone']));
	$message = cleanInput($_POST['message']);
	
	$userId = $user->getId();
	$userName = $user->getFirstName() . " " . $user->getLastName();
	$userMail = $user->getEmail();
	
	if (empty($name)) {
		$nameErr = "Please, insert your name.";
		$err = true;
	}
	if (empty($phone)) {
		$phoneErr = "Please, insert a valid phone number.";
		$err = true;
	}
	if (!preg_match('/^\+?[0-9$]/', $phone)) {
		$phoneValidErr = "Please insert a valid phone number.";
		$err = true;
	}
	if (empty($message)) {
		$messageErr = "Please, describe your organisation and the events you wish to post on SkillsBridger.";
		$err = true;
	}
	
	if (!$err) {
		// Include the PHPMailer file necessary to send  e-mails.
		require('./PHPMailer-master/PHPMailerAutoload.php');
		
		// Create a subject variable for the mail.
		$subject = "New organisation application!";
		
		// Create a message variable for the mail.
		$message = "$userName (id = $userId) would like to create a new event organisation with the name: $name.<br><br>This user's contact details are:<br>Phone number: $phone<br>E-mail address: $userMail<br><br>The user described the organisation as follows:<br>" . $message;
		
		// Send the e-mail, using PHPMailer.
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAutoTLS = false;
		$mail->SMTPAuth = true;
		$mail->Host = 'premium16.web-hosting.com';
		$mail->Port = 587;
		$mail->SMTPDebug = 0;
		$mail->Username = 'noreply@skillsbridger.com';
		$mail->Password = 'a44ad2b392aee3fa';
		$mail->setFrom('noreply@skillsbridger.com');
		$mail->addAddress('organisationapplication@skillsbridger.com');
		$mail->Subject = $subject;
		$mail->Body = $message;
		$mail->isHTML(true);
		$mail->send();
		
		header("Location: index.php?action=eventOrganisationOverview");
	}
}

?>

<h1>The quality of the events posted on SkillsBridger is of utmost importance to us. Therefore we ask all organisations that wish to publish their events on SkillsBridger, to fill in the following application form.<br>Our team will evaluate your application and contact you as soon as possible.</h1><br>

<p><span class="error">* = required fields</span></p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	
	<div class="userInput">
		<input type="text" name="name" value="<?php if (isset($name)) {echo $name;} ?>" class="<?php if (isset($nameErr)) {echo "invalid";} else if (isset($name)) {echo "valid";} ?>">
		<label>Name of the organisation you wish to add to SkillsBridger:</label>
		<span class="error"> * <?php if (isset($nameErr)) {echo $nameErr;} else if (isset($phoneValidErr)) {echo $phoneValidErr;} ?></span>
	</div>
	
	<div class="userInput">
		<input type="text" name="phone" value="<?php if (isset($phone)) {echo $phone;} ?>" class="<?php if (isset($phoneErr)) {echo "invalid";} else if (isset($phone)) {echo "valid";} ?>">
		<label>Your phone number on which we can contact you:</label>
		<span class="error"> * <?php if (isset($phoneErr)) {echo $phoneErr;} ?></span>
	</div>
	
	<div class="userInput" style="padding-top:2rem;">
		<textarea name="message" rows="20" style="width:600px;" class="<?php if (isset($messageErr)) {echo "invalid";} else if (isset($message)) {echo "valid";} ?>"><?php if (isset($message)) {echo $message;} ?></textarea>
		<label>Please, describe your organisation and which (type of) events you would like to post on SkillsBridger:</label>
		<span class="error"><?php if (isset($messageErr)) {echo $messageErr;}?></span>
	</div>
	
	<input type="hidden" name="action" value="organisationCreation">
	
	<input type="submit" name="submit" value="Apply now">
</form>