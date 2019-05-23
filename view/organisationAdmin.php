<?php
session_start();
include_once('header.html');

$user = user::isLoggedIn();
if(!$user) {
    session_destroy();
    header("Location: index.php?action=logIn");
}

if(!(user::isAdmin())){
    header("location: ./index.php?action=userPage");
}


// Define variables and set to empty values.
$err = "";

/* Check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
	$name = cleanInput($_POST['name']);
	$adminUserId = cleanInput($_POST['adminUserId']);
	
	if (empty($name)) {
		$nameErr = "Please, insert a name for the event organisation.";
		$err = true;
	}
	
	if (empty($adminUserId)) {
		$adminUserErr = "Please, insert the name of a SkillsBridger user and select the right suggestion to make him or her admin of the new organisation.";
		$err = true;
	}
	
	if (isset($name)) {
		$organisationNames = eventOrganisation::get_eventOrganisationNames();
		if (in_array($name, $organisationNames)) {
			$nameErr = "It looks like this organisation already exists.";
			$err = true;
		}
	}
	
	if (!$err) {
		$eventOrganisation = new eventOrganisation(NULL, $name, $adminUserId);
		$organisationId = $eventOrganisation->save();
		
		eventOrganisation::add_userToEventOrganisation($adminUserId, $organisationId);
		
		header("Location: index.php?action=eventOrganisationOverview&userId=$_SESSION[userId]");
	}
}

?>


<p><span class="error">* = required fields</span></p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	
	<div class="userInput">
		<input type="text" name="name" value="<?php if (isset($name)) {echo $name;} ?>" class="<?php if (isset($nameErr)) {echo "invalid";} else if (isset($name)) {echo "valid";} ?>">
		<label>The name of the organisation:</label>
		<span class="error"> * <?php if (isset($nameErr)) {echo $nameErr;} ?></span>
	</div>
	
	<div class="userInput" style="padding-top:2.2rem;">
		<input type="text" id="adminUser" name="adminUser" autocomplete="off" onkeyup="nameHint(event, this.value)" class="<?php if (isset($newUserIdErr) || isset($userAddErr)) {echo "invalid";} else if (isset($success)) {echo "valid";} ?>">
		<label>Select a suggested SkillsBridger user to add to the event organisation:</label>
		<span class="error"> * <?php if (isset($adminUserErr)) {echo $adminUserErr;} ?></span>
		<span class="success"><?php if (isset($success)) {echo "The user was successfully added!";} ?></span>

		<div id="hints" class="hintBox" style="display:none;"></div>
	</div>
	
	<input id="adminUserId" type="hidden" name="adminUserId" value="">
	
	<input type="hidden" name="action" value="organisationAdmin">
	
	<input type="submit" name="submit" value="Add organisation">
</form>

<script type="text/javascript" src="./js/organisationAdmin.js"></script>

<?php
include_once('footer.html');
?>