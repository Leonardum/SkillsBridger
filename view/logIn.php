<?php
session_start();
include_once('header.html');

$user = user::isLoggedIn();
if($user) {
    $_SESSION['userId'] = $user->getId();
	$loginId = user::storeLoginData($_SESSION['userId']);
	user::mapLoginData($_SESSION['userId'], $loginId);
	
	$student = student::get_studentByUser($_SESSION['userId']);
	$studentExists = $student->getId();
	if ($studentExists) {
		header("Location: index.php?action=student");
	} else {
		header("Location: ./index.php?action=userPage");
	}
}

$success = filter_input (INPUT_POST, 'success');
if ($success == NULL) {
	$success = filter_input (INPUT_GET, 'success');
}

// Define variables and set to empty values.
$err = "";

/* Check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$email = cleanInput($_POST['email']);
	$passwordCheck = cleanInput($_POST['passwordCheck']);
	if (isset($_POST['rememberMe'])) {
		$rememberMe = 1;
	} else {
		$rememberMe = 0;
	}
	
	/*Check if an e-mail address has been submitted. */
	if (empty($email)) {
		$emailErr = "Please, fill in your e-mail address.";
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
			$emailMatchErr = "This e-mail address was not found in our database. Please check if you have spelled it correctly. If you have not created an account yet, please click <a class='textLink' href=index.php?action=createAccount>here</a>.";
			$err = true;
		} else if ($matches > 1) {
			$emailMatchErr = "It looks like there are several e-mail addresses matching the one you entered. Please, contact our customer service to have this issues solved.";
			$err = true;
		}
	}
	
	
	// Check if the password field is not empty.
	if (empty($passwordCheck)) {
		$passwordErr = "Please, fill in your password.";
		$err = true;
	}
	
	// If there are no errors retrieve the user information.
	if (!$err) {
		$user = user::get_userByEmail($email);
		$accountActivated = $user->getAccountActivated();
		
		// Check if the account is activated
		if ($accountActivated !== 1) {
			$accountActivatedErr = "It looks like your account was not activated yet. Please check your e-mail. You should have received an activation mail.";
			$err = true;
		}
		
		$password = $user->getPassword();
		/* Convert the submitted password to the encrypted version of it. If a password was found that corresponds to the submitted e-mail address, compare it with the inserted password. */
		$passwordCheck = hash('sha256',$passwordCheck);
		
		if ($passwordCheck !== $password) {
			$passwordMatchErr = "Looks like your password does not match this username. Please make sure you spelled it correctly and make sure you have at least one upper case, one lower case and one digit.";
			$err = true;
		}
	}
}

/* isset determines if a varable exists and is not NULL, in this case it tests if the form is submitted and the second part of the statement requires there to be no errors in order to run the code inside */
if (isset($_POST["submit"]) && !$err) {
	
	/* Set the userId session variable which allows other scripts to check whether or not the user is logged in. */
	$_SESSION['userId'] = $user->getId();
	
	if ($rememberMe) {
		user::rememberMe($_SESSION['userId']);
	}
	$loginId = user::storeLoginData($_SESSION['userId']);
	user::mapLoginData($_SESSION['userId'], $loginId);
	
	/* loads the user's page */
	header("Location: ./index.php?action=userPage");
}

?>

<body style="margin:10px;">
    <h1>Hi there, please fill out the information below to log yourself in.</h1><br>

    <!-- Login form -->        
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		
		<div class="userInput">
			<input type="text" name="email" placeholder="Your e-mail address" value="<?php if (isset($email)) {echo $email;} ?>" class="<?php if (isset($emailErr) || isset($emailMatchErr)) {echo "invalid";} else if (isset($email)) {echo "valid";} ?>">
			<label>E-mail addres (this serves as your login user name):</label>
			<span class="error">
				<?php
					if (isset($emailErr)) {echo $emailErr;}
					if (isset($emailMatchErr)) {echo $emailMatchErr;}
				?>
			</span>
		</div>
		
		<div class="userInput">
			<input type="password" name="passwordCheck" class="<?php if (isset($passwordErr) || isset($passwordMatchErr)) {echo "invalid";} else if (isset($passwordCheck)) {echo "valid";} ?>">
			<label>Password:</label>
			<span class="error">
				<?php
					if (isset($passwordErr)) {echo $passwordErr;}
					if (isset($passwordMatchErr)) {echo $passwordMatchErr;}
				?>
			</span>
		</div>
		
		<span style="margin-left:2rem;"><a href="index.php?action=forgotPassword" class="textLink">I forgot my password.</a></span><span class="success"><?php if (isset($success)) {echo " The email with your new password has been sent!";} ?></span>
		
        <div class="userInput">
        	<input type="checkbox" name="rememberMe" value="rememberMe">Keep me logged in
		</div>
		
        <span class="error">
            <?php
                if (isset($accountActivatedErr)) {echo $accountActivatedErr;}
            ?>
        </span>
        
        <input type="hidden" name="action" value="logIn">

        <input type="submit" name="submit" value="Log in">
        
    </form>
</body>

<?php
include_once('footer.html');
?>