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

$success = filter_input (INPUT_POST, 'success');
if ($success == NULL) {
	$success = filter_input (INPUT_GET, 'success');
}


// define variables and set to empty values.
$err = "";

/* check whether the form has been submitted using the POST method and make sure no values are empty. */
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = cleanInput($_POST['name']);
	
	if (empty($name)) {
		$nameErr = "Please, fill in the name of the university or college.";
		$err = true;
	}

	/* Check if the career goal name entered is a unique one! */
	$universities = university::get_allUniversities();
	$arrLength = count($universities);
	for($x = 0; $x < $arrLength; $x++) {
		if (!empty($name) && $universities[$x] === $name) {
			$nameAvailableErr = "Whoops! Looks like this university is already in the database!";
			$err = true;
		}
	}
	
	if (!$err) {
		$university = new university(NULL, $name);
		$universityId = $university->save();
		
		header("Location: index.php?action=universityAdmin&success=true");
	}
}

?>

<body>
    <div style="margin-left:10px;">
		<p><span class="error">* = required fields</span></p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			
			<p>What is the name of the university or college you would like to add?</p>
			<input type="text" name="name" value="<?php if (isset($name)) {echo $name;} ?>">
			<span class="error"> *
				<?php 
					if (isset($nameErr)) {echo $nameErr;}
					if (isset($nameAvailableErr)) {echo $nameAvailableErr;}
				?>
			</span>
			<span class="success">
				<?php 
					if (isset($success)) {echo "The university or college was successfully added!";}
				?>
			</span>
			<br><br>
			
			<input type="hidden" name="action" value="universityAdmin">
			
			<input type="submit" name="submit" value="Add university or college">
		</form>
    </div>
</body>

<?php
include_once('footer.html');
?>