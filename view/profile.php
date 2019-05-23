<?php

$university = university::get_universityById($student->getUniversityId());
$study = study::get_studyById($student->getStudyId());

?>
<div class="col-20">
	<?php
		echo "<h2>" . $user->getFirstName() . " " . $user->getLastName() . "</h2><br>";
		echo "<p>" . $study->getName() . " student</p><br>";
		echo "<p>At " . $university->getName() . "</p><br>";
	?>
</div>

<div class="col-20 microdegree-two-col">
	<div id="careerGoals" class="col1"></div>
	<div id="container" class="col2">
		<p class="lightWatermark">Select a career goal to see the skills you have worked on or still need to work on!</p>
	</div>
</div>

<div id="eventOverview" class="col-20" style="margin-bottom:20px;">
</div>