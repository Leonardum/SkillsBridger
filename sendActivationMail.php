<?php
require('./model/database.php');
require('./model/user_object.php');

$unactivatedUsers = user::get_unactivatedUsers();

for($x = 0; $x < count($unactivatedUsers); $x++) {
	$unactivatedUser = $unactivatedUsers[$x];
	
	$userId = $unactivatedUser['User_id'];
	$firstname = $unactivatedUser['FirstName'];
	$lastname = $unactivatedUser['LastName'];
	$email = $unactivatedUser['Email'];
	
	
	// Encrypt the link to the activation file.
	$encryptString = $userId . $firstname . $lastname;
	$encryptLink = hash('sha256', $encryptString);

	$encryptLink = substr($encryptLink, strlen($userId));
	
	$message =
		"
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset='utf-8'>
				<title>Welcome to SkillsBridger</title>
			</head>
			<body>
				<p>Hi there $firstname,</p>
				<p style='margin:20px 0;'>You created a SkillsBridger account, but have not activated it yet! Therefore we sent you this activation mail. To activate your account, simply click the button below and then you can log in with this e-mail address and your password!</p>
				<p>In case you do not activate your account within the next week, we will remove it, to keep our database clean and relevant. We hope you will seize this last opportunity to check out SkillsBridger and work on the skills you want and need for your professional ambition!</p>
				
				<a href=http://www.skillsbridger.com/temp/$encryptLink$userId.php><button style='padding:15px; background-color:rgb(59, 161, 219); outline:none; border:none; color:rgb(255, 255, 255); cursor:pointer;'>Confirm and activate my account!</button></a>
			</body>
		</html>
		";


	// Set up the API key environment variable.
	putenv("SENDGRID_API_KEY=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");

	// Include the SendGrid file necessary to send e-mails.
	require("./sendgrid-php/sendgrid-php.php");

	// Set up the e-mail.
	$from = new SendGrid\Email(null, 'noreply@skillsbridger.com');
	$to = new SendGrid\Email(null, $email);
	$subject = 'Welcome to SkillsBridger';
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
	
	
	
	echo $unactivatedUser['User_id'] . ", " . $unactivatedUser['FirstName'] . ", " . $unactivatedUser['LastName'] . ", " . $unactivatedUser['Email'] . " MAIL SENT<br>";
}

?>