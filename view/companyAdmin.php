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
	$description = cleanInput($_POST['description']);
	$vatNumber = cleanInput(preg_replace('/[\s\-]/', '', $_POST['vatNumber']));
	$adminUserId = cleanInput($_POST['adminUserId']);
	
	if (empty($name)) {
		$nameErr = "Please, insert a name for the company.";
		$err = true;
	}
	if (empty($description)) {
		$descriptionErr = "Please, insert a description of the company.";
		$err = true;
	}
	if (empty($vatNumber)) {
		$vatNumberErr = "Please, insert the VAT number of the company.";
		$err = true;
	}
	if (empty($adminUserId)) {
		$adminUserErr = "Please, insert the name of a SkillsBridger user and select the right suggestion to make him or her admin of the new company.";
		$err = true;
	}
	
	if (isset($name)) {
		$companyNames = company::get_companyNames();
		if (in_array($name, $companyNames)) {
			$nameErr = "It looks like this company already exists.";
			$vatNumber = NULL;
			$err = true;
		}
	}
	if (isset($vatNumber)) {
		if (!preg_match('/^[0-9]*$/', $vatNumber)) {
			$vatNumberErr = "Please insert a valid VAT number.";
			$err = true;
		}
	}
	
	if (!$err) {
		$company = new company(NULL, $name, $description, $vatNumber, $adminUserId);
		$companyId = $company->save();
		
		company::add_userToCompany($adminUserId, $companyId);
		
		header("Location: index.php?action=companyOverview&userId=$_SESSION[userId]");
	}
}

?>


<p><span class="error">* = required fields</span></p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	
	<div class="userInput">
		<input type="text" name="name" value="<?php if (isset($name)) {echo $name;} ?>" class="<?php if (isset($nameErr)) {echo "invalid";} else if (isset($name)) {echo "valid";} ?>">
		<label>The name of the company:</label>
		<span class="error"> * <?php if (isset($nameErr)) {echo $nameErr;} ?></span>
	</div>
	
	<div class="userInput">
		<textarea id="description" name="description" rows="10" style="width:375px;" maxlength="500" class="<?php if (isset($descriptionErr)) {echo "invalid";} else if (isset($description)) {echo "valid";} ?>" onkeyup="countdown('description', 500, 'charsLeft')"><?php if (isset($description)) {echo $description;} ?></textarea>
		<label>Give a description of the company (max 500 chars):</label>
		<span class="error"> * <?php if (isset($descriptionErr)) {echo $descriptionErr;}?></span>
		<br>
		<span id="charsLeft" class="charCountDown">Characters left: 500</span>
	</div>
	
	<div class="userInput">
		<input type="text" name="vatNumber" value="<?php if (isset($vatNumber)) {echo $vatNumber;} ?>" class="<?php if (isset($vatNumberErr)) {echo "invalid";} else if (isset($vatNumber)) {echo "valid";} ?>">
		<label>The VAT Number of the company:</label>
		<span class="error"> * <?php if (isset($vatNumberErr)) {echo $vatNumberErr;} ?></span>
	</div>
	
	<div class="userInput" style="padding-top:2.2rem;">
		<input type="text" id="adminUser" name="adminUser" autocomplete="off" onkeyup="nameHint(event, this.value)" class="<?php if (isset($adminUserErr)) {echo "invalid";} else if (isset($success)) {echo "valid";} ?>">
		<label>Select a suggested SkillsBridger user to add to the company:</label>
		<span class="error"> * <?php if (isset($adminUserErr)) {echo $adminUserErr;} ?></span>
		<span class="success"><?php if (isset($success)) {echo "The user was successfully added!";} ?></span>

		<div id="hints" class="hintBox" style="display:none;"></div>
	</div>
	
	<input id="adminUserId" type="hidden" name="adminUserId" value="">
	
	<input type="hidden" name="action" value="companyAdmin">
	
	<input type="submit" name="submit" value="Add company">
</form>

<script type="text/javascript" src="./js/companyAdmin.js"></script>

<?php
include_once('footer.html');
?>