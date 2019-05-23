<?php
session_start();
include_once('header.html');


// Define variables and set to empty values.
$err = "";

/* Check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['submitCreate']) || isset($_POST['submitLogin']))) {
	$passwordCheck = cleanInput($_POST['passwordCheck']);
	
	// Check if the password field is not empty.
	if (empty($passwordCheck)) {
		$passwordErr = "Please, fill in the password.";
		$err = true;
	} else if ($passwordCheck !== "EventOrganiser1/SB") {
		$passwordMatchErr = "The password you entered is not correct, make sure you spelled it correctly.";
		$err = true;
	}
	
	// If there are no errors retrieve the user information.
	if (!$err && isset($_POST['submitCreate'])) {
		header("Location: ./index.php?action=createAccount");
	} else if (!$err && isset($_POST['submitLogin'])) {
		header("Location: ./index.php?action=logIn");
	}
}

?>

<body style="margin:10px;">
    <h1>Please enter the password we sent you to access SkillsBridger:</h1><br>

    <!-- Login form -->        
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		
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
        
        <input type="hidden" name="action" value="passwordAccess">
		
        <input type="submit" name="submitCreate" value="Create my account!">
		
        <input type="submit" name="submitLogin" value="Take me to skillsbridger!">
        
    </form>
	
</body>

<?php
include_once('footer.html');
?>