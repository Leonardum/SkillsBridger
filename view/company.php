<?php

$companyLogo = userFile::get_imageOfUploader('company', $companyId);
$companyLogoUrl = $companyLogo->getUrl();
if (!$companyLogoUrl) {
	$companyLogoUrl = './images/logo.png';
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
	
	/* Check if the submitted user ID is not already mapped for this company. */
	$userCheck = company::check_userPartOfCompany($newUserId, $companyId);
	if ($userCheck) {
		$userAddErr = "Well, it looks like this user is already part of your company!";
		$err = true;
	}
	
	if (!$err) {

		company::add_userToCompany($newUserId, $companyId);

		header("Location: index.php?action=company&companyId=$companyId&userId=$userId&success=true");
	}
}

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["remove"])) {
	
	$memberId = cleanInput($_POST['memberId']);
	
	company::delete_userFromCompany($memberId, $companyId);
	
	header("Location: index.php?action=company&companyId=$companyId&userId=$userId");
}

?>

<div class="col-20">
	<div class="col-8">
		<div class="organisationLogo">
			<img src="<?php echo $companyLogoUrl ?>" alt="company logo" class="organisationLogo" onmouseover="hide('direction')" onmouseout="hide('direction')">
			<button id="direction"  class="organisationLogo" onclick="document.getElementById('companyLogo').click();" onmouseover="hide('direction')" onmouseout="hide('direction')" style="display:none;">Change company logo</button>
			<form enctype="multipart/form-data" action="./uploads/fileUploadHandling.php" method="POST" id="companyLogoForm">
				
				<input type="file" id="companyLogo" name="companyLogo" hidden="true" accept=".jpg,.jpeg,.png;" onchange="checkCompanyLogoSize();"/>
				
				<input type="hidden" name="companyId" value="<?php echo $companyId; ?>">
				
				<input type="hidden" name="action" value="company">
			</form>
		</div>
	</div>
	
	<div class="col-12" style="margin:20px 0;">
		<h2>Add a user to your company:</h2>
		<p><span class="error">* = required fields</span></p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			
			<div class="userInput" style="padding-top:2.2rem;">
				<input type="text" id="name" name="name" autocomplete="off" onkeyup="nameHint(event, this.value)" class="<?php if (isset($newUserIdErr) || isset($userAddErr)) {echo "invalid";} else if (isset($success)) {echo "valid";} ?>">
				<label>Select a suggested SkillsBridger user to add to your company:</label>
				<span class="error"> * <?php if (isset($newUserIdErr)) {echo $newUserIdErr;} else if (isset($userAddErr)) {echo $userAddErr;} ?></span>
				<span class="success"><?php if ($success) {echo "The user was successfully added!";} ?></span>
				
				<div id="hints" class="hintBox" style="display:none;"></div>
			</div>
			
			<input type="hidden" id="newUserId" name="newUserId" value="<?php if (isset($newUserId)) {echo $newUserId;} ?>">
			
			<input type="hidden" name="companyId" value="<?php echo $companyId ?>">
			
			<input type="hidden" name="userId" value="<?php echo $user->getId(); ?>">
			
			<input type="hidden" name="action" value="company">
			
			<input type="submit" name="submit" value="Add this user!">
		</form>
	</div>
</div>

<div id="memberList" class="col-20" style="margin-bottom:5rem;">
	<h2>Members of <?php echo $company->getName(); ?>:</h2>
</div>