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

?>

<body>
    
    <?php
    // define variables and set to empty values.
    $err = "";
    
    /* check whether the form has been submitted using the POST method and make sure no values are empty. */
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $careerGoalName = cleanInput($_POST['careerGoalName']);
        if (isset($_POST['careerGoalLevel'])) {
            $careerGoalLevel = cleanInput($_POST['careerGoalLevel']);
        }
        if (isset($_POST['parent'])) {
            $parent = cleanInput($_POST['parent']);
        } else {
            $parent = NULL;
        }

        if (empty($careerGoalName)) {
            $careerGoaNamelErr = "Please, give a name for the career goal you want to add.";
            $err = true;
        }
        if (empty($careerGoalLevel)) {
            $careerGoalLevelErr = "Please, select the level of the career goal you want to add.";
            $err = true;
        }
                
        /* Check if the career goal name entered is a unique one! */
        $careerGoals = careerGoal::get_careerGoals();
        $arrLength = count($careerGoals);
        for($x = 0; $x < $arrLength; $x++) {
            if (!empty($careerGoalName) && $careerGoals[$x] === $careerGoalName) {
                $careerGoalAvailableErr = "Whoops! Looks like this name is already taken for a career goal!";
                $err = true;
            }
        }
    }

    if (isset($_POST["submit"]) && !$err) {
        
        $careerGoal = new careerGoal(NULL, $careerGoalName, $careerGoalLevel, $parent, NULL);
        
        $_SESSION['careerGoalId'] = $careerGoal->save();
        
        header("Location: index.php?action=careerGoalAdded");
    }
    
    ?>
    
    
    <div style="margin-left:10px;">
    <!-- The actual form -->
    <p><span class="error">* = required fields</span></p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <p>Which career goal would you like to add?</p>
        <input type="text" name="careerGoalName" placeholder="Career Goal" value="<?php if (isset($careerGoalName)) {echo $careerGoalName;} ?>">
        <span class="error"> *
            <?php 
                if (isset($careerGoaNamelErr)) {echo $careerGoaNamelErr;}
                if (isset($careerGoalAvailableErr)) {echo $careerGoalAvailableErr;}
            ?>
        </span><br><br>
        
        <p>On which level is this career goal?</p>
        <select id="careerGoalLevel" name="careerGoalLevel" onchange="checkValue(this.value)">
            <option <?php if (!isset($careerGoalLevel)){echo "selected";} ?> disabled hidden value=""></option>
            <option value=1 <?php if (isset($careerGoalLevel) && $careerGoalLevel == 1) {echo "selected";} ?>>1st Level</option>
            <option value=2 <?php if (isset($careerGoalLevel) && $careerGoalLevel == 2) {echo "selected";} ?>>2nd Level</option>
        </select>
        <span class="error"> * <?php if (isset($careerGoalLevelErr)) {echo $careerGoalLevelErr;}?></span><br><br>
        
		
		<button type="button" onclick="selectCareerGoal();">Career Goal</button>
		<button type="button" onclick="selectCareerArea();">Career Area</button>
		
		
        <div id="container"></div>
        <br id="breakOne" style="display:none;">
                                      
        <input type="hidden" name="action" value="careerGoalsAdmin">
        
		<br>
		
        <input type="submit" name="submit" value="Add career goal">
    </form>
    
    </div>
    
    <script type="text/javascript" src="./js/careerGoalsAdmin.js"></script>
	
	
	<?php
	if (isset($careerGoalLevel) && $careerGoalLevel == 2) {
	echo '<script type="text/javascript">',
		'(function() {checkValue(2);})();',
		'</script>';
	}
	?>
    
</body>

<?php
include_once('footer.html');
?>