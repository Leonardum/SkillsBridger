<?php
session_start();
include_once('header.html');

// define variables and set to empty values.
$err = "";

/* check whether the form has been submitted using the POST method. */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
	
	$email = cleanInput($_POST['email']);
	
	if (empty($email)) {
		$emailErr = "Please, fill in your e-mail address.";
		$err = true;
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$emailErr = "Whoops, looks like the e-mail address you inserted is invalid. Please, make sure you have written it correctly.";
		$err = true;
	} else {
		/* Create an array with all e-mail addresses currently stored in the database in order to check if the e-mail address that was submitted for login exists. */
		$emails = user::get_emails();
		
		/* Check if the submitted e-mail address matches one and only one e-mail address in the database. If there are less matches, return an error, if there are more matches, return an error. */
		$arrlength = count($emails);
		$matches = 0;
		
		for($x = 0; $x < $arrlength; $x++) {
			if (!empty($email) && $emails[$x] === $email) {
				$matches += 1;
			}
		}
		
		if ($matches < 1) {
			$emailErr = "This e-mail address was not found in our database. Please check if you have spelled it correctly. If you have not created an account yet, please click <a class='textLink' href=index.php?action=createAccount>here</a>.";
			$err = true;
		} else if ($matches > 1) {
			$emailErr = "It looks like there are several e-mail addresses matching the one you entered. Please, contact our customer service to have this issues solved.";
			$err = true;
		}
	}
	
	if (!$err) {
		
		$user = user::get_userByEmail($email);
		$userId = $user->getId();
		$userFirstName = $user->getFirstName();
		$userLastName = $user->getLastName();
		
		$tempPass = "";
		while (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{8,16}$/', $tempPass)) {
			$length = createRandomNumber(8, 16);
			$tempPass = createToken($length);
		}
		$password = hash('sha256',$tempPass);
		
		// Encrypt the link to the activation file.
		$encryptString = $userId . 'passReset' . $userLastName . $userFirstName;
		$encryptLink = hash('sha256', $encryptString);
		
		/* Knock off the amount of character(s), equal to the length of the user id, of the start of the encrypted link in order to keep the 64 character length for all activation links. */
		$encryptLink = substr($encryptLink, strlen($userId));
		
		// Set the directory for the temporary password reset file.
		$fileDirectory = "./temp/passReset/$encryptLink$userId.php";
		
		// Create the temporary password reset file and store the handler in $temp .
		$temp = fopen($fileDirectory, "w");
		
		/* Write the temporary password reset file. */
		fwrite($temp, "<?php
			
			session_start();
			
			\$_SESSION['userId'] = $userId;
			
			require_once('../../model/database.php');
			require_once('../../model/user_object.php');
			
			\$user = user::get_userById($userId);
			
			\$user->setPassword('$password');
			
			\$user->save();
			
			header('Location: ../../index.php?action=newPassActive');
			
			?>");
		
		// Create a message variable for the mail.
		$message = "Hi $userFirstName,<br><br>We have generated a new password for you. You can activate this password now by clicking on the link below and then you can log yourself in with this e-mail address and your new password: $tempPass .<br>However we strongly advise you to change your password again as soon as possible. This can be done in the 'Account settings', which you can navigate to by clicking on the icon next to the notification icon.<br><br>This is your new password activation link: http://www.skillsbridger.com/temp/passReset/$encryptLink$userId.php .<br><br>Kind regards,<br><br>The SkillsBridger Team!";
		
		// Set up the API key environment variable.
		putenv("SENDGRID_API_KEY=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");
		
		// Include the SendGrid file necessary to send e-mails.
		require("./sendgrid-php/sendgrid-php.php");
		
		// Set up the e-mail.
		$from = new SendGrid\Email(null, 'noreply@skillsbridger.com');
		$to = new SendGrid\Email(null, $email);
		$subject = 'Password reset';
		$content = new SendGrid\Content("text/html", $message);
		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		
		// Prepare the SendGrid API key
		$apiKey = getenv('SENDGRID_API_KEY');
		$sg = new \SendGrid($apiKey);
		
		// Send the e-mail and handle errors if any.
		try {
			$response = $sg->client->mail()->send()->post($mail);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		
		header("Location: index.php?action=logIn&success=true");
	}
}

?>

<body>
	<div class="col-15 lone-message">
		<h1>Hi there, fill out your username (the e-mail address you normally use to log in) and hit the send button, so we can send you your new password!</h1>

		<p><span class="error">* = required fields</span></p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

			<div class="userInput">
				<input type="email" name="email" value="<?php if (isset($email)) {echo $email;} ?>" class="<?php if (isset($emailErr) || isset($emailNotFoundErr)) {echo "invalid";} else if (isset($email)) {echo "valid";} ?>">
				<label>Please, fill in your e-mail address:</label>
				<span class="error"> * <?php if (isset($emailErr)) {echo $emailErr;} ?></span>
			</div>

			<input type="hidden" name="success" value=true>

			<input type="hidden" name="action" value="forgotPassword">

			<input type="submit" name="submit" value="send">
		</form>
	</div>
</body>

<?php
include_once('footer.html');
?>