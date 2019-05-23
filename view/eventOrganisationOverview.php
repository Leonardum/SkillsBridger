<div id="createEvent" style="order:2;">
	<a href="index.php?action=organisationCreation"><button>Create a new event organisation!</button></a>
</div>


<?php

if (user::isAdmin()) {
	$organisations = eventOrganisation::get_allOrganisationInfo();
	
	echo "<div class=rowDivider style=order:3;></div>";
	echo "<div class=adminEventOverview  style=order:4;>";
	echo "<h2>Admin Organisation Overview:</h2>";
	
	for($x = 0; $x < count($organisations); $x++) {
		$organisationId = $organisations[$x]['organisationId'];
		$name = $organisations[$x]['name'];
		$fileInfo = userFile::get_imageOfUploader('eventOrg', $organisationId);
		$url = $fileInfo->getUrl();
		
		echo "<a href=index.php?action=upcomingEvents&organisationId=$organisationId>";
		echo "<div style='position:relative; float:left; background-color:white; width:150px; height:200px; margin: 10px;'>";
		echo "<p style='text-align:center; font-weight:700;'>$name</p>";
		if (isset($url)) {
			echo "<img src=$url style='position:absolute; width:150px; height:150px; bottom:0;'>";
		}
		echo "</div>";
		echo "</a>";
	}
	echo "<div>";
}

?>