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

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    
	/* Use regular expression to avoid splitting string on comma's followed by a space. */
    $hardSkillsSelection = preg_split("/,(?!\s)/", $_POST['hardSkillsSelection']);
    $softSkillsSelection = preg_split("/,(?!\s)/", $_POST['softSkillsSelection']);
	
	/* Since a blank string is valid string value, the PHP explode function returns it as a blank array element. Therefore the array length will never be 0. But if the exploded string was empty, it WILL return the array [NULL]. So you can check if the first element is NULL instead of checking if the array length is zero. */
	if ($hardSkillsSelection[0] != NULL) {
		$hardLength = count($hardSkillsSelection);
		for($x = 0; $x < $hardLength; $x++) {
			$skill = skill::get_skillByName($hardSkillsSelection[$x]);
			$skillId = $skill->getId();
			careerGoal::add_skillToCareerGoal($skillId, $_SESSION['careerGoalId']);
		}
	}
    
	if ($softSkillsSelection[0] != NULL) {
		$softLength = count($softSkillsSelection);
		for($x = 0; $x < $softLength; $x++) {
			$skill = skill::get_skillByName($softSkillsSelection[$x]);
			$skillId = $skill->getId();
			careerGoal::add_skillToCareerGoal($skillId, $_SESSION['careerGoalId']);
		}
	}
	
    unset($_SESSION['careerGoalId']);
    
    header("Location: index.php?action=careerGoalsAdmin");
}


?>

<body>
    <div style="margin-left:10px;">
    <?php
    echo "<h1>Your careergoal was successfully added to the database!</h1>";
    ?>
    
    <p>Add (a) hard skill(s) to this career goal!</p>
	<div class="col-20">
		<div class="col-4">
			<input id="hardSkillInput" type="text" name="hardSkills"  oninput="skillHint(this.value, 'hardskill')" value"">
			<button type="button" class="button-small" onclick="addToList('hardSkillInput')">+ Add</button>
			<div id="hardHints" class="hintBox"></div>
		</div>
		<div id="hardSkillDisplay" class="col-10" style="height:125px; border: 2px solid; overflow:auto;"></div>
	</div>
	
	
	<p>Add (a) soft skill(s) to this career goal!</p>
	<div class="col-20">
		<div class="col-4">
			<input id="softSkillInput" type="text" name="softSkills" oninput="skillHint(this.value, 'softskill')" value"">
			<button type="button" class="button-small" onclick="addToList('softSkillInput')">+ Add</button>
			<div id="softHints" class="hintBox"></div>
		</div>
		<div id="softSkillDisplay" class="col-10" style="height:125px; border: 2px solid; overflow:auto;"></div>
	</div>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <input type="hidden" id="hardSkillsSelection" name="hardSkillsSelection" value="">
        <input type="hidden" id="softSkillsSelection" name="softSkillsSelection" value="">
		
		<input type="hidden" name="action" value="careerGoalAdded">
		
        <input type="submit" name="submit" value="Add the selected skills to this career goal.">
    </form>
    
	<div>
		<a href="./index.php?action=careerGoalsAdmin"><button type="button">Add another career goal</button></a>
	</div>
    
    </div>
    
    <script type="text/javascript" src="./js/careerGoalsAdmin.js"></script>
    
</body>

<?php
include_once('footer.html');
?>