<?php
session_start();
include_once('header.html');

$user = user::get_userById($_SESSION['userId']);
$userId = $_SESSION['userId'];
$firstname = $user->getFirstName();
$lastname = $user->getLastName();

// Encrypt the link to the activation file.
$encryptString = $userId . 'passReset' . $lastname . $firstname;
$encryptLink = hash('sha256', $encryptString);

$encryptLink = substr($encryptLink, strlen($userId));

//Delete the created activation file
unlink("./temp/passReset/$encryptLink$userId.php");

?>

<body>
	<div class='col-20'>
		<div class='col-15 lone-message'>
			<h1>Password activated!</h1>
			<p>Your new password was activated! You can now log yourself in by clicking on the "Log in" button and filling in your e-mail address and the new password we sent you. Please, change this password to a password of your choosing as soon as possible in the SkillsBridger "Account settings".</p>
			<br>
			<div>
				<a href="index.php?action=logIn"><button>Log in</button></a>
			</div>
		</div>
	</div>
</body>

<?php
//Remove all session variables
session_unset();
//Destroy the session
session_destroy();

include_once('footer.html');
?>