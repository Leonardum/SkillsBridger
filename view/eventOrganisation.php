<?php

$orgLogo = userFile::get_imageOfUploader('eventOrg', $organisationId);
$orgLogoUrl = $orgLogo->getUrl();
if (!$orgLogoUrl) {
	$orgLogoUrl = './images/logo.png';
}

$success = filter_input (INPUT_POST, 'success');
if ($success == NULL) {
	$success = filter_input (INPUT_GET, 'success');
}

// define variables and set to empty values.
$err = "";

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
	
	(int) $newUserId = cleanInput($_POST['newUserId']);
	
	if (empty($newUserId)) {
		$newUserIdErr = "Please, select a user from the search results.";
		$err = true;
	}
	
	/* Check if the submitted user ID is not already mapped for this organisation. */
	$userCheck = eventOrganisation::check_userPartOfOrganisation($newUserId, $organisationId);
	if ($userCheck) {
		$userAddErr = "Well, it looks like this user is already part of your organisation!";
		$err = true;
	}
	
	if (!$err) {

		eventOrganisation::add_userToEventOrganisation($newUserId, $organisationId);

		header("Location: index.php?action=eventOrganisation&organisationId=$organisationId&userId=$userId&success=true");
	}
}

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["remove"])) {
	
	$memberId = cleanInput($_POST['memberId']);
	
	eventOrganisation::delete_userFromEventOrganisation($memberId, $organisationId);
	
	header("Location: index.php?action=eventOrganisation&organisationId=$organisationId&userId=$userId");
}

?>

<div class="col-20">
	<div class="col-8">
		<div class="organisationLogo">
			<img src="<?php echo $orgLogoUrl ?>" alt="Organisation logo" id="organisationLogo" class="organisationLogo" onmouseover="hide('direction')" onmouseout="hide('direction')">
			<button id="direction"  class="organisationLogo" onclick="document.getElementById('orgLogo').click();" onmouseover="hide('direction')" onmouseout="hide('direction')" style="display:none;">Change organisation logo</button>
			<form enctype="multipart/form-data" action="./uploads/fileUploadHandling.php" method="POST" id="orgLogoForm">
				
				<input type="file" id="orgLogo" name="orgLogo" hidden="true" accept=".jpg,.jpeg,.png;" onchange="checkOrganisationLogoSize();"/>
				
				<input type="hidden" name="organisationId" value="<?php echo $organisationId; ?>">
				
				<input type="hidden" name="action" value="eventOrganisation">
			</form>
		</div>
	</div>
	
	<div class="col-12" style="margin:20px 0;">
		<h2>Add a user to your organisation:</h2>
		<p><span class="error">* = required fields</span></p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			
			<div class="userInput" style="padding-top:2.2rem;">
				<input type="text" id="name" name="name" autocomplete="off" onkeyup="nameHint(event, this.value)" class="<?php if (isset($newUserIdErr) || isset($userAddErr)) {echo "invalid";} else if (isset($success)) {echo "valid";} ?>">
				<label>Select a suggested SkillsBridger user to add to your event organisation:</label>
				<span class="error"> * <?php if (isset($newUserIdErr)) {echo $newUserIdErr;} else if (isset($userAddErr)) {echo $userAddErr;} ?></span>
				<span class="success"><?php if ($success) {echo "The user was successfully added!";} ?></span>
				
				<div id="hints" class="hintBox" style="display:none;"></div>
			</div>
			
			<input type="hidden" id="newUserId" name="newUserId" value="<?php if (isset($newUserId)) {echo $newUserId;} ?>">
			
			<input type="hidden" name="organisationId" value="<?php echo $organisationId ?>">
			
			<input type="hidden" name="userId" value="<?php echo $user->getId(); ?>">
			
			<input type="hidden" name="action" value="eventOrganisation">
			
			<input type="submit" name="submit" value="Add this user!">
		</form>
	</div>
</div>

<div id="memberList" class="col-20" style="margin-bottom:5rem;">
	<h2>Members of <?php echo $organisation->getName(); ?>:</h2>
</div>