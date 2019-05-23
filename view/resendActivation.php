<?php
include_once('header.html');

$user = user::get_userById($userId);
$firstname = $user->getFirstName();
$lastname = $user->getLastName();
$userEmail = $user->getEmail();

// Encrypt the link to the activation file.
$encryptString = $userId . $firstname . $lastname;
$encryptLink = hash('sha256', $encryptString);

$encryptLink = substr($encryptLink, strlen($userId));

/* The activation link in email should be "localhost/SkillsBridger" on the local server. This version is for the uploaded online version. */
$message =
	"
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset='utf-8'>
			<title>Welcome to SkillsBridger</title>
		</head>
		<body>
			<h1 style='rgb(59, 161, 219)'>Congratulations $firstname $lastname,</h1>
			<p style='margin:20px 0;'>Your account was successfully created! Please click the button below to confirm your account and activate it!</p>

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
$to = new SendGrid\Email(null, $userEmail);
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
			<h1>Trouble with the activation e-mail, <?php echo $firstname; ?>?</h1>
			<p>Not to worry, we have just sent another e-mail your way to the following address: <?php echo $userEmail; ?>.</p>
			<p>Make sure to refresh your inbox and to check your spam folders as well, as automatic mail can sometimes end up there. If the problem persists, please contact our <a class="textLink" href="index.php?action=activationMailLost&userId=<?php echo $userId; ?>">customer support</a>!</p>
		</div>
	</div>
</body>

<?php
include_once('footer.html');
?>