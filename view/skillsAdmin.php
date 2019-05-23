<?php
session_start();
include_once('header.html');

$user = user::isLoggedIn();
if(!$user) {
    session_unset();
    session_destroy();
    header("Location: index.php?action=logIn");
}

if(!(user::isAdmin())){
    header("location: ./index.php?action=userPage");
}

?>

<body>
    
    <?php
    // define variables and set to empty values.
    $err = "";
    
    /* check whether the form has been submitted using the POST method and make sure no values are empty. */
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_SESSION['skillName'] = cleanInput($_POST['skillName']);
        if (isset($_POST['skillType'])) {
            $skillType = cleanInput($_POST['skillType']);
        }
        if (isset($_POST['skillLevel'])) {
            $skillLevel = cleanInput($_POST['skillLevel']);
        }
        $_SESSION['skillDescription'] = cleanInput($_POST['skillDescription']);

        if (empty($_SESSION['skillName'])) {
            $SkillNameErr = "Please, give a name for the skill you want to add.";
            $err = true;
        }
        if (empty($skillType)) {
            $skillTypeErr = "Please, select the type of the skill you want to add.";
            $err = true;
        }
		/*
        if (empty($skillLevel)) {
            $skillLevelErr = "Please, select the level of the skill you want to add.";
            $err = true;
        }*/
        
        /* Check if the skill name entered is a unique one! */
        $skillNames = skill::get_skillNames();
        $arrLength = count($skillNames);
        for($x = 0; $x < $arrLength; $x++) {
            if (!empty($_SESSION['skillName']) && $skillNames[$x] === $_SESSION['skillName']) {
                $skillNameAvailableErr = "Whoops! Looks like this name is already taken for a skill!";
                $err = true;
            }
        }
        
        // Check if the description is not longer than 250 characters.
        if (strlen($_SESSION['skillDescription']) > 250) {
            $skillDescriptionErr = "This skill description exceeds the maximum of 250 characters! Kindly shorten it.";
            $err = true;
        }
    }

    if (isset($_POST["submit"]) && !$err) {
        
        $skill = new skill(NULL, $_SESSION['skillName'], $skillType, $skillLevel, $_SESSION['skillDescription'], NULL);
        
        $skill->save();
        
        unset($_SESSION['skillDescription']);
        
        header("Location: index.php?action=skillAdded");
    }
    
    ?>
    
    
    <div style="margin-left:10px;">
    <!-- The actual form -->
    <p><span class="error">* = required fields</span></p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <p>Which skill would you like to add?</p>
        <input type="text" name="skillName" placeholder="Skill Name" value="<?php if (isset($_SESSION['skillName'])) {echo $_SESSION['skillName'];} ?>">
        <span class="error"> *
            <?php 
                if (isset($SkillNameErr)) {echo $SkillNameErr;}
                if (isset($skillNameAvailableErr)) {echo $skillNameAvailableErr;}
            ?>
        </span><br><br>
        
        <p>What type of skill is this?</p>
        <select id="skillType" name="skillType">
            <option selected disabled hidden value=""></option>
            <option value="hardskill">Hardskill</option>
            <option value="softskill">Softskill</option>
        </select>
        <span class="error"> * <?php if (isset($skillTypeErr)) {echo $skillTypeErr;}?></span><br><br>
		
		<button type="button" onclick="selectHardSkill();">Hardskill</button>
		<button type="button" onclick="selectSoftSkill();">SoftSkill</button>
		
        <!--
        <p>On which level is this skill?</p>
        <select name="skillLevel">
            <option selected disabled hidden value=""></option>
            <option value="1">1st Level</option>
            <option value="2">2nd Level</option>
            <option value="3">3rd Level</option>
            <option value="4">4th Level</option>
            <option value="5">5th Level</option>
        </select>
        <span class="error"> * <?php if (isset($skillLevelErr)) {echo $skillLevelErr;}?></span><br><br>
        
        <p>Give a brief description of this skill (max 250 chars):</p>
        <textarea name="skillDescription" rows="10" cols="50" maxlength="250"><?php if (isset($_SESSION['skillDescription'])) {echo $_SESSION['skillDescription'];} ?></textarea>
        <span class="error"> <?php if (isset($skillDescriptionErr)) {echo $skillDescriptionErr;}?></span><br><br>
        -->
        <input type="hidden" name="action" value="skillsAdmin">
        
        <input type="submit" name="submit" value="Add Skill">
    </form>
    </div>
	
	<script type="text/javascript">
		function selectHardSkill() {
			var skillTypeSelect = document.getElementById('skillType');
			skillTypeSelect.options[1].selected = "true";
		}
		
		function selectSoftSkill() {
			var skillTypeSelect = document.getElementById('skillType');
			skillTypeSelect.options[2].selected = "true";
		}
	</script>
	
</body>

<?php
include_once('footer.html');
?>