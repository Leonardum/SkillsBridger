<?php
include_once('header.html');

$user = user::get_userById($userId);
$firstname = $user->getFirstName();
$lastname = $user->getLastName();
$email = $user->getEmail();

// Encrypt the link to the activation file.
$encryptString = $userId . $firstname . $lastname;
$encryptLink = hash('sha256', $encryptString);

$encryptLink = substr($encryptLink, strlen($userId));

//Include the PHPMailer file necessary to send  e-mails
require('./PHPMailer-master/PHPMailerAutoload.php');

/* The activation link in email should be "localhost/SkillsBridger" on the local server. This version is for the uploaded online version. */
$message = "The user with the name $firstname $lastname, has not been able to activate his / her account. The e-mail address is $email and the user id is $userId.

Send an e-mail to him with the following link: http://www.skillsbridger.com/temp/$encryptLink$userId.php .
";

//Send the e-mail, using PHPMailer
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
$mail->addAddress('lennerthabils@gmail.com');
$mail->Subject = "$userId $firstname $lastname has not been able to activate account.";
$mail->Body = $message;
$mail->isHTML(true);
$mail->send();

?>

<body>
	<div class='col-20'>
		<div class='col-15 lone-message'>
			<h1>We are sorry for the inconvenience, <?php echo $firstname; ?>,</h1>
			<p>We have just sent an e-mail to our tech support team. They will send you an e-mail with your activation link within the next 48 hours to the following address: <?php echo $email; ?>. With that link you will be able to activate your account.</p>
			<br>
			<a href="index.php"><button>Back</button></a>
		</div>
	</div>
</body>

<?php
include_once('footer.html');
?>