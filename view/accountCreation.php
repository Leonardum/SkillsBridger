<?php
session_start();
include_once('header.html');


// define variables and set to empty values.
$err = "";

/* check whether the form has been submitted using the POST method. */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$_SESSION['firstname'] = cleanInput($_POST['firstname']);
	$_SESSION['lastname'] = cleanInput($_POST['lastname']);
	/* if (isset($_POST['CustomerType'])) {
		$_SESSION['CustomerType'] = cleanInput($_POST['CustomerType']);
	} */
	$_SESSION['email'] = cleanInput($_POST['email']);
	$password = cleanInput($_POST['password']);
	$PasswordConfirm = cleanInput($_POST['PasswordConfirm']);
	if (isset($_POST['termsOfUseAccept'])) {
		$termsOfUseAcceptIp = $_SERVER['REMOTE_ADDR'];
		if ($termsOfUseAcceptIp == NULL) {
			$termsOfUseAcceptIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
	} else {
		$termsOfUseAcceptIp = NULL;
	}

	if (empty($_SESSION['firstname'])) {
		$firstnameErr = "Please, fill in your first name.";
		$err = true;
	} else {
		$noFirstnameErr = true;
	}
	if (empty($_SESSION['lastname'])) {
		$lastnameErr = "Please, fill in your last name.";
		$err = true;
	} else {
		$noLastnameErr = true;
	}
	
	/* Check if an e-mail address has been submitted and if it is a valid one with the FILTER_VALIDATE_EMAIL function */
	if (empty($_SESSION['email'])) {
		$emailErr = "Please, fill in your e-mail address.";
		$err = true;
	} else if (!filter_var($_SESSION['email'], FILTER_VALIDATE_EMAIL)) {
		$emailErr = "Whoops, looks like the e-mail address you inserted is invalid. Please, make sure you have written it correctly.";
		$err = true;
	}
	
	/* Check if the submitted e-mail address is unique in the database. This could be checked in the database as well, by making sure that all values in that collumn are unique. */
	$emails = user::get_emails();
	$arrLength = count($emails);
	for($x = 0; $x < $arrLength; $x++) {
		if (!empty($_SESSION['email']) && $emails[$x] === $_SESSION['email']) {
			$emailAvailableErr = "Whoops! Looks like this e-mail address is already in use!";
			$err = true;
		}
	}
	
	if (!isset($emailAvailableErr) && !isset($emailErr)) {
		$noEmailErr = true;
	}
	
	// Check if a password has been submitted
	if (empty($password)) {
		$pwErr = "Please, fill in your password.";
		$err = true;
	}
	
	// Check if the passwords meets security requirements
	if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{8,16}$/', $password)) {
		$pwConditionErr = "Your password must be between 8 and 16 characters long and contain at least one upper case letter, one lower case letter and one  numeric digit! Spaces are not allowed!";
		$err = true;
	}
	
	if (!isset($pwErr) && !isset($pwConditionErr)) {
		$noPwErr = true;
	}
	
	// Check if both passwords match
	if ($password !== $PasswordConfirm) {
		$pwMatchErr = "Whoops! It looks like both passwords do not match! Please, fill them in again.";
		$err = true;
	}
	
	// Set an error if the terms of use have NOT been accepted.
	if (!isset($_POST['termsOfUseAccept'])) {
		$termsOfUseAcceptIp = NULL;
		$termsOfUseAcceptErr = "This tickbox is obligatory.";
		$err = true;
	}
	
	/* If there are no errors, create the user object and save it. */
	if (!$err) {
		// Encrypt the password for the database.
		$password = hash('sha256',$password);

		$user = new user(NULL, $_SESSION['firstname'], $_SESSION['lastname'], $_SESSION['email'], $password, NULL, NULL, NULL, NULL, NULL, $termsOfUseAcceptIp);

		$_SESSION['userId'] = $user->save();

		header("Location: index.php?action=accountCreated");
	}
}

?>

<body style="margin:10px;">
    <h1>Hi there, before moving on, please choose a username and password.</h1>
	     
    <p><span class="error">* = required fields</span></p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		
		<div class="userInput">
			<input type="text" name="firstname" placeholder="FIRST Name" value="<?php if (isset($_SESSION['firstname'])) {echo $_SESSION['firstname'];} ?>" class="<?php if (isset($firstnameErr)) {echo "invalid";} else if (isset($noFirstnameErr)) {echo "valid";} ?>">
			<label>First name:</label>
			<span class="error"> * <?php if (isset($firstnameErr)) {echo $firstnameErr;} ?></span>
		</div>
		
		
		<div class="userInput">
			<input type="text" name="lastname" placeholder="LAST Name" value="<?php if (isset($_SESSION['lastname'])) {echo $_SESSION['lastname'];} ?>" class="<?php if (isset($lastnameErr)) {echo "invalid";} else if (isset($noLastnameErr)) {echo "valid";} ?>">
			<label>Last name:</label>
			<span class="error"> * <?php if (isset($lastnameErr)) {echo $lastnameErr;}?></span>
		</div>
		
		
		<div class="userInput">
			<input type="email" name="email" value="<?php if (isset($_SESSION['email'])) {echo $_SESSION['email'];} ?>" class="<?php if (isset($emailAvailableErr) || isset($emailErr)) {echo "invalid";} else if (isset($noEmailErr)) {echo "valid";} ?>">
			<label>Please, fill in your e-mail address (this will serve as your SkillsBridger user name):</label>
			<span class="error"> * 
				<?php
				if (isset($emailAvailableErr)) {echo $emailAvailableErr;}
				if (isset($emailErr)) {echo $emailErr;}
				?>
			</span>
		</div>
		
		
		<div class="userInput">
			<input type="password" name="password" class="<?php if (isset($pwErr) || isset($pwConditionErr)) {echo "invalid";} else if (isset($noPwErr)) {echo "valid";} ?>">
			<label>Please, choose a password for your account:</label>
			<span class="error"> *</span>
			<span class="<?php  if (isset($pwErr) || isset($pwConditionErr)) {echo "error";} ?>">
				<?php 
				if (isset($pwErr)) {
					echo $pwErr;
				} else {
					echo "Password requirements: 8-16 characters, contains at least one upper case letter, one lower case letter and one numeric digit! Spaces are not allowed!";
				}
				?>
			</span>
		</div>
		
		
		<div class="userInput">
			<input type="password" name="PasswordConfirm" class="<?php if (isset($pwErr) || isset($pwMatchErr)) {echo "invalid";} else if (isset($PasswordConfirm)) {echo "valid";} ?>">
			<label>Please, confirm your password:</label>
			<span class="error"> * <?php if (isset($pwMatchErr)) {echo $pwMatchErr;} ?></span>
		</div>
		
		<div class="userInput">
			<input type="checkbox" name="termsOfUseAccept" value="true" <?php if(isset($termsOfUseAcceptIp)) {echo "checked";} ?>><span class="checkboxtext">I have read and accept the <a class="textLink" href="index.php?action=terms" target="_blank">terms of service & privacy policy</a> of SkillsBridger.</span>
			<span class="error"> * <?php if (isset($termsOfUseAcceptErr)) {echo $termsOfUseAcceptErr;}?></span>
		</div>
		
        <input type="hidden" name="action" value="createAccount">
		
        <input type="submit" name="submit" value="Let's do this!">
    </form>
	
</body>

<?php
include_once('footer.html');
?>