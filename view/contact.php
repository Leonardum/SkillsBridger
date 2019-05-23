<?php
include_once('header.html');

$success = filter_input (INPUT_POST, 'success');
if ($success == NULL) {
	$success = filter_input (INPUT_GET, 'success');
}

// define variables and set to empty values.
$err = "";

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
	
	$email = cleanInput($_POST['email']);
	$subject = cleanInput($_POST['subject']);
	$message = cleanInput($_POST['message']);
	
	
	if (empty($email)) {
		$emailErr = "Please, give us your e-mail address so we can get back to you.";
		$err = true;
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$emailErr = "Whoops, looks like this e-mail address is invalid. Please, make sure you have written it correctly.";
		$err = true;
	}
	
	if (empty($subject)) {
		$subjectErr = "Please, give the subject of your message.";
		$err = true;
	}
	
	if (empty($message)) {
		$messageErr = "Please, type a message.";
		$err = true;
	}
	
	if (!$err) {
		// Include the PHPMailer file necessary to send  e-mails.
		require('./PHPMailer-master/PHPMailerAutoload.php');

		// Create a message variable for the confirmation mail.
		$message = "You got a new message from: $email.<br><br>" . $message;
		
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
		$mail->setFrom('contact@skillsbridger.com');
		$mail->addAddress('info@skillsbridger.com');
		$mail->Subject = $subject;
		$mail->Body = $message;
		$mail->isHTML(true);
		$mail->send();
		
		
		header("Location: index.php?action=contactSuccessful");
	}
}

?>

<body>
	<div class="col-16 lone-message">
		<h1>Any complaints, questions, remarks or advice? We'd like to hear from you:</h1>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<div class="userInput">
				<input type="email" name="email" value="<?php if (isset($email)) {echo $email;} ?>" class="<?php if (isset($emailErr)) {echo "invalid";} else if (isset($email)) {echo "valid";} ?>">
				<label>Your e-mail address:</label>
				<span class="error"><?php if (isset($emailErr)) {echo $emailErr;} ?></span>
			</div>
			
			<div class="userInput">
				<input type="text" name="subject" value="<?php if (isset($subject)) {echo $subject;} ?>" class="<?php if (isset($subjectErr)) {echo "invalid";} else if (isset($subject)) {echo "valid";} ?>" style="width:600px;">
				<label>Subject:</label>
				<span class="error"><?php if (isset($subjectErr)) {echo $subjectErr;} ?></span>
			</div>
			
			<div class="userInput" style="padding-top:2rem;">
				<textarea name="message" rows="20" style="width:600px;" class="<?php if (isset($messageErr)) {echo "invalid";} else if (isset($message)) {echo "valid";} ?>"><?php if (isset($message)) {echo $message;} ?></textarea>
				<label>Message:</label>
				<span class="error"><?php if (isset($messageErr)) {echo $messageErr;}?></span>
			</div>
			
			<input type="hidden" name="action" value="contact">
			
			<input type="submit" name="submit" value="Send message">
		</form>
		<div style="padding-top:1rem;">
			<a href="index.php"><button type="button">Back</button></a>
		</div>
	</div>
</body>


<?php
include_once('footer.html');
?>