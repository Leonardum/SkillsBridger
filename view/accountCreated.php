<?php
session_start();
include_once('header.html');

// Encrypt the link to the activation file.
$encryptString = $_SESSION['userId'] . $_SESSION['firstname'] . $_SESSION['lastname'];
$encryptLink = hash('sha256', $encryptString);

/* Knock off the amount of character(s), equal to the length of the user id, of the start of the encrypted link in order to keep the 64 character length for all activation links. */
$encryptLink = substr($encryptLink, strlen($_SESSION['userId']));

// Set the directory for the auxiliary activation file.
$fileDirectory ="./temp/$encryptLink$_SESSION[userId].php";

// Create the auxiliary activation file and store the handler in $temp .
$temp = fopen($fileDirectory, "w");

/* Write the auxiliary activation file. The variables will be filled out as if they were strings. In order to escape this, use the \ character, as in \$_SESSION [userId]. This will not return the value of the variable, but the literal string. */
fwrite($temp, "<?php

	session_start();
	
	\$_SESSION['userId'] = $_SESSION[userId];
	
	require('../model/database.php');
	require_once('../model/user_object.php');
	
	\$user = user::get_userById($_SESSION[userId]);
	
	\$user->setAccountActivated(1);
	
	\$user->save();
	
	header('Location: ../index.php?action=welcome');
	
	?>");

/* Create a message variable for the confirmation mail. Note that in a message you can still add quotation marks with the following hierarchy: 1) ", 2) \", 3) ' and 4) \'. For html links, you don't need to add the quotation marks for the href attribute, since the entire message is already quoted. So a link would become <a href=url></a> instead of <a href="url"></a>.

The activation link in email should be "localhost/SkillsBridger" on the local server. This version is for the uploaded online version. */
$message =
	"
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset='utf-8'>
			<title>Welcome to SkillsBridger</title>
		</head>
		<body>
			<h1 style='rgb(59, 161, 219)'>Congratulations $_SESSION[firstname] $_SESSION[lastname],</h1>
			<p style='margin:20px 0;'>Your SkillsBridger account was successfully created! Please click the button below to confirm your account and activate it!</p>

			<a href=http://www.skillsbridger.com/temp/$encryptLink$_SESSION[userId].php><button style='cursor:pointer; padding:15px; background-color:rgb(59, 161, 219); outline:none; border:none; color:rgb(255, 255, 255);'>Confirm and activate my account!</button></a>
		</body>
	</html>
	";

// Set up the API key environment variable.
putenv("SENDGRID_API_KEY=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");

// Include the SendGrid file necessary to send e-mails.
require("./sendgrid-php/sendgrid-php.php");

// Set up the e-mail.
$from = new SendGrid\Email(null, 'noreply@skillsbridger.com');
$to = new SendGrid\Email(null, $_SESSION['email']);
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

?>

<body>
	<div class='col-20'>
		<div class='col-15 lone-message'>
			<h1>Congratulations <?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname'] ?>,</h1>
			<p>Your account was successfully created! You should shortly receive a confirmation e-mail with a link to activate your account. If you don't receive an e-mail within 2 minutes, then click <a class="textLink" href="index.php?action=resendActivation&userId=<?php echo $_SESSION['userId'] ?>">this link</a> to resend it. Make sure to refresh your inbox and to check your spam folders as well, as automatic mail can sometimes end up there.</p>
		</div>
	</div>
</body>

<?php
// Remove all session variables.
session_unset();
// Destroy the session.
session_destroy();

include_once('footer.html');
?>