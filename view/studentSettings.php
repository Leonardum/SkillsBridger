<h1>Change your student settings:</h1>
<span class="success">
	<?php
	if (isset($studentSuccess)) {echo "Your student settings have been updated!";}
	?>
</span>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	
	<div class="userInput">
		<select id="study" name="study" class="<?php if (isset($studyErr)) {echo "invalid";} ?>">
			<option selected disabled hidden value=""></option>
		</select>
		<label>What do you currently study?</label>
		<span class="error"> * <?php if (isset($studyErr)) {echo $studyErr;}?></span>
	</div>
	
	<div class="userInput">
		<select id="university" name="university" class="<?php if (isset($universityErr)) {echo "invalid";} ?>">
			<option selected disabled hidden value=""></option>
		</select>
		<label>Where do you study this?</label>
		<span class="error"> * <?php if (isset($universityErr)) {echo $universityErr;}?></span>
	</div>
	
	<div class="userInput">
		<select name="currentYear" class="<?php if (isset($currentYearErr)) {echo "invalid";} ?>">
			<option selected disabled hidden value=""></option>
			<option value="1st bachelor">1st Bachelor</option>
			<option value="2nd bachelor">2nd Bachelor</option>
			<option value="3rd bachelor">3rd Bachelor</option>
			<option value="1st Master">1st Master</option>
			<option value="2nd Master">2nd Master</option>
		</select>
		<label>In what stage of your study are you currently?</label>
		<span class="error"> * <?php if (isset($currentYearErr)) {echo $currentYearErr;}?></span>
	</div>
	
	<div class="userInput">
		<select name="graduationMonth" style="min-width:20px;" class="<?php if (isset($graduationErr)) {echo "invalid";} ?>">
			<option selected disabled hidden value=""></option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
		</select>
		
		<select name="graduationYear" style="min-width:40px;" class="<?php if (isset($graduationErr)) {echo "invalid";} ?>">
			<option selected disabled hidden value=""></option>
			<option value="2016">2016</option>
			<option value="2017">2017</option>
			<option value="2018">2018</option>
			<option value="2019">2019</option>
			<option value="2020">2020</option>
			<option value="2021">2021</option>
			<option value="2022">2022</option>
			<option value="2023">2023</option>
			<option value="2024">2024</option>
			<option value="2025">2025</option>
			<option value="2026">2026</option>
			<option value="2027">2027</option>
			<option value="2028">2028</option>
			<option value="2029">2029</option>
			<option value="2030">2030</option>
		</select>
		<label>When do you expect to graduate?</label>
		<span class="error"> * <?php if (isset($graduationErr)) {echo $graduationErr;}?></span>
	</div>
	
	<div class="userInput">
		<input type="checkbox" name="internshipInterest" value="true"><span class="checkboxtext">I am interested in internship offers.</span><br>
		<input type="checkbox" name="halfTimeInterest" value="true"><span class="checkboxtext">I am interested in half-time job offers.</span><br>
		<input type="checkbox" name="fullTimeInterest" value="true"><span class="checkboxtext">I am interested in full-time job offers.</span>
	</div>
	
	<div class="userInput">
		<input type="checkbox" name="termsOfUseAccept" value="true" <?php if(isset($termsOfUseAcceptIp)) {echo "checked";} ?>><span class="checkboxtext">I hereby declare that all information given above is accurate, to the best of my knowledge, and I understand that I can face legal consequences if the given information is deliberately false.</span>
		<span class="error"> * <?php if (isset($termsOfUseAcceptErr)) {echo $termsOfUseAcceptErr;}?></span>
	</div>
	
	<input type="hidden" name="studentId" value=<?php echo $student->getId(); ?>>
	
	<input type="hidden" name="action" value="editAccount">
	
	<input type="submit" name="submitStudentSettings" style="margin-left:2rem;" value="Update data">
</form>